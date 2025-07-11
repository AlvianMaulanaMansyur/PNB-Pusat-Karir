<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.adminLogin');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Login gagal. Username atau password salah.',
        ]);
    }

    public function destroy(Request $request)
{
    Auth::logout(); // Logout user dari sesi

    // Hancurkan session & token agar aman
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    // Redirect ke halaman login admin
    return redirect()->route('admin.adminLogin'); // pastikan route ini ada
}


    
}
