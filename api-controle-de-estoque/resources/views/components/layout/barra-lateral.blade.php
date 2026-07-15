@props(['active' => ''])

@php
    $activePrefix = explode('/', $active)[0];
@endphp

<aside class="sidebar">
    <a class="sidebar-brand" href="/" style="text-decoration:none;">
        <div class="brand-mark">STI</div>
        <div>
            <div class="brand-text">Controle de estoque</div>
        </div>
    </a>
    <div>
        @if(Auth::user()?->perfil_usuario_id === 1)
        <div class="nav-group-label">Administrativo</div>
        <ul class="nav-list">
            <li><a class="nav-link @if($activePrefix === 'dashboard') active @endif" href="/dashboard"><span class="dot"></span>Dashboard</a></li>

            <li><a class="nav-link @if($activePrefix === 'unidades-organizacionais') active @endif" href="/unidades-organizacionais"><span class="dot"></span>Unidade Organizacional</a></li>

            <li><a class="nav-link @if(str_starts_with($active, 'equipamentos/marcas')) active @endif" href="/equipamentos/marcas"><span class="dot"></span>Marcas</a></li>

            <li><a class="nav-link @if(str_starts_with($active, 'equipamentos/tipos')) active @endif" href="/equipamentos/tipos"><span class="dot"></span>Tipos</a></li>

            <li><a class="nav-link @if(str_starts_with($active, 'equipamentos/condicoes')) active @endif" href="/equipamentos/condicoes"><span class="dot"></span>Condiçao Operacional</a></li>

            <li><a class="nav-link @if($activePrefix === 'usuarios-sistema') active @endif" href="/usuarios-sistema"><span class="dot"></span>Usuários do Sistema</a></li>

            <li><a class="nav-link @if($activePrefix === 'registros-auditoria') active @endif" href="/registros-auditoria"><span class="dot"></span>Registros de Auditoria</a></li>
        </ul>
        @endif
        <br>
        <div class="nav-group-label">Operacional</div>
        <ul class="nav-list">
            <li><a class="nav-link @if($activePrefix === 'equipamentos-patrimoniados') active @endif" href="/equipamentos-patrimoniados"><span class="dot"></span>Itens Patrimoniados</a></li>

            <li><a class="nav-link @if($activePrefix === 'itens-estoque') active @endif" href="/itens-estoque"><span class="dot"></span>Itens de Estoque</a></li>
        </ul>
        <br>
        <div class="nav-group-label">Conta</div>
        <ul class="nav-list">
            <li><a class="nav-link @if($activePrefix === 'perfil-usuario') active @endif" href="/perfil-usuario"><span class="dot"></span>Meu Perfil</a></li>
        </ul>
    </div>
</aside>
