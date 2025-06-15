<?php

namespace App\Http\Controllers\jobseeker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobseekerProfiles extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employeeData = $user->dataEmployees;
        return view('jobseeker.profiles', compact('employeeData'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo_profile' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();
        $employee = $user->dataEmployees;

        // Jangan hapus foto default
        if ($employee->photo_profile !== 'image/user.png' && Storage::disk('public')->exists($employee->photo_profile)) {
            Storage::disk('public')->delete($employee->photo_profile);
        }

        // Upload foto baru
        $path = $request->file('photo_profile')->store('Jobseeker-profile', 'public');

        $employee->update([
            'photo_profile' => $path,
        ]);

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}
