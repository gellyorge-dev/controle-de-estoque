<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItemEstoqueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'espaco_armazenamento_id' => ['required', 'exists:espaco_arm,id'],
            'arquivo_imagem_id' => ['nullable', 'exists:arquivo_img,id'],
            'nome_item' => ['required', 'string', 'max:150'],
            'descricao_item' => ['nullable', 'string'],
            'quantidade' => ['required', 'integer', 'min:0'],
            'observacoes_item' => ['nullable', 'string'],
        ];
    }
}
