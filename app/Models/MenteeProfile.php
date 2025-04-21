<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenteeProfile extends Model
{
    use HasFactory;

    // protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'kelas_id',
        'company_id',
        'address',
        'profile_picture',
        'bidang_usaha',
        'badan_hukum',
        'tahun_berdiri',
        'jumlah_karyawan',
        'jumlah_omset',
        'jabatan',
        'komitmen',
        'gambar_laporan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function attendance()
    {
        return $this->hasOne(Attendance::class);
    }

    public function mutabah()
    {
        return $this->hasOne(MutabaahReport::class);
    }
}
