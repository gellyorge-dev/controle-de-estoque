<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Controle de Estoque')</title>
    @fonts
    <meta name="api-url" content="{{ env('API_URL', 'http://localhost:8000/api') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased bg-secondary-light min-h-screen">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white border-r border-slate-200 flex-shrink-0 hidden lg:block">
            <div class="h-16 flex items-center px-6 border-b border-slate-200">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-primary flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-secondary">Controle de Estoque</span>
                </a>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('home')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Cadastros</p>
                </div>
                <a href="{{ route('tipos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('tipos.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    Tipos
                </a>
                <a href="{{ route('fabricantes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('fabricantes.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Fabricantes
                </a>
                <a href="{{ route('localizacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('localizacoes.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Localizações
                </a>
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Itens</p>
                </div>
                <a href="{{ route('itens-quantidade.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('itens-quantidade.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0 0v3m0-3h3m-3 0H9"/>
                    </svg>
                    Itens de Quantidade
                </a>
                <a href="{{ route('itens-patrimoniados.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('itens-patrimoniados.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Itens Patrimoniados
                </a>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 lg:px-6">
                <div class="flex items-center gap-3">
                    <button type="button" class="lg:hidden p-2 rounded-lg text-secondary hover:bg-secondary-light" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-secondary">@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="logout()" class="px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 transition-colors">
                        Sair
                    </button>
                    @yield('header-actions')
                </div>
            </header>

            <div id="mobile-menu" class="hidden lg:hidden bg-white border-b border-slate-200">
                <nav class="p-4 space-y-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('home')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Cadastros</p>
                    </div>
                    <a href="{{ route('tipos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('tipos.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">Tipos</a>
                    <a href="{{ route('fabricantes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('fabricantes.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">Fabricantes</a>
                    <a href="{{ route('localizacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('localizacoes.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">Localizações</a>
                    <div class="pt-4 pb-2">
                        <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">Itens</p>
                    </div>
                    <a href="{{ route('itens-quantidade.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('itens-quantidade.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">Itens de Quantidade</a>
                    <a href="{{ route('itens-patrimoniados.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors @if(request()->routeIs('itens-patrimoniados.*')) bg-primary-light text-primary @else text-secondary hover:bg-secondary-light @endif">Itens Patrimoniados</a>
                </nav>
            </div>

            <main class="flex-1 p-4 lg:p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
