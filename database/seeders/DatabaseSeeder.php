<?php

namespace Database\Seeders;

use App\Models\production_line;
use App\Models\machine;
use App\Models\maintenance_order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $line1 = production_line::factory()->create([
            'id' => 1,
            'code' => 'PL-001',
            'name' => 'Línea Principal de Ensamble',
            'location' => 'Nave A',
            'supervisor' => 'Carlos Gómez',
            'status' => 'activa'
        ]);
        production_line::factory(9)->create();
        $m1 = machine::factory()->create([
            'production_line_id' => 1,
            'status' => 'operativa',
            'criticality' => 'alta',
            'type' => 'Prensa'
        ]);
        $m2 = machine::factory()->create([
            'production_line_id' => 1,
            'status' => 'mantenimiento',
            'criticality' => 'media',
            'type' => 'Torno'
        ]);
        machine::factory()->create([
            'production_line_id' => $line1->id,
            'status' => 'operativa',
            'criticality' => 'baja',
            'type' => 'Robot Ensamble'
        ]);
        machine::factory(10)->create();
        maintenance_order::factory()->create([
            'machine_id' => $m1->id,
            'status' => 'pendiente',
            'maintenance_type' => 'preventivo',
            'completed_at' => null,
            'actual_cost' => null
        ]);
        maintenance_order::factory()->create([
            'machine_id' => $m2->id,
            'status' => 'finalizado',
            'maintenance_type' => 'correctivo',
            'estimated_cost' => 500.00,
            'actual_cost' => 550.00,
            'completed_at' => now()
        ]);
        maintenance_order::factory(10)->create();
    }
}