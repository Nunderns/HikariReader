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
        Schema::create('library_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('manga_id')->constrained()->onDelete('cascade');
            
            // Status: reading, completed, on_hold, dropped, plan_to_read
            $table->enum('status', ['reading', 'completed', 'on_hold', 'dropped', 'plan_to_read'])->default('reading');
            
            // Último capítulo lido (pode ser decimal para capítulos como 10.5)
            $table->float('last_chapter_read', 8, 1)->default(0);
            
            // Avaliação do usuário (0-10)
            $table->float('rating', 3, 1)->nullable();
            
            // Notas privadas do usuário
            $table->text('notes')->nullable();
            
            // Se o mangá é favorito
            $table->boolean('is_favorite')->default(false);
            
            // Contador de releituras
            $table->unsignedInteger('reread_count')->default(0);
            
            // Notas privadas
            $table->text('private_notes')->nullable();
            
            // Datas importantes
            $table->dateTime('started_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            
            // Índices
            $table->unique(['user_id', 'manga_id']);
            $table->index(['user_id', 'status']);
            $table->index(['manga_id']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('library_entries');
    }
};
