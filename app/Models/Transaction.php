<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',          // نوع العملية (بيع، انتاج، مصروف، ايراد، مرتب، الخ)
        'product_id',    // المنتج المرتبط
        'quantity',      // الكمية (لو منتج)
        'amount',        // المبلغ (لو عملية مالية)
        'description',   // وصف العملية
        'date',          // تاريخ العملية
        'created_by',    // المستخدم اللي أنشأ العملية
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // علاقات (اختياري بس مفيد بعدين)



    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
