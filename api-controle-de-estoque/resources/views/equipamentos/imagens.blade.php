@extends('layouts.app')

@section('title', 'Arquivos de Imagem')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>Arquivos de Imagem
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/equipamentos/imagens/novo">Adicionar Imagem</a>
<x-navegacao.abas :items="[
    ['label' => 'Equipamentos', 'href' => '/equipamentos-patrimoniados'],
    ['label' => 'Marcas', 'href' => '/equipamentos/marcas'],
    ['label' => 'Tipos', 'href' => '/equipamentos/tipos'],
    ['label' => 'Condições Operacionais', 'href' => '/equipamentos/condicoes'],
    ['label' => 'Arquivos de Imagem', 'href' => '/equipamentos/imagens', 'active' => true],
]" />

<x-tabela.cartao search="tbody-imagens" count="{{ $imagens->total() }} arquivos" searchPlaceholder="Buscar arquivo…">
    <x-slot:header>
        <th>ID</th>
        <th>Arquivo</th>
        <th>Tipo</th>
        <th>Tamanho</th>
        <th></th>
    </x-slot>
    @foreach($imagens as $imagem)
    <tr>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $imagem->id }}</td>
        <td data-label="Arquivo">
            <div style="display:flex; align-items:center; gap:12px;">
                <img src="{{ $imagem->caminho }}" alt="{{ $imagem->nome_arquivo }}"
                     style="width:70px; height:70px; object-fit:cover; border-radius:8px; border:1px solid #ddd;">
                <div>
                    <div class="cell-primary">{{ $imagem->nome_arquivo }}</div>
                    <div class="cell-sub" style="font-family: var(--font-mono);">{{ $imagem->caminho }}</div>
                </div>
            </div>
        </td>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="Tipo">{{ $imagem->mime_type }}</td>
        <td class="cell-sub" data-label="Tamanho">{{ number_format($imagem->tamanho / 1024, 0) }} KB</td>
        <x-tabela.acoes editUrl="/equipamentos/imagens/{{ $imagem->id }}/editar" deleteUrl="/equipamentos/imagens/{{ $imagem->id }}" />
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $imagens->links() }}
@endsection
