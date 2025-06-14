<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;

class UpdatesController extends Controller
{
    public function index()
    {
        $recentUpdates = Chapter::with(['manga', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('updates.index', [
            'recentUpdates' => $recentUpdates
        ]);
    }
}
