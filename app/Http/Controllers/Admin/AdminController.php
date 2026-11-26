<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display the administrator account creation form.
     */
    public function create()
    {
        return view('admin.tambah-admin');
    }

    /**
     * Validate and save a new administrator account.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'unique:users,nis'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        User::create([
            'name' => $request->name,
            'nis' => $request->nis,
            'kelas' => '-', // Admin tidak memiliki kelas
            'role' => 'admin', // Otomatis diset sebagai admin
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'Akun admin baru berhasil ditambahkan!');
    }
}
