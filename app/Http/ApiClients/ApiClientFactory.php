<?php

namespace App\Http\ApiClients;

use App\Models\Wallet;
use Exception;

class ApiClientFactory
{
    public function getApiClient(Wallet $wallet): WalletApiClientInterface
    {
        return match ($wallet->getAttribute('currency')) {
            'BTC', 'LTC' => BlockcypherApiClient::getInstance(),
            'ETH' => EtherscanApiClient::getInstance(),
            default => throw new Exception("Unknown currency")
        };
    }
}
