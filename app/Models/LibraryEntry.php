<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryEntry extends Model
{
    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'manga_id',
        'status',
        'last_chapter_read',
        'rating',
        'notes',
        'is_favorite',
        'reread_count',
        'private_notes',
        'started_at',
        'finished_at',
    ];

    /**
     * Os atributos que devem ser convertidos para tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'is_favorite' => 'boolean',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'reread_count' => 'integer',
        'last_chapter_read' => 'float',
        'rating' => 'float',
    ];

    /**
     * Os atributos que devem ser convertidos para datas.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
        'finished_at',
        'created_at',
        'updated_at',
    ];

    /**
     * Obtém o usuário dono desta entrada na biblioteca.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtém o mangá associado a esta entrada na biblioteca.
     */
    public function manga(): BelongsTo
    {
        return $this->belongsTo(Manga::class);
    }

    /**
     * Escopo para filtrar entradas por status.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Escopo para filtrar entradas favoritas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFavorite($query)
    {
        return $query->where('is_favorite', true);
    }

    /**
     * Marca o mangá como favorito ou remove a marcação.
     *
     * @param bool $favorite
     * @return bool
     */
    public function setFavorite(bool $favorite = true): bool
    {
        $this->is_favorite = $favorite;
        return $this->save();
    }

    /**
     * Atualiza o último capítulo lido.
     *
     * @param float $chapterNumber
     * @return bool
     */
    public function updateLastChapterRead(float $chapterNumber): bool
    {
        // Se o capítulo for maior que o atual ou for 0 (marcar como não lido)
        if ($chapterNumber > $this->last_chapter_read || $chapterNumber == 0) {
            $this->last_chapter_read = $chapterNumber;
            
            // Se for o primeiro capítulo, marca como começado
            if ($chapterNumber > 0 && !$this->started_at) {
                $this->started_at = now();
            }
            
            return $this->save();
        }
        
        return false;
    }

    /**
     * Atualiza o status da leitura.
     *
     * @param string $status
     * @return bool
     */
    public function updateStatus(string $status): bool
    {
        $validStatuses = ['reading', 'completed', 'on_hold', 'dropped', 'plan_to_read'];
        
        if (in_array($status, $validStatuses)) {
            $this->status = $status;
            
            // Se foi marcado como concluído, atualiza a data de conclusão
            if ($status === 'completed' && !$this->finished_at) {
                $this->finished_at = now();
            }
            
            return $this->save();
        }
        
        return false;
    }
}
