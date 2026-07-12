<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\choferes;
use App\Models\vehiculos;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<choferes>
 */
class choferesFactory extends Factory
{
    protected $model = choferes::class;

    public function definition(): array
    {
        return [
            'id_usuario' => User::factory(),
            'unidad_asignada' => null,
            'identificacion' => fake()->unique()->bothify('CHO-####'),
        ];
    }

    public function withVehicle(?vehiculos $vehiculo = null): static
    {
        return $this->state(function () use ($vehiculo) {
            return [
                'unidad_asignada' => $vehiculo?->matricula ?? vehiculos::factory(),
            ];
        });
    }
}