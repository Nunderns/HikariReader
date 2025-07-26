<?php

namespace App\Services;

use App\Models\Manga;
use Illuminate\Support\Facades\Log;

class MangaService
{
    /**
     * Get all unique genres from mangas
     * 
     * @return \Illuminate\Support\Collection
     */
    public static function getAllGenres()
    {
        return Manga::select('id', 'genres')
            ->whereNotNull('genres')
            ->get()
            ->flatMap(function ($manga) {
                $genres = json_decode($manga->genres, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::warning("Invalid JSON in manga genres field", [
                        'manga_id' => $manga->id, 
                        'genres' => $manga->genres
                    ]);
                    return [];
                }
                return $genres ?? [];
            })
            ->unique()
            ->sort()
            ->values();
    }
}
