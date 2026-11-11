<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\machine;
use App\Models\production_line;
use App\Models\maintenance_order;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    // Consulta 1: Máquinas por línea y estado (versión compacta en 5 líneas)
    public function machinesByLineAndStatus(Request $request)
    {
        $query = $request->query('status') 
            ? machine::where('status', $request->query('status')) 
            : machine::where('status', 'operativa')->orWhere('status', 'mantenimiento');

        if ($request->query('production_line_id')) $query->where('production_line_id', $request->query('production_line_id'));

        return response()->json($query->get());
    }

    // Consulta 2: Máquinas por criticidad (usando whereIn y select)
    public function machinesByCriticality(Request $request)
    {
        $criticalities = (array) $request->query('criticality', ['alta','media']);

        $machines = machine::select('id', 'name', 'type', 'criticality', 'status', 'production_line_id')
            ->whereIn('criticality', $criticalities)
            ->get();

        return response()->json($machines);
    }

    // Consulta 3: Máquinas operativas disponibles (excluyendo fuera de servicio y mantenimiento)
    public function availableMachines()
    {
        $machines = machine::select('id', 'name', 'type', 'status', 'production_line_id')
            ->whereNotIn('status', ['fuera_servicio', 'mantenimiento'])
            ->get();

        return response()->json($machines);
    }

    // Consulta 6: Máquinas con órdenes pendientes (usando whereHas y where)
    public function machinesWithPendingOrders()
    {
        $machines = machine::whereHas('maintenanceOrders', function ($q) {
            $q->where('status', 'pendiente');
        })->get();

        return response()->json($machines);
    }

    // Consulta 7: Máquinas con mantenimiento correctivo finalizado (usando whereHas, where y select)
    public function machinesWithCorrectiveMaintenance()
    {
        $machines = machine::select('code', 'name', 'status', 'criticality')
            ->whereHas('maintenanceOrders', function ($q) {
                $q->where('maintenance_type', 'correctivo')
                ->where('status', 'finalizado');
            })->get();

        return response()->json($machines);
    }

    // Consulta 8: Máquinas sin órdenes de mantenimiento
    public function machinesWithoutOrders()
    {
        $machines = machine::doesntHave('maintenanceOrders')
        ->select('code', 'name', 'status', 'criticality')
        ->get();
        return response()->json($machines);
    }

    // Consulta 9: Tipos únicos de máquinas (usando distinct y select)
    public function uniqueMachineTypes()
    {
        $types = machine::select('type')
            ->distinct()
            ->pluck('type');

        return response()->json($types);
    }
}