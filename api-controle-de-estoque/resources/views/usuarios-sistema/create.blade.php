@extends('layouts.app')

@section('title', isset($usuario) ? 'Editar Usuário' : 'Novo Usuário')

@section('topbar_title', isset($usuario) ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<x-tabela.cartao search="false">
    <x-slot:toolbar><h2>Informações do Usuário</h2></x-slot>
    <form action="/usuarios-sistema{{ isset($usuario) ? '/' . $usuario->id : '' }}" method="POST">
        @csrf
        @isset($usuario) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Nome do usuário" required :span="2">
                    <input type="text" name="nome_usuario" required value="{{ old('nome_usuario', $usuario->nome_usuario ?? '') }}" placeholder="Ex: Fulano de Tal">
                </x-formulario.campo>
                <x-formulario.campo label="Login" required>
                    <input type="text" name="login_usuario" required value="{{ old('login_usuario', $usuario->login_usuario ?? '') }}" placeholder="Ex: fulano.de.tal">
                </x-formulario.campo>
                <x-formulario.campo label="{{ isset($usuario) ? 'Nova senha (deixar vazio para manter)' : 'Senha' }}" required>
                    <input type="password" name="senha_usuario" {{ isset($usuario) ? '' : 'required' }} placeholder="{{ isset($usuario) ? 'Deixar vazio para manter' : 'Mín. 8 caracteres' }}">
                </x-formulario.campo>
                <x-formulario.campo label="Perfil de usuário" required>
                    <select name="perfil_usuario_id" required>
                        <option value="">Selecione o perfil</option>
                        @foreach($perfis as $perfil)
                        <option value="{{ $perfil->id }}" {{ old('perfil_usuario_id', $usuario->perfil_usuario_id ?? '') == $perfil->id ? 'selected' : '' }}>{{ $perfil->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>
                <x-formulario.campo label="Arquivo de imagem">
                    <select name="arquivo_imagem_id">
                        <option value="">Nenhuma</option>
                        @foreach($imagens as $imagem)
                        <option value="{{ $imagem->id }}" {{ old('arquivo_imagem_id', $usuario->arquivo_imagem_id ?? '') == $imagem->id ? 'selected' : '' }}>{{ $imagem->nome_arquivo }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>
                <x-formulario.campo label="" :span="2">
                    <div class="checkbox-field" style="padding-top:22px;">
                        <input type="checkbox" id="ativo" name="ativo" value="1" {{ old('ativo', $usuario->ativo ?? true) ? 'checked' : '' }}>
                        <label for="ativo">Usuário ativo</label>
                    </div>
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            <div class="form-footer-right">
                <x-botao href="/usuarios-sistema">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar usuário</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
