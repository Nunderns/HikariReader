<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Recreates the `manga_genre` pivot table with foreign key constraints and a unique manga-genre pairing.
     *
     * Drops the existing `manga_genre` table if it exists, then creates a new table with an auto-incrementing primary key, foreign keys to the `manga` and `genre` tables (with cascading deletes), timestamp columns, and a unique constraint to prevent duplicate manga-genre associations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('manga_genre');
        
        // Create the table with the correct structure
        Schema::create('manga_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            // Ensure each manga can only have one entry per genre
            $table->unique(['manga_id', 'genre_id']);
        });
    }

    /**
     * Drops the `manga_genre` table, reversing the migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('manga_genre');
    }
};
