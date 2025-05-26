<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class daily_production extends Model
{
    /** @use HasFactory<\Database\Factories\DailyProductionFactory> */
    use HasFactory , LogsActivity;
    protected $table = 'daily_productions';


    protected $fillable = ['buffaloMilk', 'cowMilk', 'eggs', 'dates','ghee','cheese', 'clover', 'created_by', 'production_date', 'notes'];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
