<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'manga_id',
        'user_id',
        'chapter_id',
        'page_number'
    ];

    protected $casts = [
        'page_number' => 'integer'
    ];

    public function manga()
    {
        return $this->belongsTo(Manga::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class);
    }
}
