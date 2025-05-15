<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tool extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'available',
        'last_maintenance_at',
        'lifespan_years',
        'maintenance_frequency',
    ];

}
