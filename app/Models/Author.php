<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'biography',
        'is_artist',
        'is_writer',
        'birth_date',
        'website',
        'twitter',
    ];

    protected $casts = [
        'is_artist' => 'boolean',
        'is_writer' => 'boolean',
        'birth_date' => 'date',
    ];

    public function mangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class, 'manga_author');
    }

    public function writtenMangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class, 'manga_author')
            ->wherePivot('role', 'writer');
    }

    public function illustratedMangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class, 'manga_author')
            ->wherePivot('role', 'artist');
    }
}
