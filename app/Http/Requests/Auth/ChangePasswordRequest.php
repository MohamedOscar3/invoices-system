<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;


class ChangePasswordRequest extends FormRequest
{
    /**
     * @return array<string,string>
     */
    public function rules(): array
    {
        return [
            "email"=>"required|email",
            "otp"=>"required|min_digits:6|max_digits:6",
            "password"=>"required|confirmed"
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
