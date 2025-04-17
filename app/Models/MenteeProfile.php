<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MenteeProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'mentee_id';
    protected $fillable = [
        'kelas_id',
        'user_id',
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
        return $this->belongsTo(User::class);
    } 

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
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
