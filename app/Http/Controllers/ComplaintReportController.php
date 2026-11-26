<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ComplaintReportController extends Controller
{
    /* ===================== HALAMAN UTAMA ===================== */

    /**
     * Prepare the public login page or the role-specific complaint dashboard.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        if (! $user) {
            return view('welcome', ['hasEmail' => Schema::hasColumn('users', 'email')]);
        }

        if ($user->role === 'admin') {
            $rows = Complaint::with('user:id,name,nis,kelas')->latest()->limit(2000)->get();
            $hist = Complaint::historiesFor($rows->pluck('id')->all());
            $userColumns = ['id', 'name', 'role', 'kelas', 'created_at'];
            foreach (['nis', 'username', 'email'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $userColumns[] = $column;
                }
            }
            $users = User::query()->select($userColumns)->withCount('complaints')
                ->orderBy('name')->limit(2000)->get()
                ->map(fn (User $account): array => [
                    'id' => $account->id,
                    'name' => $account->name,
                    'nis' => $account->nis,
                    'username' => $account->username,
                    'email' => $account->email,
                    'kelas' => $account->kelas ?? '-',
                    'role' => $account->role,
                    'complaints_count' => $account->complaints_count,
                    'created_at' => $account->created_at?->toIso8601String(),
                ])->values()->all();
            $students = User::query()->where('role', 'siswa')->orderBy('name')->limit(2000)
                ->get(['id', 'name', 'nis', 'kelas'])
                ->map(fn (User $student): array => [
                    'id' => $student->id,
                    'nama' => $student->name,
                    'nis' => $student->nis,
                    'kelas' => $student->kelas,
                ])->values()->all();

            return view('welcome', [
                'complaints' => $rows->map(fn ($c) => $c->toPanel($hist[$c->id] ?? []))->values()->all(),
                'logs' => Complaint::logs(2000),
                'users' => $users,
                'siswa' => $students,
                'userIdentityColumn' => Schema::hasColumn('users', 'username')
                    ? 'username'
                    : (Schema::hasColumn('users', 'nis') ? 'nis' : 'email'),
                'hasUserEmail' => Schema::hasColumn('users', 'email'),
            ]);
        }

        // ----- Siswa -----
        $rows = Complaint::with('user:id,name,nis,kelas')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $hist = Complaint::historiesFor($rows->pluck('id')->all());

        $mine = $rows->map(fn ($complaint) => $this->studentPayload($complaint, $hist[$complaint->id] ?? []))
            ->values()->all();

        $petugas = Complaint::hasCol('petugas')
            ? Complaint::whereNotNull('petugas')->where('petugas', '!=', '')->where('status', 'Diproses')
                ->distinct()->pluck('petugas')->take(3)->values()->all()
            : [];

        return view('welcome', ['mine' => $mine, 'petugas' => $petugas]);
    }

    /**
     * Remove admin-only reply details from a complaint shown to its student.
     */
    private function studentPayload(Complaint $complaint, array $history = []): array
    {
        $payload = $complaint->toPanel($history);
        $payload['riwayat'] = array_map(function (array $event): array {
            if (! ($event['notified'] ?? true)) {
                $event['catatan'] = null;
            }

            return $event;
        }, $payload['riwayat']);

        $feedbackNotified = false;
        if ($complaint->tanggapan !== null) {
            foreach ($history as $event) {
                if (($event['catatan'] ?? null) === $complaint->tanggapan) {
                    $feedbackNotified = (bool) ($event['notified'] ?? false);
                }
            }
        }
        $payload['tanggapan'] = $feedbackNotified === false ? null : $complaint->tanggapan;

        return $payload;
    }

    /* ===================== SISWA ===================== */

    /**
     * Validate and save a new complaint submitted by a student.
     */
    public function store(Request $request)
    {
        abort_unless($request->user()->role === 'siswa', 403, 'Hanya siswa yang dapat mengirim pengaduan.');

        $data = $request->validate([
            'kategori' => ['required', Rule::in(Complaint::KATEGORI)],
            'judul' => ['required', 'string', 'max:150'],
            'gedung' => ['required', 'string', 'max:60'],
            'detail' => ['required', 'string', 'max:100'],
            'prioritas' => ['required', Rule::in(Complaint::PRIORITAS)],
            'isi' => ['required', 'string', 'min:30', 'max:2000'],
            'fotos' => ['nullable', 'array', 'max:3'],
            'fotos.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:5120'],
            'pernyataan' => ['accepted'],
        ], [
            'kategori.required' => 'Pilih kategori sarana / prasarana.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'gedung.required' => 'Pilih gedung / wilayah.',
            'detail.required' => 'Isi lantai dan detail ruangan.',
            'isi.min' => 'Deskripsi kerusakan minimal 30 karakter.',
            'isi.required' => 'Deskripsi kerusakan wajib diisi.',
            'fotos.max' => 'Maksimal 3 foto.',
            'fotos.*.mimes' => 'Foto harus berformat JPG, PNG, WEBP, atau HEIC.',
            'fotos.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
            'pernyataan.accepted' => 'Centang pernyataan kebenaran laporan.',
        ]);

        $user = $request->user();
        $paths = [];
        foreach ($request->file('fotos', []) as $file) {
            $paths[] = $file->store('complaints', 'public');
        }

        $attrs = [
            'user_id' => $user->id,
            'kategori' => $data['kategori'],
            'lokasi' => Str::limit($data['gedung'].' • '.$data['detail'], 250, ''),
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'foto' => $paths ? json_encode($paths) : null,
            'status' => 'Menunggu',
            'prioritas' => $data['prioritas'],
            // kolom lama (hanya terisi bila masih ada di tabel)
            'nis' => $user->nis,
            'pelapor' => $user->name,
            'ket' => $data['isi'],
            'urgensi' => $data['prioritas'],
        ];

        $complaint = new Complaint;
        $complaint->forceFill(Complaint::onlyCols($attrs))->save();

        Complaint::addHistory($complaint->id, 'Menunggu', 'Pengaduan diajukan oleh siswa', $user->id, true);
        Complaint::addLog('pengaduan', "Mengirim pengaduan {$complaint->tiket} \"{$complaint->judul}\"");

        return redirect()->route('dashboard')
            ->with('success', 'Pengaduan berhasil dikirim ke admin!')
            ->with('open', 'lacak');
    }

    /**
     * Update a student's pending complaint and manage its evidence photos.
     */
    public function update(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->role === 'siswa' && (int) $complaint->user_id === (int) $request->user()->id, 403);
        abort_unless($complaint->status === 'Menunggu', 422, 'Pengaduan sudah diproses admin dan tidak dapat diubah.');

        $data = $request->validate([
            'kategori' => ['required', Rule::in(Complaint::KATEGORI)],
            'judul' => ['required', 'string', 'max:150'],
            'gedung' => ['required', 'string', 'max:60'],
            'detail' => ['required', 'string', 'max:100'],
            'prioritas' => ['required', Rule::in(Complaint::PRIORITAS)],
            'isi' => ['required', 'string', 'min:30', 'max:2000'],
            'hapus_foto' => ['nullable', 'array', 'max:3'],
            'hapus_foto.*' => ['required', 'integer', 'distinct', 'min:0', 'max:2'],
            'fotos' => ['nullable', 'array', 'max:3'],
            'fotos.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:5120'],
        ], [
            'kategori.required' => 'Pilih kategori sarana / prasarana.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'gedung.required' => 'Pilih gedung / wilayah.',
            'detail.required' => 'Isi lantai dan detail ruangan.',
            'isi.min' => 'Deskripsi kerusakan minimal 30 karakter.',
            'fotos.max' => 'Maksimal 3 foto.',
            'fotos.*.mimes' => 'Foto harus berformat JPG, PNG, WEBP, atau HEIC.',
            'fotos.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
        ]);

        $oldPaths = $complaint->fotoPaths();
        $removeIndexes = array_map('intval', $data['hapus_foto'] ?? []);
        $removedPaths = [];
        $retainedPaths = [];
        foreach ($oldPaths as $index => $path) {
            if (in_array($index, $removeIndexes, true)) {
                $removedPaths[] = $path;
            } else {
                $retainedPaths[] = $path;
            }
        }

        $newFiles = $request->file('fotos', []);
        if (count($retainedPaths) + count($newFiles) > 3) {
            throw ValidationException::withMessages([
                'fotos' => 'Maksimal 3 foto untuk setiap pengaduan.',
            ]);
        }

        $newPaths = [];
        try {
            foreach ($newFiles as $file) {
                $newPaths[] = $file->store('complaints', 'public');
            }

            $attrs = [
                'kategori' => $data['kategori'],
                'lokasi' => Str::limit($data['gedung'].' • '.$data['detail'], 250, ''),
                'judul' => $data['judul'],
                'isi' => $data['isi'],
                'foto' => ($retainedPaths || $newPaths) ? json_encode(array_merge($retainedPaths, $newPaths)) : null,
                'prioritas' => $data['prioritas'],
                'ket' => $data['isi'],
                'urgensi' => $data['prioritas'],
            ];
            $complaint->forceFill(Complaint::onlyCols($attrs))->save();
        } catch (\Throwable $exception) {
            Storage::disk('public')->delete($newPaths);
            throw $exception;
        }

        Storage::disk('public')->delete($removedPaths);
        Complaint::addHistory($complaint->id, 'Menunggu', 'Pengaduan diperbarui oleh siswa', $request->user()->id, true);
        Complaint::addLog('pengaduan', "Mengubah pengaduan {$complaint->tiket} \"{$complaint->judul}\"");

        $histories = Complaint::historiesFor([$complaint->id]);

        return response()->json([
            'complaint' => $this->studentPayload($complaint->fresh('user'), $histories[$complaint->id] ?? []),
        ]);
    }

    /**
     * Delete a student's pending complaint and its related history and files.
     */
    public function destroy(Request $request, Complaint $complaint)
    {
        abort_unless($request->user()->role === 'siswa' && (int) $complaint->user_id === (int) $request->user()->id, 403);
        abort_unless($complaint->status === 'Menunggu', 422, 'Pengaduan sudah diproses admin dan tidak dapat diubah.');

        $paths = $complaint->fotoPaths();
        $ticket = $complaint->tiket;
        $title = $complaint->judul;
        DB::transaction(function () use ($complaint): void {
            if (Schema::hasTable('complaint_histories')) {
                DB::table('complaint_histories')->where('complaint_id', $complaint->id)->delete();
            }

            $complaint->delete();
        });
        Storage::disk('public')->delete($paths);
        Complaint::addLog('pengaduan', "Menghapus pengaduan {$ticket} \"{$title}\"");

        return response()->json(['id' => $complaint->id]);
    }

    /* ===================== AKUN (siswa & admin) ===================== */

    /**
     * Change the authenticated user's password after verifying the current one.
     */
    public function password(Request $request)
    {
        $data = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.current_password' => 'Sandi lama salah.',
            'password.confirmed' => 'Konfirmasi sandi tidak cocok.',
            'password.min' => 'Sandi baru minimal 8 karakter.',
        ]);

        $request->user()->forceFill(['password' => Hash::make($data['password'])])->save();

        Complaint::addLog('sandi', 'Mengganti kata sandi');

        return redirect()->route('dashboard')->with('status', 'password-updated');
    }

    /* ===================== ADMIN ===================== */

    /**
     * Apply administrator updates to complaint status, content, and follow-up.
     */
    public function adminUpdate(Request $request, Complaint $complaint)
    {
        $data = $request->validate([
            'status' => ['sometimes', 'required', Rule::in(Complaint::STATUS)],
            'tanggapan' => ['nullable', 'string', 'max:1000'],
            'prioritas' => ['nullable', Rule::in(Complaint::PRIORITAS)],
            'petugas' => ['nullable', 'string', 'max:100'],
            'estimasi' => ['nullable', 'date_format:Y-m-d\TH:i'],
            'estimasi_offset' => ['required_with:estimasi', 'integer', 'between:-840,840'],
            'notify' => ['nullable', 'boolean'],
            'judul' => ['sometimes', 'required', 'string', 'max:150'],
            'kategori' => ['sometimes', 'required', Rule::in(Complaint::KATEGORI)],
            'lokasi' => ['sometimes', 'required', 'string', 'max:250'],
            'isi' => ['sometimes', 'required', 'string', 'min:30', 'max:2000'],
        ], [
            'estimasi_offset.required_with' => 'Zona waktu estimasi tidak valid.',
            'estimasi_offset.between' => 'Zona waktu estimasi tidak valid.',
        ]);

        if (! empty($data['estimasi'])) {
            $estimasiUtc = Carbon::createFromFormat('Y-m-d\TH:i', $data['estimasi'], 'UTC')
                ->addMinutes((int) $data['estimasi_offset']);

            if ($estimasiUtc->isBefore(now('UTC'))) {
                throw ValidationException::withMessages([
                    'estimasi' => 'Waktu estimasi harus sekarang atau di masa depan.',
                ]);
            }
        }

        $oldStatus = $complaint->status;
        $oldReply = (string) $complaint->tanggapan;
        $newReply = $request->has('tanggapan') ? (string) ($data['tanggapan'] ?? '') : $oldReply;
        $newStatus = $data['status'] ?? $oldStatus;

        $update = ['ditangani_oleh' => $request->user()->id];
        if (array_key_exists('status', $data)) {
            $update['status'] = $newStatus;
        }
        if ($request->has('tanggapan')) {
            $update['tanggapan'] = $newReply !== '' ? $newReply : null;
        }
        if (! empty($data['prioritas'])) {
            $update['prioritas'] = $data['prioritas'];
            $update['urgensi'] = $data['prioritas'];
        }
        if ($request->has('petugas')) {
            $update['petugas'] = ! empty($data['petugas']) ? $data['petugas'] : null;
        }
        if ($request->has('estimasi')) {
            $update['estimasi_selesai'] = ! empty($data['estimasi']) ? $data['estimasi'] : null;
        }
        foreach (['judul', 'kategori', 'lokasi', 'isi'] as $field) {
            if (array_key_exists($field, $data)) {
                $update[$field] = $data[$field];
            }
        }
        if (array_key_exists('isi', $data)) {
            $update['ket'] = $data['isi'];
        }
        $complaint->forceFill(Complaint::onlyCols($update))->save();

        $statusChanged = $oldStatus !== $newStatus;
        $replyChanged = $newReply !== '' && $newReply !== $oldReply;
        $contentChanged = collect(['judul', 'kategori', 'lokasi', 'isi'])
            ->contains(fn (string $field): bool => array_key_exists($field, $data));

        if ($statusChanged || $replyChanged) {
            Complaint::addHistory(
                $complaint->id,
                $newStatus,
                $replyChanged ? $newReply : 'Status diubah menjadi '.$newStatus,
                $request->user()->id,
                $request->boolean('notify', true)
            );
        }
        if ($contentChanged) {
            Complaint::addHistory($complaint->id, $newStatus, 'Data pengaduan diperbarui oleh admin', $request->user()->id, false);
        }

        $log = null;
        if ($statusChanged && $newStatus === 'Selesai') {
            $log = Complaint::addLog(
                'pengaduan',
                "Menyelesaikan tindak lanjut pengaduan {$complaint->tiket} \"{$complaint->judul}\""
            );
        } elseif ($contentChanged) {
            $log = Complaint::addLog('pengaduan', "Mengubah data pengaduan {$complaint->tiket}");
        }

        $hist = Complaint::historiesFor([$complaint->id]);

        return response()->json([
            'complaint' => $complaint->fresh('user')->toPanel($hist[$complaint->id] ?? []),
            'log' => $log,
        ]);
    }

    /**
     * Create a complaint on behalf of a selected student.
     */
    public function adminStore(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', Rule::exists('users', 'id')->where('role', 'siswa')],
            'kategori' => ['required', Rule::in(Complaint::KATEGORI)],
            'judul' => ['required', 'string', 'max:150'],
            'gedung' => ['required', 'string', 'max:60'],
            'detail' => ['required', 'string', 'max:100'],
            'prioritas' => ['required', Rule::in(Complaint::PRIORITAS)],
            'isi' => ['required', 'string', 'min:30', 'max:2000'],
            'status' => ['nullable', Rule::in(Complaint::STATUS)],
            'fotos' => ['nullable', 'array', 'max:3'],
            'fotos.*' => ['file', 'mimes:jpg,jpeg,png,webp,heic,heif', 'max:5120'],
        ], [
            'user_id.required' => 'Pilih siswa pelapor.',
            'user_id.exists' => 'Siswa yang dipilih tidak ditemukan.',
            'kategori.required' => 'Pilih kategori sarana / prasarana.',
            'judul.required' => 'Judul pengaduan wajib diisi.',
            'gedung.required' => 'Pilih gedung / wilayah.',
            'detail.required' => 'Isi lantai dan detail ruangan.',
            'isi.min' => 'Deskripsi kerusakan minimal 30 karakter.',
            'fotos.max' => 'Maksimal 3 foto.',
            'fotos.*.mimes' => 'Foto harus berformat JPG, PNG, WEBP, atau HEIC.',
            'fotos.*.max' => 'Ukuran tiap foto maksimal 5 MB.',
        ]);

        $student = User::query()->whereKey($data['user_id'])->where('role', 'siswa')->firstOrFail();
        $paths = [];
        foreach ($request->file('fotos', []) as $file) {
            $paths[] = $file->store('complaints', 'public');
        }

        $attrs = [
            'user_id' => $student->id,
            'kategori' => $data['kategori'],
            'lokasi' => Str::limit($data['gedung'].' • '.$data['detail'], 250, ''),
            'judul' => $data['judul'],
            'isi' => $data['isi'],
            'foto' => $paths ? json_encode($paths) : null,
            'status' => $data['status'] ?? 'Diterima',
            'prioritas' => $data['prioritas'],
            'nis' => $student->nis,
            'pelapor' => $student->name,
            'ket' => $data['isi'],
            'urgensi' => $data['prioritas'],
        ];
        $complaint = new Complaint;
        $complaint->forceFill(Complaint::onlyCols($attrs))->save();

        Complaint::addHistory($complaint->id, $complaint->status, 'Dibuat oleh admin atas nama siswa', $request->user()->id, true);
        $log = Complaint::addLog('pengaduan', "Membuat pengaduan {$complaint->tiket} atas nama {$student->name}");
        $histories = Complaint::historiesFor([$complaint->id]);

        return response()->json([
            'complaint' => $complaint->fresh('user')->toPanel($histories[$complaint->id] ?? []),
            'log' => $log,
        ], 201);
    }

    /**
     * Remove a complaint created by a student or administrator.
     */
    public function adminDestroy(Complaint $complaint)
    {
        foreach ($complaint->fotoPaths() as $p) {
            Storage::disk('public')->delete($p);
        }

        $label = $complaint->tiket.' "'.($complaint->judul ?: Str::limit((string) $complaint->ket, 40)).'"';
        $id = $complaint->id;
        $complaint->delete();

        try {
            DB::table('complaint_histories')->where('complaint_id', $id)->delete();
        } catch (\Throwable $e) {
            report($e);
        }

        return response()->json(['log' => Complaint::addLog('hapus', "Menghapus pengaduan {$label}")]);
    }

    /**
     * Export filtered complaints as a CSV download.
     */
    public function adminExport(Request $request)
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date'],
            'student_id' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', 'siswa')],
            'status' => ['nullable', Rule::in(Complaint::STATUS)],
            'kategori' => ['nullable', 'string', 'max:60'],
            'prioritas' => ['nullable', Rule::in(Complaint::PRIORITAS)],
        ]);

        $rows = Complaint::with('user:id,name,nis,kelas')
            ->when($request->from, fn ($q, $v) => $q->whereDate('created_at', '>=', $v))
            ->when($request->to, fn ($q, $v) => $q->whereDate('created_at', '<=', $v))
            ->when($request->student_id, fn ($q, $v) => $q->where('user_id', $v))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->when($request->kategori, fn ($q, $v) => $q->where('kategori', $v))
            ->when($request->prioritas, fn ($q, $v) => $q->where('prioritas', $v))
            ->orderBy('created_at')->get()
            ->map(fn ($c) => $c->toPanel())
            ->values();

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['No', 'Tiket', 'Tanggal', 'NIS', 'Siswa', 'Kelas', 'Kategori', 'Lokasi', 'Judul', 'Isi', 'Prioritas', 'Status', 'Petugas', 'Tanggapan']);
            foreach ($rows as $i => $p) {
                fputcsv($out, [$i + 1, $p['tiket'], $p['tanggal'], $p['nis'], $p['nama'], $p['kelas'], $p['kategori'], $p['lokasi'],
                    $p['judul'], $p['isi'], $p['prioritas'], $p['status'], $p['petugas'], $p['tanggapan']]);
            }
            fclose($out);
        }, 'laporan-rekap-pengaduan-'.now()->format('Ymd').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Update an administrator's display name and record the activity.
     */
    public function adminProfile(Request $request)
    {
        $data = $request->validateWithBag('updateProfile', ['name' => ['required', 'string', 'max:255']]);
        $request->user()->update(['name' => $data['name']]);
        Complaint::addLog('profil', 'Memperbarui nama profil menjadi '.$data['name']);

        return redirect()->route('dashboard')->with('status', 'profile-updated');
    }
}
