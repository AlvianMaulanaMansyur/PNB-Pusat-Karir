<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ManajemenLowonganController extends Controller
{
    // Tampilkan daftar semua lowongan
    public function index(Request $request)
{
    $query = JobListing::with('user');

    // Jika ada input pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_lowongan', 'like', '%' . $request->search . '%');
    }

    $joblisting = $query->latest()->get();

    return view('admin.manajemen_lowongan', compact('joblisting'));
}

    // Tampilkan form tambah lowongan
    public function create()
    {
        return view('admin.tambah_lowongan');
    }

    // Simpan data lowongan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_lowongan'     => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'jenislowongan'    => 'required|string',
            'posisi'            => 'required|string',
            'responsibility'    => 'required|string',
            'kualifikasi'       => 'required|string',
            'detailkualifikasi' => 'required|string',
            'gaji'              => 'required|numeric',
            'benefit'           => 'required|string',
            'deadline'          => 'required|date|after_or_equal:today',
            'poster'            => 'nullable|image|max:2048',
        ]);

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('poster', 'public');
        }

        JobListing::create([
            'user_id'           => Auth::id(), // atau ganti sesuai kebutuhan
            'nama_lowongan'     => $request->nama_lowongan,
            'slug'              => Str::slug($request->nama_lowongan) . '-' . uniqid(),
            'deskripsi'         => $request->deskripsi,
            'jenislowongan'    => $request->jenislowongan,
            'posisi'            => $request->posisi,
            'responsibility'    => $request->responsibility,
            'kualifikasi'       => $request->kualifikasi,
            'detailkualifikasi' => $request->detailkualifikasi,
            'gaji'              => $request->gaji,
            'benefit'           => $request->benefit,
            'deadline'          => $request->deadline,
            'poster'            => $posterPath ? basename($posterPath) : null,
        ]);

        return redirect()->route('admin.manajemen-lowongan')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    // Tampilkan detail lowongan berdasarkan slug
    public function detail($slug)
    {
        $lowongan = JobListing::with('user')->where('slug', $slug)->firstOrFail();
        return view('admin.detail_lowongan', compact('lowongan'));
    }

    public function edit($slug)
{
    $lowongan = JobListing::where('slug', $slug)->firstOrFail();
    return view('admin.edit_lowongan', compact('lowongan'));
}

public function update(Request $request, $slug)
{
    $lowongan = JobListing::where('slug', $slug)->firstOrFail();

    // Validasi data (tidak semuanya wajib diubah)
    $validated = $request->validate([
        'nama_lowongan'     => 'required|string|max:255',
        'deskripsi'         => 'required|string',
        'jenislowongan'    => 'required|string',
        'posisi'            => 'required|string',
        'responsibility'    => 'required|string',
        'kualifikasi'       => 'required|string',
        'detailkualifikasi' => 'required|string',
        'gaji'              => 'required|numeric',
        'benefit'           => 'required|string',
        'deadline'          => 'required|date|after_or_equal:today',
        'poster'            => 'nullable|image|max:2048',
    ]);

    // Update data
    $lowongan->nama_lowongan     = $validated['nama_lowongan'];
    $lowongan->slug              = Str::slug($validated['nama_lowongan']) . '-' . substr(md5(now()), 0, 8);
    $lowongan->deskripsi         = $validated['deskripsi'];
    $lowongan->jenislowongan    = $validated['jenislowongan'];
    $lowongan->posisi            = $validated['posisi'];
    $lowongan->responsibility    = $validated['responsibility'];
    $lowongan->kualifikasi       = $validated['kualifikasi'];
    $lowongan->detailkualifikasi = $validated['detailkualifikasi'];
    $lowongan->gaji              = $validated['gaji'];
    $lowongan->benefit           = $validated['benefit'];
    $lowongan->deadline          = $validated['deadline'];

    // Handle poster (jika diunggah baru)
    if ($request->hasFile('poster')) {
        if ($lowongan->poster && Storage::exists('public/poster/' . $lowongan->poster)) {
            Storage::delete('public/poster/' . $lowongan->poster);
        }

        $posterName = time() . '_' . $request->file('poster')->getClientOriginalName();
        $request->file('poster')->storeAs('public/poster', $posterName);
        $lowongan->poster = $posterName;
    }

    $lowongan->save();

    return redirect()->route('admin.manajemen-lowongan')->with('success', 'Lowongan berhasil diperbarui.');
}
public function manajemenLowongan(Request $request)
{
    $query = JobListing::with('user');

    // Jika ada input pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where('nama_lowongan', 'like', '%' . $request->search . '%');
    }

    $joblisting = $query->latest()->get();

    return view('admin.manajemen-lowongan', compact('joblisting'));
}
}
