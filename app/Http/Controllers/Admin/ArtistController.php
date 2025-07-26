<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artist;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArtistController extends Controller
{
    /**
     * Exibe uma lista de todos os artistas ordenados por nome.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $artists = Artist::orderBy('name')->get();
        return view('admin.artists.index', compact('artists'));
    }

    /**
     * Mostra o formulário para criar um novo artista.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.artists.create');
    }

    /**
     * Armazena um novo artista no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:artists,name',
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'twitter' => 'nullable|string|max:255',
            'pixiv' => 'nullable|string|max:255',
            'other_links' => 'nullable|array',
            'other_links.*.name' => 'required_with:other_links|string|max:255',
            'other_links.*.url' => 'required_with:other_links|url',
        ]);

        // Gera o slug a partir do nome
        $validated['slug'] = Str::slug($validated['name']);
        
        // Converte outros links para JSON
        if (isset($validated['other_links'])) {
            $validated['other_links'] = array_values($validated['other_links']);
        }

        Artist::create($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artista criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um artista específico.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\View\View
     */
    public function edit(Artist $artist)
    {
        return view('admin.artists.edit', compact('artist'));
    }

    /**
     * Atualiza um artista específico no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Artist $artist)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('artists', 'name')->ignore($artist->id)
            ],
            'description' => 'nullable|string',
            'website' => 'nullable|url',
            'twitter' => 'nullable|string|max:255',
            'pixiv' => 'nullable|string|max:255',
            'other_links' => 'nullable|array',
            'other_links.*.name' => 'required_with:other_links|string|max:255',
            'other_links.*.url' => 'required_with:other_links|url',
        ]);

        // Atualiza o slug se o nome foi alterado
        if ($artist->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']);
        }
        
        // Converte outros links para JSON
        if (isset($validated['other_links'])) {
            $validated['other_links'] = array_values($validated['other_links']);
        }

        $artist->update($validated);

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artista atualizado com sucesso!');
    }

    /**
     * Remove o artista especificado do banco de dados.
     *
     * @param  \App\Models\Artist  $artist
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Artist $artist)
    {
        // Verifica se o artista está associado a algum mangá
        if ($artist->mangas()->count() > 0) {
            return redirect()->route('admin.artists.index')
                ->with('error', 'Não é possível excluir este artista pois ele está associado a um ou mais mangás.');
        }

        $artist->delete();

        return redirect()->route('admin.artists.index')
            ->with('success', 'Artista excluído com sucesso!');
    }
}
