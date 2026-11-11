<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MachineController;
use App\Http\Controllers\Api\Maintenance_OrderController;
use App\Http\Controllers\Api\Production_LineController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// CONSULTA 1
Route::get('/machines/status', [MachineController::class, 'machinesByLineAndStatus']);
// CONSULTA 2
Route::get('/machines/criticality', [MachineController::class, 'machinesByCriticality']);
// CONSULTA 3
Route::get('/machines/available', [MachineController::class, 'availableMachines']);
// CONSULTA 4
Route::get('/maintenance-orders/pending-completion', [Maintenance_OrderController::class, 'pendingCompletionOrders']);
// CONSULTA 5
Route::get('/maintenance-orders/completed-with-cost', [Maintenance_OrderController::class, 'completedOrdersWithCost']);
// CONSULTA 6
Route::get('/machines/pending-orders', [MachineController::class, 'machinesWithPendingOrders']);
// CONSULTA 7
Route::get('/machines/corrective-maintenance', [MachineController::class, 'machinesWithCorrectiveMaintenance']);
// CONSULTA 8
Route::get('/machines/machines-without-orders', [MachineController::class, 'machinesWithoutOrders']);
// CONSULTA 9
Route::get('/machines/unique-types', [MachineController::class, 'uniqueMachineTypes']);
// CONSULTA 10
Route::get('/production-lines/active-machines-pending-orders', [Production_LineController::class, 'activeLinesMachinesWithPendingOrders']);