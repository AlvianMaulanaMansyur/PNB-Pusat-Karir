<?php

namespace App\Http\Controllers\jobseeker;

use App\Http\Controllers\Controller;
use App\Models\EmployeeProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobseekerProfiles extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        // Pastikan employee ada
        if (!$employeeData) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        // Ambil data profile berdasarkan employee_id
        $employeeProfile = EmployeeProfiles::where('employee_id', $employeeData->id)->first();

        // Kirimkan keduanya ke view
        return view('jobseeker.profiles', compact('employeeData', 'employeeProfile'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $employee = $user->dataEmployees;

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'suffix' => 'nullable|string',
            'no_telp' => 'nullable|string|max:20',
            'photo_profile' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo_profile')) {
            $photo = $request->file('photo_profile')->store('profile', 'public');
            $employee->photo_profile = $photo;
        }

        $employee->first_name = $validated['first_name'];
        $employee->last_name = $validated['last_name'] ?? null;
        $employee->suffix = $validated['suffix'] ?? null;
        $employee->phone = $validated['no_telp'] ?? null;
        $employee->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updateSummary(Request $request)
    {
        $validated = $request->validate([
            'summary' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $employee = $user->dataEmployees;

        // Tangani jika employee tidak ditemukan
        if (!$employee) {
            return redirect()->back()->with('error', 'Data karyawan tidak ditemukan.');
        }

        $profile = EmployeeProfiles::firstOrNew([
            'employee_id' => $employee->id,
        ]);

        $profile->summary = $validated['summary'] ?: null;
        $profile->save();

        return redirect()->back()->with('success', 'Ringkasan berhasil diperbarui.');
    }
}
