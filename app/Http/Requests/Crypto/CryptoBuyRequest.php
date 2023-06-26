<?php

namespace App\Http\Requests\Crypto;

use App\Models\Account;
use App\Rules\MaxCryptoPrice;
use App\Rules\Otp;
use Illuminate\Foundation\Http\FormRequest;

class CryptoBuyRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        /** @var Account $account */
        $account = auth()->user()->accounts()->where('number', $this->input('account'))->first();

       return [
            'account' => ['required', 'exists:accounts,number'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'price' => [new MaxCryptoPrice($this->input('amount'), $account->balance)],
            /*'one_time_password' => ['required', new Otp()]*/
        ];
    }
}
