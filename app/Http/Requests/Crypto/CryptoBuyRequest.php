<?php

namespace App\Http\Requests\Crypto;

use App\Models\Account;
use App\Models\User;
use App\Rules\OneTimePassword;
use Illuminate\Foundation\Http\FormRequest;

class CryptoBuyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       return [
            'account' => ['required', 'exists:accounts,number'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'one_time_password' => ['required', new OneTimePassword()]
        ];
    }
}
