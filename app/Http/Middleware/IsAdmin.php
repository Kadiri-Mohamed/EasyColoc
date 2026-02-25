<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Vérifie que l'utilisateur connecté est un administrateur.
     * Redirige vers le dashboard si ce n'est pas le cas.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Acces reserve aux administrateurs.');
        }

        return $next($request);
    }
}
