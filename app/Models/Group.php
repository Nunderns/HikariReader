<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name',
        'description',
        'slug',
        'avatar_url',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('role');
    }

    public function mangas()
    {
        return $this->belongsToMany(Manga::class);
    }

    public function chapters()
    {
        return $this->hasMany(Chapter::class);
    }
}
