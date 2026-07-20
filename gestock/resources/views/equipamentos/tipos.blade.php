@extends('layouts.app')

@section('title', 'Tipos de Equipamento')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>Tipos
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/equipamentos/tipos/novo">Adicionar Tipo</a>
<x-tabela.cartao search="tbody-tipos" count="{{ $tipos->total() }} tipos" searchPlaceholder="Buscar tipo…">
    <x-slot:header>
        <th>ID</th>
        <th>Nome</th>
        <th></th>
    </x-slot>
    @foreach($tipos as $tipo)
    <tr>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $tipo->id }}</td>
        <td class="cell-primary" data-label="Nome">{{ $tipo->nome }}</td>
        <x-tabela.acoes editUrl="/equipamentos/tipos/{{ $tipo->id }}/editar" deleteUrl="/equipamentos/tipos/{{ $tipo->id }}" />
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $tipos->links() }}
@endsection
