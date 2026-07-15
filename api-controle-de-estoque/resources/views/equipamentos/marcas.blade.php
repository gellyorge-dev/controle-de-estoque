@extends('layouts.app')

@section('title', 'Marcas de Equipamento')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>Marcas
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/equipamentos/marcas/novo">Adicionar Marca</a>
<x-tabela.cartao search="tbody-marcas" count="{{ $marcas->total() }} marcas" searchPlaceholder="Buscar marca…">
    <x-slot:header>
        <th>ID</th>
        <th>Nome</th>
        <th></th>
    </x-slot>
    @foreach($marcas as $marca)
    <tr>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $marca->id }}</td>
        <td class="cell-primary" data-label="Nome">{{ $marca->nome }}</td>
        <x-tabela.acoes editUrl="/equipamentos/marcas/{{ $marca->id }}/editar" deleteUrl="/equipamentos/marcas/{{ $marca->id }}" />
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $marcas->links() }}
@endsection
