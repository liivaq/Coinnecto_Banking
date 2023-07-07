<?php

namespace App\Http\Requests\Crypto;

use App\Models\Account;
use App\Models\User;
use App\Rules\MaxCryptoSellAmount;
use App\Rules\OneTimePassword;
use Illuminate\Foundation\Http\FormRequest;

class CryptoSellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $account = Account::where('number', $this->input('account'))->firstOrFail();
        $crypto = $account->cryptos()->where('cmc_id', $this->input('crypto_coin'))->first() ?? null;

        $amount = $crypto ? $crypto->amount : 0;

        return [
            'account' => ['required', 'exists:accounts,number'],
            'amount' => ['required', 'numeric', 'min:0.01', new MaxCryptoSellAmount($amount)],
            'one_time_password' => ['required', new OneTimePassword()]
        ];
    }
}
