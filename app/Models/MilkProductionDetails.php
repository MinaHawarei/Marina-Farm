<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class MilkProductionDetails extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'milk_production_details';

    // الحقول القابلة للتعبئة
    protected $fillable = [
        'animal_id' ,
        'morning_milk' ,
        'evening_milk',
        'total_milk',
        'date',
        'notes',
        'created_by',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    // العلاقة مع المستخدم (user)
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
