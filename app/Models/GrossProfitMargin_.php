<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrossProfitMargin_ extends Model
{
    use HasFactory;
    
    // protected $primaryKey = 'gross_profit_margin__id';
    protected $table = 'gross_profit_margin_';
    protected $fillable = ['targert_', 'realisasi_'];
}
