<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Manga extends Model
{
    protected $fillable = [
        'title',
        'description',
        'thumbnail_url',
        'author',
        'featured',
        'status'
    ];

    protected $casts = [
        'featured' => 'boolean',
        'status' => 'string'
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
     * The artists that belong to the manga.
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Author::class, 'manga_author')
            ->wherePivot('role', 'artist')
            ->withTimestamps();
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
