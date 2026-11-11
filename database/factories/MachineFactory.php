<?php

namespace Database\Factories;

use App\Models\machine;
use App\Models\production_line;
use Illuminate\Database\Eloquent\Factories\Factory;

class MachineFactory extends Factory
{
    protected $model = machine::class;

    public function definition(): array
    {
        return [
            'production_line_id' => production_line::factory(),
            'code' => 'MAC-' . $this->faker->unique()->numberBetween(100, 999),
            'name' => 'Máquina ' . $this->faker->word(),
            'type' => $this->faker->randomElement(['Prensa', 'Torno', 'Cinta Transportadora', 'Robot Ensamble', 'Compresor']),
            'status' => $this->faker->randomElement(['operativa', 'mantenimiento', 'fuera_servicio']),
            'criticality' => $this->faker->randomElement(['alta', 'media', 'baja']),
            'installation_date' => $this->faker->date(),
        ];
    }
}