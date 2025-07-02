<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use App\Models\JobListing;
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

        $jobApplied = JobApplication::with('job.employer')->where('employee_id', $employeeData->id)->get();
        // dd($jobApplied);
        return view('jobseeker.detailLowongan', compact('jobApplied'));
    }
}
