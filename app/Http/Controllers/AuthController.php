<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Authenticate a user with their identity, password, and selected role.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'identity' => ['required', 'string'],
            'password' => ['required', 'string'],
            'role' => ['required', 'in:siswa,admin'],
        ]);

        $authenticated = Auth::attempt([
            'nis' => $request->identity,
            'password' => $request->password,
            'role' => $request->role,
        ], $request->boolean('remember'));

        if (! $authenticated) {
            return back()->withErrors(['identity' => 'NIS/username atau kata sandi salah.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    /**
     * End the current session and return the user to the login page.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
