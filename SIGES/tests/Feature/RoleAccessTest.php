<?php

namespace Tests\Feature;

use App\Models\choferes;
use App\Models\pagos;
use App\Models\User;
use App\Models\vehiculos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_everything(): void
    {
        $admin = User::factory()->create(['rol' => 1]);

        $this->actingAs($admin)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Gestión de usuarios')
            ->assertSee('Gestión de taxis')
            ->assertSee('Gestión de inventario')
            ->assertSee('Gestión de compras')
            ->assertSee('Reportes financieros');

        $this->actingAs($admin)->get(route('usuarios.index'))->assertOk();
        $this->actingAs($admin)->get(route('vehiculos.index'))->assertOk();
        $this->actingAs($admin)->get(route('inventarios.index'))->assertOk();
        $this->actingAs($admin)->get(route('compras.index'))->assertOk();
        $this->actingAs($admin)->get(route('reportes.index'))->assertOk();
    }

    public function test_operator_can_access_only_operational_modules(): void
    {
        $operator = User::factory()->create(['rol' => 2]);

        $this->actingAs($operator)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee('Gestión de choferes')
            ->assertSee('Bitácora de choferes')
            ->assertSee('Gestión de servicios')
            ->assertSee('Gestión de pagos')
            ->assertDontSee('Gestión de usuarios')
            ->assertDontSee('Gestión de taxis')
            ->assertDontSee('Gestión de inventario')
            ->assertDontSee('Gestión de compras')
            ->assertDontSee('Reportes financieros');

        $this->actingAs($operator)->get(route('pagos.index'))->assertOk();
        $this->actingAs($operator)->get(route('choferes.index'))->assertOk();
        $this->actingAs($operator)->get(route('bitacoras.index'))->assertOk();
        $this->actingAs($operator)->get(route('servicios.index'))->assertOk();

        $this->actingAs($operator)->get(route('usuarios.index'))->assertForbidden();
        $this->actingAs($operator)->get(route('vehiculos.index'))->assertForbidden();
        $this->actingAs($operator)->get(route('inventarios.index'))->assertForbidden();
        $this->actingAs($operator)->get(route('compras.index'))->assertForbidden();
        $this->actingAs($operator)->get(route('reportes.index'))->assertForbidden();
    }

    public function test_driver_can_only_see_their_own_payments_and_cannot_manage_them(): void
    {
        $driverUser = User::factory()->create(['rol' => 3]);
        $otherUser = User::factory()->create(['rol' => 3]);

        $vehicle = vehiculos::factory()->create();
        $otherVehicle = vehiculos::factory()->create();

        $driverChofer = choferes::create([
            'id_usuario' => $driverUser->id,
            'unidad_asignada' => $vehicle->matricula,
            'identificacion' => 'CHO-DRIVER',
        ]);

        $otherChofer = choferes::create([
            'id_usuario' => $otherUser->id,
            'unidad_asignada' => $otherVehicle->matricula,
            'identificacion' => 'CHO-OTHER',
        ]);

        $ownPayment = pagos::create([
            'id_chofer' => $driverChofer->id_chofer,
            'fecha_pago' => '2026-07-01',
            'monto_pago' => 120,
        ]);

        $otherPayment = pagos::create([
            'id_chofer' => $otherChofer->id_chofer,
            'fecha_pago' => '2026-07-02',
            'monto_pago' => 220,
        ]);

        $this->actingAs($driverUser)
            ->get(route('pagos.index'))
            ->assertOk()
            ->assertSee(number_format(120, 2, ',', '.'))
            ->assertDontSee(number_format(220, 2, ',', '.'));

        $this->actingAs($driverUser)
            ->get(route('pagos.show', $ownPayment))
            ->assertOk();

        $this->actingAs($driverUser)
            ->get(route('pagos.show', $otherPayment))
            ->assertForbidden();

        $this->actingAs($driverUser)->get(route('pagos.create'))->assertForbidden();
        $this->actingAs($driverUser)->get(route('pagos.edit', $ownPayment))->assertForbidden();
        $this->actingAs($driverUser)->delete(route('pagos.destroy', $ownPayment))->assertForbidden();
    }
}