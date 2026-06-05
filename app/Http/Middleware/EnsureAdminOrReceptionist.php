<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminOrReceptionist
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->role !== 'admin' && $user->role !== 'receptionist') {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
