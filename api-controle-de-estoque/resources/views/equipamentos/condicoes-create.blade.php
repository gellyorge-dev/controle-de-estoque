@extends('layouts.app')

@section('title', isset($condicao) ? 'Editar Condição' : 'Nova Condição')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>
<a href="/equipamentos/condicoes" class="crumb-dim" style="text-decoration:none;">Condições</a>
<span class="crumb-sep">/</span>
{{ isset($condicao) ? 'Editar' : 'Nova' }}
@endsection

@section('content')
@if($errors->any())
<div class="alert alert-error">
    <ul style="margin:0;padding-left:18px;">
        @foreach($errors->all() as $erro)
        <li>{{ $erro }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<x-tabela.cartao search="false" style="max-width: 440px;">
    <x-slot:toolbar><h2>Informações</h2></x-slot>
    <form action="/equipamentos/condicoes{{ isset($condicao) ? '/' . $condicao->id : '' }}" method="POST">
        @csrf
        @isset($condicao) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome" required :span="2">
                    <input type="text" name="nome" required value="{{ old('nome', $condicao->nome ?? '') }}" placeholder="Ex: Em uso">
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            <div class="form-footer-right">
                <x-botao href="/equipamentos/condicoes">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
