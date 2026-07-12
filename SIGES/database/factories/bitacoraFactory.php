<?php

namespace Database\Factories;

use App\Models\bitacora;
use App\Models\choferes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<bitacora>
 */
class bitacoraFactory extends Factory
{
    protected $model = bitacora::class;

    public function definition(): array
    {
        return [
            'id_chofer' => choferes::factory(),
            'fecha_hora' => fake()->dateTimeBetween('-30 days', 'now'),
            'locacion' => fake()->address(),
        ];
    }
}