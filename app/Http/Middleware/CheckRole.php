<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $roleNames = array_filter(array_map('trim', preg_split('/[|,]/', $roles)));
        foreach ($roleNames as $roleName) {
            if ($user->hasRole($roleName)) {
                return $next($request);
            }
        }

        abort(403, 'Không có quyền truy cập.');
    }
}
