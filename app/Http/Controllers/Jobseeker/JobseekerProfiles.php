<?php

namespace App\Http\Controllers\jobseeker;

use App\Http\Controllers\Controller;
use App\Models\educations;
use App\Models\EmployeeProfiles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

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

    public function addEducation(Request $request)
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;
        $request->validate([
            'lembaga' => 'required|string',
            'sertifikasi' => 'required|string',
            'pendidikan' => 'required|string',
            'keahlian' => 'required|string',
            'lulus' => 'required',
            'deskripsi' => 'required',
        ]);
        // dd($request->all());
        DB::beginTransaction();
        try {
            educations::create([
                'employee_id' => $employeeData->id,
                'institution' => $request->lembaga,
                'degrees' => $request->sertifikasi,
                'dicipline' => $request->keahlian,
                'end_date' => $request->lulus,
                'description' => $request->deskripsi

            ]);
            DB::commit();

            return redirect()->back()->with('success', 'Data pendidikan berhasil di tambahkan!  ');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('jobseeker.profiles',)
                ->with('error', 'Terjadi kesalahan saat menyimpan lamaran: ' . $e->getMessage());
        }
    }
}
