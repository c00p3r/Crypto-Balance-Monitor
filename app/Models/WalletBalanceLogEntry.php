<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletBalanceLogEntry extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'wallets_balance_log';
    protected $fillable = [
        'balance',
        'timestamp'
    ];

    public function wallet()
    {
        $this->belongsTo(Wallet::class);
    }
}
