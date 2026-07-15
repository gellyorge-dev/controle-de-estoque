@extends('layouts.app')

@section('title', 'Perfil do Usuário')

@section('topbar_title', 'Perfil do Usuário')

@section('content')
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-error">
    <ul style="margin:0;padding-left:16px;">
        @foreach($errors->all() as $erro)
        <li>{{ $erro }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="table-card perfil-card">
    <div class="table-toolbar">
        <h2>Meus dados</h2>
    </div>
    <form action="/perfil-usuario" method="POST" onsubmit="return validarSenha(event)">
        @csrf
        @method('PUT')
        <div class="perfil-body">
            <div class="perfil-grid">
                @if(Auth::user()?->perfil_usuario_id === 1)
                <div class="perfil-field perfil-field-full">
                    <label>Nome do usuário <span class="req">*</span></label>
                    <input type="text" name="nome_usuario" required value="{{ old('nome_usuario', $usuario->nome_usuario ?? '') }}" placeholder="Ex: Fulano de Tal">
                </div>
                <div class="perfil-field">
                    <label>Login <span class="req">*</span></label>
                    <input type="text" name="login_usuario" required value="{{ old('login_usuario', $usuario->login_usuario ?? '') }}" placeholder="Ex: fulano.de.tal">
                </div>
                @else
                <div class="perfil-field perfil-field-full">
                    <label>Nome do usuário</label>
                    <div class="perfil-valor">{{ $usuario->nome_usuario }}</div>
                </div>
                <div class="perfil-field">
                    <label>Login</label>
                    <div class="perfil-valor">{{ $usuario->login_usuario }}</div>
                </div>
                @endif
                <div class="perfil-field">
                    <label>Nova senha <span class="form-hint">(deixar vazio para manter)</span></label>
                    <input type="password" name="senha_usuario" id="senha" placeholder="Mín. 8 caracteres">
                </div>
                <div class="perfil-field">
                    <label>Confirmar senha</label>
                    <input type="password" name="senha_usuario_confirmation" id="senha_confirmation" placeholder="Repita a senha">
                    <span class="perfil-senha-aviso" id="senha-aviso"></span>
                </div>
            </div>
        </div>
        <div class="perfil-footer">
            <button class="btn btn-primary" type="submit">Salvar alterações</button>
        </div>
    </form>
</div>

<style>
.perfil-body{ padding:20px 24px; }
.perfil-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:16px;
}
.perfil-field{ display:flex; flex-direction:column; gap:6px; }
.perfil-field-full{ grid-column:1/-1; }
.perfil-field label{ font-size:12.5px; font-weight:600; color:var(--ink); }
.perfil-field input{
    padding:10px 12px;
    border-radius:var(--radius-sm);
    border:1px solid var(--border);
    background:var(--surface);
    font-size:13px;
    color:var(--ink);
    transition:border-color var(--transition),box-shadow var(--transition);
}
.perfil-field input:focus{
    outline:none;
    border-color:var(--accent-2);
    box-shadow:0 0 0 3px var(--accent-soft);
}
.perfil-field input.erro{ border-color:var(--danger); }
.perfil-field input.ok{ border-color:var(--ok); }
.perfil-valor{ padding:10px 12px; border-radius:var(--radius-sm); border:1px solid var(--border); background:var(--muted); font-size:13px; color:var(--ink); }
.perfil-senha-aviso{ font-size:12px; font-weight:600; min-height:18px; }
.perfil-senha-aviso.erro{ color:var(--danger); }
.perfil-senha-aviso.ok{ color:var(--ok); }
.perfil-footer{
    padding:16px 24px;
    border-top:1px solid var(--border);
    display:flex;
    justify-content:flex-end;
    gap:10px;
}
@media(max-width:520px){
    .perfil-grid{ grid-template-columns:1fr; }
}
</style>

<script>
function validarSenha(e){
    var senha=document.getElementById('senha');
    var confirm=document.getElementById('senha_confirmation');
    var aviso=document.getElementById('senha-aviso');
    if(senha.value||confirm.value){
        if(senha.value!==confirm.value){
            aviso.textContent='As senhas não conferem.';
            aviso.className='perfil-senha-aviso erro';
            senha.className='erro';
            confirm.className='erro';
            e.preventDefault();
            return false;
        }
        if(senha.value.length>0&&senha.value.length<8){
            aviso.textContent='A senha deve ter no mínimo 8 caracteres.';
            aviso.className='perfil-senha-aviso erro';
            senha.className='erro';
            confirm.className='erro';
            e.preventDefault();
            return false;
        }
    }
    return true;
}
(function(){
    var senha=document.getElementById('senha');
    var confirm=document.getElementById('senha_confirmation');
    var aviso=document.getElementById('senha-aviso');
    function verificar(){
        if(!senha.value&&!confirm.value){ aviso.textContent=''; aviso.className='perfil-senha-aviso'; senha.className=''; confirm.className=''; return; }
        if(senha.value!==confirm.value){
            aviso.textContent='As senhas não conferem.';
            aviso.className='perfil-senha-aviso erro';
            senha.className='erro';
            confirm.className='erro';
        }else if(senha.value.length<8){
            aviso.textContent='Mínimo 8 caracteres.';
            aviso.className='perfil-senha-aviso erro';
            senha.className='erro';
            confirm.className='ok';
        }else{
            aviso.textContent='Senhas conferem.';
            aviso.className='perfil-senha-aviso ok';
            senha.className='ok';
            confirm.className='ok';
        }
    }
    senha.addEventListener('input',verificar);
    confirm.addEventListener('input',verificar);
})();
</script>
@endsection
