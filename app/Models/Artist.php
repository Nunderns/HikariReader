<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Artist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'website',
        'twitter',
        'pixiv',
        'other_links',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'other_links' => 'array',
    ];

    /**
     * Get all of the mangas for the artist.
     */
    public function mangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class);
    }
}
