<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;

class GroupsController extends Controller
{
    public function index()
    {
        $groups = Group::with(['users', 'mangas'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('groups.index', [
            'groups' => $groups
        ]);
    }

    public function community()
    {
        $communityGroups = Group::with(['users', 'mangas'])
            ->where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('groups.community', [
            'groups' => $communityGroups
        ]);
    }
}
