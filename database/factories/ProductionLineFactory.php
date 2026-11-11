<?php

namespace Database\Factories;

use App\Models\production_line;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductionLineFactory extends Factory
{
    protected $model = production_line::class;

    public function definition(): array
    {
        return [
            'code' => 'PL-' . $this->faker->unique()->numberBetween(100, 999),
            'name' => 'Línea de ' . $this->faker->randomElement(['Ensamble', 'Pintura', 'Empaque', 'Estampado', 'Corte']),
            'location' => 'Nave ' . $this->faker->randomElement(['A', 'B', 'C', 'D']),
            'supervisor' => $this->faker->name(),
            'status' => $this->faker->randomElement(['activa', 'inactiva']),
        ];
    }
}