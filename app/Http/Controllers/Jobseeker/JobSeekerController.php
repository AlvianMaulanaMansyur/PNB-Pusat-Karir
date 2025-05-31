<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employerData = $user->dataEmployees; // relasi

        // dd($employerData);
        return view('jobseeker.index', compact( 'employerData'));
    }
}
