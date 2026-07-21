@extends('layouts.app')

@php
    $isConsulta = Auth::user()->perfil_usuario_id === 3;
    $isViewing = $isConsulta && isset($equipamento);
@endphp

@section('title', isset($equipamento) ? ($isViewing ? 'Visualizar Equipamento' : 'Editar Equipamento') : 'Novo Equipamento')

@section('topbar_title', isset($equipamento) ? ($isViewing ? 'Visualizar Equipamento' : 'Editar Equipamento') : 'Novo Equipamento')

@php
    $espacosJson = $espacos->groupBy('unidade_organizacional_id')->map(fn($group) => $group->map(fn($e) => ['id' => $e->id, 'nome' => $e->nome])->values());
    $equipamentoUnidadeId = isset($equipamento) ? $equipamento->espacoArmazenamento?->unidade_organizacional_id : null;
@endphp

@section('content')
@if($errors->any())
<div class="alert alert-error">
    <ul style="margin:0;padding-left:16px;">
        @foreach($errors->all() as $erro)
        <li>{{ $erro }}</li>
        @endforeach
    </ul>
</div>
@endif
<x-tabela.cartao search="false">
    @if($isViewing)
    <div class="image-upload-wrap">
        <div class="image-upload-box @if(isset($equipamento) && $equipamento->arquivoImagem) has-image @endif" style="cursor:default">
            @if(isset($equipamento) && $equipamento->arquivoImagem)
            <img src="/imagens/patrimoniados/{{ $equipamento->id }}" alt="">
            @else
            <div class="placeholder">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                <span>Sem imagem</span>
            </div>
            @endif
        </div>
    </div>
    <div style="padding:20px 24px;">
        <x-formulario.grade>
            <x-formulario.campo label="Nº de patrimônio">
                <div class="form-valor">#{{ $equipamento->numero_patrimonio ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Nº de série">
                <div class="form-valor">{{ $equipamento->numero_serie ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Marca">
                <div class="form-valor">{{ $equipamento->marcaEquipamento?->nome ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Tipo de equipamento">
                <div class="form-valor">{{ $equipamento->tipoEquipamento?->nome ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Condição operacional">
                <div class="form-valor">{{ $equipamento->condicaoOperacionalEquipamento?->nome ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Unidade Organizacional">
                <div class="form-valor">{{ $equipamento->espacoArmazenamento?->unidadeOrganizacional?->nome ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Espaço de armazenamento">
                <div class="form-valor">{{ $equipamento->espacoArmazenamento?->nome ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="Descrição do equipamento" :span="2">
                <div class="form-valor">{{ $equipamento->descricao_equipamento ?? '—' }}</div>
            </x-formulario.campo>
            @if($equipamento->local_anterior)
            <x-formulario.campo label="Local anterior">
                <div class="form-valor">{{ $equipamento->local_anterior }}</div>
            </x-formulario.campo>
            @endif
            <x-formulario.campo label="Observações" :span="2">
                <div class="form-valor">{{ $equipamento->observacoes_equipamento ?? '—' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="" :span="2">
                <div class="form-valor">{{ $equipamento->informado_ao_patrimonio ? '✓ Informado ao setor de patrimônio' : '✗ Não informado' }}</div>
            </x-formulario.campo>
            <x-formulario.campo label="" :span="2">
                <div class="form-valor">{{ $equipamento->patrimonio_esta_ativo ? '✓ Ativo' : '✗ Inativo' }}</div>
            </x-formulario.campo>
        </x-formulario.grade>
    </div>
    <div class="form-footer">
        <div class="form-footer-right">
            <x-botao href="/equipamentos-patrimoniados">Voltar</x-botao>
        </div>
    </div>
    @else
    <form id="main-form" action="/equipamentos-patrimoniados{{ isset($equipamento) ? '/' . $equipamento->id : '' }}" method="POST" enctype="multipart/form-data">
        @csrf
        @isset($equipamento) @method('PUT') @endisset
        <div class="image-upload-wrap">
            <div class="image-upload-box @if(isset($equipamento) && $equipamento->arquivoImagem) has-image @endif" onclick="document.getElementById('img-input').click()">
                @if(isset($equipamento) && $equipamento->arquivoImagem)
                <img id="preview-img" src="/imagens/patrimoniados/{{ $equipamento->id }}" alt="">
                @else
                <div class="placeholder" id="preview-placeholder">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    <span>Clique para adicionar imagem</span>
                </div>
                @endif
                <div class="overlay">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:18px;height:18px;"><path d="M23 19a2 2 0 01-2 2H3a2 2 0 01-2-2V8a2 2 0 012-2h4l2-3h6l2 3h4a2 2 0 012 2z"/><circle cx="12" cy="13" r="4"/></svg>
                    <span>Alterar foto</span>
                </div>
            </div>
        </div>
        <div style="padding:20px 24px;">
            <input type="file" name="arquivo" id="img-input" accept="image/*" style="display:none" onchange="previewImagem(event)">
            <x-formulario.grade>
                <x-formulario.campo label="Nº de patrimônio" required>
                    <input type="number" name="numero_patrimonio" required min="1" value="{{ old('numero_patrimonio', $equipamento->numero_patrimonio ?? '') }}" placeholder="Ex: 30302">
                </x-formulario.campo>

                <x-formulario.campo label="Nº de série">
                    <input type="text" name="numero_serie" value="{{ old('numero_serie', $equipamento->numero_serie ?? '') }}" placeholder="Ex: 0000000">
                </x-formulario.campo>
                <x-formulario.campo label="Marca" required>
                    <select name="marca_equipamento_id" required>
                        <option value="">Selecione a marca</option>
                        @foreach($marcas as $marca)
                        <option value="{{ $marca->id }}" {{ old('marca_equipamento_id', $equipamento->marca_equipamento_id ?? '') == $marca->id ? 'selected' : '' }}>{{ $marca->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>

                <x-formulario.campo label="Tipo de equipamento" required>
                    <select name="tipo_equipamento_id" required>
                        <option value="">Selecione o tipo</option>
                        @foreach($tipos as $tipo)
                        <option value="{{ $tipo->id }}" {{ old('tipo_equipamento_id', $equipamento->tipo_equipamento_id ?? '') == $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>
                <x-formulario.campo label="Condição operacional" required>
                    <select name="condicao_operacional_equipamento_id" required>
                        <option value="">Selecione a condição</option>
                        @foreach($condicoes as $condicao)
                        <option value="{{ $condicao->id }}" {{ old('condicao_operacional_equipamento_id', $equipamento->condicao_operacional_equipamento_id ?? '') == $condicao->id ? 'selected' : '' }}>{{ $condicao->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>

                <x-formulario.campo label="Unidade Organizacional" required>
                    <select name="unidade_id" id="unidade-select" required onchange="filtrarEspacos()">
                        <option value="">Selecione a unidade</option>
                        @foreach($unidades as $unidade)
                        <option value="{{ $unidade->id }}" {{ ($equipamentoUnidadeId ?? old('unidade_id')) == $unidade->id ? 'selected' : '' }}>{{ $unidade->nome }}</option>
                        @endforeach
                    </select>
                </x-formulario.campo>

                <x-formulario.campo label="Espaço de armazenamento" required>
                    <select name="espaco_armazenamento_id" id="espaco-select" required>
                        <option value="">Selecione a unidade primeiro</option>
                    </select>
                </x-formulario.campo>

                <x-formulario.campo label="Descrição do equipamento" :span="2">
                    <textarea name="descricao_equipamento" placeholder="Especificações, observações gerais do item…">{{ old('descricao_equipamento', $equipamento->descricao_equipamento ?? '') }}</textarea>
                </x-formulario.campo>

                <x-formulario.campo label="Observações" :span="2">
                    <textarea name="observacoes_equipamento" placeholder="Observações adicionais sobre movimentação, estado, etc.">{{ old('observacoes_equipamento', $equipamento->observacoes_equipamento ?? '') }}</textarea>
                </x-formulario.campo>

                @if(isset($equipamento) && $equipamento->local_anterior)
                <x-formulario.campo label="Local anterior" :span="2">
                    <div class="form-valor">{{ $equipamento->local_anterior }}</div>
                </x-formulario.campo>
                @endif

                <x-formulario.campo label="" :span="2">
                    <div class="checkbox-field">
                        <input type="checkbox" id="informado_ao_patrimonio" name="informado_ao_patrimonio" value="1" {{ old('informado_ao_patrimonio', $equipamento->informado_ao_patrimonio ?? false) ? 'checked' : '' }}>
                        <label for="informado_ao_patrimonio">Informado ao setor de patrimônio</label>
                    </div>
                </x-formulario.campo>

                <x-formulario.campo label="" :span="2">
                    <div class="checkbox-field">
                        <input type="hidden" name="patrimonio_esta_ativo" value="0">
                        <input type="checkbox" id="patrimonio_esta_ativo" name="patrimonio_esta_ativo" value="1" {{ old('patrimonio_esta_ativo', $equipamento->patrimonio_esta_ativo ?? true) ? 'checked' : '' }}>
                        <label for="patrimonio_esta_ativo">Ativo</label>
                    </div>
                </x-formulario.campo>
            </x-formulario.grade>
        </div>
        <div class="form-footer">
            @isset($equipamento)
            <x-botao variant="danger-ghost" type="button" onclick="openDeleteModal('/equipamentos-patrimoniados/{{ $equipamento->id }}', 'Tem certeza que deseja excluir este equipamento? Esta ação é irreversível.')">Excluir equipamento</x-botao>
            @endisset
            <div class="form-footer-right">
                <x-botao href="/equipamentos-patrimoniados">Cancelar</x-botao>
                <x-botao variant="primary" type="submit">Salvar equipamento</x-botao>
            </div>
        </div>
    </form>
    @endif
</x-tabela.cartao>

@if($isViewing)
<style>.image-upload-box .overlay{display:none!important}</style>
@endif
<script>
const espacosPorUnidade = @json($espacosJson);

function filtrarEspacos(){
    const unidadeId = document.getElementById('unidade-select').value;
    const espacoSelect = document.getElementById('espaco-select');
    const selected = '{{ old("espaco_armazenamento_id", $equipamento->espaco_armazenamento_id ?? "") }}';
    espacoSelect.innerHTML = '<option value="">Selecione o espaço</option>';
    if(unidadeId && espacosPorUnidade[unidadeId]){
        espacosPorUnidade[unidadeId].forEach(function(e){
            const opt = document.createElement('option');
            opt.value = e.id;
            opt.textContent = e.nome;
            if(e.id == selected) opt.selected = true;
            espacoSelect.appendChild(opt);
        });
    }
}
document.getElementById('unidade-select').addEventListener('change', filtrarEspacos);
if(document.getElementById('unidade-select').value) filtrarEspacos();

function previewImagem(event){
    const file = event.target.files[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = function(e){
        const box = document.querySelector('.image-upload-box');
        box.classList.add('has-image');
        const placeholder = document.getElementById('preview-placeholder');
        let img = document.getElementById('preview-img');
        if(!img){
            img = document.createElement('img');
            img.id = 'preview-img';
            if(placeholder) placeholder.replaceWith(img);
            else box.insertBefore(img, box.querySelector('.overlay'));
        }
        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}
</script>
@endsection
