<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Machine;
use App\Models\MaintenanceOrder;
use App\Models\ProductionLine;

class production_line extends Model
{
    use HasFactory;
    protected static function newFactory()
    {
        return \Database\Factories\ProductionLineFactory::new();
    }

    protected $fillable = [
        'code',
        'name',
        'location',
        'supervisor',
        'status',
    ];

    public function machines()
    {
        return $this->hasMany(Machine::class);
    }
}