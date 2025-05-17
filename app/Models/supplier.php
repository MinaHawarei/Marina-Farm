<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Expense;

class supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'purchase_type',
    ];
    public function sales()
    {
        return $this->hasMany(Expense::class, 'supplier_id');
    }
}
