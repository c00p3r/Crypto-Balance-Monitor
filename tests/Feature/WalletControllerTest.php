<?php

namespace Tests\Feature;

use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_list_wallets(): void
    {
        $this->seed();

        $response = $this->getJson('/api/wallets');

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'address',
                    'currency',
                    'add_date',
                    'balance',
                    'balance_date',
                ]
            ]
        ]);

        $response->assertJsonCount(9, 'data');
    }

    public function test_show_wallet(): void
    {
        $wallet = Wallet::factory()->create();
        $response = $this->getJson('/api/wallets/' . $wallet->getKey());

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'address',
                'currency',
                'add_date',
                'balance',
                'balance_date',
            ]
        ]);
    }

    public function test_show_wallet_not_found(): void
    {
        $response = $this->getJson('/api/wallets/999');

        $response->assertNotFound();
    }

    public function test_store_wallet(): void
    {
        $data = [
            'address' => md5(Str::random()),
            'currency' => Wallet::BTC
        ];

        $response = $this->postJson('/api/wallets', $data);

        $response->assertSuccessful();

        $response->assertJsonStructure([
            'data' => [
                'address',
                'currency',
                'add_date',
                'balance',
                'balance_date',
            ]
        ]);

        $this->assertDatabaseHas('wallets', $data);
    }

    public static function invalidWalletData(): array
    {
        return [
            'invalid' => [123, 'foo'],
            'missing address' => [null, 'foo'],
            'missing both' => [null, null],
        ];
    }

    #[DataProvider('invalidWalletData')]
    public function test_store_wallet_invalid(mixed $address, mixed $currency): void
    {
        $data = [
            'address' => $address,
            'currency' => $currency
        ];

        $response = $this->postJson('/api/wallets', $data);

        $response->assertJsonValidationErrors([
            'address',
            'currency'
        ]);

        $this->assertDatabaseMissing('wallets', $data);
    }
}
