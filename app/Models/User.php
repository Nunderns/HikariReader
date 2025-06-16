<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'settings' => 'array',
        ];
    }

    /**
     * Obtém as entradas da biblioteca do usuário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function libraryEntries(): HasMany
    {
        return $this->hasMany(LibraryEntry::class);
    }

    /**
     * Verifica se um mangá específico está na biblioteca do usuário.
     *
     * @param int $mangaId
     * @return bool
     */
    public function hasInLibrary(int $mangaId): bool
    {
        return $this->libraryEntries()->where('manga_id', $mangaId)->exists();
    }
    
    /**
     * Obtém a entrada de um mangá específico na biblioteca do usuário.
     *
     * @param int $mangaId
     * @return LibraryEntry|null
     */
    public function getLibraryEntry(int $mangaId): ?LibraryEntry
    {
        return $this->libraryEntries()->where('manga_id', $mangaId)->first();
    }
    
    /**
     * Adiciona um mangá à biblioteca do usuário.
     *
     * @param int $mangaId
     * @param string $status
     * @return LibraryEntry
     */
    public function addToLibrary(int $mangaId, string $status = 'reading'): LibraryEntry
    {
        return $this->libraryEntries()->updateOrCreate(
            ['manga_id' => $mangaId],
            ['status' => $status]
        );
    }
    
    /**
     * Remove um mangá da biblioteca do usuário.
     *
     * @param int $mangaId
     * @return bool
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function removeFromLibrary(int $mangaId): bool
    {
        $entry = $this->libraryEntries()
            ->where('manga_id', $mangaId)
            ->firstOrFail();
            
        return (bool) $entry->delete();
    }
    
    /**
     * Atualiza o status de um mangá na biblioteca do usuário.
     *
     * @param int $mangaId
     * @param string $status
     * @return LibraryEntry
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function updateLibraryStatus(int $mangaId, string $status): LibraryEntry
    {
        $entry = $this->libraryEntries()
            ->where('manga_id', $mangaId)
            ->firstOrFail();
            
        $entry->update(['status' => $status]);
        
        return $entry->fresh();
    }
    
    /**
     * Marca um capítulo como lido para um mangá na biblioteca do usuário.
     *
     * @param int $mangaId
     * @param int $chapterNumber
     * @return LibraryEntry
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function markChapterRead(int $mangaId, int $chapterNumber): LibraryEntry
    {
        $entry = $this->libraryEntries()
            ->where('manga_id', $mangaId)
            ->firstOrFail();
            
        // Atualiza o último capítulo lido se for maior que o atual
        if ($chapterNumber > $entry->last_chapter_read) {
            $entry->update(['last_chapter_read' => $chapterNumber]);
        }
        
        return $entry->fresh();
    }
    
    /**
     * Alterna o status de favorito para um mangá na biblioteca do usuário.
     *
     * @param int $mangaId
     * @return LibraryEntry
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function toggleFavorite(int $mangaId): LibraryEntry
    {
        $entry = $this->libraryEntries()
            ->where('manga_id', $mangaId)
            ->firstOrFail();
            
        $entry->update(['is_favorite' => !$entry->is_favorite]);
        
        return $entry->fresh();
    }
    
    /**
     * Adiciona ou atualiza uma avaliação para um mangá na biblioteca do usuário.
     *
     * @param int $mangaId
     * @param float $rating
     * @param string|null $notes
     * @return LibraryEntry
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function rateManga(int $mangaId, float $rating, ?string $notes = null): LibraryEntry
    {
        $entry = $this->libraryEntries()
            ->where('manga_id', $mangaId)
            ->firstOrFail();
            
        $entry->update([
            'rating' => $rating,
            'notes' => $notes
        ]);
        
        return $entry->fresh();
    }
}
