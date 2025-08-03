<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    /**
     * Display a listing of the authors.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $authors = Author::withCount('mangas')
            ->orderBy('name')
            ->paginate(15);
            
        return view('admin.authors.index', compact('authors'));
    }

    /**
     * Show the form for creating a new author.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.authors.create');
    }

    /**
     * Store a newly created author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'is_artist' => 'sometimes|boolean',
            'is_writer' => 'sometimes|boolean',
            'twitter' => 'nullable|string|max:50',
        ]);

        // Generate slug from name if not provided
        $validated['slug'] = Str::slug($validated['name']);
        
        // Set default values for checkboxes if not provided
        $validated['is_artist'] = $request->has('is_artist');
        $validated['is_writer'] = $request->has('is_writer');

        Author::create($validated);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Autor/Artista criado com sucesso!');
    }

    /**
     * Display the specified author.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\View\View
     */
    public function show(Author $author)
    {
        return view('admin.authors.show', compact('author'));
    }

    /**
     * Show the form for editing the specified author.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\View\View
     */
    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    /**
     * Update the specified author in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('authors', 'name')->ignore($author->id)
            ],
            'biography' => 'nullable|string',
            'is_artist' => 'sometimes|boolean',
            'is_writer' => 'sometimes|boolean',
            'twitter' => 'nullable|string|max:50',
        ]);

        // Update slug if name changed
        if ($author->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Update checkbox values
        $validated['is_artist'] = $request->has('is_artist');
        $validated['is_writer'] = $request->has('is_writer');

        $author->update($validated);

        return redirect()->route('admin.authors.index')
            ->with('success', 'Autor/Artista atualizado com sucesso!');
    }

    /**
     * Remove the specified author from storage.
     *
     * @param  \App\Models\Author  $author
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Author $author)
    {
        // Check if author is associated with any mangas
        if ($author->mangas()->count() > 0) {
            return redirect()->route('admin.authors.index')
                ->with('error', 'Não é possível excluir este autor/artista, pois ele está associado a um ou mais mangás.');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')
            ->with('success', 'Autor/Artista excluído com sucesso!');
    }
}
