<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessFinancial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'hpp__id',
        'biayaops__id',
        'gross_profit__id',
        'nett_profit__id',
        'gross_profit_margin__id',
        'nett_profit_margin__id',
        'capaian_target_neet__id',
        'company_id',
        'realisasi',
    ];

    public function hpp_()
    {
        return $this->belongsTo(Hpp_::class);
    }
    public function biayaops_()
    {
        return $this->belongsTo(BiyayaOps_::class);
    }
    public function grossProfit_()
    {
        return $this->belongsTo(GrossProfit_::class);
    }
    public function nettProfit()
    {
        return $this->belongsTo(NettProfit_::class);
    }
    public function grossProfitMargin_()
    {
        return $this->belongsTo(GrossProfitMargin_::class);
    }
    public function nettProfitMargin_()
    {
        return $this->belongsTo(NettProfitMargin_::class);
    }
    public function capaianTargetNeetProfit()
    {
        return $this->belongsTo(CapaianTargetNettProfit_::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
