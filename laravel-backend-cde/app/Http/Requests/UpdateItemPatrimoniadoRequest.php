<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemPatrimoniadoRequest extends FormRequest
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
            'patrimonio' => [
                'required',
                'integer',
                Rule::unique('itens_patrimoniados', 'patrimonio')->ignore($this->route('item_patrimoniado')),
            ],
            'id_tipo' => ['required', 'integer', 'exists:tipos,id'],
            'id_fabricante' => ['required', 'integer', 'exists:fabricantes,id'],
            'id_localizacao' => ['required', 'integer', 'exists:localizacoes,id'],
            'observacao' => ['nullable', 'string', 'max:65535'],
        ];
    }
}
