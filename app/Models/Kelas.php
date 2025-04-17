<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    protected $primaryKey = 'kelas_id';
    protected $fillable = [
        'class_name',
        'mentors_id',
        'secretarys_id',
    ];

    public function mentee()
    {
        return $this->hasMany(MenteeProfile::class);
    }
}
