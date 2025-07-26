<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Genre extends Model
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
    ];

    /****
     * Defines a many-to-many relationship between the genre and mangas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The mangas associated with this genre.
     */
    public function mangas(): BelongsToMany
    {
        return $this->belongsToMany(Manga::class);
    }
}
