<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\Author;
use App\Models\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // If there are any search parameters, redirect to the manga index with the parameters
        if ($request->hasAny(['search', 'status', 'genre', 'sort'])) {
            return redirect()->route('manga.index', $request->all());
        }

        // Get featured mangas (top 5 by views in the last week)
        $featuredMangas = Manga::where('featured', true)
            ->withCount(['chapters', 'views'])
            ->take(5)
            ->get();

        // Get popular mangas (top 10 by views)
        $popularMangas = Manga::withCount(['chapters', 'views'])
            ->orderBy('views_count', 'desc')
            ->take(10)
            ->get();

        // Get recent chapters (last 15 added)
        $recentChapters = Chapter::with('manga')
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        // Get recently added mangas (last 10 added)
        $recentMangas = Manga::withCount(['chapters', 'views'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Get unique genres for the search filter
        $allGenres = Manga::select('genres')
            ->whereNotNull('genres')
            ->get()
            ->flatMap(function ($manga) {
                return json_decode($manga->genres, true) ?? [];
            })
            ->unique()
            ->sort()
            ->values();

        // Status options
        $statuses = [
            'all' => 'Todos os Status',
            'ongoing' => 'Em andamento',
            'completed' => 'Completo',
            'hiatus' => 'Em hiato',
            'cancelled' => 'Cancelado',
            'not_yet_published' => 'Não publicado'
        ];

        // Sort options
        $sortOptions = [
            'latest' => 'Mais Recentes',
            'title' => 'Título (A-Z)',
            'rating' => 'Melhor Avaliados',
            'views' => 'Mais Visualizados'
        ];

        return view('home.index', [
            'featuredMangas' => $featuredMangas,
            'popularMangas' => $popularMangas,
            'recentChapters' => $recentChapters,
            'recentMangas' => $recentMangas,
            'allGenres' => $allGenres,
            'statuses' => $statuses,
            'sortOptions' => $sortOptions,
            'sortBy' => 'latest',
            'mangas' => collect([]) // Empty collection for the search results section
        ]);
    }

    /**
     * Show the advanced search page.
     *
     * @return \Illuminate\View\View
     */
    public function advancedSearch()
    {
        // Get data for filters
        $authors = Author::orderBy('name')->get();
        $artists = Author::where('is_artist', true)->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();
        
        // Generate years for publication year filter
        $currentYear = date('Y');
        $years = range($currentYear, 1950);
        
        return view('advanced-search', [
            'authors' => $authors,
            'artists' => $artists,
            'tags' => $tags,
            'years' => $years
        ]);
    }

    /**
     * Show the latest updates page.
     *
     * @return \Illuminate\View\View
     */
    public function latestUpdates()
    {
        // Get the latest 50 chapters with their manga, ordered by release date
        $chapters = Chapter::with(['manga' => function($query) {
            $query->withCount('chapters');
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(20);
        
        // Group chapters by manga for the manga list
        $mangas = Manga::with(['chapters' => function($query) {
            $query->orderBy('chapter_number', 'desc');
        }])
        ->withCount('chapters')
        ->orderBy('updated_at', 'desc')
        ->take(10)
        ->get();
        
        return view('latest-updates', [
            'chapters' => $chapters,
            'mangas' => $mangas,
            'title' => 'Últimas Atualizações'
        ]);
    }
    
    /**
     * Show recently added mangas.
     *
     * @return \Illuminate\View\View
     */
    /**
     * Show the about us page.
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return view('home.about', [
            'title' => 'Sobre Nós - Hikari Reader'
        ]);
    }
    
    /**
     * Show the terms and policies page.
     *
     * @return \Illuminate\View\View
     */
    public function terms()
    {
        return view('terms');
    }
    
    /**
     * Show recently added mangas.
     *
     * @return \Illuminate\View\View
     */
    public function recentAdditions()
    {
        // Get recently added mangas with pagination
        $mangas = Manga::with(['chapters' => function($query) {
                $query->orderBy('chapter_number', 'desc');
            }])
            ->withCount('chapters')
            ->with('genres')
            ->orderBy('created_at', 'desc')
            ->paginate(24);
            
        // Get latest chapters for the sidebar
        $latestChapters = Chapter::with('manga')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Get popular tags
        $popularTags = \App\Models\Tag::withCount('mangas')
            ->orderBy('mangas_count', 'desc')
            ->take(15)
            ->get();
        
        return view('manga.recent-additions', [
            'mangas' => $mangas,
            'latestChapters' => $latestChapters,
            'popularTags' => $popularTags,
            'title' => 'Mangás Adicionados Recentemente'
        ]);
    }
}
