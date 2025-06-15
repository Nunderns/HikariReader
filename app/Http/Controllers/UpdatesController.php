<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use Illuminate\Support\Facades\Auth;

class UpdatesController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return view('updates.guest');
        }

        $recentUpdates = Chapter::with(['manga', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('updates.index', [
            'recentUpdates' => $recentUpdates
        ]);
    }
}
