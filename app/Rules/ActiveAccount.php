<?php

namespace App\Rules;

use App\Models\Account;
use Illuminate\Contracts\Validation\Rule;

class ActiveAccount implements Rule
{

    public function passes($attribute, $value)
    {
        return Account::where('number', $value)->whereNull('deleted_at')->exists();
    }

    public function message()
    {
        return 'The selected account is inactive or deleted.';
    }
}
