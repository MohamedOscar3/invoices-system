<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OtpVerifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "email"=>"required|email",
            "otp"=>"required|min_digits:6|max_digits:6",
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
