<?php

namespace App\Http\Requests;

use App\Rules\Otp;
use Illuminate\Foundation\Http\FormRequest;


class TransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $accountFrom = auth()->user()->accounts()->where('number', $this->input('account_from'))->first();

        return [
            'account_to' => ['required', 'exists:accounts,number', 'different:account_from'],
            'amount' => ['required', 'numeric', 'min:0.01', 'max:'. $accountFrom->balance],
            'one_time_password' => ['required', new Otp()]
        ];
    }
}
