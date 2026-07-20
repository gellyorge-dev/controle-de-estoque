@extends('layouts.app')

@section('title', isset($unidadeSelecionada) ? $unidadeSelecionada->nome : 'Espaços de Armazenamento')

@section('topbar_title', isset($unidadeSelecionada) ? $unidadeSelecionada->nome : 'Espaços de Armazenamento')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/espacos-armazenamento/novo{{ isset($unidadeId) ? '?unidade_id=' . $unidadeId : '' }}">Adicionar Espaço</a>
<x-tabela.cartao search="tbody-espacos" searchPlaceholder="Buscar espaço…">
    <x-slot:header>
        <th>ID</th>
        <th>Nome</th>
        <th>Unidade Organizacional</th>
        <th>Descrição</th>
    </x-slot>
    @foreach($espacos as $espaco)
    <tr onclick="window.location='/espacos-armazenamento/{{ $espaco->id }}/editar'" style="cursor:pointer;">
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $espaco->id }}</td>
        <td class="cell-primary" data-label="Nome">{{ $espaco->nome }}</td>
        <td data-label="Unidade Organizacional">{{ $espaco->unidadeOrganizacional->nome }}</td>
        <td class="cell-sub" data-label="Descrição">{{ $espaco->descricao }}</td>
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $espacos->links() }}
@endsection
