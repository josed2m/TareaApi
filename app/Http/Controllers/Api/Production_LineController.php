<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\production_line;
use Illuminate\Http\Request;
use App\Models\machine;

class Production_LineController extends Controller
{
    // Consulta 10: Máquinas de líneas activas con órdenes pendientes (usando whereHas y where)
    public function activeLinesMachinesWithPendingOrders()
    {
        $machines = machine::select('code', 'name', 'status', 'criticality', 'production_line_id')
            ->whereHas('productionLine', function ($q) {
                $q->where('status', 'activa');
            })
            ->whereHas('maintenanceOrders', function ($q) {
                $q->where('status', 'pendiente');
            })
            ->with('productionLine:id,name')
            ->get();

        return response()->json($machines);
    }
}