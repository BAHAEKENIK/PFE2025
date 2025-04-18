<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $role Le rôle requis (passé depuis la route)
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifie si l'utilisateur est connecté ET si son rôle correspond au rôle requis
        if (!Auth::check() || !Auth::user()->role || Auth::user()->role !== $role) {
            // Rediriger vers une page non autorisée ou le dashboard par défaut si le rôle ne correspond pas
            // abort(403, 'Accès non autorisé.'); // Option 1: Erreur 403
            return redirect('/dashboard')->with('error', 'Accès non autorisé à cette section.'); // Option 2: Redirection
        }

        return $next($request);
    }
}
