<?php

namespace App\Http\Requests;

use App\Rules\Otp;
use Illuminate\Foundation\Http\FormRequest;

class CryptoTransactionRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {



    }
}
