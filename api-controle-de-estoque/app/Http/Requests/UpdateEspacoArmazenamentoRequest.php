<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEspacoArmazenamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'unidade_organizacional_id' => ['required', 'exists:unidade_organizacional,id'],
            'nome' => ['required', 'string', 'max:150'],
            'descricao' => ['nullable', 'string', 'max:255'],
        ];
    }
}
