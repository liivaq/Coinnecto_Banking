<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\ActiveAccount;
use App\Rules\CheckInvestmentTransfer;
use App\Rules\OneTimePassword;
use Illuminate\Foundation\Http\FormRequest;


class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'account_to' => ['required', 'exists:accounts,number', 'different:account_from', new ActiveAccount()],
            'account_from' => ['required', new CheckInvestmentTransfer($this->input('account_to'))],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'one_time_password' => ['required', new OneTimePassword()]
        ];
    }
}
