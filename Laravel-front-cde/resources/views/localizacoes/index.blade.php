@extends('layouts.app')

@section('title', 'Localizações - Controle de Estoque')
@section('page-title', 'Localizações')

@section('header-actions')
<button onclick="openModal('createModal')" class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-medium rounded-lg hover:bg-primary-hover transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Nova Localização
</button>
@endsection

@section('content')
<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <div class="p-4 border-b border-slate-200">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex-1 min-w-[200px]">
                <input type="text" id="searchInput" placeholder="Buscar localização..." class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <label class="flex items-center gap-2 text-sm text-secondary cursor-pointer">
                <input type="checkbox" id="showTrashed" onchange="loadLocalizacoes()" class="rounded border-slate-300 text-primary focus:ring-primary/20">
                Mostrar deletados
            </label>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-secondary-light">
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-secondary">ID</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-secondary">Nome</th>
                    <th class="text-left px-4 py-3 text-xs font-semibold uppercase tracking-wider text-secondary">Status</th>
                    <th class="text-right px-4 py-3 text-xs font-semibold uppercase tracking-wider text-secondary">Ações</th>
                </tr>
            </thead>
            <tbody id="localizacoesTableBody" class="divide-y divide-slate-100">
            </tbody>
        </table>
    </div>
    <div id="emptyState" class="hidden text-center py-12 text-slate-500">
        <p>Nenhuma localização encontrada.</p>
    </div>
</div>

<div id="createModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50" onclick="if(event.target===this)closeModal('createModal')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-secondary">Nova Localização</h3>
            <button onclick="closeModal('createModal')" class="text-slate-400 hover:text-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="createForm" onsubmit="createLocalizacao(event)" class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-secondary mb-1">Nome da Localização</label>
                <input type="text" name="localizacao_nome" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 text-sm font-medium text-secondary border border-slate-300 rounded-lg hover:bg-secondary-light">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-hover">Salvar</button>
            </div>
        </form>
    </div>
</div>

<div id="editModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50" onclick="if(event.target===this)closeModal('editModal')">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-secondary">Editar Localização</h3>
            <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-secondary">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form id="editForm" onsubmit="updateLocalizacao(event)" class="p-6 space-y-4">
            <input type="hidden" name="id">
            <div>
                <label class="block text-sm font-medium text-secondary mb-1">Nome da Localização</label>
                <input type="text" name="localizacao_nome" required class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 text-sm font-medium text-secondary border border-slate-300 rounded-lg hover:bg-secondary-light">Cancelar</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-primary rounded-lg hover:bg-primary-hover">Salvar</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
async function loadLocalizacoes() {
    const showTrashed = document.getElementById('showTrashed').checked;
    const endpoint = showTrashed ? '/localizacoes/trashed' : '/localizacoes';
    try {
        const localizacoes = await api.get(endpoint);
        const tbody = document.getElementById('localizacoesTableBody');
        const emptyState = document.getElementById('emptyState');
        const searchTerm = (document.getElementById('searchInput')?.value || '').toLowerCase();

        let filtered = localizacoes;
        if (searchTerm) {
            filtered = localizacoes.filter(l => l.localizacao_nome?.toLowerCase().includes(searchTerm));
        }

        if (filtered.length === 0) {
            tbody.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }
        emptyState.classList.add('hidden');
        tbody.innerHTML = filtered.map(l => `
            <tr class="hover:bg-secondary-light/50 transition-colors">
                <td class="px-4 py-3 text-sm text-secondary">${l.id}</td>
                <td class="px-4 py-3 text-sm font-medium text-secondary">${escapeHtml(l.localizacao_nome)}</td>
                <td class="px-4 py-3">
                    ${l.deleted_at
                        ? '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700">Deletado</span>'
                        : '<span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">Ativo</span>'
                    }
                </td>
                <td class="px-4 py-3 text-right">
                    ${l.deleted_at
                        ? `<button onclick="restoreLocalizacao(${l.id})" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Restaurar
                        </button>`
                        : `<button onclick="editLocalizacao(${l.id})" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-primary bg-primary-light rounded-lg hover:bg-primary/10 transition-colors mr-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Editar
                        </button>
                        <button onclick="deleteLocalizacao(${l.id})" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Deletar
                        </button>`
                    }
                </td>
            </tr>
        `).join('');
    } catch (e) {
        showToast('Erro ao carregar localizações: ' + (e.message || 'Erro desconhecido'), 'error');
    }
}

async function createLocalizacao(event) {
    event.preventDefault();
    const data = getFormData('createForm');
    try {
        await api.post('/localizacoes', data);
        showToast('Localização criada com sucesso!');
        closeModal('createModal');
        resetForm('createForm');
        loadLocalizacoes();
    } catch (e) {
        showToast(e.errors ? Object.values(e.errors).flat().join(', ') : (e.message || 'Erro ao criar'), 'error');
    }
}

async function editLocalizacao(id) {
    try {
        const localizacao = await api.get(`/localizacoes/${id}`);
        setFormData('editForm', { id: localizacao.id, localizacao_nome: localizacao.localizacao_nome });
        openModal('editModal');
    } catch (e) {
        showToast('Erro ao carregar localização', 'error');
    }
}

async function updateLocalizacao(event) {
    event.preventDefault();
    const data = getFormData('editForm');
    try {
        await api.put(`/localizacoes/${data.id}`, data);
        showToast('Localização atualizada com sucesso!');
        closeModal('editModal');
        loadLocalizacoes();
    } catch (e) {
        showToast(e.errors ? Object.values(e.errors).flat().join(', ') : (e.message || 'Erro ao atualizar'), 'error');
    }
}

async function deleteLocalizacao(id) {
    if (!confirm('Tem certeza que deseja deletar esta localização?')) return;
    try {
        await api.delete(`/localizacoes/${id}`);
        showToast('Localização deletada com sucesso!');
        loadLocalizacoes();
    } catch (e) {
        showToast('Erro ao deletar', 'error');
    }
}

async function restoreLocalizacao(id) {
    try {
        await api.put(`/localizacoes/${id}/restore`);
        showToast('Localização restaurada com sucesso!');
        loadLocalizacoes();
    } catch (e) {
        showToast('Erro ao restaurar', 'error');
    }
}

document.getElementById('searchInput')?.addEventListener('input', loadLocalizacoes);

document.addEventListener('DOMContentLoaded', loadLocalizacoes);
</script>
@endpush
