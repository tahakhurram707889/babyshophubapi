<?php
// app/Http/Middleware\AdminMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        // ✅ FIXED: Check is_admin instead of role
        if (!Auth::user()->is_admin) {
            return redirect()->route('home')->with('error', 'Access denied. Admin only.');
        }

        return $next($request);
    }
}