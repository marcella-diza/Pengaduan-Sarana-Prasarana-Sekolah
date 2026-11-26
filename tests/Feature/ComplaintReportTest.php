<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ComplaintReportTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_the_dashboard(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    public function test_student_can_see_feedback_that_admin_notified_them_about(): void
    {
        $student = $this->createStudent('STU100');
        $admin = User::factory()->create(['role' => 'admin']);
        $feedback = 'Teknisi akan datang besok pagi.';
        $complaint = $this->createComplaint($student, ['tanggapan' => $feedback]);
        Complaint::addHistory($complaint->id, 'Diproses', $feedback, $admin->id, true);

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertViewHas('mine', function (array $reports) use ($feedback): bool {
            return ($reports[0]['tanggapan'] ?? null) === $feedback;
        });
    }

    public function test_student_cannot_see_feedback_admin_did_not_notify_them_about(): void
    {
        $student = $this->createStudent('STU101');
        $admin = User::factory()->create(['role' => 'admin']);
        $feedback = 'Catatan internal admin yang tidak dikirim.';
        $complaint = $this->createComplaint($student, ['tanggapan' => $feedback]);
        Complaint::addHistory($complaint->id, 'Diproses', $feedback, $admin->id, false);

        $response = $this->actingAs($student)->get('/dashboard');

        $response->assertViewHas('mine', function (array $reports): bool {
            return ($reports[0]['tanggapan'] ?? null) === null;
        })->assertDontSee($feedback);
    }

    public function test_admin_can_filter_recap_and_csv_export_by_student(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = $this->createStudent('STU102', 'Siswa Terpilih');
        $otherStudent = $this->createStudent('STU103', 'Siswa Lain');
        $this->createComplaint($student, ['judul' => 'Lampu milik siswa terpilih']);
        $this->createComplaint($otherStudent, ['judul' => 'Lampu milik siswa lain']);

        $page = $this->actingAs($admin)->get('/dashboard');
        $page->assertSee('id="rStudent"', false)
            ->assertSee('id="rGroup"', false)
            ->assertSee('id="rBreakdown"', false);

        $response = $this->get(route('admin.rekap.export', ['student_id' => $student->id]));

        $response->assertStreamed();
        $csv = $response->streamedContent();
        $this->assertStringContainsString('Siswa Terpilih', $csv);
        $this->assertStringContainsString('Lampu milik siswa terpilih', $csv);
        $this->assertStringNotContainsString('Siswa Lain', $csv);
        $this->assertStringNotContainsString('Lampu milik siswa lain', $csv);
    }

    public function test_admin_export_rejects_a_non_student_filter_id(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.rekap.export', [
            'student_id' => $otherAdmin->id,
        ]));

        $response->assertInvalid(['student_id']);
    }

    private function createStudent(string $nis, string $name = 'Siswa Tes'): User
    {
        return User::factory()->create([
            'nis' => $nis,
            'name' => $name,
            'kelas' => 'X MIPA 1',
            'role' => 'siswa',
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
