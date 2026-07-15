@props(['title' => 'Painel de Patrimônio', 'topbarTitle' => '', 'active' => ''])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} — Painel de Patrimônio</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/dashboard.css">
    <link rel="stylesheet" href="/assets/css/sidebar.css">
</head>
<body>
<div class="app-shell">
    <x-layout.barra-lateral :active="$active" />
    <div class="main-col">
        <x-layout.barra-superior :title="$topbarTitle" />
        <main class="content">
            {{ $slot }}
        </main>
    </div>
</div>
<script src="/assets/ui.js"></script>
</body>
</html>
