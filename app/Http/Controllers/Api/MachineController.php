<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\machine;
use App\Models\production_line;
use App\Models\maintenance_order;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    // Consulta 1: Máquinas filtradas por línea de producción y estado
    public function machinesByLineAndStatus(Request $request)
    {
        $lineId = $request->query('production_line_id');
        $status = $request->query('status');

        $query = machine::query();

        if ($lineId) {
            $query->where('production_line_id', $lineId);
        }

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json($query->get());
    }

    // Consulta 2: Máquinas por criticidad
    public function machinesByCriticality(Request $request)
    {
        $criticality = $request->query('criticality', 'alta');
        $machines = machine::where('criticality', $criticality)->get();

        return response()->json($machines);
    }

    // Consulta 3: Máquinas operativas disponibles
    public function availableMachines()
    {
        $machines = machine::where('status', 'operativa')->get();

        return response()->json($machines);
    }

    // Consulta 6: Máquinas con órdenes de mantenimiento pendientes
    public function machinesWithPendingOrders()
    {
        $machines = machine::whereHas('maintenanceOrders', function ($q) {
            $q->where('status', 'pendiente');
        })->with(['maintenanceOrders' => function ($q) {
            $q->where('status', 'pendiente');
        }])->get();

        return response()->json($machines);
    }

    // Consulta 7: Máquinas con mantenimiento correctivo
    public function machinesWithCorrectiveMaintenance()
    {
        $machines = machine::whereHas('maintenanceOrders', function ($q) {
            $q->where('maintenance_type', 'correctivo');
        })->get();

        return response()->json($machines);
    }

    // Consulta 8: Máquinas sin órdenes de mantenimiento
    public function machinesWithoutOrders()
    {
        $machines = machine::doesntHave('maintenanceOrders')->get();

        return response()->json($machines);
    }

    // Consulta 9: Tipos únicos de máquinas (distintos)
    public function uniqueMachineTypes()
    {
        $types = machine::distinct()->pluck('type');

        return response()->json($types);
    }
}