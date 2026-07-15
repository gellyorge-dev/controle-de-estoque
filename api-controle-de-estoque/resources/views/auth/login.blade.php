<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Painel de Patrimônio</title>
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <style>
        .login-page{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            background: var(--bg);
        }
        .login-card{
            width: 100%;
            max-width: 400px;
            background: var(--surface);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 32px;
        }
        .login-card h1{
            text-align: center;
            margin-bottom: 4px;
        }
        .login-card .form-hint{
            text-align: center;
            display: block;
            margin-bottom: 24px;
        }
        .login-card .btn{
            width: 100%;
            margin-top: 8px;
        }
        .login-error{
            background: var(--danger-soft);
            color: var(--danger);
            padding: 10px 14px;
            border-radius: var(--radius-sm);
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 16px;
        }
    </style>
</head>
<body class="login-page">
    <div class="login-card">
        <h1>Painel de Patrimônio</h1>
        <span class="form-hint">Faça login para continuar</span>

        @if($errors->any())
            <div class="login-error">{{ $errors->first('login_usuario') }}</div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-field">
                <label>Login</label>
                <input type="text" name="login_usuario" value="{{ old('login_usuario') }}" required autofocus placeholder="Seu login">
            </div>
            <div class="form-field" style="margin-top:12px;">
                <label>Senha</label>
                <input type="password" name="senha_usuario" required placeholder="Sua senha">
            </div>
            <button class="btn btn-primary" type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>
