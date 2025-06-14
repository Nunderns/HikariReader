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
}
