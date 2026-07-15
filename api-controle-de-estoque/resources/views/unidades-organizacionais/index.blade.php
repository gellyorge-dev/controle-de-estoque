@extends('layouts.app')

@section('title', 'Unidades Organizacionais')

@section('topbar_title', 'Unidades Organizacionais')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/unidades-organizacionais/novo">Adicionar Unidade</a>
<x-tabela.cartao search="tbody-unidades" searchPlaceholder="Buscar unidade…">
    <x-slot:header>
        <th>ID</th>
        <th>Nome</th>
        <th>Espaços</th>
        <th>Criada em</th>
        <th></th>
    </x-slot>
    @foreach($unidades as $unidade)
    <tr onclick="window.location='/espacos-armazenamento?unidade_id={{ $unidade->id }}'" style="cursor:pointer;">
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $unidade->id }}</td>
        <td class="cell-primary" data-label="Nome">{{ $unidade->nome }}</td>
        <td data-label="Espaços">{{ $unidade->espacoArmazenamento->count() }}</td>
        <td class="cell-sub" data-label="Criada em">{{ $unidade->created_at->format('d/m/Y') }}</td>
        <td data-label="">
            <x-botao href="/unidades-organizacionais/{{ $unidade->id }}/editar" size="sm" onclick="event.stopPropagation()">Editar</x-botao>
        </td>
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $unidades->links() }}
@endsection
