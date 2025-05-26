<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\daily_sale;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class buyers extends Model
{
    /** @use HasFactory<\Database\Factories\BuyersFactory> */
    use HasFactory , LogsActivity;
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
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}
