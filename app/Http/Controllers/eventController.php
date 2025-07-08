<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class eventController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;

        

        return view('jobseeker.event', compact('employeeData'));
    }
}
