<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // If the admin is not authenticated, bounce them back to the login screen
        if (!session()->has('admin_authenticated')) {
            return redirect()->route('admin.login')->with('error', 'Please log in to access the administrator panel.');
        }

        return $next($request);
    }
}
