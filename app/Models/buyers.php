<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\daily_sale;
class buyers extends Model
{
    /** @use HasFactory<\Database\Factories\BuyersFactory> */
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
        return $this->hasMany(daily_sale::class, 'buyer_id');
    }
}
