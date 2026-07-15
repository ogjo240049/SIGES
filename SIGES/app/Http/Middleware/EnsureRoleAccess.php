<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleAccess
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $allowedRoles = array_map('intval', $roles);

        if (! in_array((int) $user->rol, $allowedRoles, true)) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Acceso denegado.'], Response::HTTP_FORBIDDEN);
            }

            abort(Response::HTTP_FORBIDDEN, 'Acceso denegado.');
        }

        return $next($request);
    }
}