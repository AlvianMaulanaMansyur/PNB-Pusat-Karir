<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            return match (Auth::user()->role) {
                'employer' => redirect()->route('employer.dashboard')->with('error', 'Silahkan login sebagai pencari kerja untuk mengakses halaman.'),
                'employee' => redirect()->route('employee.landing-page')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                'admin' => redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.'),
                default => redirect()->route('login')->with('error', 'Role tidak dikenali.'),
            };
        }

        return $next($request);
    }
}
