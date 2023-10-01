<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CurrencyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string,array<int|Rule|string>|string>
     */
    public function rules() : array
    {
        $id = $this->route("currency");
        return [
            'title' => ['required','string',Rule::unique("currencies")->ignore($id)],
            'symbol'=>['required','string',Rule::unique("currencies")->ignore($id)],
            "status"=>"required|bool",
        ];
    }

}
