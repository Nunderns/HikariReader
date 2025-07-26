<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenreController extends Controller
{
    /**
     * Displays a list of all genres.
     */
    public function index()
    {
        //
    }

    /**
     * Displays the form for creating a new genre resource.
     */
    public function create()
    {
        //
    }

    /**
     * Handles storing a newly created Genre resource using data from the HTTP request.
     *
     * @param Request $request The HTTP request containing data for the new Genre.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Displays the specified Genre resource.
     *
     * @param Genre $genre The Genre instance to display.
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Displays a form for editing the specified genre.
     *
     * @param Genre $genre The genre to edit.
     */
    public function edit(Genre $genre)
    {
        //
    }

    /**
     * Updates the specified Genre resource with data from the request.
     *
     * @param Request $request The HTTP request containing updated data.
     * @param Genre $genre The Genre instance to update.
     */
    public function update(Request $request, Genre $genre)
    {
        //
    }

    /**
     * Deletes the specified Genre resource from storage.
     *
     * @param Genre $genre The Genre instance to be deleted.
     */
    public function destroy(Genre $genre)
    {
        //
    }
}
