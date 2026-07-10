<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permissions)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $permissionNames = array_filter(array_map('trim', preg_split('/[|,]/', $permissions)));

        foreach ($permissionNames as $permissionName) {
            if ($user->hasPermission($permissionName)) {
                return $next($request);
            }
        }

        abort(403, 'Không có quyền truy cập.');
    }
}
