<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\User;
use App\Models\Artist;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $stats = [
            'total_mangas' => Manga::count(),
            'total_users' => User::count(),
            'total_artists' => Artist::count(),
            'recent_mangas' => Manga::latest()->take(5)->get(),
            'recent_users' => User::latest()->take(5)->get(),
            'mangas_by_status' => Manga::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status')
                ->toArray(),
        ];

        // Passa as contagens para a visualização
        $counts = [
            'mangas' => $stats['total_mangas'],
            'users' => $stats['total_users'],
            'authors' => \App\Models\Author::count(),
            'genres' => \App\Models\Genre::count(),
        ];

        return view('admin.dashboard.index', compact('stats', 'counts'));
    }
}
