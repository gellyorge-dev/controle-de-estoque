@extends('layouts.app')

@section('title', 'Dashboard')

@section('topbar_title', 'Dashboard')

@section('content')
<div class="table-card">
    <div class="table-toolbar"><h2>Resumo do Sistema</h2></div>
    <div style="padding:24px;">
        <div class="dashboard-grid">
            <div class="stat-box">
                <span class="stat-label">Equipamentos Patrimoniados</span>
                <span class="stat-value">{{ $counts['equipamentos'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Itens em Estoque</span>
                <span class="stat-value">{{ $counts['itens'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Unidades Organizacionais</span>
                <span class="stat-value">{{ $counts['unidades'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Espaços de Armazenamento</span>
                <span class="stat-value">{{ $counts['espacos'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Usuários</span>
                <span class="stat-value">{{ $counts['usuarios'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Perfis</span>
                <span class="stat-value">{{ $counts['perfis'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Marcas</span>
                <span class="stat-value">{{ $counts['marcas'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Tipos de Equipamento</span>
                <span class="stat-value">{{ $counts['tipos'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Condições Operacionais</span>
                <span class="stat-value">{{ $counts['condicoes'] }}</span>
            </div>
            <div class="stat-box">
                <span class="stat-label">Registros de Auditoria</span>
                <span class="stat-value">{{ $counts['auditorias'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection