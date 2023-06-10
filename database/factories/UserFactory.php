<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'codes' => $this->generateSecurityCodes(),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
        ];
    }

    public function generateSecurityCodes(int $amount = 15, int $codeLength = 4): string
    {
        $codes = [];
        for ($i = 0; $i < $amount; $i++) {
            $codes[] = str_pad(random_int(0, 999999), $codeLength, 0, STR_PAD_LEFT);;
        }

        return json_encode($codes);
    }

    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
