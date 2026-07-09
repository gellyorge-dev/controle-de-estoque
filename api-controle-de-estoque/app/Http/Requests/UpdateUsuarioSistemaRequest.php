<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUsuarioSistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perfil_usuario_id' => ['required', 'exists:perfil_usuario,id'],
            'arquivo_imagem_id' => ['nullable', 'exists:arquivo_imagem,id'],
            'nome_usuario' => ['required', 'string', 'max:150'],
            'login_usuario' => ['required', 'string', 'max:100', Rule::unique('usuario_sistema', 'login_usuario')->ignore($this->route('usuarios_sistema'))],
            'senha_usuario' => ['required', 'string', 'max:255'],
            'ativo' => ['boolean'],
        ];
    }
}
