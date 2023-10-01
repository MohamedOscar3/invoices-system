<?php

namespace App\Http\Requests;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string,array<int|Rule|string>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'total' => 'required|numeric',
            'currency_id' => 'required|exists:currencies,id',
            "totals"=> "array",
            "totals.*.title"=>"required",
            "totals.*.cost"=>"required|numeric",
            "totals.*.type"=>"required|in:percentage,fixed",

        ];
    }
}
