<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\employers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function Employer(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function EmployerDataStore(Request $request): RedirectResponse
    {
        $request->validate([
            // 'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'nameCompany' => ['required', 'string', 'max:255'],
            'business_registration_number' => ['required', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class, ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'same:password',],
            'phone' => ['required','numeric' , ],

        ]);


        $user = employers::create([
            'company_name' => $request->nameCompany,
            'business_registration_number' => $request->noPendaftaranBisnis,

            'industry'=> $request->industry,
            'company_website' => $request->website,
            'organization_type' => $request->organisasi,
            'staff_strength' => $request->staff,
            'country' => $request->negara,
            'city' => $request->kota,
            'company_profile' => $request->profil_perusahaan,
            'salutation' => $request->sapaan,
            'first_name' => $request->nama_depan,
            'last_name' => $request->nama_belakang,
            'suffix' => $request->akhiran,
            'job_title' => $request->pekerjaan,
            'department' => $request->departemen,
            'email' => $request->email,
            'phone' => $request->telepon,
            'password' => Hash::make($request->password),
        ]);

        dd($user);
        dd($request->all());

        event(new Registered($user));

        return redirect(route('login', absolute: false));
    }
}
