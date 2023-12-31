<?php

namespace App\Http\Requests;

use App\Rules\CheckBalance;
use App\Rules\CheckCryptoBalance;
use App\Rules\CheckMainAccount;
use Illuminate\Foundation\Http\FormRequest;

class DeleteAccountRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'account' => ['required', new CheckBalance(), new CheckCryptoBalance(), new CheckMainAccount()]
        ];
    }
}
