<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BiyayaOps_ extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'biyaya_ops__id';
    protected $table = 'biayaops_';
    protected $fillable = ['targert_', 'realisasi_'];
}
