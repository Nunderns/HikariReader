<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_nsfw',
    ];

    protected $casts = [
        'is_nsfw' => 'boolean',
    ];

    public function mangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class, 'manga_tag');
    }
}
