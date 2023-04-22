<?php

namespace App\Http\ApiClients;

use App\Models\Wallet;

interface WalletApiClientInterface
{
    public function getBalance(Wallet $wallet): string;
}
