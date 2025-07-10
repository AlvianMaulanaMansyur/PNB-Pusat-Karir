<?php

namespace App\Http\Controllers\jobseeker;

use App\Http\Controllers\Controller;
use App\Models\educations;
use App\Models\employee_skill;
use App\Models\EmployeeProfiles;
use App\Models\expertness;
use App\Models\Skill;
use App\Models\work_experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

        $experience = work_experience::where('employee_id', $employeeData->id)->get();

        $skills = employee_skill::where('employee_id', $employeeData->id)->with('skill')->get();

        // dd($skills);

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
                'description' => $request->deskripsi,
            ]);
            DB::commit();

            return redirect()->back()->with('success', 'Data pendidikan berhasil di tambahkan!  ');
        } catch (Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('jobseeker.profiles')
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
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function educationDelete($id)
    {
        try {
            $education = educations::findOrFail($id);
            $education->delete();

            return redirect()->back()->with('success', 'Data pendidikan berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus data pendidikan: ' . $e->getMessage());
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
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menambahkan pengalaman kerja: ' . $e->getMessage());
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
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengalaman kerja: ' . $e->getMessage());
        }
    }

    public function deleteWorkExperience($id)
    {
        try {
            $workExperience = work_experience::findOrFail($id);
            $workExperience->delete();

            return redirect()->back()->with('success', 'Pengalaman kerja berhasil dihapus.');
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus pengalaman kerja: ' . $e->getMessage());
        }
    }

    // Contoh di JobseekerProfiles.php
    // Ambil skill employee
    public function fetchSkills()
    {
         $user = Auth::user();
        $employeeData = $user->dataEmployees;
        $skills = $employeeData
            ->employeeSkills()
            ->with('skill')
            ->get()
            ->map(function ($empSkill) {
                return [
                    'id' => $empSkill->skill->id,
                    'name' => $empSkill->skill->name,
                ];
            });
        return response()->json(['skills' => $skills]);
    }

    // Simpan skill dan relasi employee_skill
    public function addSkill(Request $request)
    {
        $user = Auth::user();
        $employee = $user->dataEmployees;
        $skills = $request->skills; // array dari front-end

        // Hitung jumlah skill yang sudah dimiliki employee
        $currentSkillCount = $employee->employeeSkills()->count();

        // Jika total skill akan melebihi 25, tolak
        if ($currentSkillCount + count($skills) > 25) {
            return response()->json([
                'success' => false,
                'message' => 'Batas maksimum keahlian adalah 25.',
            ]);
        }

        $savedSkills = [];

        foreach ($skills as $skillData) {
            if ($skillData['id']) {
                // Skill sudah ada, cek relasi employee_skill
                $exists = $employee->employeeSkills()->where('skill_id', $skillData['id'])->exists();
                if (!$exists) {
                    $employee->employeeSkills()->create(['skill_id' => $skillData['id']]);
                }
                $savedSkills[] = ['id' => $skillData['id'], 'name' => $skillData['name']];
            } else {
                // Skill baru, simpan dulu di tabel skills
                $skill = Skill::firstOrCreate(['name' => $skillData['name']]);

                // Cek lagi untuk berjaga-jaga (jika sudah dibuat sebelumnya)
                $exists = $employee->employeeSkills()->where('skill_id', $skill->id)->exists();
                if (!$exists) {
                    $employee->employeeSkills()->create(['skill_id' => $skill->id]);
                }

                $savedSkills[] = ['id' => $skill->id, 'name' => $skill->name];
            }
        }

        return response()->json([
            'success' => true,
            'savedSkills' => $savedSkills,
        ]);
    }

    // Hapus skill employee
    public function deleteSkill($skillId)
    {
         $user = Auth::user();
        $employee = $user->dataEmployees;
        

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee tidak ditemukan']);
        }

        try {
            $deleted = employee_skill::where('employee_id', $employee->id)->where('skill_id', $skillId)->delete();

            if ($deleted) {
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan']);
            }
        } catch (Throwable $th) {
            Log::error('Gagal menghapus skill: ' . $th->getMessage());
            return response()->json(['success' => false, 'message' => 'Gagal menghapus skill: ' . $th->getMessage()]);
        }
    }

    // FUNGSI SEARCH SKILL
    public function searchSkill(Request $request)
    {
        $keyword = $request->query('keyword');
        $skills = Skill::where('name', 'LIKE', "%{$keyword}%")
            ->limit(10)
            ->get();
        return response()->json(['skills' => $skills]);
    }
}
