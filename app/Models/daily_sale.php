<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class daily_sale extends Model
{
    /** @use HasFactory<\Database\Factories\DailySaleFactory> */
    use HasFactory , LogsActivity;
    protected $table = 'daily_sales';

    protected $fillable = [
        'production_id',
        'category',
        'type',
        'quantity',
        'amount',
        'unit_price',
        'paid',
        'remaining',
        'date',
        'payment_due_date',
        'buyer_name',
        'buyer_id',
        'description',
        'created_by'
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
     protected $casts = [
        'date' => 'date', // هنا الحل!
        'payment_due_date' => 'date', // لو payment_due_date كمان بيسبب نفس المشكلة
    ];
     public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

}
