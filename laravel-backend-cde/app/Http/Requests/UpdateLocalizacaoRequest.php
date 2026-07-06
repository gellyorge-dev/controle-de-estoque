<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLocalizacaoRequest extends FormRequest
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
            'localizacao_nome' => [
                'required',
                'string',
                'max:255',
                Rule::unique('localizacoes', 'localizacao_nome')->ignore($this->route('localizacao')),
            ],
        ];
    }
}
