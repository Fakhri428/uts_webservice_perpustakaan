<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserRole
{
    /**
     * Handle an incoming request.
     * Usage: ->middleware([EnsureUserRole::class . ':admin'])
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if (! $user) {
            return redirect('/login');
        }

        if ($user->role !== $role) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
