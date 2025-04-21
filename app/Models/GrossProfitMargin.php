<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrossProfitMargin extends Model
{
    use HasFactory;
    
    // protected $primaryKey = 'gross_profit_margin_id';
    protected $table = 'gross_profit_margins';
    protected $fillable = ['targert', 'realisasi'];

    public function businessProgress()
    {
        return $this->hasOne(BusinessProgress::class);
    }
}
