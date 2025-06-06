<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManajemenLowonganController extends Controller
{
    public function index()
    {
        // Dummy data
        $lowongans = [
            ['posisi' => 'FRONT–END DEVELOPER', 'perusahaan' => 'PT. NGODING JAYA'],
            ['posisi' => 'BACK–END DEVELOPER', 'perusahaan' => 'PT. STECU STECU'],
            ['posisi' => 'UI/UX DESIGNER', 'perusahaan' => 'PT. AJIK PANTAU'],
            ['posisi' => 'DIGITAL MARKETING', 'perusahaan' => 'PT. ASAMLAM UP'],
            ['posisi' => 'DATA ANALYST', 'perusahaan' => 'PT. BEGADANG BERFAEDAH'],
        ];

        return view('admin.manajemen_lowongan', compact('lowongans'));
    }
}