<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MangaController extends Controller
{
    /**
     * Display the specified manga.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $manga = Manga::with(['chapters' => function($query) {
            $query->orderBy('number', 'desc');
        }])->findOrFail($id);

        // Increment view count
        $manga->increment('view_count');

        // Prepare the data for the view
        $mangaData = [
            'id' => $manga->id,
            'title' => $manga->title,
            'english_title' => $manga->english_title ?? $manga->title,
            'alt_titles' => $this->getAlternativeTitles($manga->alt_titles ?? []),
            'cover_url' => $manga->cover_url ?? 'https://via.placeholder.com/300x450?text=No+Cover',
            'description' => $manga->description ?? 'No description available.',
            'author' => $manga->author ?? 'Unknown',
            'artist' => $manga->artist ?? $manga->author ?? 'Unknown',
            'published_date' => $manga->published_date ? $this->formatPublishedDate($manga->published_date) : 'N/A',
            'status' => $this->formatStatus($manga->status ?? 'unknown'),
            'rating' => (float)($manga->rating ?? 0),
            'rating_count' => (int)($manga->rating_count ?? 0),
            'view_count' => (int)($manga->view_count ?? 0),
            'is_adult' => (bool)($manga->is_adult ?? false),
            'is_suggestive' => (bool)($manga->is_suggestive ?? false),
            'genres' => $manga->genres ?? [],
            'themes' => $manga->themes ?? [],
            'demographic' => $manga->demographic ?? 'Seinen',
            'serialization' => $manga->serialization ?? 'Weekly Shonen Jump',
            'chapters' => $this->formatChapters($manga->chapters),
            'rating_distribution' => $this->generateRatingDistribution($manga->rating ?? 0, $manga->rating_count ?? 0),
            'reviews' => $this->generateSampleReviews(),
            'recommendations' => $this->generateSampleRecommendations()
        ];

        return view('manga.show', ['manga' => $mangaData]);
    }

    /**
     * Get rating distribution for the manga
     */
    protected function getRatingDistribution($manga)
    {
        // In a real application, you would query the database for actual rating distribution
        // This is a simplified example
        $distribution = array_fill(1, 10, 0);
        
        if ($manga->rating_count > 0) {
            // Simulate a normal distribution around the average rating
            $avg = $manga->rating;
            $total = 0;
            
            for ($i = 1; $i <= 10; $i++) {
                $distance = abs($i - $avg);
                $distribution[$i] = (int) max(0, round($manga->rating_count * (1 - $distance / 10) / 3));
                $total += $distribution[$i];
            }
            
            // Scale to match rating_count
            if ($total > 0) {
                $scale = $manga->rating_count / $total;
                foreach ($distribution as $key => $value) {
                    $distribution[$key] = (int) round($value * $scale);
                }
            }
        }
        
        return $distribution;
    }
    
    /**
     * Format status for display
     */
    protected function formatStatus($status)
    {
        $statuses = [
            'ongoing' => 'Em andamento',
            'completed' => 'Completo',
            'hiatus' => 'Em hiato',
            'cancelled' => 'Cancelado',
            'not_yet_published' => 'Não publicado',
            'unknown' => 'Desconhecido'
        ];
        
        return $statuses[strtolower($status)] ?? ucfirst($status);
    }
    
    /**
     * Generate a random rating distribution based on average rating and count
     *
     * @param float $averageRating
     * @param int $ratingCount
     * @return array
     */
    protected function generateRatingDistribution($averageRating, $ratingCount)
    {
        if ($ratingCount === 0) {
            return array_fill(1, 5, 0);
        }
        
        $distribution = [];
        $remaining = $ratingCount;
        $totalStars = $averageRating * $ratingCount * 2; // Multiply by 2 to have more precise distribution
        
        // Distribute ratings from 5 to 1 stars
        for ($i = 5; $i >= 1; $i--) {
            if ($i === 1) {
                $distribution[$i] = $remaining;
            } else {
                // Higher probability for ratings around the average
                $weight = ($i <= $averageRating + 1 && $i >= $averageRating - 1) ? 0.6 : 0.4;
                $count = min(
                    $remaining,
                    (int) round($weight * $totalStars / $i)
                );
                $distribution[$i] = max(0, $count);
                $remaining -= $count;
                $totalStars -= $i * $count;
            }
        }
        
        // Sort by rating (1-5)
        krsort($distribution);
        
        return $distribution;
    }
    
    /**
     * Format chapters data for the view
     *
     * @param \Illuminate\Database\Eloquent\Collection $chapters
     * @return array
     */
    protected function formatChapters($chapters)
    {
        if (!$chapters) {
            return [];
        }
        
        return $chapters->map(function($chapter) {
            return [
                'id' => $chapter->id,
                'number' => $chapter->number,
                'title' => $chapter->title,
                'volume' => $chapter->volume,
                'pages' => $chapter->pages ?? 0,
                'date' => $chapter->created_at ? $chapter->created_at->diffForHumans() : 'N/A',
                'url' => route('chapter.show', ['id' => $chapter->id])
            ];
        })->sortByDesc('number')->values()->all();
    }
    
    /**
     * Extract alternative titles from the manga
     *
     * @param mixed $altTitles
     * @return array
     */
    protected function getAlternativeTitles($altTitles)
    {
        if (empty($altTitles)) {
            return [];
        }
        
        if (is_string($altTitles)) {
            $altTitles = json_decode($altTitles, true) ?? [];
        }
        
        if (!is_array($altTitles)) {
            return [];
        }
        
        $result = [];
        
        // Handle different formats of alternative titles
        foreach ($altTitles as $key => $value) {
            if (is_numeric($key) && is_string($value)) {
                // If it's a simple array of titles
                $result['title'] = $value;
            } elseif (is_string($key) && is_string($value)) {
                // If it's an associative array with language/title pairs
                $result[$key] = $value;
            }
        }
        
        return $result;
    }
    
    /**
     * Generate sample reviews for the manga
     *
     * @return array
     */
    protected function generateSampleReviews()
    {
        $reviews = [];
        $reviewCount = rand(3, 8);
        $reviewTexts = [
            "A história é incrível e os personagens são muito bem desenvolvidos. A arte é linda e as cenas de ação são muito dinâmicas. Estou ansioso para os próximos capítulos!",
            "Um dos melhores mangás que já li. A narrativa é envolvente e os personagens são muito bem construídos. Recomendo muito!",
            "A arte é espetacular e a história é muito original. Vale cada minuto de leitura.",
            "Comecei a ler sem muitas expectativas, mas fiquei impressionado com a qualidade. A evolução dos personagens é incrível.",
            "A premissa é interessante, mas acho que o ritmo poderia ser mais rápido. Mesmo assim, estou gostando muito.",
            "A arte é linda e a história é muito bem construída. Um dos meus favoritos do gênero.",
            "Não consigo parar de ler! A cada capítulo fico mais envolvido com a história e os personagens.",
            "A construção de mundo é incrível e os personagens são muito carismáticos. Recomendo muito!"
        ];
        
        $names = ['João Silva', 'Maria Santos', 'Carlos Oliveira', 'Ana Pereira', 'Pedro Souza', 'Juliana Costa'];
        
        for ($i = 0; $i < $reviewCount; $i++) {
            $rating = rand(3, 5);
            $name = $names[array_rand($names)];
            $initials = '';
            $nameParts = explode(' ', $name);
            foreach ($nameParts as $part) {
                $initials .= strtoupper(substr($part, 0, 1));
                if (strlen($initials) >= 2) break;
            }
            
            $reviews[] = [
                'id' => $i + 1,
                'user' => [
                    'name' => $name,
                    'avatar' => null,
                    'initials' => $initials
                ],
                'rating' => $rating,
                'date' => $this->getRandomDate(),
                'title' => $this->getReviewTitle($rating),
                'content' => $reviewTexts[array_rand($reviewTexts)],
                'likes' => rand(5, 100),
                'replies' => rand(0, 15)
            ];
        }
        
        // Sort by rating (highest first)
        usort($reviews, function($a, $b) {
            return $b['rating'] <=> $a['rating'];
        });
        
        return $reviews;
    }
    
    /**
     * Generate sample recommendations for the manga
     *
     * @return array
     */
    protected function generateSampleRecommendations()
    {
        $titles = [
            'A Ascensão dos Heróis', 'Crônicas do Além', 'O Último Feiticeiro', 'Reinos em Guerra',
            'A Lenda do Dragão', 'Estrelas Caídas', 'O Código do Samurai', 'Terra de Sombras',
            'O Ceifador de Almas', 'A Princesa Guerreira', 'O Jardim das Lembranças', 'O Templo Esquecido',
            'A Maldição da Lua', 'O Clã das Sombras', 'A Jornada do Viajante', 'O Livro Proibido'
        ];
        
        $genres = [
            'Ação', 'Aventura', 'Comédia', 'Drama', 'Fantasia', 'Horror',
            'Mistério', 'Romance', 'Sci-Fi', 'Sobrenatural', 'Esportes', 'Suspense'
        ];
        
        $recommendations = [];
        $usedIndexes = [];
        $recommendationCount = 6;
        
        for ($i = 0; $i < $recommendationCount; $i++) {
            // Get a unique title
            do {
                $randomIndex = array_rand($titles);
            } while (in_array($randomIndex, $usedIndexes));
            
            $usedIndexes[] = $randomIndex;
            $title = $titles[$randomIndex];
            
            // Get 1-3 random genres
            $genreCount = rand(1, 3);
            shuffle($genres);
            $selectedGenres = array_slice($genres, 0, $genreCount);
            
            $recommendations[] = [
                'id' => $i + 1,
                'title' => $title,
                'cover_url' => 'https://via.placeholder.com/200x300?text=' . urlencode(substr($title, 0, 20)),
                'rating' => number_format(rand(65, 100) / 10, 1),
                'genres' => $selectedGenres
            ];
        }
        
        return $recommendations;
    }
    
    /**
     * Get a random review title based on rating
     *
     * @param int $rating
     * @return string
     */
    protected function getReviewTitle($rating)
    {
        if ($rating >= 4.5) {
            $titles = [
                'Obra-prima!', 'Incrível!', 'Perfeito em todos os aspectos', 'Um clássico instantâneo',
                'Simplesmente espetacular', 'Uma experiência inesquecível'
            ];
        } elseif ($rating >= 4.0) {
            $titles = [
                'Muito bom', 'Excelente leitura', 'Altamente recomendado', 'Vale cada minuto',
                'Surpreendentemente bom', 'Um dos melhores que já li'
            ];
        } elseif ($rating >= 3.0) {
            $titles = [
                'Bom, mas poderia melhorar', 'Gostei bastante', 'Vale a pena ler',
                'Interessante', 'Boa história', 'Tem potencial'
            ];
        } else {
            $titles = [
                'Não é ruim', 'Mediano', 'Nem bom, nem ruim', 'Poderia ser melhor',
                'Esperava mais', 'Decepcionante'
            ];
        }
        
        return $titles[array_rand($titles)];
    }
    
    /**
     * Get a random date string (e.g., "2 days ago", "1 week ago")
     *
     * @return string
     */
    protected function getRandomDate()
    {
        $times = [
            [1, 'hour'],
            [2, 'hours'],
            [1, 'day'],
            [2, 'days'],
            [1, 'week'],
            [2, 'weeks'],
            [1, 'month'],
            [2, 'months'],
            [3, 'months']
        ];
        
        $time = $times[array_rand($times)];
        return $time[0] . ' ' . $time[1] . ' ago';
    }
    
    /**
     * Format the published date.
     *
     * @param  string  $date
     * @return string
     */
    protected function formatPublishedDate($date)
    {
        try {
            return \Carbon\Carbon::parse($date)->format('M d, Y');
        } catch (\Exception $e) {
            return $date;
        }
    }
    

    

}
