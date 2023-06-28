<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AccountName implements Rule
{

    public function passes($attribute, $value)
    {
        $normalizedValue = preg_replace('/\s+/', ' ', $value);
        $forbiddenValue = 'Main Checking account';

        return strcasecmp($normalizedValue, $forbiddenValue);
    }

    public function message()
    {
        return 'Account name Main Checking Account is not allowed';
    }
}
