<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreWallet extends Model
{
    use HasFactory;

    protected $table = 'store_wallets';

    protected $fillable = [
        'vendor_id',
        'total_earning',
        'total_withdrawn',
        'pending_withdraw',
        'collected_cash',
    ];

    protected $casts = [
        'total_earning' => 'float',
        'total_withdrawn' => 'float',
        'pending_withdraw' => 'float',
        'collected_cash' => 'float',
    ];

    public function getBalanceAttribute()
    {
        return ($this->total_earning ?? 0)
            - (
                ($this->total_withdrawn ?? 0)
                + ($this->pending_withdraw ?? 0)
                + ($this->collected_cash ?? 0)
            );
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}


//     public function getBalanceAttribute()
//     {
//         return $this->total_earning - ($this->total_withdrawn + $this->pending_withdraw + $this->collected_cash);
//     }
//
