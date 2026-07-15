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
