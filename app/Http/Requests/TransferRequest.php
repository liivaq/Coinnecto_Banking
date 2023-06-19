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
        return [
            'account_to' => 'required|exists:accounts,number',
            'amount' => ['required', 'numeric', 'min:1'],
            'one_time_password' => ['required', new Otp()]
        ];
    }
}
