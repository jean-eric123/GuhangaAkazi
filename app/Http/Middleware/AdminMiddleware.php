<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('admin')->check()) {
            $request->session()->put('url.intended', $request->fullUrl());
            return redirect()->route('admin.login');
        }

        $response = $next($request);

        // Prevent the browser from caching any admin pages
        return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma', 'no-cache')
                        ->header('Expires', 'Fri, 01 Jan 1990 00:00:00 GMT');
    }
}
