<?php

namespace App\Http\Requests;

use App\Rules\AccountName;
use Illuminate\Foundation\Http\FormRequest;

class CreateAccountRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'min:3', new AccountName()],
            'currency' => ['required'],
            'type' => ['required']
        ];
    }
}
