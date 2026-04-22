<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();
        
        // Load role if not loaded
        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        if ($user->hasRole($roles)) {
            return $next($request);
        }

        // If user is a teacher and trying to access dashboard, allow (since it's common)
        // But for specific management routes, we restrict.
        
        return redirect()->route('dashboard')->with('error', 'Anda tidak mempunyai kebenaran untuk mengakses halaman tersebut.');
    }
}
