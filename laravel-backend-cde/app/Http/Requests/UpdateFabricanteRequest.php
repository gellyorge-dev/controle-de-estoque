<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateFabricanteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome_fabricante' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fabricantes', 'nome_fabricante')->ignore($this->route('fabricante')),
            ],
        ];
    }
}
