<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect('/profile');

        $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
    }

    public function test_correct_password_must_be_provided_to_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ]);

        $response
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }

    public function test_admin_can_update_their_password_from_the_admin_route(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this
            ->actingAs($admin)
            ->put(route('admin.password.update'), [
                'current_password' => 'password',
                'password' => 'new-admin-password',
                'password_confirmation' => 'new-admin-password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertTrue(Hash::check('new-admin-password', $admin->refresh()->password));
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $admin->id,
            'aksi' => 'sandi',
            'deskripsi' => 'Mengganti kata sandi',
        ]);
    }

    public function test_student_password_change_is_recorded_in_admin_history(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);

        $response = $this
            ->actingAs($student)
            ->put(route('account.password'), [
                'current_password' => 'password',
                'password' => 'new-student-password',
                'password_confirmation' => 'new-student-password',
            ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $student->id,
            'actor_name' => $student->name,
            'actor_role' => 'siswa',
            'aksi' => 'sandi',
        ]);
    }
}
