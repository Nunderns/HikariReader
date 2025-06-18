<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the authenticated user's profile.
     */
    public function show()
    {
        $user = auth()->user();
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.show')
            ->with('success', 'Perfil atualizado com sucesso!');
    }
    
    /**
     * Show the form to change the user's password.
     */
    public function showChangePasswordForm()
    {
        return view('profile.change-password');
    }
    
    /**
     * Change the user's password.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        $user = auth()->user();
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.show')
            ->with('success', 'Senha alterada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
