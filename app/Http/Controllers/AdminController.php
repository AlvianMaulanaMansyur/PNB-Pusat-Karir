<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function AdminDashboard()
    {
        $users = User::whereIn('role', ['employer', 'employee'])->get();
        return view('admin.dashboard', compact('users'));
    }

    public function verifikasiAkun()
{
    $users = User::whereIn('role', ['employer', 'employee'])->get();

    return view('admin.verifikasiAkun', compact('users'));
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

    public function updateStatus(Request $request, $id)
        {
            $request->validate([
                'is_active' => 'required|boolean',
            ]);

            $user = User::findOrFail($id);
            $user->is_active = $request->is_active;
            $user->save();

            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        }
}
