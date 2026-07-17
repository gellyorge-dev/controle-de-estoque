<header class="topbar">
    <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Abrir menu">☰</button>
    <div class="topbar-title">
        <a class="topbar-back" onclick="history.back(); return false;" href="#">←</a>
        @yield('topbar_title')
    </div>
    <div style="display:flex;align-items:center;gap:12px;">
        <div class="topbar-user" onclick="window.location.href='/perfil-usuario'" style="cursor:pointer;">
            @if(Auth::user()?->arquivoImagem)
            <img class="topbar-avatar" src="/imagens/perfil/{{ Auth::user()->id }}" alt="">
            @endif
            <span>{{ Auth::user()?->nome_usuario }}</span>
        </div>
        <form action="/logout" method="POST" style="margin:0;">
            @csrf
            <button class="btn btn-sm btn-ghost" type="submit" style="color:var(--ink-faint);">Sair</button>
        </form>
    </div>
</header>
