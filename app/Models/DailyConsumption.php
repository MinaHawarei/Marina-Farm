<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyConsumption extends Model
{
    /** @use HasFactory<\Database\Factories\DailyConsumptionFactory> */
    use HasFactory;
    protected $fillable = ['hay','corn','clover','soybean','soybean_hulls','bran','silage','gasoline','solar','consumptions_date','created_by', 'notes'];

}
