@extends('layouts.app')

@section('title', isset($unidade) ? 'Editar Unidade' : 'Nova Unidade')

@section('topbar_title', isset($unidade) ? 'Editar Unidade' : 'Nova Unidade')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<x-tabela.cartao search="false" style="max-width: 520px;">
    <x-slot:toolbar><h2>Informações</h2></x-slot>
    <form action="/unidades-organizacionais{{ isset($unidade) ? '/' . $unidade->id : '' }}" method="POST">
        @csrf
        @isset($unidade) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome" required :span="2">
                    <input type="text" name="nome" required value="{{ old('nome', $unidade->nome ?? '') }}" placeholder="Ex: Diretoria de Tecnologia">
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            @isset($unidade)
            <x-botao variant="danger-ghost" type="button" onclick="if(confirm('Confirmar exclusão?')){document.getElementById('delete-unidade').submit()}">Excluir unidade</x-botao>
            @endisset
            <div class="form-footer-right">
                <x-botao href="/unidades-organizacionais">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
    @isset($unidade)
    <form id="delete-unidade" action="/unidades-organizacionais/{{ $unidade->id }}" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
    @endisset
</x-tabela.cartao>
@endsection
