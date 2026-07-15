@extends('layouts.app')

@section('title', isset($tipo) ? 'Editar Tipo' : 'Novo Tipo')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>
<a href="/equipamentos/tipos" class="crumb-dim" style="text-decoration:none;">Tipos</a>
<span class="crumb-sep">/</span>
{{ isset($tipo) ? 'Editar' : 'Novo' }}
@endsection

@section('content')
<x-tabela.cartao search="false" style="max-width: 440px;">
    <x-slot:toolbar><h2>Informações</h2></x-slot>
    <form action="/equipamentos/tipos{{ isset($tipo) ? '/' . $tipo->id : '' }}" method="POST">
        @csrf
        @isset($tipo) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome" required :span="2">
                    <input type="text" name="nome" required value="{{ old('nome', $tipo->nome ?? '') }}" placeholder="Ex: Notebook">
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            <div class="form-footer-right">
                <x-botao href="/equipamentos/tipos">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
