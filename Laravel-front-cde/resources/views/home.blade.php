@extends('layouts.app')

@section('title', 'Dashboard - Controle de Estoque')
@section('page-title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <a href="{{ route('tipos.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-primary/30 hover:shadow-md transition-all group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-secondary">Tipos</h3>
                <p class="text-sm text-slate-500">Gerenciar tipos de itens</p>
            </div>
        </div>
    </a>

    <a href="{{ route('fabricantes.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-primary/30 hover:shadow-md transition-all group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-secondary">Fabricantes</h3>
                <p class="text-sm text-slate-500">Gerenciar fabricantes</p>
            </div>
        </div>
    </a>

    <a href="{{ route('localizacoes.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-primary/30 hover:shadow-md transition-all group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-secondary">Localizações</h3>
                <p class="text-sm text-slate-500">Gerenciar localizações</p>
            </div>
        </div>
    </a>

    <a href="{{ route('itens-quantidade.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-primary/30 hover:shadow-md transition-all group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7v3m0 0v3m0-3h3m-3 0H9"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-secondary">Itens de Quantidade</h3>
                <p class="text-sm text-slate-500">Gerenciar itens por quantidade</p>
            </div>
        </div>
    </a>

    <a href="{{ route('itens-patrimoniados.index') }}" class="bg-white rounded-xl border border-slate-200 p-6 hover:border-primary/30 hover:shadow-md transition-all group">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-primary-light flex items-center justify-center group-hover:bg-primary/10 transition-colors">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div>
                <h3 class="font-semibold text-secondary">Itens Patrimoniados</h3>
                <p class="text-sm text-slate-500">Gerenciar itens com patrimônio</p>
            </div>
        </div>
    </a>
</div>
@endsection
