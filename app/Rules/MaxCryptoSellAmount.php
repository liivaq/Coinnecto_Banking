<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxCryptoSellAmount implements Rule
{

    private float $amount;

    public function __construct($amount)
    {
        $this->amount = (float) $amount;
    }


    public function passes($attribute, $value)
    {
        return $value <= $this->amount ;
    }


    public function message()
    {
        return 'You do not have '.$this->amount .' coins to sell';
    }
}
