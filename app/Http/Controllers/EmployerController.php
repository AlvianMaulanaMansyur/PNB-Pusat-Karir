<?php

namespace App\Http\Controllers;

use App\Models\employers;
use App\Models\JobApplication;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class EmployerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $employerData = $user->dataEmployers; // relasi

        // dd($employerData);
        return view('employer.dashboard', compact('user'));
    }
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
                'nama_lowongan'     => 'required|string|max:255',
                'deskripsi'         => 'required|string',
                'posisi'            => 'required|string|max:255',
                'kualifikasi'       => 'required|string|max:255',
                'gaji'              => 'required|string|max:255',  // tetap string karena ada format Rp
                'benefit'           => 'required|string|',
                'responsibility'    => 'required|string|',
                'detailkualifikasi' => 'required|string|',
                'jenislowongan'     => 'required|string|max:100',
                'deadline'          => 'required|date',
                'poster'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Bersihkan nilai gaji: hapus semua selain angka
            $cleanedGaji = preg_replace('/\D/', '', $validated['gaji']);

            // Jika hasil bersih kosong, cek apakah input asli berupa '0' (atau 'Rp 0')
            if ($cleanedGaji === '') {
                $checkZero = trim(str_replace(['Rp', '.', ',', ' '], '', $validated['gaji']));
                if ($checkZero === '0') {
                    $cleanedGaji = '0';
                } else {
                    return redirect()->back()->with('error', 'Nilai gaji tidak valid.')->withInput();
                }
            }

            $validated['gaji'] = $cleanedGaji;

            Log::debug('Data input berhasil divalidasi.', ['validated_data' => $validated]);

            // Ambil employer_id dari user yang login
            $userId = Auth::id();

            if (!$userId) {
                Log::warning('Employer tidak ditemukan untuk user yang login.', ['user_id' => $userId]);
                return redirect()->back()->with('error', 'Employer tidak ditemukan untuk user ini.');
            }

            // Simpan poster jika ada
            if ($request->hasFile('poster')) {
                $posterPath = $request->file('poster')->store('posters', 'public');
                $validated['poster'] = $posterPath;
                Log::info('Poster berhasil diunggah.', ['poster_path' => $posterPath]);
            } else {
                Log::info('Tidak ada poster yang diunggah.');
            }

            // Tambahkan employer_id ke data
            $validated['user_id'] = $userId;

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
                'user_id'       => $userId,
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
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    public function manajemenlowongan()
    {
        $userId =  Auth::id();

        $job_listings = JobListing::where('user_id', $userId)->latest()->get();
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
            'nama_lowongan'     => 'required|string|max:255',
            'deskripsi'         => 'required|string',
            'posisi'            => 'required|string|max:255',
            'kualifikasi'       => 'required|string|max:255',
            'gaji'              => 'required|string|max:255',
            'benefit'           => 'required|string|',
            'responsibility'    => 'required|string|',
            'detailkualifikasi' => 'required|string|',
            'jenislowongan'     => 'required|string|max:100',
            'deadline'          => 'required|date',
            'poster'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Bersihkan nilai gaji: hapus semua selain angka
        $cleanedGaji = preg_replace('/\D/', '', $validated['gaji']);

        // Jika hasil bersih kosong, cek apakah input asli berupa '0' (atau 'Rp 0')
        if ($cleanedGaji === '') {
            $checkZero = trim(str_replace(['Rp', '.', ',', ' '], '', $validated['gaji']));
            if ($checkZero === '0') {
                $cleanedGaji = '0';
            } else {
                return redirect()->back()->withErrors(['gaji' => 'Nilai gaji tidak valid.'])->withInput();
            }
        }

        $validated['gaji'] = $cleanedGaji;

        // Jika nama lowongan berubah, update slug juga
        if ($lowongan->nama_lowongan !== $validated['nama_lowongan']) {
            $validated['slug'] = Str::slug($validated['nama_lowongan']);
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (JobListing::where('slug', $validated['slug'])->where('id', '!=', $lowongan->id)->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter++;
            }
        }

        // Update poster jika diunggah ulang
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
            'user_id' => Auth::check() ? Auth::id() : 'guest'
        ]);

        try {
            // Cari employer berdasarkan slug
            $employer = employers::where('slug', $slug)->firstOrFail();

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
                'alamat_perusahaan' => 'nullable|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'suffix' => 'nullable|string|max:50',
                'job_title' => 'nullable|string|max:255',
                'department' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
                'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            Log::debug('Data input berhasil divalidasi untuk update.', ['validated_data' => $validated]);

            // Hapus foto profil jika diminta
            if ($request->has('remove_photo') && $employer->photo_profile) {
                if (Storage::disk('public')->exists($employer->photo_profile)) {
                    Storage::disk('public')->delete($employer->photo_profile);
                }

                $validated['photo_profile'] = null;

                Log::info('Foto profil employer dihapus.', [
                    'employer_id' => $employer->id,
                    'deleted_photo' => $employer->photo_profile
                ]);
            }

            // Handle upload foto profil baru
            if ($request->hasFile('photo_profile')) {
                $path = $request->file('photo_profile')->store('employer_profiles', 'public');
                $validated['photo_profile'] = $path;

                if ($employer->photo_profile && Storage::disk('public')->exists($employer->photo_profile)) {
                    Storage::disk('public')->delete($employer->photo_profile);
                }

                Log::info('Foto profil employer diperbarui.', [
                    'employer_id' => $employer->id,
                    'new_photo_path' => $path
                ]);
            }

            // Simpan data lama sebelum update (opsional)
            $oldData = $employer->getOriginal();

            // Lakukan update
            $employer->update($validated);

            Log::info('Profil employer berhasil diupdate.', [
                'employer_id' => $employer->id,
                'old_data' => $oldData,
                'new_data' => $employer->fresh()->toArray()
            ]);

            return redirect()->route('employer.edit-profile', $employer->slug)
                ->with('success', 'Profil berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Upaya update gagal: Employer tidak ditemukan.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage()
            ]);
            return redirect()->back()->withErrors(['error' => 'Profil employer tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Gagal validasi input saat update profil employer.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
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

    public function showApplicants($slug)
    {
        $employer = employers::where('slug', $slug)->with('jobListings')->firstOrFail();

        // Cek jika employer punya job listing
        if (!$employer->jobListings) {
            return back()->with('error', 'Employer belum memiliki lowongan.');
        }

        $applications = JobApplication::with(['employee', 'job'])
            ->whereIn('job_id', $employer->jobListings->pluck('id'))
            ->orderBy('applied_at', 'desc')
            ->get()
            ->groupBy('job_id');

        return view('employer.pelamar-lowongan', compact('applications'));
    }

    public function updateStatus(Request $request, $slug)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,accepted,rejected',
            'interview_date' => 'nullable|date',
        ]);

        // Cari berdasarkan slug, bukan ID
        $application = JobApplication::where('slug', $slug)->firstOrFail();
        $application->status = $request->status;

        if ($request->status === 'interview') {
            $application->interview_date = $request->interview_date;
        } else {
            $application->interview_date = null;
        }

        $application->save();

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }

    public function showInterviewApplicants($slug)
    {
        $employer = employers::where('slug', $slug)->with('jobListings')->firstOrFail();

        if (!$employer->jobListings || $employer->jobListings->isEmpty()) {
            return back()->with('error', 'Employer belum memiliki lowongan.');
        }

        $applications = JobApplication::with(['employee', 'job'])
            ->whereIn('job_id', $employer->jobListings->pluck('id'))
            ->whereIn('status', ['interview'])
            ->orderBy('applied_at', 'desc')
            ->get()
            ->groupBy('job_id');

        return view('employer.kelola-interview', compact('applications'));
    }

    public function updateInterviewDate(Request $request, $slug)
    {
        // Log: Memulai proses update tanggal interview
        Log::info('Memulai proses updateInterviewDate.', [
            'slug_aplikasi' => $slug,
            'user_id' => Auth::check() ? Auth::id() : 'guest' // Melacak user yang melakukan update
        ]);

        try {
            // Validasi input
            $request->validate([
                'interview_date' => 'nullable|date',
            ]);

            // Log: Data input validasi
            Log::debug('Data input untuk update interview date berhasil divalidasi.', [
                'interview_date_input' => $request->interview_date
            ]);

            // Cari aplikasi berdasarkan slug
            $application = JobApplication::where('slug', $slug)->firstOrFail();

            // Log: Aplikasi ditemukan
            Log::info('Aplikasi lamaran ditemukan untuk update tanggal interview.', [
                'application_id' => $application->id,
                'current_status' => $application->status,
                'current_interview_date' => $application->interview_date
            ]);

            // Simpan data lama sebelum diupdate
            $oldInterviewDate = $application->interview_date;
            $oldStatus = $application->status;

            // Update tanggal interview
            $application->interview_date = $request->interview_date;

            // Update status otomatis berdasarkan tanggal interview
            $application->status = $request->interview_date ? 'interview' : 'reviewed';

            $application->save();

            // Log: Tanggal interview dan status berhasil diperbarui
            Log::info('Tanggal interview dan status aplikasi berhasil diperbarui.', [
                'application_id' => $application->id,
                'old_interview_date' => $oldInterviewDate,
                'new_interview_date' => $application->interview_date,
                'old_status' => $oldStatus,
                'new_status' => $application->status,
                'updated_by_user_id' => Auth::check() ? Auth::id() : 'guest'
            ]);

            return back()->with('success', 'Tanggal interview berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log: Aplikasi tidak ditemukan
            Log::warning('Upaya update tanggal interview gagal: Aplikasi dengan slug "' . $slug . '" tidak ditemukan.', [
                'slug_aplikasi' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage()
            ]);
            return back()->withErrors(['error' => 'Aplikasi lamaran tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log: Gagal validasi input
            Log::error('Gagal validasi input saat update tanggal interview.', [
                'slug_aplikasi' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log: Terjadi kesalahan tak terduga
            Log::critical('Terjadi kesalahan tak terduga saat update tanggal interview.', [
                'slug_aplikasi' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }

    public function filterstatus(Request $request)
    {
        $statusFilter = $request->query('status');

        $applications = \App\Models\JobApplication::with('job', 'employee')
            ->when($statusFilter, function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->orderBy('applied_at', 'desc')
            ->get()
            ->groupBy('job_id'); // Penting untuk tampilan di view

        return view('employer.pelamar-lowongan', compact('applications'));
    }
}
