<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class DailyConsumption extends Model
{
    /** @use HasFactory<\Database\Factories\DailyConsumptionFactory> */
    use HasFactory , LogsActivity;
    protected $fillable = ['hay','corn','clover','soybean','soybean_hulls','bran','silage','gasoline','solar','consumptions_date','created_by', 'notes'];

     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
