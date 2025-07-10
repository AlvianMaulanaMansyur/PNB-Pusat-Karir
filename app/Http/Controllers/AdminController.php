<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Event;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /* =======================================================
    |  DASHBOARD & VERIFIKASI AKUN
    ======================================================== */

    // Menampilkan dashboard admin
    public function AdminDashboard()
    {
    $users = User::whereIn('role', ['employer', 'employee'])->get();

    $jobCount = JobListing::count();
    $eventCount = Event::where('is_active', '1')->count();

    return view('admin.dashboard', compact('users', 'jobCount', 'eventCount'));
    }

    // Menampilkan halaman verifikasi semua akun
    public function verifikasiAkun()
    {
        $users = User::whereIn('role', ['employer', 'employee'])->get();
        return view('admin.verifikasiAkun', compact('users'));
    }

    // Verifikasi akun employer
    public function verifikasiEmployer()
    {
        $users = User::where('role', 'employer')->get();
        return view('admin.Verifikasi_employer', compact('users'));
    }

    // Verifikasi akun employee
    public function verifikasiEmployee()
    {
        $users = User::where('role', 'employee')->get();
        return view('admin.Verifikasi_employee', compact('users'));
    }

    /* =======================================================
    |  STATUS & MANAJEMEN AKUN
    ======================================================== */

    // Menampilkan form edit data employer
    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        return view('admin.edit', compact('employer'));
    }

    // Update status employer (TERVERIFIKASI/DITOLAK)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:TERVERIFIKASI,DITOLAK,MENUNGGU',
        ]);

        $employer = Employer::findOrFail($id);
        $employer->status = $request->status;
        $employer->save();

        return redirect()->route('employers.index')->with('success', 'Status updated.');
    }

    // Update status aktif/nonaktif user
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->is_active = $request->is_active;
        $user->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    // Hapus akun user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

       

        $user->delete();
        return redirect()->back()->with('success', 'Akun berhasil dihapus.');
    }

    /* =======================================================
    |  PEMBUATAN AKUN EMPLOYER OLEH ADMIN
    ======================================================== */

    // Form tambah akun employer
    public function create()
    {
        return view('admin.TambahAkun');
    }

    // Proses simpan akun employer
    public function store(Request $request)
    {
        $request->validate([
            'nameCompany' => 'required|string|max:255',
            'business_registration_number' => 'nullable|string|max:255',
            'industry' => 'required|string',
            'website' => 'required|url',
            'organisasi' => 'required|string',
            'staff' => 'required|string',
            'negara' => 'required|string',
            'kota' => 'required|string',
            'profil_perusahaan' => 'required|string',
            'sapaan' => 'required|string',
            'nama_depan' => 'required|string',
            'nama_belakang' => 'required|string',
            'akhiran' => 'nullable|string',
            'pekerjaan' => 'required|string',
            'departemen' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'alamat_perusahaan' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employer',
            'is_active' => 1,
            'nameCompany' => $request->nameCompany,
            'business_registration_number' => $request->business_registration_number,
            'industry' => $request->industry,
            'website' => $request->website,
            'organisasi' => $request->organisasi,
            'staff' => $request->staff,
            'negara' => $request->negara,
            'kota' => $request->kota,
            'profil_perusahaan' => $request->profil_perusahaan,
            'sapaan' => $request->sapaan,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'akhiran' => $request->akhiran,
            'pekerjaan' => $request->pekerjaan,
            'departemen' => $request->departemen,
            'phone' => $request->phone,
            'alamat_perusahaan' => $request->alamat_perusahaan,
        ]);

        return redirect()->route('admin.employer.create')->with('success', 'Akun employer berhasil dibuat.');
    }

}
