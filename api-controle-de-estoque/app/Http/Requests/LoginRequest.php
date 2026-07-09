<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'login_usuario' => ['required', 'string'],
            'senha_usuario' => ['required', 'string'],
        ];
    }
}
