@extends('layouts.app')

@section('title', isset($imagem) ? 'Editar Imagem' : 'Enviar Imagem')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>
<a href="/equipamentos/imagens" class="crumb-dim" style="text-decoration:none;">Imagens</a>
<span class="crumb-sep">/</span>
{{ isset($imagem) ? 'Editar' : 'Enviar' }}
@endsection

@section('content')
<x-tabela.cartao search="false" style="max-width: 560px;">
    <x-slot:toolbar><h2>Arquivo</h2></x-slot>
    <form action="/equipamentos/imagens{{ isset($imagem) ? '/' . $imagem->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($imagem) @method('PUT') @endisset
        <div style="padding:20px 24px;">
            <x-formulario.grade>
                <x-formulario.campo label="Arquivo" required :span="2">
                    <input type="file" name="arquivo" accept="image/*" {{ isset($imagem) ? '' : 'required' }}>
                </x-formulario.campo>
                <x-formulario.campo label="Nome do arquivo" :span="2">
                    <input type="text" name="nome_arquivo" value="{{ old('nome_arquivo', $imagem->nome_arquivo ?? '') }}" placeholder="Ex: notebook-dell-01.jpg">
                </x-formulario.campo>
                <x-formulario.campo label="Caminho" :span="2">
                    <input type="text" name="caminho" value="{{ old('caminho', $imagem->caminho ?? '') }}" placeholder="Ex: /uploads/equipamentos/notebook-dell-01.jpg">
                </x-formulario.campo>
                <x-formulario.campo label="Tipo MIME">
                    <input type="text" name="mime_type" value="{{ old('mime_type', $imagem->mime_type ?? '') }}" placeholder="Ex: image/jpeg">
                </x-formulario.campo>
                <x-formulario.campo label="Tamanho (bytes)">
                    <input type="number" name="tamanho" value="{{ old('tamanho', $imagem->tamanho ?? '') }}" placeholder="Ex: 188416">
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            <div class="form-footer-right">
                <x-botao href="/equipamentos/imagens">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar</x-botao>
            </div>
        </div>
    </form>
</x-tabela.cartao>
@endsection
