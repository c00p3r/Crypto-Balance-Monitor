<?php

namespace Database\Seeders;

use App\Models\Wallet;
use App\Models\WalletBalanceLogEntry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // some random real wallets
        $btcWallets = [
            'bc1q34aq5drpuwy3wgl9lhup9892qp6svr8ldzyy7c',
            '35M4yNBemd6ijtCLzJmEf8jZrfJRt48uUn',
            '383Dgj3jiNGLTbPRa7T5wB5WkCu8Dr52Sm'
        ];

        $ltcWallets = [
            'MMJWtjRxk5f9WGoVXZnNgcr22KhQpZJPXS',
            'Ler4HNAEfwYhBmGXcFP2Po1NpRUEiK8km2',
            'MB4KPcAV11BkTVVmaJFzKTprc5MBCUnXbH'
        ];

        $ethWallets = [
            '0xdbCF1F4F93d32118949A9af08D63fe0905482f39',
            '0x4675C7e5BaAFBFFbca748158bEcBA61ef3b0a263',
            '0xeB2629a2734e272Bcc07BDA959863f316F4bD4Cf'
        ];

        foreach ($btcWallets as $address) {
            $wallet = Wallet::factory()->create([
                'address' => $address,
                'currency' => Wallet::BTC
            ]);

            WalletBalanceLogEntry::factory(10)->create([
                'wallet_id' => $wallet->getKey()
            ]);
        }

        foreach ($ltcWallets as $address) {
            $wallet = Wallet::factory()->create([
                'address' => $address,
                'currency' => Wallet::LTC
            ]);

            WalletBalanceLogEntry::factory(10)->create([
                'wallet_id' => $wallet->getKey()
            ]);
        }

        foreach ($ethWallets as $address) {
            $wallet = Wallet::factory()->create([
                'address' => $address,
                'currency' => Wallet::ETH
            ]);

            WalletBalanceLogEntry::factory(10)->create([
                'wallet_id' => $wallet->getKey()
            ]);
        }
    }
}
