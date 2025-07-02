<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\employees;
use App\Models\employers;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     */
    // menampilkan halaman register jobseeker
    public function JobSeeker(): View
    {
        return view('auth.employee-register');
    }


    // menampilkan halaman register employer
    public function Employer(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    // menyimpan data jobseeker ke database
    public function EmployerDataStore(Request $request): RedirectResponse
    {
        // dd($request->all());
        $username = session('registered_username');
        $email = session('registered_email');
        $request->validate([
            'nameCompany' => ['required', 'string', 'max:255'],
            'alamat_perusahaan' => ['required', 'string', 'max:255'],
            'password' => ['required', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'same:password',],
            'phone' => ['required', 'numeric',],
            'negara' => ['required', 'string',],
            'kota' => ['required', 'string',],
            'business_registration_number' => ['required', 'numeric', ],
            'industry' => ['required', 'string',],
            'website' => ['required', 'string', 'url'],
            'organisasi' => ['required', 'string',],
            'staff' => ['required', 'string',],
            'profil_perusahaan' => ['required', 'string',],
            'sapaan' => ['required', 'string',],
            'nama_depan' => ['required', 'string',],
            'nama_belakang' => ['required', 'string',],
            'akhiran' => ['nullable', 'string',],
            'pekerjaan' => ['required', 'string',],
            'departemen' => ['required', 'string',],

        ]);

        DB::beginTransaction();

        try {

            // dd($request->all());
            $user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($request->password),
                'role' => 'employer',
                'is_active' => false,
            ]);
            $employer = employers::create([
                'user_id' => $user->id,
                'slug' => str('employer-'.substr($user->id, 0, 8)),
                'photo_profile' => 'employer_profiles/default_employer.png',
                'alamat_perusahaan' => $request->alamat_perusahaan,
                'company_name' => $request->nameCompany,
                'business_registration_number' => $request->business_registration_number,
                'industry' => $request->industry,
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
                'phone' => $request->phone,
            ]);
            DB::commit();

            // event(new Registered($user));
            return redirect(route('login', absolute: false));
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }


    // menyimpan data jobseeker ke database
    public function JobSeekerDataStore(Request $request)
    {
        // dd($request->all());
        // mengambil data dari session
        $username = session('registered_username');
        $email = session('registered_email');
        $request->validate([
            // 'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            // 'username' => ['required', 'string', 'max:255', 'unique:' . User::class,],
            'password' => ['required', 'confirmed', 'confirmed', Rules\Password::defaults()],
            'password_confirmation' => ['required', 'string', 'same:password',],
            'phone' => ['required', 'numeric',],
            'negara' => ['required', 'string',],
            'kota' => ['required', 'string',],
            'education' => ['required', 'string'],
            'sapaan' => ['required', 'string',],
            'nama_depan' => ['required', 'string',],
            'nama_belakang' => ['required', 'string',],
            'akhiran' => ['nullable', 'string',],
            'bidang' => ['required', 'string',],
            'previous_industry' => ['required', 'string',],
            'jenis_pekerjaan' => ['required', 'string',],
            'jabatan' => ['required', 'string',],
            'status' => ['required', 'string',],
            'tahun_pengalaman' => ['required', 'string',],
            'ketersediaan_bekerja' => ['required', 'string',],
            // 'akhiran' => ['nullable', 'string'],

        ]);
        DB::beginTransaction();

        try {
            $user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => Hash::make($request->password),
                'role' => 'Employee',
                'is_active' => false,
            ]);
            $jobseeker = employees::create([
                'user_id' => $user->id,
                'salutation' => $request->sapaan,
                'first_name' => $request->nama_depan,
                'last_name' => $request->nama_belakang,
                'suffix' => $request->akhiran,
                'phone' => $request->phone,
                'photo_profile' => '/images/profile.png',
                'country' => $request->negara,
                'city' => $request->kota,
                'highest_education' => $request->education,
                'main_skill' => $request->bidang,
                'current_or_previous_industry' => $request->previous_industry,
                'current_or_previous_job_type' => $request->jenis_pekerjaan,
                'current_or_previous_position' => $request->jabatan,
                'employment_status' => $request->status,
                'years_of_experience' => $request->tahun_pengalaman,
                'availability' => $request->ketersediaan_bekerja,
            ]);

            // mengkomit data ke database
            DB::commit();
            // event(new Registered($user));
            return redirect(route('login', absolute: false));

            // merollback jika terjadi error
        } catch (\Throwable $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

    public function messages(): array
    {
        return [
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan simbol.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ];
    }
}
