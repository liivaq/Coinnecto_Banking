<?php

namespace App\Http\Requests\Crypto;

use App\Rules\MaxCryptoSellAmount;
use App\Rules\Otp;
use Illuminate\Foundation\Http\FormRequest;

class CryptoSellRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $userCrypto = auth()->user()->cryptos()->where('cmc_id', $this->input('crypto_coin'))->first();

        return [
            'account' => ['required', 'exists:accounts,number'],
            'amount' => ['required', 'numeric', 'min:0.01', new MaxCryptoSellAmount($userCrypto->amount)],
            /*'one_time_password' => ['required', new Otp()]*/
        ];
    }
}
