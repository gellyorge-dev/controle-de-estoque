@extends('layouts.app')

@section('title', isset($item) ? 'Editar Item' : 'Novo Item')

@section('topbar_title', isset($item) ? 'Editar Item' : 'Novo Item')

@php
    $espacosJson = $espacos->groupBy('unidade_organizacional_id')->map(fn($group) => $group->map(fn($e) => ['id' => $e->id, 'nome' => $e->nome])->values());
    $itemUnidadeId = isset($item) ? $item->espacoArmazenamento?->unidade_organizacional_id : null;
@endphp

@section('content')
<x-tabela.cartao search="false">
    <x-slot:toolbar><h2>{{ isset($item) ? 'Editar' : 'Novo' }} Item</h2></x-slot>
    <form action="/itens-estoque{{ isset($item) ? '/' . $item->id : '' }}" method="POST">
        @csrf
        @isset($item) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome do item" required :span="2">
                    <input type="text" name="nome_item" required value="{{ old('nome_item', $item->nome_item ?? '') }}" placeholder="Ex: Monitor Dell">
                </x-formulario.campo>

                <x-formulario.campo label="Quantidade" required>
                    <input type="number" name="quantidade" required value="{{ old('quantidade', $item->quantidade ?? '') }}" placeholder="Ex: 3">
                </x-formulario.campo>
                <x-formulario.campo label="Unidade Organizacional" required>
                    <select id="unidade-select" required onchange="filtrarEspacos()">
                        <option value="">Selecione a unidade</option>
                        @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id }}" {{ ($itemUnidadeId ?? old('unidade_id')) == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>
                <x-formulario.campo label="Espaço de armazenamento" required>
                    <select name="espaco_armazenamento_id" id="espaco-select" required>
                        <option value="">Selecione a unidade primeiro</option>
                    </select>
                </x-formulario.campo>

                <x-formulario.campo label="Descrição do item" :span="2">
                    <textarea name="descricao_item" placeholder="Ex: Monitor Samsung 24 polegadas">{{ old('descricao_item', $item->descricao_item ?? '') }}</textarea>
                </x-formulario.campo>

                <x-formulario.campo label="Observações" :span="2">
                    <textarea name="observacoes_item" placeholder="Observações adicionais sobre o item">{{ old('observacoes_item', $item->observacoes_item ?? '') }}</textarea>
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            @isset($item)
            <x-botao variant="danger-ghost" type="button" onclick="if(confirm('Confirmar exclusão?')){document.getElementById('delete-item').submit()}">Excluir item</x-botao>
            @endisset
            <div class="form-footer-right">
                <x-botao href="/itens-estoque">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar item</x-botao>
            </div>
        </div>
    </form>
    @isset($item)
    <form id="delete-item" action="/itens-estoque/{{ $item->id }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    @endisset
</x-tabela.cartao>

<script>
const espacosPorUnidade = @json($espacosJson);

function filtrarEspacos(){
    const unidadeId = document.getElementById('unidade-select').value;
    const espacoSelect = document.getElementById('espaco-select');
    const selected = '{{ old("espaco_armazenamento_id", $item->espaco_armazenamento_id ?? "") }}';
    espacoSelect.innerHTML = '<option value="">Selecione o espaço</option>';
    if(unidadeId && espacosPorUnidade[unidadeId]){
        espacosPorUnidade[unidadeId].forEach(function(e){
            const opt = document.createElement('option');
            opt.value = e.id;
            opt.textContent = e.nome;
            if(e.id == selected) opt.selected = true;
            espacoSelect.appendChild(opt);
        });
    }
}
document.getElementById('unidade-select').addEventListener('change', filtrarEspacos);
if(document.getElementById('unidade-select').value) filtrarEspacos();
</script>
@endsection
