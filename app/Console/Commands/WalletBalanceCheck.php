<?php

namespace App\Console\Commands;

use App\Http\Services\WalletService;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Throwable;

class WalletBalanceCheck extends Command
{
    protected $signature = 'wallet-balance:check';
    protected $description = 'Check wallet balance';

    public function handle(WalletService $walletService)
    {
        $wallets = Wallet::query()->get();

        foreach ($wallets as $wallet) {
            // We don't want command to quit if checking one of the wallets failed
            try {
                $walletService->checkBalance($wallet);
            } catch (Throwable $e) {
                Log::error(
                    'Failed to check balance for wallet ID  ' . $wallet->getKey(),
                    ['reason' => $e->getMessage()]
                );
            }
        }
    }
}
