<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarksController extends Controller
{
    /**
     * Display a listing of the bookmarks.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookmarks = [];
        if (Auth::check()) {
            $bookmarks = Auth::user()->bookmarks()->latest()->paginate(10);
        }
        
        return view('bookmarks.index', compact('bookmarks'));
    }
}
