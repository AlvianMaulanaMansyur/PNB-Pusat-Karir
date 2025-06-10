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
            'sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        // simpan ke folder sementara storage/temp
        $cvPath = $request->file('cv')->store('temp');
        $sertifikatPath = [];

        if ($request->hasFile('sertifikat')) {
            foreach ($request->file('sertifikat') as $sertifikat) {
                $sertifikatPath[] = $sertifikat->store('temp');
            }
        }

        session([
            'suratLamaran' => $validate['suratLamaran'],
            'cv' => $cvPath,
            'sertifikat' => $sertifikatPath,
        ]);


        // dd(storage_path('app/' . $cvPath));
        // dd(route('preview'));
        return redirect()->route('file-preview', ['id' => $id]);
    }

    public function showPreview()
    {
        // dd(session()->all());
        $suratLamaran = session('suratLamaran');
        $cv = session('cv');
        $sertifikat = session('sertifikat', []);



        return view('jobseeker.preview-file', compact('suratLamaran', 'cv', 'sertifikat'));
    }
}
