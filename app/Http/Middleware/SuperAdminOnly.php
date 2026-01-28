<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminOnly
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$request->user()?->isSuperAdmin()) {
            abort(403, 'Hanya superadmin yang bisa mengelola admin.');
        }

        return $next($request);
    }
}
