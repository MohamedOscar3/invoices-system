<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            "email"=>"required|email"
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
