<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCondicaoOperacionalEquipamentoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:100', Rule::unique('condicao_operacional_equipamento', 'nome')->ignore($this->route('condicoes_operacionai'))],
        ];
    }
}
