@extends('layouts.app')

@section('title', 'Registros de Auditoria')

@section('topbar_title', 'Registros de Auditoria')

@section('content')
<x-tabela.cartao search="tbody-auditoria" count="{{ $registros->total() }} registros" searchPlaceholder="Buscar registro...">
    <x-slot:header>
        <th>ID</th>
        <th>Usuário</th>
        <th>Tabela</th>
        <th>Registro</th>
        <th>Ação</th>
        <th>Valor Anterior</th>
        <th>Valor Novo</th>
        <th>Observação</th>
        <th>Data</th>
    </x-slot>
    @forelse($registros as $registro)
    <tr>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="ID">#{{ $registro->id }}</td>
        <td data-label="Usuário">{{ $registro->usuarioSistema->nome_usuario ?? '—' }}</td>
        <td class="cell-sub" data-label="Tabela">{{ $registro->nome_tabela }}</td>
        <td class="cell-sub" data-label="Registro">{{ $registro->identificador_registro }}</td>
        <td data-label="Ação">{{ $registro->tipo_acao }}</td>
        <td class="cell-sub" data-label="Valor Anterior">{{ $registro->valor_anterior ?? '—' }}</td>
        <td class="cell-sub" data-label="Valor Novo">{{ $registro->valor_novo ?? '—' }}</td>
        <td class="cell-sub" data-label="Observação">{{ $registro->observacao ?? '—' }}</td>
        <td class="cell-sub" data-label="Data">{{ $registro->created_at->format('d/m/Y H:i') }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="9" class="cell-sub" style="text-align:center; padding:28px;">Nenhum registro de auditoria encontrado.</td>
    </tr>
    @endforelse
</x-tabela.cartao>
{{ $registros->links() }}
@endsection
