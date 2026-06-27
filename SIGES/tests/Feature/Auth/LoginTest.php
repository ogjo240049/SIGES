<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_accessible(): void
    {
        $this->get('/login')
            ->assertOk()
            ->assertSee('Iniciar sesión');
    }

    public function test_user_can_login_and_reach_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@siges.test',
            'password' => 'password',
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ])
            ->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee($user->name);
    }

    public function test_api_login_returns_a_sanctum_token_and_profile_endpoint_works(): void
    {
        $user = User::factory()->create([
            'email' => 'api@siges.test',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'token_type',
                'token',
                'user' => [
                    'id',
                    'name',
                    'email',
                ],
            ]);

        Sanctum::actingAs($user);

        $this->getJson('/api/me')
            ->assertOk()
            ->assertJsonFragment([
                'email' => $user->email,
            ]);
    }
}