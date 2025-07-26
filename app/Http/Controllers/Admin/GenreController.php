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
     * Displays a list of all genres ordered by name in the admin panel.
     *
     * @return \Illuminate\View\View The view displaying the list of genres.
     */
    public function index()
    {
        $genres = Genre::orderBy('name')->get();
        return view('admin.genres.index', compact('genres'));
    }

    /**
     * Displays the form for creating a new genre.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.genres.create');
    }

    /**
     * Validates and creates a new genre using the provided request data.
     *
     * Redirects to the genres index page with a success message upon successful creation.
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
     * Displays the form for editing the specified genre.
     *
     * @param Genre $genre The genre to edit.
     * @return \Illuminate\View\View
     */
    public function edit(Genre $genre)
    {
        return view('admin.genres.edit', compact('genre'));
    }

    /**
     * Updates an existing genre with validated data and redirects to the genres index with a success message.
     *
     * @param Request $request The HTTP request containing updated genre data.
     * @param Genre $genre The genre instance to update.
     * @return \Illuminate\Http\RedirectResponse
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
     * Displays a confirmation page for deleting the specified genre, including the count of associated mangas.
     *
     * @param Genre $genre The genre to be considered for deletion.
     * @return \Illuminate\View\View
     */
    public function confirmDelete(Genre $genre)
    {
        $mangaCount = DB::table('manga_genre')
            ->where('genre_id', $genre->id)
            ->count();
            
        return view('admin.genres.confirm-delete', compact('genre', 'mangaCount'));
    }

    /**
     * Deletes the specified genre and detaches all associated mangas.
     *
     * Redirects to the genres index page with a success message after deletion.
     *
     * @param Genre $genre The genre to be deleted.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Genre $genre)
    {
        // Detach all relationships with mangas before deleting
        $genre->mangas()->detach();
        
        $genre->delete();

        return redirect()->route('admin.genres.index')
            ->with('success', 'Gênero excluído com sucesso!');
    }
}
