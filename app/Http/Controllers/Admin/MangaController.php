<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use App\Models\User;
use App\Notifications\MangaNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;

class MangaController extends Controller
{
    /**
     * Retrieves a paginated list of mangas with optional filtering by search term, status, and genre.
     *
     * Passes the filtered mangas, available genres, and status options to the admin manga index view.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Manga::query();
        
        // Apply search
        if ($request->has('search')) {
            $query->search($request->search);
        }
        
        // Apply status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }
        
        // Apply genre filter
        if ($request->has('genre') && $request->genre !== 'all') {
            $query->byGenre($request->genre);
        }
        
        $mangas = $query->latest()->paginate(15)->withQueryString();
        
        // Get genres from the genres table
        $allGenres = \App\Models\Genre::orderBy('name')->pluck('name');
            
        // Status options
        $statuses = [
            'all' => 'Todos os Status',
            'ongoing' => 'Em andamento',
            'completed' => 'Completo',
            'hiatus' => 'Em hiato',
            'cancelled' => 'Cancelado',
            'not_yet_published' => 'Não publicado'
        ];
        
        return view('admin.mangas.index', compact('mangas', 'allGenres', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.mangas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Prepare themes, converting comma-separated string to array
        if ($request->has('themes') && is_string($request->themes)) {
            $themes = array_filter(array_map('trim', explode(',', $request->themes)));
            $request->merge(['themes' => $themes]);
        }

        // Prepare alt_titles, converting newline-separated string to array
        if ($request->has('alt_titles') && is_string($request->alt_titles)) {
            $alt_titles = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $request->alt_titles)));
            $request->merge(['alt_titles' => $alt_titles]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'english_title' => 'nullable|string|max:255',
            'author' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:ongoing,completed,hiatus,cancelled,not_yet_published',
            'demographic' => 'nullable|string|max:100',
            'serialization' => 'nullable|string|max:100',
            'published_date' => 'nullable|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_adult' => 'boolean',
            'is_suggestive' => 'boolean',
            'genres' => 'nullable|array',
            'themes' => 'nullable|array',
            'alt_titles' => 'nullable|array',
        ]);

        // Handle file upload
        if ($request->hasFile('cover')) {
            $path = $request->file('cover')->store('public/manga_covers');
            $validated['cover_url'] = Storage::url($path);
        } else {
            $validated['cover_url'] = 'images/default-cover.jpg';
        }
        
        // Set default thumbnail if not provided
        if (!isset($validated['thumbnail_url'])) {
            $validated['thumbnail_url'] = $validated['cover_url'];
        }

        // Convert arrays to JSON
        if (isset($validated['genres'])) {
            $validated['genres'] = json_encode($validated['genres']);
        }
        if (isset($validated['themes'])) {
            $validated['themes'] = json_encode($validated['themes']);
        }
        if (isset($validated['alt_titles'])) {
            $validated['alt_titles'] = json_encode($validated['alt_titles']);
        }

        // Create slug
        $validated['slug'] = Str::slug($validated['title']);
        
        // Remove fields that don't exist in the database yet
        $fieldsToRemove = ['rating', 'rating_count', 'view_count'];
        foreach ($fieldsToRemove as $field) {
            if (array_key_exists($field, $validated)) {
                unset($validated[$field]);
            }
        }

        // Create manga
        $manga = Manga::create($validated);
        
        // Send notification to all admins except the one who created the manga
        $admins = User::where('is_admin', true)
            ->where('id', '!=', auth()->id())
            ->get();
            
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new MangaNotification($manga, 'created'));
        }

        return redirect()->route('admin.mangas.index')
            ->with('success', 'Mangá criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function edit(Manga $manga)
    {
        return view('admin.mangas.edit', compact('manga'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manga $manga)
    {
        // Prepare themes, converting comma-separated string to array
        if ($request->has('themes') && is_string($request->themes)) {
            $themes = array_filter(array_map('trim', explode(',', $request->themes)));
            $request->merge(['themes' => $themes]);
        }

        // Prepare alt_titles, converting newline-separated string to array
        if ($request->has('alt_titles') && is_string($request->alt_titles)) {
            $alt_titles = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $request->alt_titles)));
            $request->merge(['alt_titles' => $alt_titles]);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'english_title' => 'nullable|string|max:255',
            'author' => 'required|string|max:255',
            'artist' => 'nullable|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:ongoing,completed,hiatus,cancelled,not_yet_published',
            'demographic' => 'nullable|string|max:100',
            'serialization' => 'nullable|string|max:100',
            'published_date' => 'nullable|date',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_adult' => 'boolean',
            'is_suggestive' => 'boolean',
            'genres' => 'nullable|array',
            'themes' => 'nullable|array',
            'alt_titles' => 'nullable|array',
        ]);

        // Handle file upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($manga->cover_url) {
                $oldCover = str_replace('/storage', 'public', $manga->cover_url);
                if (Storage::exists($oldCover)) {
                    Storage::delete($oldCover);
                }
            }
            
            $path = $request->file('cover')->store('public/manga_covers');
            $validated['cover_url'] = Storage::url($path);
        }

        // Convert arrays to JSON
        if (isset($validated['genres'])) {
            $validated['genres'] = json_encode($validated['genres']);
        }
        if (isset($validated['themes'])) {
            $validated['themes'] = json_encode($validated['themes']);
        }
        if (isset($validated['alt_titles'])) {
            $validated['alt_titles'] = json_encode($validated['alt_titles']);
        }

        // Remove fields that don't exist in the database yet
        $fieldsToRemove = ['rating', 'rating_count', 'view_count'];
        foreach ($fieldsToRemove as $field) {
            if (array_key_exists($field, $validated)) {
                unset($validated[$field]);
            }
        }

        // Update slug if title changed
        if ($manga->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $manga->update($validated);

        // Send update notification to all admins except the one who updated the manga
        $admins = User::where('is_admin', true)
            ->where('id', '!=', auth()->id())
            ->get();
            
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new MangaNotification($manga, 'updated'));
        }

        return redirect()->route('admin.mangas.index')
            ->with('success', 'Mangá atualizado com sucesso!');
    }

    /**
     * Show the confirmation page for deleting a manga.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function confirmDelete(Manga $manga)
    {
        return view('admin.mangas.confirm-delete', compact('manga'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Manga  $manga
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manga $manga)
    {
        try {
            // Delete cover if exists
            if ($manga->cover_url) {
                $coverPath = str_replace('/storage', 'public', $manga->cover_url);
                if (Storage::exists($coverPath)) {
                    Storage::delete($coverPath);
                }
            }
            
            // Delete related data (chapters, etc.) - You might need to adjust this based on your relationships
            $manga->chapters()->delete();
            
            // Delete the manga
            $manga->delete();
            
            return redirect()->route('admin.mangas.index')
                ->with('success', 'Mangá excluído com sucesso!');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Ocorreu um erro ao excluir o mangá: ' . $e->getMessage());
        }
    }
}
