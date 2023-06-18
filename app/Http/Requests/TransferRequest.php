<?php

namespace App\Http\Requests;

use App\Rules\MaxBalance;
use App\Rules\Otp;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

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
            /*'one_time_password' => ['required', new Otp()],*/
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->redirector->to($this->getRedirectUrl())
            ->withErrors($validator)
            ->with('custom_error', 'The provided account does not exist'));
    }
}
