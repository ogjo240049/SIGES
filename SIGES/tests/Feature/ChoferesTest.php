<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\choferes;
use App\Models\vehiculos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChoferesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_manage_choferes(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@siges.test',
            'rol' => 1,
            'password' => 'password',
        ]);

        $driverUser = User::factory()->create([
            'email' => 'chofer@siges.test',
            'rol' => 3,
            'password' => 'password',
        ]);

        $vehiculo = vehiculos::create([
            'nombre' => 'Unidad 1',
            'placa' => 'XYZ-123',
            'marca' => 'Nissan',
            'modelo' => 'Tsuru',
            'motor' => 'MTR-01',
            'serie' => 'SER-01',
            'concesionario' => 'Concesionario SIGES',
        ]);

        $this->actingAs($admin)
            ->get(route('choferes.index'))
            ->assertOk()
            ->assertSee('Gestión de choferes');

        $this->actingAs($admin)
            ->post(route('choferes.store'), [
                'id_usuario' => $driverUser->id,
                'unidad_asignada' => $vehiculo->matricula,
                'identificacion' => 'ID-001',
            ])
            ->assertRedirect(route('choferes.index'));

        $chofer = choferes::firstOrFail();

        $this->assertSame((int) $vehiculo->matricula, (int) $chofer->unidad_asignada);

        $this->actingAs($admin)
            ->put(route('choferes.update', $chofer), [
                'id_usuario' => $driverUser->id,
                'unidad_asignada' => null,
                'identificacion' => 'ID-002',
            ])
            ->assertRedirect(route('choferes.index'));

        $chofer->refresh();

        $this->assertSame('ID-002', $chofer->identificacion);
        $this->assertNull($chofer->unidad_asignada);

        $this->actingAs($admin)
            ->delete(route('choferes.destroy', $chofer))
            ->assertRedirect(route('choferes.index'));

        $this->assertDatabaseMissing('choferes', [
            'id_chofer' => $chofer->id_chofer,
        ]);
    }
}