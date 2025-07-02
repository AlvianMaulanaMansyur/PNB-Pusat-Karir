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

        $application = JobApplication::with('job')->first();
        $application->job->nama_lowongan;

        if (!$employeeData) {
            abort(403, 'Data karyawan tidak ditemukan');
        }

        // data sertifikat
        $serticificate = portofoliopathimg::where('employee_id', $employeeData->id)->get();


        $jobApplied = JobApplication::with('job.employer')->where('employee_id', $employeeData->id)->where('job_id', $application->job->id)->get();
        // dd($jobApplied);
        return view('jobseeker.allJobsAppliedPage', compact('jobApplied', 'serticificate'));
    }
}
