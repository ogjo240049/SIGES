<?php

namespace Tests\Feature;

use App\Models\bitacora;
use App\Models\choferes;
use App\Models\pagos;
use App\Models\servicios;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UsuariosTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_manage_users(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@siges.test',
            'rol' => 1,
            'password' => 'password',
        ]);

        $this->actingAs($admin)
            ->get(route('usuarios.index'))
            ->assertOk()
            ->assertSee('Gestión de usuarios');

        $this->actingAs($admin)
            ->post(route('usuarios.store'), [
                'name' => 'Nuevo',
                'apellido_pat' => 'Usuario',
                'apellido_mat' => 'SIGES',
                'telefono' => '5551234567',
                'rol' => 2,
                'email' => 'nuevo@siges.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect(route('usuarios.index'));

        $user = User::where('email', 'nuevo@siges.test')->firstOrFail();

        $this->actingAs($admin)
            ->put(route('usuarios.update', $user), [
                'name' => 'Usuario',
                'apellido_pat' => 'Actualizado',
                'apellido_mat' => 'SIGES',
                'telefono' => '5557654321',
                'rol' => 3,
                'email' => 'actualizado@siges.test',
                'password' => 'password456',
                'password_confirmation' => 'password456',
            ])
            ->assertRedirect(route('usuarios.index'));

        $user->refresh();

        $this->assertSame('actualizado@siges.test', $user->email);
        $this->assertSame(3, $user->rol);
        $this->assertTrue(Hash::check('password456', $user->password));

        $this->actingAs($admin)
            ->delete(route('usuarios.destroy', $user))
            ->assertRedirect(route('usuarios.index'));

        $this->assertDatabaseMissing('users', [
            'email' => 'actualizado@siges.test',
        ]);
    }

    public function test_user_cannot_delete_their_own_account(): void
    {
        $user = User::factory()->create([
            'email' => 'self@siges.test',
            'rol' => 1,
            'password' => 'password',
        ]);

        $this->actingAs($user)
            ->delete(route('usuarios.destroy', $user))
            ->assertRedirect(route('usuarios.index'))
            ->assertSessionHas('error', 'No puedes eliminar tu propia cuenta.');

        $this->assertDatabaseHas('users', [
            'email' => 'self@siges.test',
        ]);
    }

    public function test_admin_can_delete_user_with_chofer_dependencies(): void
    {
        $admin = User::factory()->create([
            'rol' => 1,
            'password' => 'password',
        ]);

        $driverUser = User::factory()->create([
            'rol' => 3,
            'password' => 'password',
        ]);

        $chofer = choferes::factory()->create([
            'id_usuario' => $driverUser->id,
        ]);

        $pago = pagos::factory()->create([
            'id_chofer' => $chofer->id_chofer,
        ]);

        $servicio = servicios::factory()->create([
            'id_chofer' => $chofer->id_chofer,
        ]);

        $bitacora = bitacora::factory()->create([
            'id_chofer' => $chofer->id_chofer,
        ]);

        $this->actingAs($admin)
            ->delete(route('usuarios.destroy', $driverUser))
            ->assertRedirect(route('usuarios.index'))
            ->assertSessionHas('success', 'Usuario eliminado correctamente.');

        $this->assertDatabaseMissing('users', [
            'id' => $driverUser->id,
        ]);

        $this->assertDatabaseMissing('choferes', [
            'id_chofer' => $chofer->id_chofer,
        ]);

        $this->assertDatabaseMissing('pagos', [
            'id_pago' => $pago->id_pago,
        ]);

        $this->assertDatabaseMissing('servicios', [
            'id_servicio' => $servicio->id_servicio,
        ]);

        $this->assertDatabaseMissing('bitacoras', [
            'id_bitacora' => $bitacora->id_bitacora,
        ]);
    }
}