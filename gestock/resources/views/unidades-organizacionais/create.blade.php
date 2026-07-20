@extends('layouts.app')

@section('title', isset($unidade) ? 'Editar Unidade' : 'Nova Unidade')

@section('topbar_title', isset($unidade) ? 'Editar Unidade' : 'Nova Unidade')

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
            <x-botao variant="danger-ghost" type="button" onclick="openDeleteModal('/unidades-organizacionais/{{ $unidade->id }}', 'Tem certeza que deseja excluir esta unidade? Esta ação é irreversível.')">Excluir unidade</x-botao>
            @endisset
            <div class="form-footer-right">
                <x-botao href="/unidades-organizacionais">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
