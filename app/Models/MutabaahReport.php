<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutabaahReport extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'mentee_id',
        'solat_berjamaah',
        'baca_quraan',
        'solat_duha',
        'puasa_sunnah',
        'sodaqoh_subuh',
        'relasibaru',
        'menabung',
        'penjualan',
    ];

    public function mentee()
    {
        return $this->belongsTo(MenteeProfile::class, 'mentee_id', 'id');
    }
}
