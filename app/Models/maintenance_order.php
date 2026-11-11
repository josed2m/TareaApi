<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Machine;
use App\Models\MaintenanceOrder;
use App\Models\ProductionLine;

class maintenance_order extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return \Database\Factories\MaintenanceOrderFactory::new();
    }

    protected $fillable = [
        'order_number',
        'maintenance_type',
        'description',
        'status',
        'estimated_cost',
        'actual_cost',
        'technician',
        'scheduled_at',
        'completed_at',
        'machine_id',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}