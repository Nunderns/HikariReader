<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Seeds the database with a predefined list of genres, ensuring each genre is created only once based on its slug.
     */
    public function run(): void
    {
        $genres = [
            ['name' => 'Ação', 'slug' => 'acao'],
            ['name' => 'Aventura', 'slug' => 'aventura'],
            ['name' => 'Comédia', 'slug' => 'comedia'],
            ['name' => 'Drama', 'slug' => 'drama'],
            ['name' => 'Fantasia', 'slug' => 'fantasia'],
            ['name' => 'Ficção Científica', 'slug' => 'ficcao-cientifica'],
            ['name' => 'Harém', 'slug' => 'harem'],
            ['name' => 'Histórico', 'slug' => 'historico'],
            ['name' => 'Horror', 'slug' => 'horror'],
            ['name' => 'Mistério', 'slug' => 'misterio'],
            ['name' => 'Psicológico', 'slug' => 'psicologico'],
            ['name' => 'Romance', 'slug' => 'romance'],
            ['name' => 'Seinen', 'slug' => 'seinen'],
            ['name' => 'Shoujo', 'slug' => 'shoujo'],
            ['name' => 'Shounen', 'slug' => 'shounen'],
            ['name' => 'Sobrenatural', 'slug' => 'sobrenatural'],
            ['name' => 'Esportes', 'slug' => 'esportes'],
            ['name' => 'Vida Escolar', 'slug' => 'vida-escolar'],
            ['name' => 'Slice of Life', 'slug' => 'slice-of-life'],
            ['name' => 'Sobrevivência', 'slug' => 'sobrevivencia'],
        ];

        foreach ($genres as $genre) {
            Genre::firstOrCreate(
                ['slug' => $genre['slug']],
                ['name' => $genre['name']]
            );
        }
    }
}
