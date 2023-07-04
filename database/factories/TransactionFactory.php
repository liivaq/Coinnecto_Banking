<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $accountFrom = Account::factory()->create();
        $accountTo = Account::factory()->create();

        return [
            'account_from_id' => $accountFrom->id,
            'account_to_id' => $accountTo->id,
            'currency_from' => $accountFrom->currency,
            'currency_to' => $accountTo->currency,
            'amount' => rand(100, 500),
            'amount_converted' => rand(100, 500),
            'exchange_rate' => 1
        ];
    }
}
