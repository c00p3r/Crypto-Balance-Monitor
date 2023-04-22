<?php

namespace Tests\Feature;

use App\Http\ApiClients\ApiClientFactory;
use App\Http\ApiClients\WalletApiClientInterface;
use App\Http\Services\WalletService;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class WalletServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_check_balance(): void
    {
        $wallet = Wallet::factory()->create();

        $balance = '1234567890';

        $apiClient = Mockery::mock(WalletApiClientInterface::class);
        $apiClient
            ->shouldReceive('getBalance')
            ->with($wallet)
            ->andReturn($balance);

        $apiClientFactory = Mockery::mock(ApiClientFactory::class);
        $apiClientFactory
            ->shouldReceive('getApiClient')
            ->with($wallet)
            ->andReturn($apiClient);

        $service = new WalletService($apiClientFactory);

        $service->checkBalance($wallet);

        $this->assertDatabaseHas('wallets_balance_log', [
            'wallet_id' => $wallet->getKey(),
            'balance' => $balance,
        ]);
    }
}
