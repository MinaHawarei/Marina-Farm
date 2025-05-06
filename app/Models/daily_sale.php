<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class daily_sale extends Model
{
    /** @use HasFactory<\Database\Factories\DailySaleFactory> */
    use HasFactory;
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
}
