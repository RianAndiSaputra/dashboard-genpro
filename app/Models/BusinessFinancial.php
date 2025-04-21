<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessFinancial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'hpp__id',
        'biyaya_ops__id',
        'gross_profit__id',
        'nett_profit__id',
        'gross_profit_margin__id',
        'nett_profit_margin__id',
        // 'capaian_target_neet_profit__id',
        'company_id',
        'realisasi',
        'capaian_target_nett_profit',
    ];

    // Relasi dengan explicit foreign key
    public function hpp()
    {
        return $this->belongsTo(Hpp_::class, 'hpp__id');
    }

    public function biyayaOps()
    {
        return $this->belongsTo(BiyayaOps_::class, 'biyaya_ops__id');
    }

    public function grossProfit()
    {
        return $this->belongsTo(GrossProfit_::class, 'gross_profit__id');
    }

    public function nettProfit()
    {
        return $this->belongsTo(NettProfit_::class, 'nett_profit__id');
    }

    public function grossProfitMargin()
    {
        return $this->belongsTo(GrossProfitMargin_::class, 'gross_profit_margin__id');
    }

    public function nettProfitMargin()
    {
        return $this->belongsTo(NettProfitMargin_::class, 'nett_profit_margin__id');
    }

    public function capaianTargetNeetProfit()
    {
        return $this->belongsTo(CapaianTargetNettProfit_::class, 'capaian_target_neet_profit__id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
