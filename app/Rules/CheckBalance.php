<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckBalance implements Rule
{

    public function passes($attribute, $value)
    {
        $account = Account::find($value);
        return $account->balance == 0;
    }

    public function message()
    {
        return 'Account\'s balance must be 0 to delete';
    }
}
