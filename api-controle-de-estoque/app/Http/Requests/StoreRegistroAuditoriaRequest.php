<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroAuditoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'usuario_sistema_id' => ['required', 'exists:usuario_sistema,id'],
            'nome_tabela' => ['required', 'string', 'max:100'],
            'identificador_registro' => ['required', 'integer'],
            'tipo_acao' => ['required', 'string', 'max:30'],
            'valor_anterior' => ['nullable', 'string'],
            'valor_novo' => ['nullable', 'string'],
            'observacao' => ['nullable', 'string'],
        ];
    }
}
