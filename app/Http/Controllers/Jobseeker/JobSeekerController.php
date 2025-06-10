<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'sertifikat' => $sertifikatNames,
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
        $sertifikat = session('sertifikat', []);

        $job = JobListing::with('employer')->findOrFail($id);
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        return view('jobseeker.preview-file', compact('suratLamaran', 'cv', 'sertifikat', 'job', 'employeeData'));
    }
}
