<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\employees;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class JobSeekerController extends Controller
{
    public function index()
    {
        // mengambil data karyawan yang sedang login
        $user = Auth::user();
        $employeeData = $user->dataEmployees; // relasi

        // mengambil data lowongan kerja dengan relasi employer
        $jobs = JobListing::with('employer')->latest()->paginate(5);

        // dd($employerData);
        return view('jobseeker.index', compact('employeeData', 'jobs'));
    }

    public function detailLowongan($id)
    {
        $job = JobListing::with('employer')->findOrFail($id);
        return view('jobseeker.detail-lowongan', compact('job'));
    }

    public function applyJob($id)
    {
        $job = JobListing::with('employer')->findOrFail($id);
        $user = Auth::user();
        $employeeData = $user->dataEmployees;
        return view('jobseeker.apply', compact('job', 'employeeData'));
    }

    public function storeStepOne(Request $request, $id)
    {
        $validate = $request->validate([
            'suratLamaran' => 'required|string',
            'cv' => 'required|file|mimes:pdf|max:2048',
            'certificates.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // simpan file ke folder sementara storage/temp

        $cv = $request->file('cv');
        $cvPath = $cv->store('temp');
        $cvOriginalName = $cv->getClientOriginalName();
        $sertifikatPath = [];
        $sertifikatNames = [];

        if ($request->hasFile('certificates')) {
            foreach ($request->file('certificates') as $sertifikat) {
                $sertifikatPath[] = $sertifikat->store('temp');
                $sertifikatNames[] = $sertifikat->getClientOriginalName();
            }
        }

        session([
            'suratLamaran' => $validate['suratLamaran'],
            'cv' => $cvOriginalName,
            'cv_path' => $cvPath,
            'sertifikat' => $sertifikatNames,
            'sertifikat_path' => $sertifikatPath,
            'applied_job_id' => $id, // simpan job id di session
            'step_1_completed' => true, // tandai step 1 sudah selesai
        ]);

        return redirect()->route('file-preview', ['id' => $id]);
    }

    public function showPreview($id)
    {
        if (!session('step_1_completed', false)) {
            return redirect()
                ->route('job-apply', ['id' => $id])
                ->with('error', 'Anda harus menyelesaikan langkah pertama terlebih dahulu.');
        }

        if (session('applied_job_id') != $id) {
            return redirect()
                ->route('job-apply', ['id' => $id])
                ->with('error', 'Silahkan pilih lowongan yang sesuai.');
        }
        // dd(session()->all());
        $suratLamaran = session('suratLamaran');
        $cv = session('cv');
        $cvPath = session('cv_path');
        $sertifikat = session('sertifikat', []);

        $job = JobListing::with('employer')->findOrFail($id);
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        session(['step_2_completed' => true]); // tandai step 2 sudah selesai
        return view('jobseeker.preview-file', compact('suratLamaran', 'cv', 'sertifikat', 'job', 'employeeData'));
    }

    public function storeStepTwo($id)
    {
        if (!session('step_2_completed', false)) {
            return redirect()
                ->route('file-preview', ['id' => $id])
                ->with('error', 'Selesaikan semua langkah secara bertahap');
        }
        if (session('applied_job_id') != $id) {
            return redirect()
                ->route('job-apply', ['id' => $id])
                ->with('error', 'Silahkan pilih lowongan yang sesuai.');
        }
        // mengambil data user
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        $suratLamaran = session('suratLamaran');
        $cv = session('cv');
        $cvPath = session('cv_path');

        // mengambil data sertifikat dari session dan di pindahkan ke storage/cv
        $sertifikat = session('sertifikat', []);
        $sertifikatPaths = session('sertifikat_path', []);
        $finalSertifikatPaths = [];

        foreach ($sertifikatPaths as $index => $path) {
            $newPath = 'sertifikat/' . basename($path);
            Storage::move($path, $newPath);
            $finalSertifikatPaths[] = $newPath;
        }
        // dd($finalSertifikatPaths);

        // memindahkan file dari storage/temp ke storage/cv
        $cvNewPath = 'cv/' . basename($cvPath);
        Storage::disk('public')->move($cvPath, $cvNewPath);

        $job = JobListing::with('employer')->findOrFail($id);

        DB::beginTransaction();
        try {
            $user=JobApplication::create([
                'job_id' => $id,
                'slug' => str('lamaran-' . substr(Auth::id(), 0, 8)),
                'employee_id' => $employeeData->id,
                'applied_at' => now(),
                'status' => 'pending',
                'cover_letter' => $suratLamaran,
                'cv_file' => $cvNewPath,
                'employer_notes' => null,
                'interview_status' => 'not_scheduled',
                'interview_date' => null,
            ]);


            DB::commit();
            return redirect()->route('job-apply.success', ['id' => $id]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()
                ->route('file-preview', ['id' => $id])
                ->with('error', 'Anda sudah melamar untuk lowongan ini');
        }
    }

    public function successApply($id)
    {
        if (!session('step_2_completed', false)) {
            return redirect()
                ->route('job-apply', ['id' => $id])
                ->with('error', 'Selesaikan semua langkah secara bertahap');
        }

        if (session('applied_job_id') != $id) {
            return redirect()
                ->route('job-apply', ['id' => $id])
                ->with('error', 'Silahkan pilih lowongan yang sesuai.');
        }

        // Hapus session setelah sukses apply
        session()->forget(['suratLamaran', 'cv', 'cv_path', 'sertifikat', 'sertifikat_path', 'applied_job_id', 'step_1_completed', 'step_2_completed']);

        return view('jobseeker.jobapplied');
    }
}
