<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallet extends Model
{
    use HasFactory;

    public const BTC = 'BTC';
    public const LTC = 'LTC';
    public const ETH = 'ETH';
    public $timestamps = false;
    protected $fillable = [
        'address',
        'currency',
        'add_date'
    ];

    public function balanceLog(): HasMany
    {
        return $this
            ->hasMany(WalletBalanceLogEntry::class)
            ->orderBy('timestamp', 'desc');
    }

    public function latestBalance(): HasMany
    {
        /*
         * We can assume that log entries go in historical order
         * (which has to be true in production)
         * and use 'ID' instead of 'timestamp' for better performance
         * ->whereRaw('id IN (SELECT MAX(id) FROM wallets_balance_log GROUP BY wallet_id)');
         */
        return $this
            ->hasMany(WalletBalanceLogEntry::class)
            ->whereRaw('timestamp IN (SELECT MAX(timestamp) FROM wallets_balance_log GROUP BY wallet_id)');
    }
}
