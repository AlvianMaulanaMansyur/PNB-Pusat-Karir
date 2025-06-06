<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TambahLowonganController extends Controller
{
    public function create()
    {
        return view('admin.tambah_lowongan');
    }
}