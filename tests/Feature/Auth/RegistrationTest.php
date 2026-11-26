<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertSee('Registrasi Akun Siswa');
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'nis' => '20260001',
            'name' => 'Test User',
            'kelas' => 'X MIPA 1',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'nis' => '20260001',
            'name' => 'Test User',
            'role' => 'siswa',
        ]);
        $this->assertDatabaseHas('admin_logs', [
            'actor_name' => 'Test User',
            'actor_role' => 'siswa',
            'aksi' => 'akun',
            'deskripsi' => 'Mendaftar sebagai siswa',
        ]);
        $response->assertRedirect(route('login'));
    }
}
