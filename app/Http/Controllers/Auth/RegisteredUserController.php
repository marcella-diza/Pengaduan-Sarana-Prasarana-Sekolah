<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
$request->validate([
    'nis'      => ['required', 'string', 'max:20', 'unique:users,nis'],
    'name'     => ['required', 'string', 'max:255'],
    'kelas'    => ['required', 'string', 'max:50'],
    'password' => ['required', 'string', 'min:8'],
]);

User::create([
    'nis'      => $request->nis,
    'name'     => $request->name,
    'kelas'    => $request->kelas,
    'role'     => 'siswa',
    'password' => Hash::make($request->password),
]);

return redirect('/login')->with('success', 'Pendaftaran berhasil! Silakan masuk.');
}
}