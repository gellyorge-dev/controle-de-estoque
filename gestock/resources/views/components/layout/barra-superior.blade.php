<header class="topbar">
    <div class="topbar-left">
        <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Abrir menu">☰</button>
        <a class="topbar-back" onclick="history.back(); return false;" href="#">←</a>
    </div>
    <div class="topbar-title">
        @yield('topbar_title')
    </div>
    <div class="topbar-right">
        <div class="topbar-user" onclick="window.location.href='/perfil-usuario'" style="cursor:pointer;">
            @if(Auth::user()?->arquivoImagem)
            <img class="topbar-avatar" src="/imagens/perfil/{{ Auth::user()->id }}" alt="">
            @endif
        </div>
    </div>
</header>
