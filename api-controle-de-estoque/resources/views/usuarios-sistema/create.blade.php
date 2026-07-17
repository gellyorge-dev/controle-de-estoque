@extends('layouts.app')

@section('title', isset($usuario) ? 'Editar Usuário' : 'Novo Usuário')

@section('topbar_title', isset($usuario) ? 'Editar Usuário' : 'Novo Usuário')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<x-tabela.cartao search="false">
    <x-slot:toolbar><h2>Informações do Usuário</h2></x-slot>
    <form action="/usuarios-sistema{{ isset($usuario) ? '/' . $usuario->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($usuario) @method('PUT') @endisset
        <div class="image-upload-wrap">
            <div class="image-upload-box rounded @if(isset($usuario) && $usuario->arquivoImagem) has-image @endif" onclick="document.getElementById('img-input').click()">
                @if(isset($usuario) && $usuario->arquivoImagem)
                <img id="preview-img" src="/imagens/perfil/{{ $usuario->id }}" alt="">
                @else
                <div class="placeholder" id="preview-placeholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span>Clique para adicionar foto</span>
                </div>
                @endif
                <div class="overlay">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <span>Alterar foto</span>
                </div>
            </div>
        </div>
        <div style="padding:20px 24px;">
            <input type="file" name="arquivo" id="img-input" accept="image/*" style="display:none" onchange="previewImagem(event)">
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

<script>
function previewImagem(event){
    const file = event.target.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(e){
        const box = document.querySelector('.image-upload-box');
        box.classList.add('has-image');
        const placeholder = document.getElementById('preview-placeholder');
        let img = document.getElementById('preview-img');
        if(!img){
            img = document.createElement('img');
            img.id = 'preview-img';
            if(placeholder) placeholder.replaceWith(img);
            else box.insertBefore(img, box.querySelector('.overlay'));
        }
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
