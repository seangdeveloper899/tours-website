<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'Please login to access the admin panel.');
        }

        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Unauthorized access. Admin privileges required.');
        }

        return $next($request);
    }
}
