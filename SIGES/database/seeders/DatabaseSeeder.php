<?php

namespace Database\Seeders;

use App\Models\bitacora;
use App\Models\choferes;
use App\Models\compras;
use App\Models\inventario;
use App\Models\pagos;
use App\Models\servicios;
use App\Models\User;
use App\Models\vehiculos;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin SIGES',
            'apellido_pat' => 'Principal',
            'apellido_mat' => 'Sistema',
            'telefono' => '5550000001',
            'rol' => 1,
            'email' => 'admin@siges.test',
        ]);

        $users = collect([
            $admin,
            User::factory()->create([
                'name' => 'Carlos',
                'apellido_pat' => 'López',
                'apellido_mat' => 'Ramírez',
                'telefono' => '5550000002',
                'rol' => 3,
                'email' => 'carlos@siges.test',
            ]),
            User::factory()->create([
                'name' => 'María',
                'apellido_pat' => 'Hernández',
                'apellido_mat' => 'Gómez',
                'telefono' => '5550000003',
                'rol' => 3,
                'email' => 'maria@siges.test',
            ]),
            User::factory()->create([
                'name' => 'Laura',
                'apellido_pat' => 'Pérez',
                'apellido_mat' => 'Díaz',
                'telefono' => '5550000004',
                'rol' => 2,
                'email' => 'laura@siges.test',
            ]),
        ]);

        $vehiculos = vehiculos::factory()
            ->count(4)
            ->create();

        $choferes = collect([
            choferes::create([
                'id_usuario' => $users[1]->id,
                'unidad_asignada' => $vehiculos[0]->matricula,
                'identificacion' => 'CHO-1001',
            ]),
            choferes::create([
                'id_usuario' => $users[2]->id,
                'unidad_asignada' => $vehiculos[1]->matricula,
                'identificacion' => 'CHO-1002',
            ]),
            choferes::create([
                'id_usuario' => $users[3]->id,
                'unidad_asignada' => $vehiculos[2]->matricula,
                'identificacion' => 'CHO-1003',
            ]),
        ]);

        $inventarios = inventario::factory()
            ->count(6)
            ->create();

        foreach ($inventarios as $inventario) {
            compras::create([
                'id_inventario' => $inventario->id_inventario,
                'precio_unitario' => fake()->randomFloat(2, 20, 500),
                'cantidad_compra' => fake()->numberBetween(1, 20),
                'fecha' => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                'lugar_compra' => fake()->company(),
            ]);
        }

        foreach ($choferes as $index => $chofer) {
            pagos::create([
                'id_chofer' => $chofer->id_chofer,
                'fecha_pago' => now()->subDays($index * 7 + 1)->format('Y-m-d'),
                'monto_pago' => 250 + ($index * 50),
            ]);

            servicios::create([
                'origen_viaje' => fake()->city(),
                'destino_viaje' => fake()->city(),
                'id_chofer' => $chofer->id_chofer,
                'fecha_pedido' => now()->subDays($index * 5 + 2)->format('Y-m-d'),
            ]);

            bitacora::create([
                'id_chofer' => $chofer->id_chofer,
                'fecha_hora' => now()->subHours($index * 6 + 1),
                'locacion' => fake()->address(),
            ]);
        }
    }
}
