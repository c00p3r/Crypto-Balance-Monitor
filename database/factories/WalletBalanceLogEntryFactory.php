<?php

namespace Database\Factories;

use App\Models\Wallet;
use App\Models\WalletBalanceLogEntry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WalletBalanceLogEntry>
 */
class WalletBalanceLogEntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wallet_id' => Wallet::factory(),
            'balance' => (string)rand(),
            'timestamp' => fake()->dateTimeThisYear(),
        ];
    }
}
