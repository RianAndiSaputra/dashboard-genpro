<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NettProfit_ extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'nett_profit__id';
    protected $table = 'nett_profit_';
    protected $fillable = ['targert_', 'realisasi_'];
}
