<?php

namespace Database\Factories;

use App\Models\choferes;
use App\Models\servicios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<servicios>
 */
class serviciosFactory extends Factory
{
    protected $model = servicios::class;

    public function definition(): array
    {
        return [
            'origen_viaje' => fake()->city(),
            'destino_viaje' => fake()->city(),
            'id_chofer' => choferes::factory(),
            'fecha_pedido' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
        ];
    }
}