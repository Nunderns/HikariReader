<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres,name',
            'slug' => 'required|string|max:255|unique:genres,slug',
            'description' => 'nullable|string',
        ]);

        Genre::create($validated);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Gênero criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'name')->ignore($genre->id),
            ],
            'slug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('genres', 'slug')->ignore($genre->id),
            ],
            'description' => 'nullable|string',
        ]);

        $genre->update($validated);

        return redirect()->route('admin.genres.index')
            ->with('success', 'Gênero atualizado com sucesso!');
    }

    /**
     * Show the confirmation page for deleting a resource.
     */
    public function confirmDelete(Genre $genre)
    {
        $mangaCount = DB::table('manga_genre')
            ->where('genre_id', $genre->id)
            ->count();
            
        return view('admin.genres.confirm-delete', compact('genre', 'mangaCount'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        // Detach all relationships with mangas before deleting
        $genre->mangas()->detach();
        
        $genre->delete();

        DB::transaction(function () use ($genre) {
            // Detach all relationships with mangas before deleting
            $genre->mangas()->detach();
            
            $genre->delete();
        });

        return redirect()->route('admin.genres.index')
            ->with('success', 'Gênero excluído com sucesso!');
    }
}
