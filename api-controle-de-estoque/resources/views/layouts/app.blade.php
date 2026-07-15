<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel de Patrimônio') — Painel de Patrimônio</title>
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
</body>
</html>
