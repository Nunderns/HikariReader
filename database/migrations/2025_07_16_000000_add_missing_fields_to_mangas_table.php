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
            $table->string('english_title')->nullable()->after('title');
            $table->string('artist')->nullable()->after('author');
            $table->string('demographic')->nullable()->after('status');
            $table->string('serialization')->nullable()->after('demographic');
            $table->dateTime('published_date')->nullable()->after('serialization');
            $table->json('themes')->nullable()->after('published_date');
            $table->json('alt_titles')->nullable()->after('themes');
            $table->string('cover_url')->nullable()->after('thumbnail_url');
            $table->boolean('is_adult')->default(false)->after('alt_titles');
            $table->boolean('is_suggestive')->default(false)->after('is_adult');
            $table->json('genres')->nullable()->after('is_suggestive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mangas', function (Blueprint $table) {
            $table->dropColumn([
                'english_title',
                'artist',
                'demographic',
                'serialization',
                'published_date',
                'themes',
                'alt_titles',
                'cover_url',
                'is_adult',
                'is_suggestive',
                'genres'
            ]);
        });
    }
};
