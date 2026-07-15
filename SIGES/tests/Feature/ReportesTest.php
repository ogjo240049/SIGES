<?php

namespace Tests\Feature;

use App\Models\choferes;
use App\Models\pagos;
use App\Models\User;
use App\Models\vehiculos;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportesTest extends TestCase
{
    use RefreshDatabase;

    public function test_reports_page_generates_expected_payments_reports(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@siges.test',
            'rol' => 1,
            'password' => 'password',
        ]);

        $vehiculoUno = vehiculos::create([
            'marca' => 'Nissan',
            'modelo' => 'Versa',
            'motor' => '1.6',
            'serie' => 'SERIE-001',
        ]);

        $vehiculoDos = vehiculos::create([
            'marca' => 'Toyota',
            'modelo' => 'Yaris',
            'motor' => '1.5',
            'serie' => 'SERIE-002',
        ]);

        $choferUno = choferes::create([
            'id_usuario' => User::factory()->create(['rol' => 3])->id,
            'unidad_asignada' => $vehiculoUno->matricula,
            'identificacion' => 'CHOFER-001',
        ]);

        $choferDos = choferes::create([
            'id_usuario' => User::factory()->create(['rol' => 3])->id,
            'unidad_asignada' => $vehiculoDos->matricula,
            'identificacion' => 'CHOFER-002',
        ]);

        pagos::create([
            'id_chofer' => $choferUno->id_chofer,
            'fecha_pago' => '2026-07-01',
            'monto_pago' => 100,
        ]);

        pagos::create([
            'id_chofer' => $choferUno->id_chofer,
            'fecha_pago' => '2026-07-02',
            'monto_pago' => 150,
        ]);

        pagos::create([
            'id_chofer' => $choferDos->id_chofer,
            'fecha_pago' => '2026-07-08',
            'monto_pago' => 300,
        ]);

        $this->actingAs($admin)
            ->get(route('reportes.index', [
                'reporte' => 'chofer',
                'id_chofer' => $choferUno->id_chofer,
            ]))
            ->assertOk()
            ->assertSee('Reporte de pagos por chofer')
            ->assertSee('$250,00');

        $this->actingAs($admin)
            ->get(route('reportes.index', [
                'reporte' => 'unidad',
                'matricula' => $vehiculoUno->matricula,
            ]))
            ->assertOk()
            ->assertSee('Reporte de pagos por unidad de taxi')
            ->assertSee('$250,00');

        $this->actingAs($admin)
            ->get(route('reportes.index', [
                'reporte' => 'fechas',
                'fecha_inicio' => '2026-07-01',
                'fecha_fin' => '2026-07-31',
            ]))
            ->assertOk()
            ->assertSee('Reporte de pagos por rango de fechas')
            ->assertSee('$550,00');

        $this->actingAs($admin)
            ->get(route('reportes.index', ['reporte' => 'semanal']))
            ->assertOk()
            ->assertSee('Reporte semanal del total de ingresos registrados')
            ->assertSee('$550,00');
    }

    public function test_reports_can_be_downloaded_as_pdf(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@siges.test',
            'rol' => 1,
            'password' => 'password',
        ]);

        $vehiculo = vehiculos::create([
            'marca' => 'Nissan',
            'modelo' => 'Versa',
            'motor' => '1.6',
            'serie' => 'SERIE-010',
        ]);

        $chofer = choferes::create([
            'id_usuario' => User::factory()->create(['rol' => 3])->id,
            'unidad_asignada' => $vehiculo->matricula,
            'identificacion' => 'CHO-0100',
        ]);

        pagos::create([
            'id_chofer' => $chofer->id_chofer,
            'fecha_pago' => '2026-07-01',
            'monto_pago' => 200,
        ]);

        $this->actingAs($admin)
            ->get(route('reportes.pdf', [
                'reporte' => 'chofer',
                'id_chofer' => $chofer->id_chofer,
            ]))
            ->assertOk()
            ->assertDownload('reporte-de-pagos-por-chofer.pdf');
    }
}