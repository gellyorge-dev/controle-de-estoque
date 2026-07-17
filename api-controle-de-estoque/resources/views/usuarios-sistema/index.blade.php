@extends('layouts.app')

@section('title', 'Usuários do Sistema')

@section('topbar_title', 'Usuários do Sistema')

@section('content')
@if(session('error'))
<div class="alert alert-error">{{ session('error') }}</div>
@endif
<a class="fab" href="/usuarios-sistema/novo">Adicionar Usuário</a>
<x-tabela.cartao search="tbody-usuarios" count="{{ $usuarios->total() }} usuários" searchPlaceholder="Buscar por nome ou login…">
    <x-slot:header>
        <th>Usuário</th>
        <th>Login</th>
        <th>Perfil</th>
        <th>Status</th>
        <th></th>
    </x-slot>
    @foreach($usuarios as $usuario)
    <tr>
        <td class="cell-primary" data-label="Usuário">{{ $usuario->nome_usuario }}</td>
        <td class="cell-sub" style="font-family: var(--font-mono);" data-label="Login">{{ $usuario->login_usuario }}</td>
        <td data-label="Perfil">{{ $usuario->perfilUsuario->nome }}</td>
        <td data-label="Status">
            <form action="/usuarios-sistema/{{ $usuario->id }}/toggle-ativo" method="POST" style="display:inline;">
                @csrf
                @method('PATCH')
                @if($usuario->ativo)
                <x-botao size="sm" variant="primary" type="button" onclick="openDeleteModal('/usuarios-sistema/{{ $usuario->id }}/toggle-ativo', 'Tem certeza que deseja desativar este usuário? Esta ação pode ser revertida ativando novamente.', 'PATCH')">Ativo</x-botao>
                @else
                <x-botao size="sm" type="submit">Inativo</x-botao>
                @endif
            </form>
        </td>
        <x-tabela.acoes editUrl="/usuarios-sistema/{{ $usuario->id }}/editar" deleteUrl="/usuarios-sistema/{{ $usuario->id }}" />
    </tr>
    @endforeach
</x-tabela.cartao>
{{ $usuarios->links() }}
@endsection
