<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\production_line;
use Illuminate\Http\Request;

class Production_LineController extends Controller
{
    // Consulta 10: Líneas activas con máquinas que tienen órdenes pendientes
    public function activeLinesMachinesWithPendingOrders()
    {
        $lines = production_line::where('status', 'activa')
            ->whereHas('machines.maintenanceOrders', function ($query) {
                $query->where('status', 'pendiente');
            })
            ->with(['machines' => function ($q) {
                $q->whereHas('maintenanceOrders', function ($subQ) {
                    $subQ->where('status', 'pendiente');
                })->with(['maintenanceOrders' => function ($subQ) {
                    $subQ->where('status', 'pendiente');
                }]);
            }])
            ->get();

        return response()->json($lines);
    }
}