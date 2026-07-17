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
            <input class="search-input filter-search" name="search" placeholder="Buscar por nome, patrimônio ou série…" value="{{ $search ?? '' }}">
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
                <option value="">Unidade</option>
                @foreach($unidades as $unidade)
                <option value="{{ $unidade->id }}" {{ ($unidadeId ?? '') == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="localizacao_id" onchange="this.form.submit()">
                <option value="">Localização</option>
                @foreach($espacos as $espaco)
                <option value="{{ $espaco->id }}" {{ ($localizacaoId ?? '') == $espaco->id ? 'selected' : '' }}>{{ $espaco->nome }}</option>
                @endforeach
            </select>
            <select class="filter-select" name="status" onchange="this.form.submit()">
                <option value="">Status</option>
                <option value="ativo" {{ ($status ?? '') === 'ativo' ? 'selected' : '' }}>Ativo</option>
                <option value="informado" {{ ($status ?? '') === 'informado' ? 'selected' : '' }}>Informado</option>
            </select>
            @if($marcaId || $tipoId || $condicaoId || $unidadeId || $localizacaoId || $status || $search)
            <a class="filter-clear" href="/equipamentos-patrimoniados">Limpar</a>
            @endif
        </form>
    </x-slot>
    <x-slot:header>
        <th>Patrimônio</th>
        <th>Equipamento</th>
        <th>Marca</th>
        <th>Tipo</th>
        <th>Condição</th>
        <th>Unidade</th>
        <th>Localização</th>
        <th>Status</th>
    </x-slot>
    @foreach($equipamentos as $equipamento)
    @if($isConsulta)
    <tr>
    @else
    <tr onclick="window.location='/equipamentos-patrimoniados/{{ $equipamento->id }}/editar'" style="cursor:pointer;">
    @endif
        <td data-label="Patrimônio"><x-tabela.patrimonio :number="$equipamento->numero_patrimonio" /></td>
        <td data-label="Equipamento">
            <div class="cell-primary">{{ $equipamento->nome_equipamento }}</div>
            <div class="cell-sub">{{ $equipamento->numero_serie }}</div>
        </td>
        <td data-label="Marca">{{ $equipamento->marcaEquipamento->nome }}</td>
        <td data-label="Tipo">{{ $equipamento->tipoEquipamento->nome }}</td>
        <td data-label="Condição"><x-indicador variant="ok">{{ $equipamento->condicaoOperacionalEquipamento->nome }}</x-indicador></td>
        <td data-label="Unidade">{{ $equipamento->espacoArmazenamento->unidadeOrganizacional->nome }}</td>
        <td data-label="Localização">{{ $equipamento->espacoArmazenamento->nome }}</td>
        <td data-label="Status">
            @if($equipamento->informado_ao_patrimonio)
            <x-indicador variant="ok">Informado</x-indicador>
            @else
            <x-indicador variant="warn">Ativo</x-indicador>
            @endif
        </td>
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $equipamentos->appends(Request::only(['marca_id', 'tipo_id', 'condicao_id', 'unidade_id', 'localizacao_id', 'status', 'search']))->links() }}
@endsection
