<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel de Patrimônio') — Painel de Patrimônio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
</head>
<body>
<div class="app-shell">
    <x-layout.barra-lateral :active="request()->path()" />
    <div class="main-col">
        <x-layout.barra-superior />
        <main class="content">
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/assets/ui.js"></script>
<div class="modal-overlay" id="modal-confirm-delete">
    <div class="modal modal-danger">
        <div class="modal-head">
            <div>
                <h2>Confirmar exclusão</h2>
                <p style="font-size:13px;color:var(--ink-soft);margin:4px 0 0;">Esta ação é irreversível.</p>
            </div>
            <button class="modal-close" onclick="fecharModalExclusao()">✕</button>
        </div>
        <div class="modal-body">
            <p id="modal-delete-message" style="font-size:14px;color:var(--ink);margin:0;">Tem certeza que deseja excluir este registro?</p>
        </div>
        <div class="modal-foot">
            <button class="btn" onclick="fecharModalExclusao()">Cancelar</button>
            <button class="btn btn-danger" id="modal-delete-confirm" onclick="confirmarExclusao()">Sim, excluir</button>
        </div>
    </div>
</div>
</body>
</html>
