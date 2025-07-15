<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MangaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mangas = Manga::latest()->paginate(15);
        return view('admin.mangas.index', compact('mangas'));
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

        // Create manga
        $manga = Manga::create($validated);

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

        // Update slug if title changed
        if ($manga->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $manga->update($validated);

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
