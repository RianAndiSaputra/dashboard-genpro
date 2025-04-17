<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hpp_ extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'omzet_id',
        'hpp_id',
        'biayaops_id',
        'GROSS_PROFITgross_profit_id',
        'NET_PROFITnet_profit_id',
        'GROSS_PROFIT_MARGINgross_profit_margin_id',
        'nett_profit_margin_id',
        'company_id',
    ];
}
