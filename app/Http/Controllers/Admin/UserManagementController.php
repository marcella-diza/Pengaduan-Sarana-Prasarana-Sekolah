<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    private const CLASSES = [
        'X MIPA 1', 'X MIPA 2', 'X MIPA 3', 'X MIPA 4', 'X IPS 1', 'X IPS 2', 'X IPS 3',
        'XI MIPA 1', 'XI MIPA 2', 'XI MIPA 3', 'XI MIPA 4', 'XI IPS 1', 'XI IPS 2', 'XI IPS 3',
        'XII MIPA 1', 'XII MIPA 2', 'XII MIPA 3', 'XII MIPA 4', 'XII IPS 1', 'XII IPS 2', 'XII IPS 3',
    ];

    /**
     * Return managed accounts as JSON or send the browser to the user panel.
     */
    public function index(Request $request): JsonResponse|RedirectResponse
    {
        $users = User::query()
            ->select($this->userColumns())
            ->withCount('complaints')
            ->orderBy('name')
            ->limit(2000)
            ->get()
            ->map(fn (User $user): array => $this->userPayload($user))
            ->values();

        if ($request->expectsJson()) {
            return response()->json(['users' => $users]);
        }

        return redirect()->to(route('dashboard').'#pengguna');
    }

    /**
     * Validate and create a student or administrator account.
     */
    public function store(Request $request): JsonResponse
    {
        $role = $request->input('role');
        $data = $request->validate($this->rulesFor($role), [
            'role.required' => 'Pilih jenis akun.',
            'role.in' => 'Jenis akun tidak valid.',
            'name.required' => 'Nama wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan.',
            'kelas.required' => 'Pilih kelas siswa.',
            'kelas.in' => 'Kelas siswa tidak valid.',
            'password.required' => 'Sandi awal wajib diisi atau dibuat secara acak.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $attributes = [
            'name' => $data['name'],
            'role' => $role,
            'kelas' => $role === 'siswa' ? $data['kelas'] : '-',
            'password' => Hash::make($data['password']),
        ];
        foreach (['nis', 'username', 'email'] as $column) {
            if (Schema::hasColumn('users', $column) && array_key_exists($column, $data)) {
                $attributes[$column] = $data[$column] !== '' ? $data[$column] : null;
            }
        }

        $user = new User;
        $user->forceFill(array_intersect_key($attributes, array_flip(Schema::getColumnListing('users'))))->save();

        $this->log('pengguna', "Membuat akun {$role}: {$user->name}");

        return response()->json(['user' => $this->userPayload($user->loadCount('complaints'))], 201);
    }

    /**
     * Update account details without allowing its role to be changed.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $data = $request->validate($this->rulesFor($user->role, $user), [
            'name.required' => 'Nama wajib diisi.',
            'nis.required' => 'NIS wajib diisi.',
            'nis.unique' => 'NIS ini sudah terdaftar.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username ini sudah digunakan.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan.',
            'kelas.required' => 'Pilih kelas siswa.',
            'kelas.in' => 'Kelas siswa tidak valid.',
        ]);

        $attributes = ['name' => $data['name']];
        if ($user->role === 'siswa') {
            $attributes['kelas'] = $data['kelas'];
        }
        foreach (['nis', 'username', 'email'] as $column) {
            if (Schema::hasColumn('users', $column) && array_key_exists($column, $data)) {
                $attributes[$column] = $data[$column] !== '' ? $data[$column] : null;
            }
        }

        $user->forceFill(array_intersect_key($attributes, array_flip(Schema::getColumnListing('users'))))->save();
        $this->log('pengguna', "Memperbarui akun {$user->role}: {$user->name}");

        return response()->json(['user' => $this->userPayload($user->fresh()->loadCount('complaints'))]);
    }

    /**
     * Delete an account and clean up its complaints, history, and evidence.
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        abort_unless((int) $request->user()->id !== (int) $user->id, 403, 'Anda tidak dapat menghapus akun sendiri.');

        if ($user->role === 'admin') {
            abort_if(User::query()->where('role', 'admin')->count() <= 1, 422, 'Admin terakhir tidak dapat dihapus.');
        }

        $complaints = $user->complaints()->get();
        if ($user->role === 'siswa' && $complaints->isNotEmpty() && ! $request->boolean('hapus_pengaduan')) {
            return response()->json([
                'message' => "Siswa memiliki {$complaints->count()} pengaduan. Hapus pengaduan beserta foto dan riwayatnya?",
                'count' => $complaints->count(),
            ], 422);
        }

        $paths = $complaints->flatMap(fn (Complaint $complaint): array => $complaint->fotoPaths())->all();
        DB::transaction(function () use ($complaints, $user): void {
            $ids = $complaints->pluck('id')->all();
            if ($ids !== [] && Schema::hasTable('complaint_histories')) {
                DB::table('complaint_histories')->whereIn('complaint_id', $ids)->delete();
            }

            if ($ids !== []) {
                $user->complaints()->delete();
            }

            $user->delete();
        });
        Storage::disk('public')->delete($paths);
        $this->log('pengguna', "Menghapus akun {$user->role}: {$user->name}");

        return response()->json(['id' => $user->id]);
    }

    /**
     * Generate and return a one-time display of the account's new password.
     */
    public function resetPassword(User $user): JsonResponse
    {
        $password = Str::random(10);
        $user->forceFill(['password' => Hash::make($password)])->save();
        $this->log('pengguna', "Mereset sandi akun {$user->role}: {$user->name}");

        return response()->json(['password' => $password]);
    }

    /**
     * Build account validation rules using the active user-table columns.
     *
     * @return array<string, array<int, mixed>>
     */
    private function rulesFor(?string $role, ?User $user = null): array
    {
        $isStudent = $role === 'siswa';
        $rules = [
            'role' => [$user ? 'prohibited' : 'required', 'in:siswa,admin'],
            'name' => ['required', 'string', 'max:255'],
        ];

        if (Schema::hasColumn('users', 'nis') && ($isStudent || ! Schema::hasColumn('users', 'username'))) {
            $rules['nis'] = [$isStudent || ! Schema::hasColumn('users', 'email') ? 'required' : 'nullable', 'string', 'max:20', Rule::unique('users', 'nis')->ignore($user)];
        }
        if (Schema::hasColumn('users', 'username')) {
            $rules['username'] = [$isStudent ? 'nullable' : 'required', 'string', 'max:80', Rule::unique('users', 'username')->ignore($user)];
        }
        if (Schema::hasColumn('users', 'email')) {
            $rules['email'] = ['nullable', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)];
            if (! $isStudent && ! Schema::hasColumn('users', 'nis') && ! Schema::hasColumn('users', 'username')) {
                $rules['email'][0] = 'required';
            }
        }
        if ($isStudent) {
            $rules['kelas'] = ['required', Rule::in(self::CLASSES)];
        }
        if (! $user) {
            $rules['password'] = ['required', 'string', 'min:8'];
        }

        return $rules;
    }

    /**
     * Select only account fields that exist in the current schema.
     *
     * @return array<int, string>
     */
    private function userColumns(): array
    {
        $columns = ['id', 'name', 'role', 'kelas', 'created_at'];
        foreach (['nis', 'username', 'email'] as $column) {
            if (Schema::hasColumn('users', $column)) {
                $columns[] = $column;
            }
        }
        if (Schema::hasColumn('users', 'complaints_count')) {
            $columns[] = 'complaints_count';
        }

        return $columns;
    }

    /**
     * Shape a user model into the account data returned to the frontend.
     *
     * @return array<string, mixed>
     */
    private function userPayload(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role,
            'nis' => $user->nis ?? null,
            'username' => $user->username ?? null,
            'email' => $user->email ?? null,
            'kelas' => $user->kelas ?? '-',
            'complaints_count' => $user->complaints_count ?? $user->complaints()->count(),
            'created_at' => $user->created_at?->toIso8601String(),
        ];
    }

    /**
     * Record a user-management action in administrator activity history.
     */
    private function log(string $action, string $message): void
    {
        Complaint::addLog($action, $message);
    }
}
