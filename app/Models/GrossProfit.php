<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrossProfit extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'gross_profit_id';
    protected $table = 'gross_profit';
    protected $fillable = ['targert', 'realisasi'];

    public function businessProgress()
    {
        return $this->hasOne(BusinessProgress::class);
    }
}
