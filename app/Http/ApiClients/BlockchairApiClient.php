<?php

namespace App\Http\ApiClients;

use App\Models\Wallet;
use Exception;
use GuzzleHttp\Client;

class BlockchairApiClient extends ApiClientBase
{
    private Client $apiClient;

    protected function init()
    {
        $this->apiClient = new Client([
            'base_uri' => config('apis.blockchair.url'),
            'headers' => [
                'X-Api-Key' => config('apis.blockchair.api_key')
            ]
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

        $response = $this->apiClient->request('GET', "$chain/dashboards/address/$address");

        $data = json_decode($response->getBody());

        return $data?->data?->$address?->address?->balance ?? throw new Exception('Failed to parse balance check response');
    }
}
