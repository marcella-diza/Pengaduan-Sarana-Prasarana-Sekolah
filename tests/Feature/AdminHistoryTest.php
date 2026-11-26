<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_completed_follow_up_is_added_to_admin_history(): void
    {
        $admin = User::factory()->create([
            'nis' => 'ADMIN001',
            'role' => 'admin',
        ]);
        $reporter = User::factory()->create([
            'nis' => 'SISWA001',
            'role' => 'siswa',
        ]);
        $complaint = Complaint::create([
            'user_id' => $reporter->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala.',
            'status' => 'Diproses',
        ]);

        $response = $this->actingAs($admin)->patchJson(
            route('admin.complaints.update', $complaint),
            ['status' => 'Selesai']
        );

        $response->assertOk()
            ->assertJsonPath('log.aksi', 'pengaduan')
            ->assertJsonPath('log.text', "Menyelesaikan tindak lanjut pengaduan {$complaint->tiket} \"Lampu rusak\"");
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'Selesai',
        ]);
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $admin->id,
            'aksi' => 'pengaduan',
            'deskripsi' => "Menyelesaikan tindak lanjut pengaduan {$complaint->tiket} \"Lampu rusak\"",
        ]);
    }

    public function test_non_completed_follow_up_is_not_added_to_admin_history(): void
    {
        $admin = User::factory()->create([
            'nis' => 'ADMIN001',
            'role' => 'admin',
        ]);
        $reporter = User::factory()->create([
            'nis' => 'SISWA001',
            'role' => 'siswa',
        ]);
        $complaint = Complaint::create([
            'user_id' => $reporter->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala.',
            'status' => 'Menunggu',
        ]);

        $response = $this->actingAs($admin)->patchJson(
            route('admin.complaints.update', $complaint),
            ['status' => 'Diproses']
        );

        $response->assertOk()->assertJsonPath('log', null);
        $this->assertDatabaseEmpty('admin_logs');
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'status' => 'Diproses',
        ]);
    }

    public function test_recap_export_is_not_added_to_admin_history(): void
    {
        $admin = User::factory()->create([
            'nis' => 'ADMIN001',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.rekap.export'));

        $response->assertDownload();
        $this->assertDatabaseEmpty('admin_logs');
    }

    public function test_admin_cannot_save_an_estimated_datetime_in_the_past(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'siswa']);
        $complaint = Complaint::create([
            'user_id' => $student->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala.',
            'status' => 'Diproses',
        ]);

        $response = $this->actingAs($admin)->patchJson(
            route('admin.complaints.update', $complaint),
            ['estimasi' => '2024-01-15T09:30', 'estimasi_offset' => 0]
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['estimasi'])
            ->assertJsonPath('errors.estimasi.0', 'Waktu estimasi harus sekarang atau di masa depan.');
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'estimasi_selesai' => null,
        ]);
    }

    public function test_admin_can_save_an_estimated_datetime_in_the_future_in_their_local_timezone(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'siswa']);
        $complaint = Complaint::create([
            'user_id' => $student->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala.',
            'status' => 'Diproses',
        ]);
        $localEstimate = now('UTC')->addHours(8)->format('Y-m-d\TH:i');

        $response = $this->actingAs($admin)->patchJson(
            route('admin.complaints.update', $complaint),
            ['estimasi' => $localEstimate, 'estimasi_offset' => -420]
        );

        $response->assertOk()
            ->assertJsonPath('complaint.estimasi', $localEstimate);
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'estimasi_selesai' => str_replace('T', ' ', $localEstimate).':00',
        ]);
    }

    public function test_student_complaint_changes_are_visible_in_admin_history_with_their_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create([
            'name' => 'Siswa Terpantau',
            'role' => 'siswa',
        ]);
        $complaint = Complaint::create([
            'user_id' => $student->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala.',
            'status' => 'Menunggu',
        ]);

        $this->actingAs($student)->putJson(route('complaint.update', $complaint), [
            'kategori' => 'Ruang Kelas',
            'judul' => 'Lampu kelas rusak',
            'gedung' => 'Gedung A',
            'detail' => 'Lantai 1',
            'prioritas' => 'Sedang',
            'isi' => 'Lampu ruang kelas tidak menyala dan mengganggu kegiatan belajar.',
        ])->assertOk();

        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $student->id,
            'actor_name' => 'Siswa Terpantau',
            'actor_role' => 'siswa',
            'aksi' => 'pengaduan',
        ]);

        $this->actingAs($admin)->get('/dashboard')
            ->assertSee('Siswa Terpantau (Siswa)')
            ->assertSee('Mengubah pengaduan');
    }

    public function test_admin_activity_page_shows_filters_without_a_clear_history_button(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/dashboard')
            ->assertSee('id="hFrom"', false)
            ->assertSee('id="hTo"', false)
            ->assertSee('id="hRole"', false)
            ->assertSee('id="hAction"', false)
            ->assertSee('id="hSearch"', false)
            ->assertSee('id="resetHistFilters"', false)
            ->assertSee('id="historyCsv"', false)
            ->assertSee('class="history-filter-actions"', false)
            ->assertDontSee('id="clearHist"', false)
            ->assertDontSee('Hapus Riwayat');
    }

    public function test_admin_activity_history_cannot_be_cleared_through_the_old_endpoint(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        Complaint::addLog('login', 'Login ke sistem');

        $this->deleteJson('/admin/riwayat')->assertNotFound();

        $this->assertDatabaseCount('admin_logs', 1);
    }
}
