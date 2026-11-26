<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Complaint extends Model
{
    public const KATEGORI = ['Ruang Kelas', 'Toilet & Sanitasi', 'Laboratorium', 'AC & Kelistrikan', 'Lapangan Olahraga', 'IT & Jaringan', 'Perpustakaan', 'Lainnya'];

    public const STATUS = ['Menunggu', 'Diterima', 'Diproses', 'Selesai', 'Ditolak'];

    public const PRIORITAS = ['Tinggi', 'Sedang', 'Rendah'];

    protected $guarded = [];

    protected $casts = ['estimasi_selesai' => 'datetime'];

    /* ---------------- Skema ---------------- */

    /**
     * Cache the columns available in the complaints table for legacy schemas.
     */
    public static function cols(): array
    {
        static $cols = null;
        if ($cols === null) {
            try {
                $cols = Schema::getColumnListing('complaints');
            } catch (\Throwable $e) {
                $cols = [];
            }
        }

        return $cols;
    }

    /**
     * Check whether a complaint-table column is available.
     */
    public static function hasCol(string $name): bool
    {
        return in_array($name, self::cols(), true);
    }

    /** Hanya ambil atribut yang benar-benar ada kolomnya. */
    public static function onlyCols(array $attrs): array
    {
        return array_intersect_key($attrs, array_flip(self::cols()));
    }

    /* ---------------- Relasi & accessor ---------------- */

    /**
     * Get the account that submitted this complaint.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Build the public ticket number from the creation year and record ID.
     */
    public function getTiketAttribute(): string
    {
        $d = $this->created_at ?? now();

        return '#PG-'.$d->format('Y').'-'.str_pad((string) $this->id, 3, '0', STR_PAD_LEFT);
    }

    /** Daftar path foto (disimpan sebagai JSON array, atau satu path lama). */
    public function fotoPaths(): array
    {
        $v = $this->attributes['foto'] ?? null;
        if (! $v) {
            return [];
        }
        if (str_starts_with($v, '[')) {
            $arr = json_decode($v, true);

            return is_array($arr) ? array_values($arr) : [];
        }

        return [$v];
    }

    /**
     * Convert stored photo paths into URLs for the frontend.
     */
    public function getFotosAttribute(): array
    {
        return array_map(fn ($p) => asset('storage/'.$p), $this->fotoPaths());
    }

    /**
     * Map the legacy urgency value to the current priority labels.
     */
    private function legacyPrioritas(): string
    {
        $u = strtolower((string) ($this->urgensi ?? ''));
        if (str_contains($u, 'tinggi') || str_contains($u, 'mendesak') || str_contains($u, 'darurat')) {
            return 'Tinggi';
        }
        if (str_contains($u, 'rendah')) {
            return 'Rendah';
        }

        return 'Sedang';
    }

    /** Bentuk data untuk panel admin / portal siswa. */
    public function toPanel(array $hist = []): array
    {
        $this->loadMissing('user:id,name,nis,kelas');

        $created = $this->created_at ?? now();
        $nama = $this->user->name ?? ($this->pelapor ?? '-');
        $judul = $this->judul ?: Str::limit((string) ($this->ket ?? ''), 60, '…');
        $isi = $this->isi ?: (string) ($this->ket ?? '');

        $initial = [
            'status' => 'Menunggu',
            'catatan' => 'Pengaduan diajukan oleh siswa',
            'oleh' => $nama,
            'waktu' => $created->toIso8601String(),
            'notified' => true,
        ];
        $riwayat = $hist;
        if (empty($riwayat) || ($riwayat[0]['status'] ?? '') !== 'Menunggu') {
            array_unshift($riwayat, $initial);
        }

        $respon = null;
        foreach ($riwayat as $e) {
            if (($e['status'] ?? '') !== 'Menunggu') {
                $respon = (int) round(abs($created->diffInMinutes(Carbon::parse($e['waktu']))));
                break;
            }
        }

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'tiket' => $this->tiket,
            'tanggal' => $created->format('Y-m-d'),
            'waktu' => $created->toIso8601String(),
            'nama' => $nama,
            'nis' => $this->user->nis ?? ($this->nis ?? '-'),
            'kelas' => $this->user->kelas ?? '-',
            'kategori' => (string) $this->kategori,
            'lokasi' => (string) $this->lokasi,
            'judul' => $judul,
            'isi' => $isi,
            'fotos' => $this->fotos,
            'status' => $this->status ?: 'Menunggu',
            'prioritas' => $this->prioritas ?: $this->legacyPrioritas(),
            'petugas' => $this->petugas,
            'estimasi' => $this->estimasi_selesai ? $this->estimasi_selesai->format('Y-m-d\TH:i') : null,
            'tanggapan' => $this->tanggapan,
            'respon_menit' => $respon,
            'riwayat' => array_values($riwayat),
        ];
    }

    /* ---------------- Riwayat tiket ---------------- */

    /**
     * Group complaint history records by complaint ID for panel rendering.
     */
    public static function historiesFor($ids): array
    {
        if (empty($ids) || ! Schema::hasTable('complaint_histories')) {
            return [];
        }

        try {
            $rows = DB::table('complaint_histories as h')
                ->leftJoin('users as u', 'u.id', '=', 'h.user_id')
                ->whereIn('h.complaint_id', $ids)
                ->orderBy('h.created_at')->orderBy('h.id')
                ->get(['h.complaint_id', 'h.status', 'h.catatan', 'h.notified', 'h.created_at', 'u.name as oleh']);
        } catch (\Throwable $e) {
            report($e);

            return [];
        }

        $out = [];
        foreach ($rows as $r) {
            $out[$r->complaint_id][] = [
                'status' => $r->status,
                'catatan' => $r->catatan,
                'oleh' => $r->oleh,
                'waktu' => Carbon::parse($r->created_at)->toIso8601String(),
                'notified' => (bool) $r->notified,
            ];
        }

        return $out;
    }

    /**
     * Save a status or follow-up entry when the history table is available.
     */
    public static function addHistory(int $complaintId, string $status, ?string $catatan, ?int $userId, bool $notified = true): void
    {
        if (! Schema::hasTable('complaint_histories')) {
            return;
        }

        try {
            $now = now();
            DB::table('complaint_histories')->insert([
                'complaint_id' => $complaintId,
                'user_id' => $userId,
                'status' => $status,
                'catatan' => $catatan,
                'notified' => $notified,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }
    }

    /* ---------------- Riwayat aktivitas ---------------- */

    /**
     * Persist a user's activity and return its display payload.
     */
    public static function addLog(string $aksi, string $text, ?User $actor = null): array
    {
        $now = now();
        $actor ??= auth()->user();
        $name = $actor?->name ?? '-';
        $role = $actor?->role;
        $label = $role ? $name.' ('.ucfirst($role).')' : $name;

        try {
            DB::table('admin_logs')->insert([
                'user_id' => $actor?->id,
                'actor_name' => $name,
                'actor_role' => $role,
                'aksi' => $aksi,
                'deskripsi' => Str::limit($text, 480, ''),
                'ip' => request()->ip(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        } catch (\Throwable $e) {
            report($e);
        }

        return [
            'aksi' => $aksi,
            'text' => $text,
            'actor' => $label,
            'actor_role' => $role,
            'waktu' => $now->toIso8601String(),
        ];
    }

    /**
     * Retrieve recent user activity in frontend-ready format.
     */
    public static function logs(int $limit = 2000): array
    {
        try {
            return DB::table('admin_logs as l')
                ->leftJoin('users as u', 'u.id', '=', 'l.user_id')
                ->orderByDesc('l.id')->limit($limit)
                ->get([
                    'l.aksi',
                    'l.deskripsi',
                    'l.created_at',
                    'l.actor_name',
                    'l.actor_role',
                    'u.name as user_name',
                    'u.role as user_role',
                ])
                ->map(function ($row): array {
                    $name = $row->actor_name ?? $row->user_name ?? '-';
                    $role = $row->actor_role ?? $row->user_role;

                    return [
                        'aksi' => $row->aksi,
                        'text' => $row->deskripsi,
                        'actor' => $role ? $name.' ('.ucfirst($role).')' : $name,
                        'actor_role' => $role,
                        'waktu' => Carbon::parse($row->created_at)->toIso8601String(),
                    ];
                })->all();
        } catch (\Throwable $e) {
            report($e);

            return [];
        }
    }
}
