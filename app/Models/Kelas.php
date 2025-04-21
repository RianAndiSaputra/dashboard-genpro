<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MenteeProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kelas extends Model
{
    use HasFactory;

    // protected $primaryKey = 'kelas_id';
    protected $fillable = [
        'user_id',
        'class_name',
        'mentor_id',
        'secretary_id',
        'mentee_id',
        'user_ids',
    ];

    public function mentee()
    {
        return $this->belongsTo(User::class, 'mentee_id', 'user_id');
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id', 'user_id'); // Sesuaikan 'mentor_id' dan 'user_id'
    }

    public function secretary()
    {
        return $this->belongsTo(User::class, 'secretary_id', 'user_id'); // Sesuaikan 'secretary_id' dan 'user_id'
    }

    public function mentees()
    {
        return $this->hasMany(MenteeProfile::class, 'kelas_id', 'id'); // sesuaikan foreign key dan local key
    }
    // public function menteee()
    // {
    //     return $this->belongsTo(MenteeProfile::class, 'mentee_id', 'user_id');
    // }
}
