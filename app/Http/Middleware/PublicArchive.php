<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PublicArchive
{
    public function handle($request, Closure $next)
    {
        $publicRoutes = [
            'welcome',
            'archive.show-guest',
            'archive.show_file',
            'jelajah',
            'file.download.watermark',
            'about',
            'team',
            'team.show',
        ];

        if (!Auth::check() && !in_array($request->route()->getName(), $publicRoutes)) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
