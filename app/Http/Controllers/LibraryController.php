<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\LibraryEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    /**
     * Exibe a página da biblioteca do usuário
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('library.guest');
        }

        $user = Auth::user();
        $status = request()->input('status', 'all');
        $search = request()->input('search', '');
        $sort = request()->input('sort', 'recent');

        // Query base para os mangás da biblioteca do usuário
        $query = $user->libraryEntries()
            ->with(['manga.genres', 'manga.chapters']);

        // Aplicar filtro de status
        if (in_array($status, ['reading', 'completed', 'on_hold', 'dropped', 'plan_to_read', 'rereading'])) {
            $query->where('status', $status);
        }

        // Aplicar busca
        if (!empty($search)) {
            $query->whereHas('manga', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('alt_titles', 'like', "%{$search}%");
            });
        }

        // Aplicar ordenação
        switch ($sort) {
            case 'title':
                $query->orderBy(
                    Manga::select('title')
                        ->whereColumn('mangas.id', 'library_entries.manga_id')
                );
                break;
            case 'score':
                $query->orderBy('score', 'desc');
                break;
            case 'chapters':
                $query->orderBy('chapters_read', 'desc');
                break;
            case 'updated':
                $query->latest('updated_at');
                break;
            default: // recent
                $query->latest('library_entries.created_at');
        }

        // Paginar resultados
        $mangas = $query->paginate(20)->appends(request()->query());

        // Contagem de mangás por status
        $statusCounts = [
            'all' => $user->libraryEntries()->count(),
            'reading' => $user->libraryEntries()->where('status', 'reading')->count(),
            'completed' => $user->libraryEntries()->where('status', 'completed')->count(),
            'on_hold' => $user->libraryEntries()->where('status', 'on_hold')->count(),
            'dropped' => $user->libraryEntries()->where('status', 'dropped')->count(),
            'plan_to_read' => $user->libraryEntries()->where('status', 'plan_to_read')->count(),
            'rereading' => $user->libraryEntries()->where('status', 'rereading')->count(),
        ];

        // Se for uma requisição AJAX, retorna JSON
        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => $mangas,
                'status_counts' => $statusCounts
            ]);
        }

        return view('library.index', [
            'mangas' => $mangas,
            'status' => $status,
            'search' => $search,
            'sort' => $sort,
            'statusCounts' => $statusCounts,
            'totalMangas' => $statusCounts['all']
        ]);
    }
    
    /**
     * Atualiza o modo de visualização da biblioteca do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateViewMode(Request $request)
    {
        $request->validate([
            'view_mode' => 'required|in:card,compact,detailed'
        ]);

        if (Auth::check()) {
            $user = Auth::user();
            $user->settings = array_merge((array) $user->settings, [
                'library_view' => $request->view_mode
            ]);
            $user->save();
        }

        // Salva também na sessão para usuários não autenticados
        session(['library_view' => $request->view_mode]);

        return response()->json([
            'success' => true,
            'view_mode' => $request->view_mode
        ]);
    }

    /**
     * Atualiza o status de leitura de um mangá na biblioteca do usuário.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $mangaId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Request $request, $mangaId)
    {
        $request->validate([
            'status' => 'required|in:reading,completed,on_hold,dropped,plan_to_read,rereading,remove'
        ]);

        $user = Auth::user();
        $manga = Manga::findOrFail($mangaId);

        if ($request->status === 'remove') {
            $user->libraryEntries()->where('manga_id', $manga->id)->delete();
            
            return response()->json([
                'success' => true,
                'action' => 'removed',
                'message' => 'Mangá removido da sua biblioteca.'
            ]);
        }

        $libraryEntry = $user->libraryEntries()->updateOrCreate(
            ['manga_id' => $manga->id],
            ['status' => $request->status]
        );

        return response()->json([
            'success' => true,
            'action' => 'updated',
            'entry' => $libraryEntry,
            'message' => 'Status atualizado com sucesso!'
        ]);
    }
    
    /**
     * Adiciona um mangá à biblioteca do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'manga_id' => 'required|exists:mangas,id'
        ]);
        
        try {
            DB::beginTransaction();
            
            // Verifica se o mangá já está na biblioteca do usuário
            $exists = Auth::user()->libraryEntries()
                ->where('manga_id', $request->manga_id)
                ->exists();
                
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Este mangá já está na sua biblioteca.'
                ], 422);
            }
            
            // Adiciona o mangá à biblioteca usando o método do modelo User
            $entry = Auth::user()->addToLibrary($request->manga_id, 'reading');
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Mangá adicionado à sua biblioteca com sucesso!',
                'data' => [
                    'entry_id' => $entry->id,
                    'manga_id' => $entry->manga_id,
                    'status' => $entry->status,
                    'is_favorite' => $entry->is_favorite
                ]
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Erro ao adicionar mangá à biblioteca: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Ocorreu um erro ao adicionar o mangá à sua biblioteca.'
            ], 500);
        }
    }
    
    /**
     * Remove um mangá da biblioteca do usuário
     *
     * @param  int  $id ID do mangá
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $removed = Auth::user()->removeFromLibrary($id);
            
            if (!$removed) {
                throw new \Exception('Falha ao remover o mangá da biblioteca.');
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Mangá removido da sua biblioteca com sucesso!'
            ]);
            
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mangá não encontrado na sua biblioteca.'
            ], 404);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao remover mangá da biblioteca: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
