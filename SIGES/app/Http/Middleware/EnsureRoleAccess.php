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

        abort_unless($user, 403);

        $allowedRoles = array_map('intval', $roles);

        abort_unless(in_array((int) $user->rol, $allowedRoles, true), 403);

        return $next($request);
    }
}