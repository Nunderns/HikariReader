<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drops the 'manga_genre' table from the database if it exists.
     */
    public function up(): void
    {
        Schema::dropIfExists('manga_genre');
    }

    /**
     * Leaves the migration rollback empty, intentionally not recreating the dropped table.
     */
    public function down(): void
    {
        // This is intentionally left blank as we don't want to recreate the table
        // in case of rollback, as the original migration will handle that
    }
};
