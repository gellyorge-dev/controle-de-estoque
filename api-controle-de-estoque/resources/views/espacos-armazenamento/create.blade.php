@extends('layouts.app')

@php
    $backUrl = '/espacos-armazenamento';
    $deleteUrl = '';
    if (isset($espaco)) {
        $unidadeId = $espaco->unidade_organizacional_id;
        if ($unidadeId) { $backUrl .= '?unidade_id=' . $unidadeId; }
        $deleteUrl = '/espacos-armazenamento/' . $espaco->id;
    } elseif (isset($unidadeId) && $unidadeId) {
        $backUrl .= '?unidade_id=' . $unidadeId;
    }
@endphp

@section('title', isset($espaco) ? 'Editar Espaço' : 'Novo Espaço')

@section('topbar_title', isset($espaco) ? 'Editar Espaço' : 'Novo Espaço')

@section('content')
<x-tabela.cartao search="false" style="max-width: 560px;">
    <x-slot:toolbar><h2>Informações</h2></x-slot>
    <form action="/espacos-armazenamento{{ isset($espaco) ? '/' . $espaco->id : '' }}" method="POST">
        @csrf
        @isset($espaco) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome" required :span="2">
                    <input type="text" name="nome" required value="{{ old('nome', $espaco->nome ?? '') }}" placeholder="Ex: Depósito">
                </x-formulario.campo>
                <x-formulario.campo label="Unidade Organizacional" required :span="2">
                    @if(isset($unidadeId) && $unidadeId)
                    <input type="hidden" name="unidade_organizacional_id" value="{{ $unidadeId }}">
                    <div class="form-valor">{{ $unidadeSelecionada?->nome ?? '—' }} <span class="form-valor-hint">(localização)</span></div>
                    @else
                    <select name="unidade_organizacional_id" required>
                        <option value="">Selecione a unidade</option>
                        @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id }}" {{ old('unidade_organizacional_id', $espaco->unidade_organizacional_id ?? '') == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                    @endif
                </x-formulario.campo>
                <x-formulario.campo label="Descrição" :span="2">
                    <textarea name="descricao" placeholder="Ex: Depósito de equipamentos">{{ old('descricao', $espaco->descricao ?? '') }}</textarea>
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            @if($deleteUrl)
            <x-botao variant="danger-ghost" type="button" onclick="openDeleteModal('{{ $deleteUrl }}', 'Tem certeza que deseja excluir este espaço? Esta ação é irreversível.')">Excluir espaço</x-botao>
            @endif
            <div class="form-footer-right">
                <x-botao href="{{ $backUrl }}">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
