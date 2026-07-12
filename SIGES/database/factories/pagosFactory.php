<?php

namespace Database\Factories;

use App\Models\choferes;
use App\Models\pagos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<pagos>
 */
class pagosFactory extends Factory
{
    protected $model = pagos::class;

    public function definition(): array
    {
        return [
            'id_chofer' => choferes::factory(),
            'fecha_pago' => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
            'monto_pago' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}