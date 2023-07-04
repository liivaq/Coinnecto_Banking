<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $currencies = ['AUD', 'USD', 'NZD', 'EUR', 'GBP'];

        return [
            'user_id' => User::factory()->create()->id,
            'currency' => $currencies[rand(0, count($currencies)-1)],
            'number' => $this->faker->iban,
            'balance' => $this->faker->numberBetween(100, 2000),
            'name' => 'Main Checking Account',
            'type' => 'checking'
        ];
    }
}
