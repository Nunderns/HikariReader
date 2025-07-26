<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Manga;
use App\Models\Chapter;
use App\Models\User;
use App\Models\Genre;
use Illuminate\Support\Facades\Cache;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('admin.layouts.app', function ($view) {
            $counts = Cache::remember('admin.sidebar.counts', now()->addHours(6), function () {
                return [
                    'mangas' => Manga::count(),
                    'chapters' => Chapter::count(),
                    'genres' => Genre::count(),
                    'users' => User::count(),
                ];
            });

            $view->with('counts', $counts);
        });
    }
}
