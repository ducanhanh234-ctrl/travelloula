<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('Admin.login');
        }

        if (!$user->isAdmin()) {
            abort(403, 'Không có quyền truy cập.');
        }

        return $next($request);
    }
}
