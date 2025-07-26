<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Creates the `genres` table and the `manga_genre` pivot table for managing genres and their association with mangas.
     *
     * Defines columns, indexes, foreign key constraints, and uniqueness rules to ensure data integrity and efficient querying.
     */
    public function up(): void
    {
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index('name');
            $table->index('slug');
        });
        
        // Create the pivot table for the many-to-many relationship with mangas
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
     * Drops the `manga_genre` and `genres` tables, reversing the migration changes.
     */
    public function down(): void
    {
        Schema::dropIfExists('manga_genre');
        Schema::dropIfExists('genres');
    }
};
