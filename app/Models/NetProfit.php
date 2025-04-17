<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NetProfit extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'net_profit_id';
    protected $table = 'net_profit';
    protected $fillable = ['targert', 'realisasi'];

    public function businessProgress()
    {
        return $this->hasOne(BusinessProgress::class);
    }
}
