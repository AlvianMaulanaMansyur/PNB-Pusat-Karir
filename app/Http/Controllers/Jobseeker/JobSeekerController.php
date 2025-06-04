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
        $jobs = JobListing::with('employer')->latest()->get();

        // dd($employerData);
        return view('jobseeker.index', compact( 'employeeData', 'jobs'));
    }

    public function detailLowongan($id)
    {
        $job = JobListing::with('employer')->findOrFail($id);
        return view('jobseeker.detail-lowongan', compact('job'));
    }
}
