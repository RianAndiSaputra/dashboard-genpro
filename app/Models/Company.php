<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'email',
        'nomor_wa',
    ];

    public function mentee()
    {
        return $this->hasMany(MenteeProfile::class);
    }

    public function businessFinancial()
    {
        return $this->hasOne(BusinessFinancial::class);
    }
    public function businessProgress()
    {
        return $this->hasOne(BusinessProgress::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
