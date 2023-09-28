<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            "email"=>"required|email",
            "password"=>"required",
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
