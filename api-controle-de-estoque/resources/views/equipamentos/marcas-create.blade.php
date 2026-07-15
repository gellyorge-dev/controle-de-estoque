@extends('layouts.app')

@section('title', isset($marca) ? 'Editar Marca' : 'Nova Marca')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>
<a href="/equipamentos/marcas" class="crumb-dim" style="text-decoration:none;">Marcas</a>
<span class="crumb-sep">/</span>
{{ isset($marca) ? 'Editar' : 'Nova' }}
@endsection

@section('content')
<x-tabela.cartao search="false" style="max-width: 440px;">
    <x-slot:toolbar><h2>Informações</h2></x-slot>
    <form action="/equipamentos/marcas{{ isset($marca) ? '/' . $marca->id : '' }}" method="POST">
        @csrf
        @isset($marca) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome" required :span="2">
                    <input type="text" name="nome" required value="{{ old('nome', $marca->nome ?? '') }}" placeholder="Ex: Dell">
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            <div class="form-footer-right">
                <x-botao href="/equipamentos/marcas">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
