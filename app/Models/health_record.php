<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class health_record extends Model
{
    /** @use HasFactory<\Database\Factories\HealthRecordFactory> */
    use HasFactory , LogsActivity;
    protected $fillable = [
        'animal_id',
        'date',
        'treatment_type',
        'veterinarian_name',
        'cost',
        'notes',
        'created_by'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
