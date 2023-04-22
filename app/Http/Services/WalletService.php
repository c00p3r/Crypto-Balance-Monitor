<?php

namespace App\Http\Services;

use App\Http\ApiClients\ApiClientFactory;
use App\Models\Wallet;
use Carbon\Carbon;

class WalletService
{
    protected ApiClientFactory $apiClientFactory;

    public function __construct(ApiClientFactory $apiClientFactory)
    {
        $this->apiClientFactory = $apiClientFactory;
    }

    public function checkBalance(Wallet $wallet): void
    {
        $apiClient = $this->apiClientFactory->getApiClient($wallet);

        /*
         * For different currencies there are different balance unit (satoshi, wei etc)
         * to not overcomplicate the task
         * we store them 'as is' without conversions to decimal
         */
        $balance = $apiClient->getBalance($wallet);

        $latestBalanceEntry = $wallet
            ->balanceLog()
            ->latest('timestamp')
            ->first();

        if ($latestBalanceEntry?->getAttribute('balance') !== $balance) {
            $wallet
                ->balanceLog()
                ->create([
                    'balance' => $balance,
                    /*
                     * To not overcomplicate the task
                     * since we fetch data every minute
                     * I assume that balance change date
                     * is the date when we get response from API
                     * opposed to checking last transaction date
                     */
                    'timestamp' => Carbon::now()
                ]);
        }
    }
}
