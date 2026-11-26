<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ComplaintCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_update_their_pending_complaint_and_replace_photos(): void
    {
        Storage::fake('public');
        $student = $this->createStudent('STU001');
        $oldPhoto = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldPhoto->store('complaints', 'public');
        $complaint = $this->createComplaint($student, ['foto' => json_encode([$oldPath])]);

        $response = $this->actingAs($student)->post(route('complaint.update', $complaint), [
            '_method' => 'PUT',
            'kategori' => 'Ruang Kelas',
            'judul' => 'Jendela ruang kelas rusak',
            'gedung' => 'Gedung B',
            'detail' => 'Lantai 2 ruang XI MIPA 1',
            'prioritas' => 'Tinggi',
            'isi' => 'Jendela ruang kelas sulit ditutup dan berbahaya saat hujan.',
            'hapus_foto' => [0],
            'fotos' => [UploadedFile::fake()->image('replacement.jpg')],
        ], ['Accept' => 'application/json']);

        $response->assertOk()
            ->assertJsonPath('complaint.judul', 'Jendela ruang kelas rusak')
            ->assertJsonPath('complaint.lokasi', 'Gedung B • Lantai 2 ruang XI MIPA 1')
            ->assertJsonPath('complaint.status', 'Menunggu');
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'prioritas' => 'Tinggi',
        ]);
        Storage::disk('public')->assertMissing($oldPath);
        $this->assertCount(1, Storage::disk('public')->allFiles('complaints'));
        $this->assertDatabaseHas('complaint_histories', [
            'complaint_id' => $complaint->id,
            'catatan' => 'Pengaduan diperbarui oleh siswa',
            'notified' => true,
        ]);
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $student->id,
            'actor_role' => 'siswa',
            'aksi' => 'pengaduan',
        ]);
    }

    public function test_student_complaint_submission_is_recorded_in_admin_history(): void
    {
        $student = $this->createStudent('STU011');

        $response = $this->actingAs($student)->post(route('complaint.store'), [
            'kategori' => 'Ruang Kelas',
            'judul' => 'Pintu kelas rusak',
            'gedung' => 'Gedung A',
            'detail' => 'Lantai 1 ruang XI MIPA 1',
            'prioritas' => 'Sedang',
            'isi' => 'Pintu ruang kelas sulit ditutup dan mengganggu kegiatan belajar.',
            'pernyataan' => '1',
        ]);

        $response->assertRedirect(route('dashboard'));
        $complaint = Complaint::query()->where('user_id', $student->id)->firstOrFail();
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $student->id,
            'actor_name' => $student->name,
            'actor_role' => 'siswa',
            'aksi' => 'pengaduan',
            'deskripsi' => "Mengirim pengaduan {$complaint->tiket} \"{$complaint->judul}\"",
        ]);
    }

    public function test_student_cannot_update_another_students_complaint(): void
    {
        $owner = $this->createStudent('STU002');
        $otherStudent = $this->createStudent('STU003');
        $complaint = $this->createComplaint($owner);

        $response = $this->actingAs($otherStudent)->putJson(route('complaint.update', $complaint), [
            'kategori' => 'Ruang Kelas',
            'judul' => 'Perubahan tidak sah',
            'gedung' => 'Gedung A',
            'detail' => 'Lantai 1',
            'prioritas' => 'Sedang',
            'isi' => 'Deskripsi yang cukup panjang untuk memenuhi validasi.',
        ]);

        $response->assertForbidden();
        $this->assertDatabaseHas('complaints', ['id' => $complaint->id, 'judul' => 'Lampu rusak']);
    }

    public function test_processed_complaints_cannot_be_updated_by_student(): void
    {
        $student = $this->createStudent('STU004');
        $complaint = $this->createComplaint($student, ['status' => 'Diproses']);

        $response = $this->actingAs($student)->putJson(route('complaint.update', $complaint), [
            'kategori' => 'Ruang Kelas',
            'judul' => 'Perubahan tidak diizinkan',
            'gedung' => 'Gedung A',
            'detail' => 'Lantai 1',
            'prioritas' => 'Sedang',
            'isi' => 'Deskripsi yang cukup panjang untuk memenuhi validasi.',
        ]);

        $response->assertUnprocessable()
            ->assertJsonPath('message', 'Pengaduan sudah diproses admin dan tidak dapat diubah.');
        $this->assertDatabaseHas('complaints', ['id' => $complaint->id, 'status' => 'Diproses']);
    }

    public function test_student_cannot_delete_a_processed_complaint(): void
    {
        $student = $this->createStudent('STU008');
        $complaint = $this->createComplaint($student, ['status' => 'Diproses']);

        $response = $this->actingAs($student)->deleteJson(route('complaint.destroy', $complaint));

        $response->assertUnprocessable()
            ->assertJsonPath('message', 'Pengaduan sudah diproses admin dan tidak dapat diubah.');
        $this->assertDatabaseHas('complaints', ['id' => $complaint->id, 'status' => 'Diproses']);
    }

    public function test_student_can_delete_their_pending_complaint_and_related_files_and_history(): void
    {
        Storage::fake('public');
        $student = $this->createStudent('STU005');
        $photoPath = UploadedFile::fake()->image('evidence.jpg')->store('complaints', 'public');
        $complaint = $this->createComplaint($student, ['foto' => json_encode([$photoPath])]);
        Complaint::addHistory($complaint->id, 'Menunggu', 'Pengaduan diajukan oleh siswa', $student->id);

        $response = $this->actingAs($student)->deleteJson(route('complaint.destroy', $complaint));

        $response->assertOk()->assertJsonPath('id', $complaint->id);
        $this->assertDatabaseMissing('complaints', ['id' => $complaint->id]);
        $this->assertDatabaseMissing('complaint_histories', ['complaint_id' => $complaint->id]);
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $student->id,
            'actor_role' => 'siswa',
            'aksi' => 'pengaduan',
        ]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_student_cannot_delete_another_students_complaint(): void
    {
        $owner = $this->createStudent('STU006');
        $otherStudent = $this->createStudent('STU007');
        $complaint = $this->createComplaint($owner);

        $response = $this->actingAs($otherStudent)->deleteJson(route('complaint.destroy', $complaint));

        $response->assertForbidden();
        $this->assertDatabaseHas('complaints', ['id' => $complaint->id]);
    }

    public function test_admin_can_create_a_complaint_for_a_student(): void
    {
        $admin = User::factory()->create(['nis' => 'ADMIN001', 'role' => 'admin']);
        $student = $this->createStudent('STU009');

        $response = $this->actingAs($admin)->postJson(route('admin.complaints.store'), [
            'user_id' => $student->id,
            'kategori' => 'Toilet & Sanitasi',
            'judul' => 'Keran wastafel bocor',
            'gedung' => 'Gedung C',
            'detail' => 'Toilet lantai 1',
            'prioritas' => 'Sedang',
            'isi' => 'Keran wastafel terus mengeluarkan air dan perlu diperbaiki.',
        ]);

        $response->assertCreated()
            ->assertJsonPath('complaint.nama', $student->name)
            ->assertJsonPath('complaint.status', 'Diterima');
        $this->assertDatabaseHas('complaints', [
            'user_id' => $student->id,
            'judul' => 'Keran wastafel bocor',
            'status' => 'Diterima',
        ]);
        $this->assertDatabaseHas('complaint_histories', [
            'status' => 'Diterima',
            'catatan' => 'Dibuat oleh admin atas nama siswa',
            'user_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('admin_logs', ['user_id' => $admin->id, 'aksi' => 'pengaduan']);
    }

    public function test_admin_cannot_create_a_complaint_for_another_admin_account(): void
    {
        $admin = User::factory()->create(['nis' => 'ADMIN002', 'role' => 'admin']);
        $otherAdmin = User::factory()->create(['nis' => 'ADMIN003', 'role' => 'admin']);

        $response = $this->actingAs($admin)->postJson(route('admin.complaints.store'), [
            'user_id' => $otherAdmin->id,
            'kategori' => 'Ruang Kelas',
            'judul' => 'Lampu rusak',
            'gedung' => 'Gedung A',
            'detail' => 'Lantai 1',
            'prioritas' => 'Sedang',
            'isi' => 'Lampu ruang kelas mati dan mengganggu kegiatan belajar.',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors('user_id');
        $this->assertDatabaseCount('complaints', 0);
    }

    public function test_admin_can_edit_complaint_content_without_changing_status(): void
    {
        $admin = User::factory()->create(['nis' => 'ADMIN004', 'role' => 'admin']);
        $student = $this->createStudent('STU010');
        $complaint = $this->createComplaint($student);

        $response = $this->actingAs($admin)->patchJson(route('admin.complaints.update', $complaint), [
            'judul' => 'Lampu lorong rusak',
            'kategori' => 'AC & Kelistrikan',
            'lokasi' => 'Gedung A • Lantai 2',
            'isi' => 'Lampu lorong lantai dua mati dan area menjadi gelap saat sore.',
        ]);

        $response->assertOk()
            ->assertJsonPath('complaint.judul', 'Lampu lorong rusak')
            ->assertJsonPath('complaint.status', 'Menunggu');
        $this->assertDatabaseHas('complaints', [
            'id' => $complaint->id,
            'judul' => 'Lampu lorong rusak',
            'status' => 'Menunggu',
        ]);
        $this->assertDatabaseHas('complaint_histories', [
            'complaint_id' => $complaint->id,
            'catatan' => 'Data pengaduan diperbarui oleh admin',
            'notified' => false,
        ]);
        $this->assertDatabaseHas('admin_logs', ['user_id' => $admin->id, 'aksi' => 'pengaduan']);
    }

    private function createStudent(string $nis): User
    {
        return User::factory()->create([
            'nis' => $nis,
            'role' => 'siswa',
            'kelas' => 'X MIPA 1',
        ]);
    }

    private function createComplaint(User $student, array $attributes = []): Complaint
    {
        return Complaint::create(array_merge([
            'user_id' => $student->id,
            'kategori' => 'Ruang Kelas',
            'lokasi' => 'Gedung A • Lantai 1',
            'judul' => 'Lampu rusak',
            'isi' => 'Lampu ruang kelas tidak menyala dan mengganggu kegiatan belajar.',
            'status' => 'Menunggu',
        ], $attributes));
    }
}
