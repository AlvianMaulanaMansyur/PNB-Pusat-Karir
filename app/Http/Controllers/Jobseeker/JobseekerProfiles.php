<?php

namespace App\Http\Controllers\jobseeker;

use App\Http\Controllers\Controller;
use App\Models\educations;
use App\Models\EmployeeProfiles;
use App\Models\expertness;
use App\Models\work_experience;
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

        // Ambil data education berdasarkan employee_id
        $educations = educations::where('employee_id', $employeeData->id)->get();

        $experience  = work_experience::where('employee_id', $employeeData->id)->get();

        $skills = expertness::where('employee_id', $employeeData->id)->get();

        // Kirimkan keduanya ke view
        return view('jobseeker.profiles', compact('employeeData', 'employeeProfile', 'educations', 'experience'));
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
            'pendidikan' => 'required',
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
                'sertifications' => $request->sertifikasi,
                'degrees' => $request->pendidikan,
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

    public function educationUpdate(Request $request, $id)
    {
        // dd($request->all());

        $validated = $request->validate([
            'institution' => 'required|string',
            'sertifications' => 'required|string',
            'degrees' => 'required',
            'dicipline' => 'required|string',
            'end_date' => 'required|date',
            'description' => 'required|string',
        ]);
        try {

            $educationlist = educations::findOrFail($id);

            $educationlist->institution = $validated['institution'];
            $educationlist->sertifications = $validated['sertifications'];
            $educationlist->degrees = $validated['degrees'];
            $educationlist->dicipline = $validated['dicipline'];
            $educationlist->end_date = $validated['end_date'];
            $educationlist->description = $validated['description'];

            $educationlist->save();

            return redirect()->back()->with('success', 'data berhasil di perbarui');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function educationDelete($id)
    {
        try {
            $education = educations::findOrFail($id);
            $education->delete();

            return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus data pendidikan: ' . $e->getMessage());
        }
    }

    public function addWorkingExperience(Request $request)
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'required|string|max:1000',
        ]);

        DB::beginTransaction();
        try {
            work_experience::create([
                'employee_id' => $employeeData->id,
                'company' => $request->company,
                'position' => $request->position,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'description' => $request->description,
                'is_current' => empty($request->end_date) ? 1 : 0,
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Pengalaman kerja berhasil ditambahkan!');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menambahkan pengalaman kerja: ' . $e->getMessage());
        }
    }

    public function updateWorkExperience(Request $request, $id)
    {
        $validated = $request->validate([
            'company' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'required|string|max:1000',
        ]);

        try {
            $workExperience = work_experience::findOrFail($id);

            $workExperience->company = $validated['company'];
            $workExperience->position = $validated['position'];
            $workExperience->start_date = $validated['start_date'];
            $workExperience->end_date = $validated['end_date'];
            $workExperience->description = $validated['description'];
            $workExperience->is_current = empty($validated['end_date']) ? 1 : 0;

            $workExperience->save();

            return redirect()->back()->with('success', 'Pengalaman kerja berhasil diperbarui!');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengalaman kerja: ' . $e->getMessage());
        }
    }

    public function deleteWorkExperience($id)
    {
        try {
            $workExperience = work_experience::findOrFail($id);
            $workExperience->delete();

            return redirect()->back()->with('success', 'Pengalaman kerja berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengalaman kerja: ' . $e->getMessage());
        }
    }

    public function fetchSkills()
    {
        $user = Auth::user();
        $skills = $user->dataEmployees->skills()->select('id', 'skill_name')->get();

        return response()->json(['skills' => $skills]);
    }

    public function addSkill(Request $request)
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $saved = [];

            foreach ($request->skills as $skill) {
                if (!empty($skill)) {
                    $saved[] = expertness::create([
                        'employee_id' => $employeeData->id,
                        'skill_name' => $skill,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'savedSkills' => $saved, // Sudah berupa koleksi model
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => 'Gagal menyimpan keahlian: ' . $e->getMessage()
            ]);
        }
    }

    public function deleteSkill($id)
    {
        try {
            $user = Auth::user();
            $employeeId = $user->dataEmployees->id;

            // Ambil skill berdasarkan ID dan pastikan milik employee yang sedang login
            $skill = expertness::where('id', $id)
                ->where('employee_id', $employeeId)
                ->first();

            if (!$skill) {
                return response()->json(['success' => false, 'error' => 'Skill tidak ditemukan atau bukan milik Anda.']);
            }

            $skill->delete();

            return response()->json(['success' => true]);
        } catch (Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }
}
