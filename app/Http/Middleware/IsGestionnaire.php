<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsGestionnaire
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'gestionnaire') {
            return $next($request);
        }

        abort(403, 'Accès réservé uniquement au gestionnaire.');
    }
}
