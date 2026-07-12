<?php

namespace Database\Factories;

use App\Models\inventario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<inventario>
 */
class inventarioFactory extends Factory
{
    protected $model = inventario::class;

    public function definition(): array
    {
        return [
            'nombre_pieza' => fake()->unique()->words(2, true),
            'tipo_pieza' => fake()->randomElement(['Filtro', 'Llanta', 'Aceite', 'Freno', 'Batería']),
            'cantidad' => fake()->numberBetween(5, 50),
        ];
    }
}