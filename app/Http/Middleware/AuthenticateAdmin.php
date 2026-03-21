<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class AuthenticateAdmin extends Middleware
{
    /**
     * Force le guard admin pour ce middleware.
     */
    protected function authenticate($request, array $guards): void
    {
        parent::authenticate($request, ['admin']);
    }

    /**
     * Redirige l'utilisateur non authentifie.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            return route('admin.login');
        }

        return null;
    }
}
