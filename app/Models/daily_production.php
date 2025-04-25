<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily_production extends Model
{
    /** @use HasFactory<\Database\Factories\DailyProductionFactory> */
    use HasFactory;
    protected $fillable = ['buffaloMilk', 'cowMilk', 'eggs', 'dates', 'created_by', 'production_date', 'notes'];

}
