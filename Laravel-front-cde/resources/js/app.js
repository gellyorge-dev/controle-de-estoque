const API_URL = document.querySelector('meta[name="api-url"]')?.getAttribute('content') || 'http://localhost:8000/api';

const api = {
    async request(url, options = {}) {
        const config = {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                ...options.headers,
            },
            ...options,
        };

        const response = await fetch(url, config);

        if (response.status === 204) return null;
        if (response.status === 422) {
            const data = await response.json();
            throw { status: 422, errors: data.errors, message: data.message };
        }
        if (!response.ok) {
            throw { status: response.status, message: response.statusText };
        }

        return response.json();
    },

    get(endpoint) { return this.request(`${API_URL}${endpoint}`); },
    post(endpoint, data) { return this.request(`${API_URL}${endpoint}`, { method: 'POST', body: JSON.stringify(data) }); },
    put(endpoint, data) { return this.request(`${API_URL}${endpoint}`, { method: 'PUT', body: JSON.stringify(data) }); },
    delete(endpoint) { return this.request(`${API_URL}${endpoint}`, { method: 'DELETE' }); },
};

function showToast(message, type = 'success') {
    const container = document.getElementById('toast-container') || (() => {
        const el = document.createElement('div');
        el.id = 'toast-container';
        el.className = 'fixed top-4 right-4 z-50 flex flex-col gap-2';
        document.body.appendChild(el);
        return el;
    })();

    const colors = {
        success: 'bg-emerald-50 text-emerald-800 border-emerald-200',
        error: 'bg-red-50 text-red-800 border-red-200',
        info: 'bg-blue-50 text-blue-800 border-blue-200',
    };

    const toast = document.createElement('div');
    toast.className = `${colors[type] || colors.info} border px-4 py-3 rounded-lg shadow-lg text-sm font-medium flex items-center gap-2 transition-all duration-300`;
    toast.innerHTML = `
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 opacity-70 hover:opacity-100">&times;</button>
    `;
    container.appendChild(toast);
    setTimeout(() => { toast.style.opacity = '0'; setTimeout(() => toast.remove(), 300); }, 4000);
}

function openModal(modalId) {
    document.getElementById(modalId)?.classList.remove('hidden');
    document.getElementById(modalId)?.classList.add('flex');
}

function closeModal(modalId) {
    document.getElementById(modalId)?.classList.add('hidden');
    document.getElementById(modalId)?.classList.remove('flex');
}

function getFormData(formId) {
    const form = document.getElementById(formId);
    if (!form) return {};
    const data = {};
    new FormData(form).forEach((value, key) => {
        data[key] = value;
    });
    return data;
}

function resetForm(formId) {
    const form = document.getElementById(formId);
    if (form) form.reset();
}

function setFormData(formId, data) {
    const form = document.getElementById(formId);
    if (!form) return;
    Object.entries(data).forEach(([key, value]) => {
        const input = form.querySelector(`[name="${key}"]`);
        if (input) input.value = value;
    });
}

function escapeHtml(str) {
    if (!str) return '';
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

window.api = api;
window.showToast = showToast;
window.openModal = openModal;
window.closeModal = closeModal;
window.getFormData = getFormData;
window.resetForm = resetForm;
window.setFormData = setFormData;
window.escapeHtml = escapeHtml;
