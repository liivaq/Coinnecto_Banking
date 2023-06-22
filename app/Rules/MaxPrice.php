<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxPrice implements Rule
{

    private float $amount;
    private float $balance;

    public function __construct($amount, $balance)
    {
        $this->amount = (float) $amount;
        $this->balance = (float) $balance;
    }

    public function passes($attribute, $value)
    {
        return $value * $this->amount <= $this->balance;
    }


    public function message()
    {
        return 'You do not have enough money in you account to purchase '. $this->amount . ' coins';
    }
}
