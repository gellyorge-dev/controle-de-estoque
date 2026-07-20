<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    private const MAP = [
        'administrador' => 1,
        'operador' => 2,
        'consulta' => 3,
    ];

    public function handle(Request $request, Closure $next, string ...$profiles): Response
    {
        $allowed = array_map(
            fn (string $p) => self::MAP[$p] ?? (int) $p,
            $profiles,
        );

        abort_unless(
            in_array(Auth::user()?->perfil_usuario_id, $allowed, true),
            403,
            'Acesso não autorizado para este perfil.',
        );

        return $next($request);
    }
}
