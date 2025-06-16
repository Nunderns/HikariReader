<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
        'manga_id',
        'title',
        'number',
        'pages',
        'status'
    ];

    protected $casts = [
        'number' => 'integer',
        'status' => 'string'
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    public function pages()
    {
        return $this->hasMany(Page::class)->orderBy('number', 'asc');
    }
}
