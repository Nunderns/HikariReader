<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('manga_genre');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is intentionally left blank as we don't want to recreate the table
        // in case of rollback, as the original migration will handle that
    }
};
