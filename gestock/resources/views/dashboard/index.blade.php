@extends('layouts.app')

@section('title', 'Dashboard')

@section('topbar_title', 'Dashboard')

@php
    $pieData = [
        ['label' => 'Equipamentos', 'value' => $counts['equipamentos'], 'color' => '#3b82f6'],
        ['label' => 'Itens', 'value' => $counts['itens'], 'color' => '#8b5cf6'],
        ['label' => 'Unidades', 'value' => $counts['unidades'], 'color' => '#10b981'],
        ['label' => 'Espaços', 'value' => $counts['espacos'], 'color' => '#14b8a6'],
        ['label' => 'Usuários', 'value' => $counts['usuarios'], 'color' => '#f97316'],
        ['label' => 'Perfis', 'value' => $counts['perfis'], 'color' => '#f43f5e'],
        ['label' => 'Marcas', 'value' => $counts['marcas'], 'color' => '#06b6d4'],
        ['label' => 'Tipos', 'value' => $counts['tipos'], 'color' => '#a855f7'],
        ['label' => 'Condições', 'value' => $counts['condicoes'], 'color' => '#eab308'],
    ];
    $total = array_sum(array_column($pieData, 'value'));
    $pctSum = 0;
    $stops = [];
    foreach ($pieData as $item) {
        $pct = $total > 0 ? ($item['value'] / $total) * 100 : 0;
        $stops[] = $item['color'] . ' ' . round($pctSum, 2) . '% ' . round($pctSum + $pct, 2) . '%';
        $pctSum += $pct;
    }
    $gradient = 'conic-gradient(' . implode(', ', $stops) . ')';
@endphp

@section('content')
<div class="table-card">
    <div class="table-toolbar">
        <h2>Resumo do Sistema</h2>
        <x-botao href="/dashboard/exportar/resumo" variant="primary" size="sm">Exportar CSV</x-botao>
    </div>
    <div style="padding:24px;">
        <div class="pie-wrap">
            <div class="pie" style="background:{{ $gradient }}">
                <div class="pie-hole">
                    <span class="pie-total">{{ $total }}</span>
                    <span class="pie-total-label">total</span>
                </div>
            </div>
            <div class="pie-legend">
                @foreach($pieData as $item)
                @php $pct = $total > 0 ? round(($item['value'] / $total) * 100, 1) : 0; @endphp
                <div class="pie-legend-item">
                    <span class="pie-dot" style="background:{{ $item['color'] }}"></span>
                    <span class="pie-legend-label">{{ $item['label'] }}</span>
                    <span className="legend-value">{{ $item['value'] }}</span>
                    <span class="pie-legend-pct">{{ $pct }}%</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="table-card">
    <div class="table-toolbar"><h2>Exportar Dados</h2></div>
    <div style="padding:24px;">
        <div class="card-grid">
            <a href="/dashboard/exportar/equipamentos" class="entity-card">
                <div class="icon-dot">E</div>
                <h3>Equipamentos Patrimoniados</h3>
                <p>Exportar todos os equipamentos cadastrados em CSV</p>
            </a>
            <a href="/dashboard/exportar/itens-estoque" class="entity-card">
                <div class="icon-dot">I</div>
                <h3>Itens de Estoque</h3>
                <p>Exportar todos os itens de estoque cadastrados em CSV</p>
            </a>
        </div>
    </div>
</div>
@endsection