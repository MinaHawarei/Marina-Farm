<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $table = 'animals';

    // الحقول القابلة للتعبئة
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
    ];

    // العلاقة مع المستخدم (user)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
