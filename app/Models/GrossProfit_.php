<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrossProfit_ extends Model
{
    use HasFactory;
    
    // protected $primaryKey = 'gross_profit__id';
    protected $table = 'gross_profit_';
    protected $fillable = ['targert_', 'realisasi_'];
}
