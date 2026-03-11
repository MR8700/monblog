<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Redirige l'utilisateur non authentifié.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // Si l'utilisateur essaie d'accéder à une route admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // Sinon, route normale
            return route('home');
        }
    }
}
