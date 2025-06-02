<?php

namespace App\Http\Controllers;

use App\Models\employers;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EmployerController extends Controller
{
    public function tambahlowongan()
    {
        return view('employer.tambah-lowongan');
    }
    public function storelowongan(Request $request)
    {
        Log::info('Memulai proses storelowongan.', ['user_id' => Auth::id()]);

        try {
            // Validasi input
            $validated = $request->validate([
                'nama_lowongan' => 'required|string|max:255',
                'deskripsi'     => 'required|string',
                'posisi'        => 'required|string|max:255',
                'kualifikasi'   => 'required|string|max:255',
                'jenislowongan' => 'required|string|max:100',
                'deadline'      => 'required|date',
                'poster'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            Log::debug('Data input berhasil divalidasi.', ['validated_data' => $validated]);

            // Ambil employer_id dari user yang login
            $userId = Auth::id();
            $employer = employers::where('user_id', $userId)->first();

            if (!$employer) {
                Log::warning('Employer tidak ditemukan untuk user yang login.', ['user_id' => $userId]);
                return redirect()->back()->withErrors(['error' => 'Employer tidak ditemukan untuk user ini.']);
            }

            Log::info('Employer ditemukan.', ['employer_id' => $employer->id, 'user_id' => $userId]);

            // Simpan poster jika ada
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
                $validated['poster'] = $posterPath;
                Log::info('Poster berhasil diunggah.', ['poster_path' => $posterPath]);
            } else {
                Log::info('Tidak ada poster yang diunggah.');
            }

            // Tambahkan employer_id ke data
            $validated['employer_id'] = $employer->id;

            // Generate slug unik dari nama_lowongan
            $slug = Str::slug($validated['nama_lowongan']);
            $originalSlug = $slug;
            $counter = 1;

            while (JobListing::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }

            $validated['slug'] = $slug;

            Log::debug('Data akhir sebelum disimpan ke database.', ['final_data' => $validated]);

            // Simpan ke database
            JobListing::create($validated);

            Log::info('Lowongan berhasil disimpan ke database.', [
                'nama_lowongan' => $validated['nama_lowongan'],
                'employer_id'   => $employer->id,
                'slug'          => $slug,
            ]);

            return redirect()->route('employer.manajemen-lowongan')->with('success', 'Lowongan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Gagal validasi input saat menyimpan lowongan.', [
                'user_id' => Auth::id(),
                'errors'  => $e->errors(),
                'input'   => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::critical('Terjadi kesalahan tak terduga saat menyimpan lowongan.', [
                'user_id' => Auth::id(),
                'error'   => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }
    public function manajemenlowongan()
    {
        $employerId = employers::where('user_id', Auth::id())->value('id');

        $job_listings = JobListing::where('employer_id', $employerId)->latest()->get();
        return view('employer.manage-lowongan', ['joblisting' => $job_listings]);
    }
    public function editlowongan($slug)
    {
        $lowongan = JobListing::where('slug', $slug)->firstOrFail();

        return view('employer.edit-lowongan', compact('lowongan'));
    }
    public function updatelowongan(Request $request, $slug)
    {
        $lowongan = JobListing::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'nama_lowongan' => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'posisi'        => 'required|string|max:255',
            'kualifikasi'   => 'required|string|max:255',
            'jenislowongan' => 'required|string|max:100',
            'deadline'      => 'required|date',
            'poster'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Jika nama lowongan berubah, update slug juga
        if ($lowongan->nama_lowongan !== $validated['nama_lowongan']) {
            $validated['slug'] = Str::slug($validated['nama_lowongan']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (JobListing::where('slug', $validated['slug'])->where('id', '!=', $lowongan->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('posters', 'public');
            $validated['poster'] = $posterPath;
        }

        $lowongan->update($validated);

        return redirect()->route('employer.manajemen-lowongan')->with('success', 'Lowongan berhasil diperbarui.');
    }

    public function destroyLowongan($slug)
    {
        $lowongan = JobListing::where('slug', $slug)->firstOrFail();

        // Hapus poster jika ada
        if ($lowongan->poster && Storage::exists($lowongan->poster)) {
            Storage::delete($lowongan->poster);
        }

        // Hapus data lowongan
        $lowongan->delete();

        return redirect()->route('employer.manajemen-lowongan')
            ->with('success', 'Lowongan berhasil dihapus.');
    }
    public function editprofile($slug)
    {
        $employer = employers::where('slug', $slug)->firstOrFail();
        $user = $employer->user;

        return view('employer.edit-profile', compact('employer', 'user'));
    }


    public function update(Request $request, $slug)
    {
        // Log: Memulai proses update profil employer
        Log::info('Memulai proses update profil employer.', [
            'slug' => $slug,
            'user_id' => Auth::check() ? Auth::id() : 'guest' // Melacak user jika login
        ]);

        try {
            // Cari employer berdasarkan slug
            $employer = employers::where('slug', $slug)->firstOrFail();

            // Log: Employer ditemukan
            Log::info('Employer ditemukan untuk update.', [
                'employer_id' => $employer->id,
                'current_company_name' => $employer->company_name
            ]);

            // Validasi input
            $validated = $request->validate([
                'company_name' => 'required|string|max:255',
                'business_registration_number' => 'required|string|max:255',
                'industry' => 'required|string|max:255',
                'company_website' => 'nullable|url|max:255',
                'organization_type' => 'nullable|string|max:255',
                'staff_strength' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:255',
                'city' => 'nullable|string|max:255',
                'company_profile' => 'nullable|string',
                'salutation' => 'nullable|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'job_title' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            // Log: Data input yang berhasil divalidasi
            Log::debug('Data input berhasil divalidasi untuk update.', ['validated_data' => $validated]);

            // Dapatkan data lama sebelum diupdate (opsional, tapi sangat berguna untuk audit trail)
            $oldData = $employer->getOriginal();
            
            // Lakukan update
            $employer->update($validated);

            // Log: Data baru setelah diupdate
            Log::info('Profil employer berhasil diupdate.', [
                'employer_id' => $employer->id,
                'old_data' => $oldData, // Data sebelum update
                'new_data' => $employer->fresh()->toArray() // Data setelah update
            ]);

            return redirect()->route('employer.edit-profile', $employer->slug)->with('success', 'Profil berhasil diperbarui!');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log: Employer tidak ditemukan
            Log::warning('Upaya update gagal: Employer dengan slug "' . $slug . '" tidak ditemukan.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors(['error' => 'Profil employer tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log: Gagal validasi input
            Log::error('Gagal validasi input saat update profil employer.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log: Terjadi kesalahan tak terduga
            Log::critical('Terjadi kesalahan tak terduga saat update profil employer.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }
}
