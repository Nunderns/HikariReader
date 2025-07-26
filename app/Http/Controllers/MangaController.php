<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recentMangas = Manga::withCount('chapters')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $popularMangas = Manga::withCount('chapters')
            ->orderBy('views', 'desc')
            ->take(10)
            ->get();

        return view('home', [
            'recentMangas' => $recentMangas,
            'popularMangas' => $popularMangas,
        ]);
    }

    /**
     * Display search results.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = Manga::query()
            ->withCount(['chapters', 'views'])
            ->search($request->q)
            ->byStatus($request->status)
            ->byGenre($request->genre)
            ->orderBySort($request->input('sort', 'latest'));

        $mangas = $query->paginate(24);

        // Get all available genres for the filter dropdown
        $allGenres = Manga::select('genres')
            ->whereNotNull('genres')
            ->get()
            ->flatMap(function ($manga) {
                return $manga->genres ?? [];
            })
            ->unique()
            ->sort()
            ->values();

        // Status options
        $statuses = [
            'all' => 'Todos',
            'ongoing' => 'Em Andamento',
            'completed' => 'Completo',
            'hiatus' => 'Em Hiato',
            'cancelled' => 'Cancelado'
        ];

        // Sort options
        $sortOptions = [
            'latest' => 'Mais Recentes',
            'oldest' => 'Mais Antigos',
            'title-asc' => 'Título (A-Z)',
            'title-desc' => 'Título (Z-A)',
            'views-desc' => 'Mais Visualizados',
            'rating-desc' => 'Melhor Avaliados',
            'chapters-desc' => 'Mais Capítulos',
        ];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.manga-grid', [
                    'mangas' => $mangas,
                    'allGenres' => $allGenres,
                    'statuses' => $statuses,
                    'sortOptions' => $sortOptions,
                ])->render(),
            ]);
        }

        return view('manga.search', [
            'mangas' => $mangas,
            'allGenres' => $allGenres,
            'statuses' => $statuses,
            'sortOptions' => $sortOptions,
        ]);
    }

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

        // Ensure genres and themes are arrays
        $genres = is_string($manga->genres) ? json_decode($manga->genres, true) : ($manga->genres ?: []);
        $themes = is_string($manga->themes) ? json_decode($manga->themes, true) : ($manga->themes ?: []);
        
        // Get recommended manga
        $recommendedManga = $this->getRecommendedManga($manga);
        
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
            'genres' => is_array($genres) ? $genres : [],
            'themes' => is_array($themes) ? $themes : [],
            'demographic' => $manga->demographic ?? 'Seinen',
            'serialization' => $manga->serialization ?? 'Weekly Shonen Jump',
            'chapters' => $this->formatChapters($manga->chapters),
            'rating_distribution' => $this->generateRatingDistribution($manga->rating ?? 0, $manga->rating_count ?? 0),
            'recommended_manga' => $recommendedManga,
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
        
        // If chapters is a Collection, convert to array
        $chaptersArray = $chapters instanceof \Illuminate\Database\Eloquent\Collection 
            ? $chapters->toArray() 
            : (is_array($chapters) ? $chapters : []);
        
        // Process each chapter to ensure all required fields exist
        $formattedChapters = array_map(function($chapter) {
            // Handle both object and array access
            $id = is_array($chapter) ? ($chapter['id'] ?? null) : ($chapter->id ?? null);
            $number = is_array($chapter) ? ($chapter['number'] ?? 0) : ($chapter->number ?? 0);
            $title = is_array($chapter) ? ($chapter['title'] ?? 'Sem título') : ($chapter->title ?? 'Sem título');
            $volume = is_array($chapter) ? ($chapter['volume'] ?? null) : ($chapter->volume ?? null);
            $pages = is_array($chapter) ? ($chapter['pages'] ?? 0) : ($chapter->pages ?? 0);
            $createdAt = is_array($chapter) 
                ? (isset($chapter['created_at']) ? (is_string($chapter['created_at']) ? \Carbon\Carbon::parse($chapter['created_at']) : $chapter['created_at']) : now())
                : ($chapter->created_at ?? now());
            
            return [
                'id' => $id,
                'number' => (float)$number,
                'title' => $title,
                'volume' => $volume ? (int)$volume : null,
                'pages' => (int)$pages,
                'date' => $createdAt->diffForHumans(),
                'url' => route('chapter.show', ['id' => $id])
            ];
        }, $chaptersArray);
        
        // Sort chapters by number in descending order
        usort($formattedChapters, function($a, $b) {
            return $b['number'] <=> $a['number']; // Sort by number in descending order
        });
        
        return $formattedChapters;
    }
    
    /**
     * Get recommended manga based on genres and themes
     *
     * @param Manga $currentManga
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    protected function getRecommendedManga($currentManga, $limit = 6)
    {
        // Get current manga's genres and themes
        $currentGenres = is_array($currentManga->genres) ? $currentManga->genres : [];
        $currentThemes = is_array($currentManga->themes) ? $currentManga->themes : [];
        
        if (empty($currentGenres) && empty($currentThemes)) {
            // If no genres or themes, return popular manga
            return Manga::where('id', '!=', $currentManga->id)
                ->orderBy('view_count', 'desc')
                ->limit($limit)
                ->get();
        }
        
        // Search for manga with similar genres or themes
        return Manga::where('id', '!=', $currentManga->id)
            ->where(function($query) use ($currentGenres, $currentThemes) {
                if (!empty($currentGenres)) {
                    $query->whereJsonContains('genres', $currentGenres[0]);
                    
                    for ($i = 1; $i < min(count($currentGenres), 3); $i++) {
                        $query->orWhereJsonContains('genres', $currentGenres[$i]);
                    }
                }
                
                if (!empty($currentThemes)) {
                    if (empty($currentGenres)) {
                        $query->orWhereJsonContains('themes', $currentThemes[0]);
                    } else {
                        $query->orWhereJsonContains('themes', $currentThemes[0]);
                    }
                    
                    for ($i = 1; $i < min(count($currentThemes), 2); $i++) {
                        $query->orWhereJsonContains('themes', $currentThemes[$i]);
                    }
                }
            })
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
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
        // Return empty array as we don't want to show any sample reviews
        return [];
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
