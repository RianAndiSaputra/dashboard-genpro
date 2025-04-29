<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessProgress extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'omzet_id',
        'hpp_id',
        'biayaops_id',
        'gross_profit_id',
        'net_profit_id',
        'gross_profit_margin_id',
        // 'nett_profit_margin_id',
        'nett_profit_margin_id',
        'company_id',
        'targert',
        'realisasi'
    ];

    public function omzet()
    {
        return $this->belongsTo(Omzet::class);
    }
    public function hpp()
    {
        return $this->belongsTo(Hpp::class);
    }
    public function biayaops()
    {
        return $this->belongsTo(Biayaops::class);
    }
    public function grossProfit()
    {
        return $this->belongsTo(GrossProfit::class);
    }
    public function netProfit()
    {
        return $this->belongsTo(NetProfit::class);
    }
    public function grossProfitMargin()
    {
        return $this->belongsTo(GrossProfitMargin::class);
    }
    public function nettProfitMargin()
    {
        return $this->belongsTo(NettProfitMargin::class, 'nett_profit_margin_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
