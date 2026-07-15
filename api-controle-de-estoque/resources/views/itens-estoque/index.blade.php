@extends('layouts.app')

@section('title', 'Itens de Estoque')

@section('topbar_title', 'Itens de Estoque')

@section('content')
@php $isConsulta = Auth::user()->perfil_usuario_id === 3; @endphp
@if(!$isConsulta)
<a class="fab" href="/itens-estoque/novo">Adicionar Item</a>
@endif
<x-tabela.cartao search="tbody-itens" count="{{ $itens->total() }} itens" searchPlaceholder="Buscar item…">
    <x-slot:header>
        <th>Item</th>
        <th>Unidade</th>
        <th>Espaço de armazenamento</th>
        <th>Quantidade</th>
        <th>Atualizado em</th>
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
        <td data-label="Quantidade"><x-indicador variant="ok">{{ $item->quantidade }} un.</x-indicador></td>
        <td class="cell-sub" data-label="Atualizado em">{{ $item->created_at->format('d/m/Y') }}</td>
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $itens->links() }}
@endsection
