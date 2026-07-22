<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioSistemaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'perfil_usuario_id' => ['required', 'exists:perfil_usr,id'],
            'arquivo_imagem_id' => ['nullable', 'exists:arquivo_img,id'],
            'nome_usuario' => ['required', 'string', 'max:150'],
            'login_usuario' => ['required', 'string', 'max:100', 'unique:usuario_sis,login_usuario'],
            'senha_usuario' => ['required', 'string', 'min:8', 'max:255'],
            'ativo' => ['boolean'],
            'arquivo' => ['nullable', 'file', 'mimes:jpg,jpeg,png,bmp,gif,webp,heic,heif'],
        ];
    }
}
