@extends('layouts.app')

@section('title', 'Equipamentos Patrimoniados')

@section('topbar_title', 'Equipamentos Patrimoniados')

@section('content')
@php $isConsulta = Auth::user()->perfil_usuario_id === 3; @endphp
@if(!$isConsulta)
<a class="fab" href="/equipamentos-patrimoniados/novo">Adicionar Equipamento</a>
@endif
<x-tabela.cartao search="tbody-equipamentos" count="{{ $equipamentos->total() }} equipamentos" searchPlaceholder="Buscar por nome, patrimônio ou série…">
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
{{ $equipamentos->links() }}
@endsection
