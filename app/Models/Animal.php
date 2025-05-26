<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Animal extends Model
{
    use HasFactory , LogsActivity;
    protected $table = 'animals';

    protected $fillable = [
        'animal_code',
        'type',
        'breed',
        'age',
        'weight',
        'health_status',
        'gender',
        'origin',
        'arrival_date',
        'status',
        'pen_id',
        'insemination_type',
        'created_by',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    // العلاقة مع المستخدم (user)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function milkProductions()
    {
        return $this->hasMany(MilkProductionDetails::class, 'animal_id', 'animal_code');
    }
}
