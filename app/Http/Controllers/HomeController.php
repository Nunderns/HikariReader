<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Manga;
use App\Models\Chapter;

class HomeController extends Controller
{
    public function index()
    {
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

        return view('home.index', [
            'featuredMangas' => $featuredMangas,
            'popularMangas' => $popularMangas,
            'recentChapters' => $recentChapters,
            'recentMangas' => $recentMangas
        ]);
    }
}
