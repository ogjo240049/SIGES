<?php

namespace Database\Factories;

use App\Models\vehiculos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<vehiculos>
 */
class vehiculosFactory extends Factory
{
    protected $model = vehiculos::class;

    public function definition(): array
    {
        return [
            'nombre' => fake()->unique()->word() . ' Taxi',
            'placa' => strtoupper(fake()->bothify('???-####')),
            'marca' => fake()->randomElement(['Nissan', 'Toyota', 'Kia', 'Hyundai']),
            'modelo' => fake()->randomElement(['Versa', 'Yaris', 'Rio', 'Accent']),
            'motor' => fake()->bothify('MTR-####'),
            'serie' => fake()->unique()->bothify('SR-########'),
            'concesionario' => fake()->company(),
        ];
    }
}