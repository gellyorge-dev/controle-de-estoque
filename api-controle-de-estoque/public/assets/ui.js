function toggleSidebar() {
    document.querySelector('.sidebar').classList.toggle('open');
}

function filterTable(input, tbodyId) {
    const filter = input.value.toLowerCase();
    const tbody = document.getElementById(tbodyId);
    const rows = tbody.getElementsByTagName('tr');
    for (const row of rows) {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    }
}

document.addEventListener('submit', function(e) {
    if (!e.target.matches('form')) return;
    const btns = e.target.querySelectorAll('button[type="submit"], .btn-primary');
    for (const btn of btns) {
        btn.disabled = true;
        btn.textContent = 'Aguarde…';
    }
});

let acaoExclusao = null;

function openDeleteModal(action, message, method) {
    acaoExclusao = { action: action, method: method || 'DELETE' };
    document.getElementById('modal-delete-message').textContent = message || 'Tem certeza que deseja excluir este registro?';
    document.getElementById('modal-confirm-delete').classList.add('open');
}

function confirmarExclusao() {
    if (acaoExclusao) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = acaoExclusao.action;
        form.style.display = 'none';
        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
        form.appendChild(csrf);
        if (acaoExclusao.method !== 'POST') {
            const method = document.createElement('input');
            method.type = 'hidden';
            method.name = '_method';
            method.value = acaoExclusao.method;
            form.appendChild(method);
        }
        document.body.appendChild(form);
        form.submit();
    }
    fecharModalExclusao();
}

function fecharModalExclusao() {
    document.getElementById('modal-confirm-delete').classList.remove('open');
    acaoExclusao = null;
}

document.getElementById('modal-confirm-delete')?.addEventListener('click', function(e) {
    if (e.target === this) fecharModalExclusao();
});
