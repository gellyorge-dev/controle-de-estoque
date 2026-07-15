@extends('layouts.app')

@section('title', 'Condições Operacionais')

@section('topbar_title')
<a href="/equipamentos-patrimoniados" class="crumb-dim" style="text-decoration:none;">Equipamentos Patrimoniados</a>
<span class="crumb-sep">/</span>Condições Operacionais
@endsection

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/equipamentos/condicoes/novo">Adicionar Condição</a>
<x-tabela.cartao search="tbody-condicoes" count="{{ $condicoes->total() }} condições" searchPlaceholder="Buscar condição…">
    <x-slot:header>
        <th>ID</th>
        <th>Nome</th>
        <th></th>
    </x-slot>
    @foreach($condicoes as $condicao)
    <tr>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $condicao->id }}</td>
        <td class="cell-primary" data-label="Nome">{{ $condicao->nome }}</td>
        <x-tabela.acoes editUrl="/equipamentos/condicoes/{{ $condicao->id }}/editar" deleteUrl="/equipamentos/condicoes/{{ $condicao->id }}" />
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $condicoes->links() }}
@endsection
