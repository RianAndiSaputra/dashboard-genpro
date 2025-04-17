<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NettProfitMargin_ extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nett_profit_margin__id';
    protected $table = 'nett_profit_margin_';
    protected $fillable = ['targert_', 'realisasi_'];
}
