<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biayaops extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'biayaops_id';
    protected $table = 'biayaops';
    protected $fillable = ['targert', 'realisasi'];

    public function businessProgress()
    {
        return $this->hasOne(BusinessProgress::class);
    }
}
