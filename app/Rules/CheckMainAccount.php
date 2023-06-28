<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class CheckMainAccount implements Rule
{

    public function passes($attribute, $value)
    {
        $account = Account::find($value);
        return $account->name !== 'Main Checking Account';
    }


    public function message()
    {
        return 'You are not allowed to delete your Main account';
    }
}
