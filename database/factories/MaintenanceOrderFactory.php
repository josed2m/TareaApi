<?php

namespace Database\Factories;

use App\Models\maintenance_order;
use App\Models\machine;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceOrderFactory extends Factory
{
    protected $model = maintenance_order::class;

    public function definition(): array
    {
        $status = $this->faker->randomElement(['pendiente', 'en_proceso', 'finalizado', 'cancelado']);
        $isCompleted = $status === 'finalizado';

        return [
            'machine_id' => machine::factory(),
            'order_number' => 'ORD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'maintenance_type' => $this->faker->randomElement(['preventivo', 'correctivo']),
            'description' => $this->faker->sentence(),
            'status' => $status,
            'estimated_cost' => $this->faker->randomFloat(2, 100, 2000),
            'actual_cost' => $isCompleted ? $this->faker->randomFloat(2, 100, 2200) : null,
            'technician' => $this->faker->name(),
            'scheduled_at' => $this->faker->date(),
            'completed_at' => $isCompleted ? $this->faker->date() : null,
        ];
    }
}