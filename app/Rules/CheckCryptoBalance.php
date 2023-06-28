<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckCryptoBalance implements Rule
{

    public function passes($attribute, $value)
    {
        $account = Account::find($value);

        if($account->type === 'investment')
        {
            return !$account->userCryptos()->exists();
        }

        return true;
    }

    public function message()
    {
        return 'You have cryptos associated with this account';
    }
}
