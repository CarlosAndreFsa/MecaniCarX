<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ... $roles): Response
    {
        $user = $request->user();

        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Usuário sem permissão');
        }

        return $next($request);
    }
}
