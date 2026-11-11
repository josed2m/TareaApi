<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\maintenance_order; 
use Illuminate\Http\Request;

class Maintenance_OrderController extends Controller 
{
    // Consulta 4: Órdenes sin fecha de finalización (usando whereNull, where y select)
    public function pendingCompletionOrders()
    {
        $orders = maintenance_order::select('order_number', 'maintenance_type', 'status', 'technician', 'estimated_cost')
            ->whereNull('completed_at')
            ->where('status', '!=', 'finalizado')
            ->get();

        return response()->json($orders);
    }
    
    // Consulta 5: Órdenes con costo real registrado y estado finalizado (whereNotNull, where, select)
    public function completedOrdersWithCost()
    {
        $orders = maintenance_order::select('order_number', 'machine_id', 'estimated_cost', 'actual_cost')
            ->with('machine:id,name,code')
            ->whereNotNull('actual_cost')
            ->where('status', 'finalizado')
            ->get();

        return response()->json($orders);
    }
}