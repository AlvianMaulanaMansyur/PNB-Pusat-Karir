<?php

namespace App\Http\Controllers;

use App\Models\employees;
use App\Models\EmployerNotification;
use App\Models\employers;
use App\Models\JobApplication;
use App\Models\JobListing;
use App\Models\Skill;
use App\Notifications\ApplicationStatusUpdated;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
                'nama_lowongan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'posisi' => 'required|string|max:255',
                'kualifikasi' => 'required|string|max:255',
                'gaji' => 'required|string|max:255', // tetap string karena ada format Rp
                'benefit' => 'required|string|',
                'responsibility' => 'required|string|',
                'detailkualifikasi' => 'required|string|',
                'jenislowongan' => 'required|string|max:100',
                'deadline' => 'required|date',
                'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
                'user_id' => $userId,
                'slug' => $slug,
            ]);

            return redirect()->route('employer.manajemen-lowongan')->with('success', 'Lowongan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Gagal validasi input saat menyimpan lowongan.', [
                'user_id' => Auth::id(),
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::critical('Terjadi kesalahan tak terduga saat menyimpan lowongan.', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi nanti.');
        }
    }

    public function manajemenlowongan()
{
    $userId = Auth::id();

    $lowongan_aktif = JobListing::where('user_id', $userId)
        ->where('deadline', '>=', now())
        ->orderBy('deadline', 'asc')
        ->get();

    $lowongan_kedaluwarsa = JobListing::where('user_id', $userId)
        ->where('deadline', '<', now())
        ->orderBy('deadline', 'desc')
        ->get();

    return view('employer.manage-lowongan', [
        'lowongan_aktif' => $lowongan_aktif,
        'lowongan_kedaluwarsa' => $lowongan_kedaluwarsa,
    ]);
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
            'deskripsi' => 'required|string',
            'posisi' => 'required|string|max:255',
            'kualifikasi' => 'required|string|max:255',
            'gaji' => 'required|string|max:255',
            'benefit' => 'required|string|',
            'responsibility' => 'required|string|',
            'detailkualifikasi' => 'required|string|',
            'jenislowongan' => 'required|string|max:100',
            'deadline' => 'required|date',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Bersihkan nilai gaji: hapus semua selain angka
        $cleanedGaji = preg_replace('/\D/', '', $validated['gaji']);

        // Jika hasil bersih kosong, cek apakah input asli berupa '0' (atau 'Rp 0')
        if ($cleanedGaji === '') {
            $checkZero = trim(str_replace(['Rp', '.', ',', ' '], '', $validated['gaji']));
            if ($checkZero === '0') {
                $cleanedGaji = '0';
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['gaji' => 'Nilai gaji tidak valid.'])
                    ->withInput();
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
        if ($lowongan->poster && Storage::disk('public')->exists($lowongan->poster)) {
            Storage::disk('public')->delete($lowongan->poster);
        }

        // Hapus data lowongan
        $lowongan->delete();

        return redirect()->route('employer.manajemen-lowongan')->with('success', 'Lowongan berhasil dihapus.');
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
            'user_id' => Auth::check() ? Auth::id() : 'guest',
        ]);

        try {
            // Cari employer berdasarkan slug
            $employer = employers::where('slug', $slug)->firstOrFail();

            Log::info('Employer ditemukan untuk update.', [
                'employer_id' => $employer->id,
                'current_company_name' => $employer->company_name,
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
                    'deleted_photo' => $employer->photo_profile,
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
                    'new_photo_path' => $path,
                ]);
            }

            // Simpan data lama sebelum update (opsional)
            $oldData = $employer->getOriginal();

            // Lakukan update
            $employer->update($validated);

            Log::info('Profil employer berhasil diupdate.', [
                'employer_id' => $employer->id,
                'old_data' => $oldData,
                'new_data' => $employer->fresh()->toArray(),
            ]);

            return redirect()->route('employer.edit-profile', $employer->slug)->with('success', 'Profil berhasil diperbarui!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::warning('Upaya update gagal: Employer tidak ditemukan.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage(),
            ]);
            return redirect()
                ->back()
                ->withErrors(['error' => 'Profil employer tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Gagal validasi input saat update profil employer.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'errors' => $e->errors(),
                'input' => $request->all(),
            ]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::critical('Terjadi kesalahan tak terduga saat update profil employer.', [
                'slug' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()
                ->back()
                ->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }

    public function showApplicants($slug, Request $request)
    {
        $employer = employers::where('slug', $slug)->with('jobListings')->firstOrFail();

        if (!$employer->jobListings || $employer->jobListings->isEmpty()) {
            return back()->with('error', 'Employer belum memiliki lowongan.');
        }

        $applications = $this->filterstatus($request, $employer->user_id);
        $withoutFilter = $this->getAllApplications($employer->user_id);

        $summary = [
            'total' => $withoutFilter->flatten()->count(),
            'interview' => $withoutFilter->flatten()->where('status', 'interview')->count(),
            'accepted' => $withoutFilter->flatten()->where('status', 'accepted')->count(),
            'rejected' => $withoutFilter->flatten()->where('status', 'rejected')->count(),
        ];

        return view('employer.pelamar-lowongan', compact('applications', 'summary'));
    }


    public function filterstatus(Request $request, $employerId)
    {
        $statusFilter = $request->query('status');
        $searchKeyword = $request->query('search');

        $applications = \App\Models\JobApplication::with('job', 'employee')
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('user_id', $employerId);
            })
            ->when($statusFilter, function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->when($searchKeyword, function ($query) use ($searchKeyword) {
                $query->whereHas('job', function ($q) use ($searchKeyword) {
                    $q->where('nama_lowongan', 'like', '%' . $searchKeyword . '%')
                        ->orWhere('posisi', 'like', '%' . $searchKeyword . '%');
                });
            })
            ->orderBy('applied_at', 'desc')
            ->get()
            ->groupBy('job_id');

        return $applications;
    }


    public function getAllApplications($employerId)
    {
        return JobApplication::with('job', 'employee')
            ->whereHas('job', function ($query) use ($employerId) {
                $query->where('user_id', $employerId);
            })
            ->orderBy('applied_at', 'desc')
            ->get()
            ->groupBy('job_id');
    }

    public function updateStatus(Request $request, $slug)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,interview,accepted,rejected',
            'interview_date' => 'required_if:status,interview|nullable|date|after:now',
        ], [
            'interview_date.required_if' => 'Tanggal interview wajib diisi jika status adalah interview.',
            'interview_date.after' => 'Tanggal interview harus di masa depan.',
        ]);

        $application = JobApplication::where('slug', $slug)->firstOrFail();
        $application->status = $request->status;

        if ($request->status === 'interview') {
            $application->interview_date = $request->interview_date;
            $application->interview_status = 'scheduled';
        } else {
            $application->interview_date = null;
            $application->interview_status = null;
        }

        $application->save();

        // Kirim notifikasi
        $employee = $application->employee;
        $job = $application->job;
        $employee->notify(new ApplicationStatusUpdated($job, $application->status, $application->interview_date));

        return back()->with('success', 'Status pelamar berhasil diperbarui.');
    }


    public function showInterviewApplicants($slug)
{
    $employer = Employers::where('slug', $slug)->with('jobListings')->firstOrFail();

    if (!$employer->jobListings || $employer->jobListings->isEmpty()) {
        return back()->with('error', 'Employer belum memiliki lowongan.');
    }

    $applications = JobApplication::with(['employee', 'job'])
        ->whereIn('job_id', $employer->jobListings->pluck('id'))
        ->where('status', 'interview')
        ->get()
        ->sortBy(function ($app) {
            $date = \Carbon\Carbon::parse($app->interview_date);
            return $date->isPast() ? $date->addYears(1000) : $date;
        })
        ->groupBy('job_id');

    return view('employer.kelola-interview', compact('applications'));
}


    public function updateInterviewDate(Request $request, $slug)
    {
        // Log: Memulai proses update tanggal interview
        Log::info('Memulai proses updateInterviewDate.', [
            'slug_aplikasi' => $slug,
            'user_id' => Auth::check() ? Auth::id() : 'guest', // Melacak user yang melakukan update
        ]);

        try {
            // Validasi input
            $request->validate([
                'interview_date' => 'nullable|date',
            ]);

            // Log: Data input validasi
            Log::debug('Data input untuk update interview date berhasil divalidasi.', [
                'interview_date_input' => $request->interview_date,
            ]);

            // Cari aplikasi berdasarkan slug
            $application = JobApplication::where('slug', $slug)->firstOrFail();

            // Log: Aplikasi ditemukan
            Log::info('Aplikasi lamaran ditemukan untuk update tanggal interview.', [
                'application_id' => $application->id,
                'current_status' => $application->status,
                'current_interview_date' => $application->interview_date,
            ]);

            // Simpan data lama sebelum diupdate
            $oldInterviewDate = $application->interview_date;
            $oldStatus = $application->status;

            // Update tanggal interview
            $application->interview_date = $request->interview_date;

            // Update status otomatis berdasarkan tanggal interview
            $application->status = $request->interview_date ? 'interview' : 'reviewed';

            $application->save();

            // if ($application->interview_date) {
            //     $job = $application->job;
            //     $employer = $job->employer;
            //     $employee = $application->employee;

            //     // Pastikan semuanya tidak null (hindari error jika data belum lengkap)
            //     if ($employer && $employee) {
            //         $formattedDate = Carbon::parse($application->interview_date)->format('d M Y H:i');

            //         $message = 'Interview dengan pelamar ' . $employee->name .
            //             ' untuk lowongan "' . $job->nama_lowongan .
            //             '" dijadwalkan pada ' . $formattedDate . '.';

            //         EmployerNotification::create([
            //             'employer_id' => $employer->id,
            //             'title' => 'Jadwal Interview Baru',
            //             'message' => $message,
            //             'is_read' => false,
            //         ]);
            //     }
            // }

            // Log: Tanggal interview dan status berhasil diperbarui
            Log::info('Tanggal interview dan status aplikasi berhasil diperbarui.', [
                'application_id' => $application->id,
                'old_interview_date' => $oldInterviewDate,
                'new_interview_date' => $application->interview_date,
                'old_status' => $oldStatus,
                'new_status' => $application->status,
                'updated_by_user_id' => Auth::check() ? Auth::id() : 'guest',
            ]);

            return back()->with('success', 'Tanggal interview berhasil diperbarui.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Log: Aplikasi tidak ditemukan
            Log::warning('Upaya update tanggal interview gagal: Aplikasi dengan slug "' . $slug . '" tidak ditemukan.', [
                'slug_aplikasi' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'error' => $e->getMessage(),
            ]);
            return back()->withErrors(['error' => 'Aplikasi lamaran tidak ditemukan.']);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log: Gagal validasi input
            Log::error('Gagal validasi input saat update tanggal interview.', [
                'slug_aplikasi' => $slug,
                'user_id' => Auth::check() ? Auth::id() : 'guest',
                'errors' => $e->errors(),
                'input' => $request->all(),
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
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }


    public function notifications()
    {
        $employer = Auth::user()->employer;

        // Ambil semua notifikasi milik employer
        $notifications = EmployerNotification::where('employer_id', $employer->id)
            ->orderBy('created_at', 'desc')
            ->get(); // <-- TIDAK lagi pakai paginate()

        // Ambil notifikasi terbaru yang belum dibaca (hanya satu)
        $latestUnread = EmployerNotification::where('employer_id', $employer->id)
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->first();

        // Tandai semua sebagai telah dibaca (setelah ambil latestUnread)
        EmployerNotification::where('employer_id', $employer->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('employer.notifikasi', compact('notifications', 'latestUnread'));
    }

    public function destroyNotification($id)
    {
        $notif = EmployerNotification::findOrFail($id);
        $notif->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    public function caripelamar(Request $request)
    {
        $skills = Skill::all();
        $selectedSkills = $request->input('skills', []);

        if (!empty($selectedSkills)) {
            $placeholders = implode(',', array_fill(0, count($selectedSkills), '?'));

            $query = "
            SELECT 
                e.*, 
                GROUP_CONCAT(s.name SEPARATOR ', ') AS skills, 
                u.email as email,
                COUNT(DISTINCT s.id) AS matching_count
            FROM employees e
            JOIN employee_skill es ON e.id = es.employee_id
            JOIN skills s ON s.id = es.skill_id
            JOIN users u ON u.id = e.user_id
            WHERE s.id IN ($placeholders)
            GROUP BY e.id
            ORDER BY matching_count DESC
        ";

            $candidates = DB::select($query, $selectedSkills);
        } else {
            $candidates = DB::select("
            SELECT 
                e.*, 
                GROUP_CONCAT(s.name SEPARATOR ', ') AS skills, 
                u.email as email
            FROM employees e
            JOIN employee_skill es ON e.id = es.employee_id
            JOIN skills s ON s.id = es.skill_id
            JOIN users u ON u.id = e.user_id
            GROUP BY e.id
        ");
        }

        $employer = Auth::user()->employer;

        $jobListings = JobListing::where('user_id', $employer->user_id)->get();


        return view('employer.cari_pelamar', compact('skills', 'candidates', 'selectedSkills', 'jobListings'));
    }

    public function detailKandidat($slug, $id)
    {
        // Query kandidat utama
        $candidate = DB::selectOne("
        SELECT 
            e.*, 
            u.email,
            ANY_VALUE(ep.summary) AS summary,
            ANY_VALUE(ep.linkedin) AS linkedin,
            ANY_VALUE(ep.website) AS website,
            GROUP_CONCAT(s.name SEPARATOR ', ') AS skills
        FROM employees e
        JOIN users u ON u.id = e.user_id
        LEFT JOIN employee_profiles ep ON ep.employee_id = e.id
        LEFT JOIN employee_skill es ON e.id = es.employee_id
        LEFT JOIN skills s ON s.id = es.skill_id
        WHERE e.id = ?
        GROUP BY e.id
    ", [$id]);

        if (!$candidate) {
            abort(404, 'Kandidat tidak ditemukan');
        }

        // Ambil data pendidikan
        $educations = \App\Models\educations::where('employee_id', $id)->get();

        // Ambil data lowongan milik employer yang sedang login
        $employer = Auth::user()->employer;
        $jobListings = DB::table('job_listings')
            ->where('user_id', $employer->user_id)
            ->get();

        // Kirim ke view
        return view('employer.detail_kandidat', compact('candidate', 'jobListings', 'educations'));
    }

    public function detailPelamar($slug, $jobId, $userId)
    {
        $employer = Employers::where('slug', $slug)
            ->with('jobListings')
            ->firstOrFail();

        // Pastikan job_id termasuk milik employer ini
        $jobIds = $employer->jobListings->pluck('id')->toArray();
        if (!in_array($jobId, $jobIds)) {
            abort(403, 'Lowongan tidak valid atau tidak dimiliki employer ini.');
        }

        // Ambil lamaran sesuai job_id dan employee_id (MUAT skills)
        $application = JobApplication::with(['employee.educations', 'employee.skills', 'job'])
            ->where('job_id', $jobId)
            ->where('employee_id', $userId)
            ->firstOrFail();

        $jobListings = $employer->jobListings;

        return view('employer.detail_pelamar', compact('application', 'jobListings'));
    }
}
