<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPasswordUpdate
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if (
                $user->doit_changer_password &&
                !$request->routeIs('profile.password.edit') &&
                !$request->routeIs('profile.password.update') &&
                !$request->is('logout')
            ) {
                return redirect()->route('profile.password.edit')
                    ->with('warning', 'Veuillez modifier votre mot de passe avant de continuer.');
            }
        }

        return $next($request);
    }
}
