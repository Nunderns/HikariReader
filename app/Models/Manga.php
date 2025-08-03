<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manga extends Model
{
    protected $fillable = [
        'title',
        'english_title',
        'description',
        'cover_url',
        'thumbnail_url',
        'author',
        'artist',
        'status',
        'published_date',
        'rating',
        'rating_count',
        'view_count',
        'is_adult',
        'is_suggestive',
        'featured',
        'alt_titles',
        'genres',
        'themes',
        'demographic',
        'serialization'
    ];
    
    /**
     * Defines a many-to-many relationship between the manga and its genres.
     *
     * @return BelongsToMany The relationship instance for genres associated with the manga.
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'thumbnail_url' => '/images/default-thumbnail.jpg',
        'cover_url' => '/images/default-cover.jpg',
        'is_adult' => false,
        'is_suggestive' => false,
        'featured' => false
    ];

    protected $casts = [
        'featured' => 'boolean',
        'is_adult' => 'boolean',
        'is_suggestive' => 'boolean',
        'published_date' => 'date',
        'rating' => 'float',
        'rating_count' => 'integer',
        'view_count' => 'integer',
        'alt_titles' => 'array',
        'genres' => 'array',
        'themes' => 'array'
    ];

    public function chapters()
    {
        return $this->hasMany(Chapter::class)->orderBy('number', 'asc');
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }
    
    /**
     * Obtém as entradas da biblioteca associadas a este mangá.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function libraryEntries(): HasMany
    {
        return $this->hasMany(LibraryEntry::class);
    }
    
    /**
     * The authors that belong to the manga.
     */
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'manga_author')
            ->wherePivot('role', 'writer')
            ->withTimestamps();
    }
    
    /**
     * Returns the artists associated with the manga.
     *
     * Defines a many-to-many relationship with the Author model, filtered to include only those with the 'artist' role.
     *
     * @return BelongsToMany
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'manga_author')
            ->wherePivot('role', 'artist')
            ->withTimestamps();
    }
    
    /**
     * Filters the query to include mangas matching the search term in the title, English title, author, or artist fields.
     *
     * @param string|null $search The search term to match against manga attributes.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder.
     */
    public function scopeSearch($query, $search = null)
    {
        if (!$search) {
            return $query;
        }
        
        return $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('english_title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%")
              ->orWhere('artist', 'like', "%{$search}%");
        });
    }
    
    /****
     * Filters the query to include only mangas with the specified status.
     *
     * If the status is null or 'all', no filtering is applied.
     *
     * @param string|null $status The status to filter by, or null/'all' for no filtering.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByStatus($query, $status = null)
    {
        if (!$status || $status === 'all') {
            return $query;
        }
        
        return $query->where('status', $status);
    }
    
    /**
     * Filters the query to include only mangas that contain the specified genre in their genres attribute.
     *
     * @param string|null $genre The genre to filter by, or null/'all' to disable filtering.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGenre($query, $genre = null)
    {
        if (!$genre || $genre === 'all') {
            return $query;
        }
        
        return $query->whereJsonContains('genres', $genre);
    }
    
    /**
     * Applies ordering to the manga query based on the specified sort option.
     *
     * Supported sort options are 'title' (ascending), 'rating' (descending), 'views' (descending), and 'latest' (most recently created or updated).
     *
     * @param string $sortBy The field to sort by: 'title', 'rating', 'views', or 'latest'.
     * @return \Illuminate\Database\Eloquent\Builder The modified query builder.
     */
    public function scopeOrderBySort($query, $sortBy = 'latest')
    {
        switch ($sortBy) {
            case 'title':
                return $query->orderBy('title', 'asc');
            case 'rating':
                return $query->orderBy('rating', 'desc');
            case 'views':
                return $query->orderBy('view_count', 'desc');
            case 'latest':
            default:
                return $query->latest();
        }
    }
    

    
    /**
     * The tags that belong to the manga.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'manga_tag')
            ->withTimestamps();
    }
    
    /**
     * Verifica se um usuário específico tem este mangá em sua biblioteca.
     *
     * @param int $userId
     * @return bool
     */
    public function isInUserLibrary(int $userId): bool
    {
        return $this->libraryEntries()->where('user_id', $userId)->exists();
    }
    
    /**
     * Obtém a entrada da biblioteca para um usuário específico.
     *
     * @param int $userId
     * @return \App\Models\LibraryEntry|null
     */
    public function getUserLibraryEntry(int $userId): ?LibraryEntry
    {
        return $this->libraryEntries()->where('user_id', $userId)->first();
    }
}
