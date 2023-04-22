<?php

namespace Database\Factories;

use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wallet>
 */
class WalletFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'address' => md5(uniqid(mt_rand(), true)),
            'currency' => fake()->randomElement([Wallet::BTC, Wallet::LTC, Wallet::ETH]),
            'add_date' => fake()->dateTimeThisYear(),
        ];
    }
}
