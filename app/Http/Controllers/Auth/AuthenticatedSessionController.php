<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // proses Auth::attempt di LoginRequest

        $request->session()->regenerate();

        $user = Auth::user();

        // 🚫 Cek apakah akun aktif
        if ($user->is_active !== 1) {
            Auth::logout(); // keluarin user dari session
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda belum aktif. Silahkan tunggu hingga admin mengubah status akun Anda.',
            ]);
        }

        // ✅ Jika aktif, redirect sesuai role
        switch ($user->role) {
            case 'employer':
                return redirect()->route('employer.dashboard');
            case 'employee':
                return redirect()->route('employee.lowongan');
            case 'admin':
                return redirect()->route('admin.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->with([
                    'error' => 'Role tidak dikenali atau tidak memiliki akses ke dashboard.',
                ]);
        }
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
