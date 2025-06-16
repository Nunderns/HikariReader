<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
