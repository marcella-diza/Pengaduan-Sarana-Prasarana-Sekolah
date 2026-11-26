<?php

namespace Tests\Feature;

use App\Models\Complaint;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_student_account(): void
    {
        $admin = $this->createAdmin('ADMIN101');
        $studentData = [
            'role' => 'siswa',
            'name' => 'Siswa Baru',
            'nis' => 'SISWA101',
            'kelas' => 'XI MIPA 2',
            'email' => 'siswa101@example.test',
            'password' => 'initial-pass',
        ];

        $created = $this->actingAs($admin)->postJson(route('admin.pengguna.store'), $studentData);

        $created->assertCreated()->assertJsonPath('user.role', 'siswa');
        $studentId = $created->json('user.id');
        $this->assertDatabaseHas('users', ['id' => $studentId, 'nis' => 'SISWA101', 'kelas' => 'XI MIPA 2']);
        $this->assertDatabaseHas('admin_logs', ['user_id' => $admin->id, 'aksi' => 'pengguna']);
    }

    public function test_admin_can_update_a_student_account(): void
    {
        $admin = $this->createAdmin('ADMIN108');
        $student = $this->createStudent('SISWA108');

        $response = $this->actingAs($admin)->putJson(route('admin.pengguna.update', $student), [
            'name' => 'Siswa Diperbarui',
            'nis' => $student->nis,
            'kelas' => 'XI MIPA 3',
            'email' => $student->email,
        ]);

        $response->assertOk()->assertJsonPath('user.name', 'Siswa Diperbarui');
        $this->assertDatabaseHas('users', ['id' => $student->id, 'kelas' => 'XI MIPA 3']);
    }

    public function test_admin_can_list_users_as_json(): void
    {
        $admin = $this->createAdmin('ADMIN109');
        $student = $this->createStudent('SISWA109');

        $this->actingAs($admin)->getJson(route('admin.pengguna.index'))
            ->assertOk()
            ->assertJsonFragment(['id' => $student->id, 'role' => 'siswa']);
    }

    public function test_duplicate_student_nis_is_rejected_with_a_field_error(): void
    {
        $admin = $this->createAdmin('ADMIN102');
        $this->createStudent('SISWA102');

        $response = $this->actingAs($admin)->postJson(route('admin.pengguna.store'), [
            'role' => 'siswa',
            'name' => 'Siswa Duplikat',
            'nis' => 'SISWA102',
            'kelas' => 'X MIPA 1',
            'password' => 'initial-pass',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['nis'])
            ->assertJsonPath('errors.nis.0', 'NIS ini sudah terdaftar.');
    }

    public function test_admin_cannot_change_a_users_role_through_the_edit_endpoint(): void
    {
        $admin = $this->createAdmin('ADMIN103');
        $student = $this->createStudent('SISWA103');

        $response = $this->actingAs($admin)->putJson(route('admin.pengguna.update', $student), [
            'role' => 'admin',
            'name' => 'Siswa',
            'nis' => 'SISWA103',
            'kelas' => 'X MIPA 1',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['role']);
        $this->assertDatabaseHas('users', ['id' => $student->id, 'role' => 'siswa']);
    }

    public function test_student_cannot_access_user_management_routes(): void
    {
        $student = $this->createStudent('SISWA110');

        $response = $this->actingAs($student)->getJson(route('admin.pengguna.index'));

        $response->assertForbidden();
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = $this->createAdmin('ADMIN104');

        $response = $this->actingAs($admin)->deleteJson(route('admin.pengguna.destroy', $admin));

        $response->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
    }

    public function test_student_with_complaints_requires_confirmation_before_deletion(): void
    {
        $admin = $this->createAdmin('ADMIN105');
        $student = $this->createStudent('SISWA105');
        $complaint = $this->createComplaint($student);

        $response = $this->actingAs($admin)->deleteJson(route('admin.pengguna.destroy', $student));

        $response->assertUnprocessable()
            ->assertJsonPath('count', 1)
            ->assertJsonPath('message', 'Siswa memiliki 1 pengaduan. Hapus pengaduan beserta foto dan riwayatnya?');
        $this->assertDatabaseHas('users', ['id' => $student->id]);
        $this->assertDatabaseHas('complaints', ['id' => $complaint->id]);
    }

    public function test_admin_can_delete_a_student_with_confirmed_complaints_and_related_files(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin('ADMIN106');
        $student = $this->createStudent('SISWA106');
        $photoPath = UploadedFile::fake()->image('student-evidence.jpg')->store('complaints', 'public');
        $complaint = $this->createComplaint($student, ['foto' => json_encode([$photoPath])]);
        Complaint::addHistory($complaint->id, 'Menunggu', 'Pengaduan diajukan oleh siswa', $student->id);

        $response = $this->actingAs($admin)->deleteJson(
            route('admin.pengguna.destroy', $student),
            ['hapus_pengaduan' => 1]
        );

        $response->assertOk()->assertJsonPath('id', $student->id);
        $this->assertDatabaseMissing('users', ['id' => $student->id]);
        $this->assertDatabaseMissing('complaints', ['id' => $complaint->id]);
        $this->assertDatabaseMissing('complaint_histories', ['complaint_id' => $complaint->id]);
        Storage::disk('public')->assertMissing($photoPath);
    }

    public function test_password_reset_returns_the_new_password_once_and_persists_its_hash(): void
    {
        $admin = $this->createAdmin('ADMIN107');
        $student = $this->createStudent('SISWA107');

        $response = $this->actingAs($admin)->postJson(route('admin.pengguna.reset-password', $student));

        $password = $response->assertOk()->json('password');
        $this->assertSame(10, strlen($password));
        $this->assertTrue(Hash::check($password, $student->fresh()->password));
        $this->assertDatabaseHas('admin_logs', ['user_id' => $admin->id, 'aksi' => 'pengguna']);
    }

    private function createAdmin(string $nis): User
    {
        return User::factory()->create(['nis' => $nis, 'role' => 'admin', 'kelas' => '-']);
    }

    private function createStudent(string $nis): User
    {
        return User::factory()->create(['nis' => $nis, 'role' => 'siswa', 'kelas' => 'X MIPA 1']);
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
