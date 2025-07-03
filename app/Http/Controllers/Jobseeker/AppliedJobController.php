<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\portofoliopathimg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppliedJobController extends Controller
{
    public function index()
{
    $user = Auth::user();
    $employeeData = $user->dataEmployees;

    if (!$employeeData) {
        abort(403, 'Data karyawan tidak ditemukan');
    }

    // Ambil semua lamaran dan relasi job
    $jobApplied = JobApplication::with('job.employer')->where('employee_id', $employeeData->id)->get();

    // Ambil semua sertifikat yang berkaitan dengan employee_id dan job yang dilamar
    $serticificate = portofoliopathimg::where('employee_id', $employeeData->id)
        ->whereIn('job_id', $jobApplied->pluck('job_id'))
        ->get();

    return view('jobseeker.allJobsAppliedPage', compact('jobApplied', 'serticificate'));
}

}
