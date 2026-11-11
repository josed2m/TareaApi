<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\production_line; 
use App\Models\maintenance_order; 
use App\Models\MachineFactory; 

class machine extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return \Database\Factories\MachineFactory::new();
    }

    protected $fillable = [
        'code',
        'name',
        'type',
        'status',
        'criticality',
        'installation_date',
        'production_line_id',
    ];

    public function productionLine()
    {
        return $this->belongsTo(production_line::class, 'production_line_id');
    }

    public function maintenanceOrders()
    {
        return $this->hasMany(maintenance_order::class, 'machine_id');
    }
}