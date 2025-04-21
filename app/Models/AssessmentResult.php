<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssessmentResult extends Model
{
    use HasFactory;

    protected $primaryKey = 'asn_id';
    protected $fillable = [
        'mentee_id',
        'assessment_data',
        'suggested_phase',
    ];

    protected $casts = [
        'assessment_data' => 'array',
    ];
}
