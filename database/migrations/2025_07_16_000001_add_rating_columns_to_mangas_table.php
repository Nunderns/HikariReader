<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->decimal('rating', 3, 1)->default(0)->after('published_date');
            $table->integer('rating_count')->default(0)->after('rating');
            $table->integer('view_count')->default(0)->after('rating_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->dropColumn(['rating', 'rating_count', 'view_count']);
        });
    }
};
