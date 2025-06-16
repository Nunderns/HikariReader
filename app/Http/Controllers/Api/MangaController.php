<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MangaController extends Controller
{
    /**
     * Busca mangás por título
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        try {
            $query = $request->input('q', '');
            
            if (empty($query)) {
                return response()->json([]);
            }
            
            $mangas = Manga::query()
                ->where('title', 'LIKE', "%{$query}%")
                ->orWhere('alt_titles', 'LIKE', "%{$query}%")
                ->select(['id', 'title', 'cover_url', 'author'])
                ->limit(10)
                ->get()
                ->map(function ($manga) {
                    return [
                        'id' => $manga->id,
                        'title' => $manga->title,
                        'cover_url' => $manga->cover_url,
                        'author' => $manga->author,
                        'is_new' => $manga->created_at->gt(now()->subDays(7)), // Considera como novo se foi adicionado nos últimos 7 dias
                    ];
                });
            
            return response()->json($mangas);
            
        } catch (\Exception $e) {
            Log::error('Erro ao buscar mangás: ' . $e->getMessage());
            return response()->json(['error' => 'Erro ao buscar mangás'], 500);
        }
    }
}
