<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string  $roles
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::guard('employee')->check()) {
            return redirect()->route('login');
        }

        $user = Auth::guard('employee')->user();
        // $allowedRoles = explode(',', $roles);
        $allowedRoles = collect(explode(',', $roles))->map(fn($r) => trim($r))->all();



        if (!in_array($user->role->role_name, $allowedRoles)) {
            abort(403, 'Access denied. You do not have permission to access this page.');
        }

        return $next($request);
    }
}
