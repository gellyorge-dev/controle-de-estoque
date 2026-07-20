<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArquivoImagemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome_arquivo' => ['required', 'string', 'max:255'],
            'caminho' => ['required', 'string', 'max:500'],
            'mime_type' => ['nullable', 'string', 'max:100'],
            'tamanho' => ['nullable', 'integer'],
            'hash' => ['nullable', 'string', 'max:255'],
        ];
    }
}
