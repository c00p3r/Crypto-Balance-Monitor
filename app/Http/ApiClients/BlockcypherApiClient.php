<?php

namespace App\Http\ApiClients;

use App\Models\Wallet;
use Exception;
use GuzzleHttp\Client;

class BlockcypherApiClient extends ApiClientBase
{
    private Client $apiClient;

    protected function init()
    {
        $this->apiClient = new Client([
            'base_uri' => config('apis.blockcypher.url'),
        ]);
    }

    public function getBalance(Wallet $wallet): string
    {
        $chain = match ($wallet->getAttribute('currency')) {
            'BTC' => 'btc',
            'LTC' => 'ltc',
            default => throw new Exception("Unknown currency")
        };

        $address = $wallet->getAttribute('address');

        $response = $this->apiClient->request('GET', "$chain/main/addrs/$address/balance");

        $data = json_decode($response->getBody());

        return $data?->balance ?? throw new Exception('Failed to parse balance check response');
    }
}
