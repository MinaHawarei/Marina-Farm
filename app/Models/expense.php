<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expense extends Model
{
    /** @use HasFactory<\Database\Factories\ExpenseFactory> */
    use HasFactory;
    protected $fillable = [
        'category',
        'type',
        'quantity',
        'unit_price',
        'amount',
        'paid',
        'remaining',
        'date',
        'supplier_name',
        'supplier_id',
        'description',
        'created_by',
    ];

}
