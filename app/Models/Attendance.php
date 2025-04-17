<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'mentee_id',
        'check_in_time',
        'selfie_url',
    ];

    protected $casts = [
        'check_in_time' => 'datetime',
    ];

    public function mentee()
    {
        return $this->belongsTo(MenteeProfile::class);
    }
}
