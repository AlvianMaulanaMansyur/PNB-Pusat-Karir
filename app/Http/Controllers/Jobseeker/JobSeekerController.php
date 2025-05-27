<?php

namespace App\Http\Controllers\Jobseeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JobSeekerController extends Controller
{
    public function index()
    {
        return view('layouts.jobseeker');
    }
}
