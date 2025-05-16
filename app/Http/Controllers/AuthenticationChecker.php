<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthenticationChecker extends Controller
{
    public function CheckerShowForm(Request $request)
    {
        $role = $request->query('role');

        if (!in_array($role, ['employee', 'employer']))
        {
            abort('403', 'Illegal Authorization!');
        }

        return view('auth.auth-checker', compact('role'));
    }

    public function CheckerFormStore(Request $request)
    {
        $validated = $request->validate([
        'role' => 'required|in:employer,employee',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|unique:users,username'
    ]);

    $redirectRoute = $validated['role'] === 'employer' ? 'register-employer' : 'jobseeker-register';

    return redirect()->route($redirectRoute)->withInput();
    }
}
