<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class health_record extends Model
{
    /** @use HasFactory<\Database\Factories\HealthRecordFactory> */
    use HasFactory;
    protected $fillable = [
        'animal_id',
        'date',
        'treatment_type',
        'veterinarian_name',
        'cost',
        'notes',
        'created_by'];
}
