<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // On vérifie si l'utilisateur est authentifié avec le guard admin
        // Ou si c'est un utilisateur classique avec un flag admin (dépend de l'implémentation API)
        if (auth()->guard('admin')->check()) {
            return $next($request);
        }

        return response()->json(['message' => 'Accès refusé. Administrateurs uniquement.'], 403);
    }
}
