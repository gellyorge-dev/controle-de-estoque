<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Controle de Estoque</title>
    @fonts
    <meta name="api-url" content="{{ env('API_URL', 'http://localhost:8000/api') }}">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="font-sans antialiased bg-secondary-light min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-4">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <div class="text-center mb-8">
                <div class="w-12 h-12 rounded-xl bg-primary flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-secondary">Controle de Estoque</h1>
                <p class="text-sm text-slate-500 mt-1">Faça login para continuar</p>
            </div>

            <form id="login-form" class="space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-secondary mb-1">Usuário</label>
                    <input type="text" id="username" name="username" required
                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors text-sm">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-secondary mb-1">Senha</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2.5 rounded-lg border border-slate-300 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-colors text-sm">
                </div>
                <button type="submit"
                    class="w-full bg-primary text-white py-2.5 rounded-lg font-medium text-sm hover:bg-primary/90 transition-colors">
                    Entrar
                </button>
            </form>

            <div id="login-error" class="mt-4 text-sm text-red-600 text-center hidden"></div>
        </div>
    </div>

    <script>
        document.getElementById('login-form').addEventListener('submit', async (e) => {
            e.preventDefault();
            const errorEl = document.getElementById('login-error');
            errorEl.classList.add('hidden');

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const API_URL = document.querySelector('meta[name="api-url"]')?.getAttribute('content') || 'http://localhost:8000/api';

            try {
                const response = await fetch(`${API_URL}/login`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ username, password }),
                });

                if (!response.ok) {
                    throw new Error('Usuário ou senha inválidos');
                }

                const data = await response.json();
                localStorage.setItem('auth_token', data.token);
                window.location.href = '/';
            } catch (err) {
                errorEl.textContent = err.message;
                errorEl.classList.remove('hidden');
            }
        });
    </script>
</body>
</html>
