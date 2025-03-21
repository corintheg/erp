<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{

    public function handle(Request $request, Closure $next, string $role)
    {
        $user = Auth::user();

        // Si pas connecté ou n'a pas le rôle, on refuse l'accès
        if (!$user || !$user->hasRole($role)) {
            abort(403, 'Accès refusé');
        }

        return $next($request);
    }
}