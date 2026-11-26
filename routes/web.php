<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\ComplaintReportController;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| SIPRASKA - Route File
|--------------------------------------------------------------------------
*/

// Halaman Utama & Login
Route::get('/', [ComplaintReportController::class, 'index']);

Route::get('/login', [ComplaintReportController::class, 'index'])
    ->name('login');

// Dashboard (Admin & Siswa)
Route::get('/dashboard', [ComplaintReportController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Kirim Pengaduan (Siswa)
Route::post('/pengaduan', [ComplaintReportController::class, 'store'])
    ->middleware(['auth', 'throttle:20,1'])
    ->name('complaint.store');

Route::put('/pengaduan/{complaint}', [ComplaintReportController::class, 'update'])
    ->middleware(['auth', 'throttle:30,1'])
    ->name('complaint.update');

Route::delete('/pengaduan/{complaint}', [ComplaintReportController::class, 'destroy'])
    ->middleware(['auth', 'throttle:30,1'])
    ->name('complaint.destroy');

// Ganti Kata Sandi (Siswa & Admin)
Route::put('/akun/password', [ComplaintReportController::class, 'password'])
    ->middleware('auth')
    ->name('account.password');

// Register (Khusus Siswa)
Route::post('/register', function (Request $request) {
    $hasEmail = Schema::hasColumn('users', 'email');

    $rules = [
        'nis' => ['required', 'string', 'max:20', 'unique:users,nis'],
        'name' => ['required', 'string', 'max:255'],
        'kelas' => ['required', 'string', 'max:50'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    if ($hasEmail) {
        $rules['email'] = ['nullable', 'email', 'max:255', 'unique:users,email'];
    }

    $data = $request->validate($rules, [
        'nis.unique' => 'NIS ini sudah terdaftar.',
        'nis.required' => 'NIS wajib diisi.',
        'password.min' => 'Kata sandi minimal 8 karakter.',
        'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        'email.unique' => 'Email ini sudah dipakai.',
    ]);

    $attrs = [
        'nis' => $data['nis'],
        'name' => $data['name'],
        'kelas' => $data['kelas'],
        'role' => 'siswa',
        'password' => Hash::make($data['password']),
    ];

    if ($hasEmail) {
        $attrs['email'] = $data['email'] ?? ($data['nis'].'@siswa.sipraska.local');
    }

    $user = User::create($attrs);
    Complaint::addLog('akun', 'Mendaftar sebagai siswa', $user);

    return redirect()->route('login')
        ->with('success', 'Pendaftaran berhasil! Silakan masuk menggunakan akun Anda.');
})->middleware('throttle:10,1')->name('register.store');

// Proses Login
Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'identity' => ['required', 'string'],
        'password' => ['required', 'string'],
        'role' => ['required', 'in:siswa,admin'],
    ]);

    $credentials = [
        'nis' => $data['identity'],
        'password' => $data['password'],
        'role' => $data['role'],
    ];

    $ok = Auth::attempt(
        $credentials,
        $request->boolean('remember')
    );

    if (! $ok && Schema::hasColumn('users', 'username')) {
        $ok = Auth::attempt([
            'username' => $data['identity'],
            'password' => $data['password'],
            'role' => $data['role'],
        ], $request->boolean('remember'));
    }

    if (
        ! $ok &&
        filter_var($data['identity'], FILTER_VALIDATE_EMAIL) &&
        Schema::hasColumn('users', 'email')
    ) {
        $ok = Auth::attempt([
            'email' => $data['identity'],
            'password' => $data['password'],
            'role' => $data['role'],
        ], $request->boolean('remember'));
    }

    if (! $ok) {
        return back()
            ->withErrors([
                'identity' => 'NIS/username atau kata sandi salah untuk akses '.ucfirst($data['role']).'.',
            ])
            ->withInput($request->except('password'));
    }

    $request->session()->regenerate();

    Complaint::addLog('login', 'Login ke sistem');

    return redirect()->route('dashboard');
})->middleware('throttle:10,1')->name('login.store');

// Logout
Route::post('/logout', function (Request $request) {
    Complaint::addLog('logout', 'Logout dari sistem');

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

// Area Admin (Khusus Admin)
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Manajemen Admin
        Route::get('/tambah-admin', [AdminController::class, 'create'])
            ->name('users.create');

        Route::post('/tambah-admin', [AdminController::class, 'store'])
            ->name('users.store');

        Route::get('/pengguna', [UserManagementController::class, 'index'])
            ->name('pengguna.index');

        Route::post('/pengguna', [UserManagementController::class, 'store'])
            ->middleware('throttle:30,1')
            ->name('pengguna.store');

        Route::put('/pengguna/{user}', [UserManagementController::class, 'update'])
            ->middleware('throttle:30,1')
            ->name('pengguna.update');

        Route::delete('/pengguna/{user}', [UserManagementController::class, 'destroy'])
            ->middleware('throttle:30,1')
            ->name('pengguna.destroy');

        Route::post('/pengguna/{user}/reset-sandi', [UserManagementController::class, 'resetPassword'])
            ->middleware('throttle:10,1')
            ->name('pengguna.reset-password');

        // Pengaduan
        Route::post('/pengaduan', [ComplaintReportController::class, 'adminStore'])
            ->middleware('throttle:30,1')
            ->name('complaints.store');

        Route::patch('/pengaduan/{complaint}', [ComplaintReportController::class, 'adminUpdate'])
            ->middleware('throttle:30,1')
            ->name('complaints.update');

        Route::delete('/pengaduan/{complaint}', [ComplaintReportController::class, 'adminDestroy'])
            ->name('complaints.destroy');

        // Rekap
        Route::get('/rekap/export', [ComplaintReportController::class, 'adminExport'])
            ->name('rekap.export');

        // Profil
        Route::put('/profil', [ComplaintReportController::class, 'adminProfile'])
            ->name('profile.update');

        // Password
        Route::put('/password', [ComplaintReportController::class, 'password'])
            ->name('password.update');

        // Catat aktivitas admin dari halaman frontend
        Route::post('/aktivitas', function (Request $request) {
            $data = $request->validate([
                'aksi' => ['required', 'string', 'max:100'],
                'deskripsi' => ['required', 'string', 'max:480'],
            ]);

            $log = Complaint::addLog(
                $data['aksi'],
                $data['deskripsi']
            );

            return response()->json([
                'success' => true,
                'log' => $log,
            ]);
        })->name('logs.store');
    });
