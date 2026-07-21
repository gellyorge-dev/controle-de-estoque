<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipamentoPatrimoniadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'numero_patrimonio' => ['required', 'integer', 'min:1', Rule::unique('equip_patrim', 'numero_patrimonio')->ignore($this->route('id'))],
            'numero_serie' => ['nullable', 'string', 'max:150'],
            'espaco_armazenamento_id' => ['required', 'exists:espaco_arm,id'],
            'marca_equipamento_id' => ['nullable', 'exists:marca_eqp,id'],
            'tipo_equipamento_id' => ['nullable', 'exists:tipo_eqp,id'],
            'condicao_operacional_equipamento_id' => ['required', 'exists:cond_eqp,id'],
            'arquivo_imagem_id' => ['nullable', 'exists:arquivo_img,id'],
            'descricao_equipamento' => ['nullable', 'string'],
            'informado_ao_patrimonio' => ['boolean'],
            'patrimonio_esta_ativo' => ['boolean'],
            'observacoes_equipamento' => ['nullable', 'string'],
            'arquivo' => ['nullable', 'file', 'image'],
        ];
    }
}
