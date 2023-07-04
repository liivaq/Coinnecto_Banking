<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PragmaRX\Google2FA\Google2FA;

class OneTimePassword implements Rule
{

    public function __construct()
    {

    }

    public function passes($attribute, $value)
    {
       return (new Google2FA())->verifyKey(auth()->user()->google2fa_secret, $value);
    }


    public function message()
    {
        return 'Wrong code';
    }
}
