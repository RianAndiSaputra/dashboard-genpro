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
        'lokasi_zoom',
        'kategori_kelas',
        'tanggal_mulai',
        'tanggal_selesai',
        'jam_mulai',
        'jam_selesai',
        'status',
        'deskripsi_kelas',
        'kuota_peserta',
        'pdf_path',
        'mentor_id',
        'secretary_id',
        'mentee_id',
        'user_ids',
    ];
    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
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
