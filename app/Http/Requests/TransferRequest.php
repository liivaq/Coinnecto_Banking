<?php

namespace App\Http\Requests;

use App\Models\Account;
use App\Rules\ActiveAccount;
use App\Rules\CheckInvestmentTransfer;
use App\Rules\MaxTransferAmount;
use App\Rules\Otp;
use Illuminate\Foundation\Http\FormRequest;


class TransferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $accountFrom = auth()->user()->accounts()->where('number', $this->input('account_from'))->firstOrFail();

        return [
            'account_to' => ['required', 'exists:accounts,number', 'different:account_from', new ActiveAccount()],
            'account_from' => ['required', new CheckInvestmentTransfer($this->input('account_to'))],
            'amount' => ['required', 'numeric', 'min:0.01', new MaxTransferAmount($accountFrom->balance)],
            /*'one_time_password' => ['required', new Otp()]*/
        ];
    }
}
