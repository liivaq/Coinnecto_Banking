<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxTransferAmount implements Rule
{
    private float $balance;

    public function __construct($balance)
    {
        $this->balance = (float) $balance;
    }

    public function passes($attribute, $value)
    {
        return $value <= $this->balance;
    }

    public function message()
    {
        return 'You do not have enough money in your account';
    }
}
