<?php

namespace App\Http\Controllers;

use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManajemenEventController extends Controller
{
    public function manajemenevent()
    {
        $joblisting = JobListing::with('user')->latest()->get();
        return view('admin.manajemenevent', compact('joblisting'));
    }

    /**
     * Menampilkan form tambah event.
     */
    public function create()
    {
        return view('admin.tambah_event'); // Ganti sesuai view form tambah jika ada
    }

    // Anda bisa tambahkan fungsi store, edit, update, destroy jika diperlukan
    public function detailEvent($id)
    {
        $job = JobListing::with('user')->findOrFail($id);
        return view('admin.detail_event', compact('job'));
    }

    public function editEvent($id)
{
    $job = JobListing::with('user')->findOrFail($id);
    return view('admin.edit_event', compact('job'));
}

public function updateEvent(Request $request, $id)
{
    $request->validate([
        'posisi' => 'required|string|max:255',
        'deskripsi' => 'required|string',
        'poster' => 'nullable|image|max:2048',
    ]);

    $job = JobListing::findOrFail($id);
    $job->posisi = $request->posisi;
    $job->deskripsi = $request->deskripsi;

    if ($request->hasFile('poster')) {
        // Hapus poster lama jika ada
        if ($job->poster) {
            Storage::delete('public/posters/' . $job->poster);
        }

        $file = $request->file('poster');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/posters', $filename);
        $job->poster = $filename;
    }

    $job->save();

    return redirect()->route('admin.event.detail', $job->id)->with('success', 'Event berhasil diperbarui.');
}
}
