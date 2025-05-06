<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
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
        'payment_due_date',
        'supplier_name',
        'supplier_id',
        'description',
        'created_by',
    ];

}
