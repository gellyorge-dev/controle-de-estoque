@extends('layouts.app')

@section('title', 'Itens de Estoque')

@section('topbar_title', 'Itens de Estoque')

@section('content')
@php $isConsulta = Auth::user()->perfil_usuario_id === 3; @endphp
@if(!$isConsulta)
<a class="fab" href="/itens-estoque/novo">Adicionar Item</a>
@endif
<x-tabela.cartao search="" count="{{ $itens->total() }} itens">
    <x-slot:toolbar>
        <form class="filter-form" method="GET" action="/itens-estoque">
            <input class="search-input filter-search" name="search" placeholder="Buscar item…" value="{{ $search ?? '' }}">
            <select class="filter-select" name="unidade_id" onchange="this.form.submit()">
                <option value="">Unidade</option>
                @foreach($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ ($unidadeId ?? '') == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="localizacao_id" onchange="this.form.submit()">
                <option value="">Espaço de armazenamento</option>
                @foreach($espacos as $espaco)
                <option value="{{ $espaco->id }}" {{ ($localizacaoId ?? '') == $espaco->id ? 'selected' : '' }}>{{ $espaco->nome }}</option>
                @endforeach
            </select>
            @if($unidadeId || $localizacaoId || $search)
            <a class="filter-clear" href="/itens-estoque">Limpar</a>
            @endif
        </form>
    </x-slot>
    <x-slot:header>
        <th>Item</th>
        <th>Unidade</th>
        <th>Espaço de armazenamento</th>
        <th>Quantidade</th>
        <th>Atualizado em</th>
        @if($isConsulta)
        <th>Ações</th>
        @endif
    </x-slot>
    @foreach($itens as $item)
    @if($isConsulta)
    <tr>
    @else
    <tr onclick="window.location='/itens-estoque/{{ $item->id }}/editar'" style="cursor:pointer;">
    @endif
        <td data-label="Item">
            <div class="cell-primary">{{ $item->nome_item }}</div>
            <div class="cell-sub">{{ $item->descricao_item }}</div>
        </td>
        <td data-label="Unidade">{{ $item->espacoArmazenamento?->unidadeOrganizacional?->nome ?? '—' }}</td>
        <td data-label="Espaço de armazenamento">{{ $item->espacoArmazenamento?->nome ?? '—' }}</td>
        <td data-label="Quantidade" onclick="event.stopPropagation()"><x-indicador variant="ok">{{ $item->quantidade }} un.</x-indicador></td>
        <td class="cell-sub" data-label="Atualizado em">{{ $item->created_at->format('d/m/Y') }}</td>
        @if($isConsulta)
        <td data-label="Ações"><x-botao size="sm" href="/itens-estoque/{{ $item->id }}/editar">Visualizar</x-botao></td>
        @endif
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $itens->appends(Request::only(['unidade_id', 'localizacao_id', 'search']))->links() }}
@endsection
