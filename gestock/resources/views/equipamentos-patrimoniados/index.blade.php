@extends('layouts.app')

@section('title', 'Equipamentos Patrimoniados')

@section('topbar_title', 'Equipamentos Patrimoniados')

@section('content')
@php $isConsulta = Auth::user()->perfil_usuario_id === 3; @endphp
@if(!$isConsulta)
<a class="fab" href="/equipamentos-patrimoniados/novo">Adicionar Equipamento</a>
@endif
<x-tabela.cartao search="" count="{{ $equipamentos->total() }} equipamentos">
    <x-slot:toolbar>
        <form class="filter-form" method="GET" action="/equipamentos-patrimoniados">
            <input class="search-input filter-search" name="search" placeholder="Buscar por patrimônio ou série…" value="{{ $search ?? '' }}">
            <select class="filter-select" name="marca_id" onchange="this.form.submit()">
                <option value="">Marca</option>
                @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ ($marcaId ?? '') == $marca->id ? 'selected' : '' }}>{{ $marca->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="tipo_id" onchange="this.form.submit()">
                <option value="">Tipo</option>
                @foreach($tipos as $tipo)
                <option value="{{ $tipo->id }}" {{ ($tipoId ?? '') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="condicao_id" onchange="this.form.submit()">
                <option value="">Condição</option>
                @foreach($condicoes as $condicao)
                <option value="{{ $condicao->id }}" {{ ($condicaoId ?? '') == $condicao->id ? 'selected' : '' }}>{{ $condicao->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="unidade_id" onchange="this.form.submit()">
                <option value="">Unidade Organizacional</option>
                @foreach($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ ($unidadeId ?? '') == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="localizacao_id" onchange="this.form.submit()" {{ !$unidadeId ? 'style=display:none' : '' }}>
                <option value="">Localização</option>
                @foreach($espacos->where('unidade_organizacional_id', $unidadeId) as $espaco)
                <option value="{{ $espaco->id }}" {{ ($localizacaoId ?? '') == $espaco->id ? 'selected' : '' }}>{{ $espaco->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="status" onchange="this.form.submit()">
                <option value="">Informado ao patrimônio</option>
                <option value="sim" {{ ($status ?? '') === 'sim' ? 'selected' : '' }}>Sim</option>
                <option value="nao" {{ ($status ?? '') === 'nao' ? 'selected' : '' }}>Não</option>
            </select>
            <select class="filter-select" name="ativo" onchange="this.form.submit()">
                <option value="">Ativo</option>
                <option value="sim" {{ ($ativo ?? '') === 'sim' ? 'selected' : '' }}>Sim</option>
                <option value="nao" {{ ($ativo ?? '') === 'nao' ? 'selected' : '' }}>Não</option>
            </select>
            @if($marcaId || $tipoId || $condicaoId || $unidadeId || $localizacaoId || $status || $ativo || $search)
            <a class="filter-clear" href="/equipamentos-patrimoniados">Limpar</a>
            @endif
        </form>
    </x-slot>
    <x-slot:header>
        <th>Patrimônio</th>
        <th>Nº Série</th>
        <th>Marca</th>
        <th>Tipo</th>
        <th>Condição</th>
        <th>Unidade Organizacional</th>
        <th>Informado ao Patrimônio</th>
        <th>Ativo</th>
        @if($isConsulta)
        <th>Ações</th>
        @endif
    </x-slot>
    @foreach($equipamentos as $equipamento)
    @if($isConsulta)
    <tr>
    @else
    <tr onclick="window.location='/equipamentos-patrimoniados/{{ $equipamento->id }}/editar'" style="cursor:pointer;">
    @endif
        <td data-label="Patrimônio" onclick="event.stopPropagation()"><x-tabela.patrimonio :number="$equipamento->numero_patrimonio" /></td>
        <td data-label="Nº Série">
            <div class="cell-primary">{{ $equipamento->numero_serie ?? '—' }}</div>
        </td>
        <td data-label="Marca">{{ $equipamento->marcaEquipamento->nome }}</td>
        <td data-label="Tipo">{{ $equipamento->tipoEquipamento->nome }}</td>
        <td data-label="Condição" onclick="event.stopPropagation()"><x-indicador variant="ok">{{ $equipamento->condicaoOperacionalEquipamento->nome }}</x-indicador></td>
        <td data-label="Unidade Organizacional">
            <div class="cell-primary">{{ $equipamento->espacoArmazenamento->unidadeOrganizacional->nome }}</div>
            <div class="cell-sub">{{ $equipamento->espacoArmazenamento->nome }}</div>
        </td>
        <td data-label="Informado ao Patrimônio" onclick="event.stopPropagation()">
            @if($equipamento->informado_ao_patrimonio)
            <x-indicador variant="ok">Sim</x-indicador>
            @else
            <x-indicador variant="warn">Não</x-indicador>
            @endif
        </td>
        <td data-label="Ativo" onclick="event.stopPropagation()">
            @if($equipamento->patrimonio_esta_ativo)
            <x-indicador variant="ok">Sim</x-indicador>
            @else
            <x-indicador variant="danger">Não</x-indicador>
            @endif
        </td>
        @if($isConsulta)
        <td data-label="Ações"><x-botao size="sm" href="/equipamentos-patrimoniados/{{ $equipamento->id }}/editar">Visualizar</x-botao></td>
        @endif
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $equipamentos->appends(Request::only(['marca_id', 'tipo_id', 'condicao_id', 'unidade_id', 'localizacao_id', 'status', 'ativo', 'search']))->links() }}
@endsection
