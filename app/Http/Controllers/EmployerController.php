<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function index()
    {
        $employers = Employer::all();
        return view('admin.index', compact('employers')); // Ubah view ke admin.index
    }

    public function edit($id)
    {
        $employer = Employer::findOrFail($id);
        return view('admin.edit', compact('employer')); // Ubah view ke admin.edit
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:TERVERIFIKASI,DITOLAK,MENUNGGU',
        ]);

        $employer = Employer::findOrFail($id);
        $employer->status = $request->status;
        $employer->save();

        return redirect()->route('employers.index')->with('success', 'Status updated.');
    }
}