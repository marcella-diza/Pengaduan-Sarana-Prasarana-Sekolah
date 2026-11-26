<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_guests_see_login_on_home_and_remember_is_opt_in(): void
    {
        $response = $this->get('/');

        $response->assertSee('Masuk ke Portal')
            ->assertSee('name="remember" value="1"', false)
            ->assertDontSee('name="remember" value="1" checked', false);
        $this->assertGuest();
    }

    public function test_admins_have_only_the_header_logout_option(): void
    {
        $admin = User::factory()->create([
            'nis' => 'admin-test',
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/');

        $response->assertSee('Keluar')
            ->assertDontSee('Log out');
    }

    public function test_admin_name_is_shown_in_the_header_and_profile(): void
    {
        $admin = User::factory()->create([
            'name' => 'Ika',
            'email' => 'ika@example.test',
            'role' => 'admin',
        ]);

        $this->actingAs($admin)->get('/dashboard')
            ->assertSee('<b>Ika</b>', false)
            ->assertSee('value="Ika"', false)
            ->assertDontSee('<b>Administrator</b>', false);
    }

    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'identity' => $user->nis,
            'password' => 'password',
            'role' => 'siswa',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard', absolute: false));
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $user->id,
            'actor_role' => 'siswa',
            'aksi' => 'login',
        ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'identity' => $user->nis,
            'password' => 'wrong-password',
            'role' => 'siswa',
        ]);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create(['role' => 'siswa']);

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('admin_logs', [
            'user_id' => $user->id,
            'actor_role' => 'siswa',
            'aksi' => 'logout',
        ]);
    }
}
