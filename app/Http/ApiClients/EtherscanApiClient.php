<?php

namespace App\Http\ApiClients;

use App\Models\Wallet;
use Exception;
use GuzzleHttp\Client;

class EtherscanApiClient extends ApiClientBase
{
    private Client $apiClient;

    protected function init()
    {
        $this->apiClient = new Client([
            'base_uri' => config('apis.etherscan.url'),
        ]);
    }

    public function getBalance(Wallet $wallet): string
    {
        $address = $wallet->getAttribute('address');

        $response = $this->apiClient->request('GET', '', [
            'query' => [
                'module' => 'account',
                'action' => 'balance',
                'address' => $address,
                'tag' => 'latest',
                'apikey' => config('apis.etherscan.api_key')
            ]
        ]);

        $data = json_decode($response->getBody());

        return $data->result ?? throw new Exception('Failed to parse balance check response');
    }
}
