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
        $types = ['checking', 'investment'];

        return [
            'user_id' => User::factory(),
            'currency' => $this->faker->currencyCode,
            'number' => $this->faker->iban,
            'balance' => $this->faker->numberBetween(100, 2000),
            'name' => $this->faker->sentence(2),
            'type' => $types[rand(0,1)]
        ];
    }
}
