<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;



class AdminController extends Controller
{
    public function AdminDashboard()
    {
        $users = User::whereIn('role', ['employer', 'employee'])->get();
        // dd($users);
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
        public function storeLowongan(Request $request)
    {
        // Log: Memulai proses penyimpanan lowongan
        Log::info('Memulai proses penyimpanan lowongan baru.', [
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('User-Agent')
        ]);

        try {
            // Log: Memulai validasi data
            Log::debug('Memulai validasi data request untuk lowongan.');
            $validated = $request->validate([
                'nama_lowongan' => 'required|string|max:255',
                'deskripsi' => 'required|string',
                'jenislowongan' => 'required|string',
                'posisi' => 'required|string',
                'responsibility' => 'required|string',
                'kualifikasi' => 'required|string',
                'detailkualifikasi' => 'required|string',
                'gaji' => 'required|numeric',
                'benefit' => 'required|string',
                'deadline' => 'required|date|after_or_equal:today',
                'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            // Log: Validasi data berhasil
            Log::info('Data request berhasil divalidasi.', ['validated_data_keys' => array_keys($validated)]);

            $userId = Auth::id();

            if (!$userId) {
                // Log: Peringatan jika user tidak terautentikasi
                Log::warning('Upaya penyimpanan lowongan oleh user tidak terautentikasi.', ['user_id' => $userId, 'ip_address' => $request->ip()]);
                return redirect()->back()->withErrors(['error' => 'Anda tidak terautentikasi.'])->withInput();
            }
            // Log: User terautentikasi
            Log::info('User terautentikasi ditemukan.', ['user_id' => $userId]);

            if ($request->hasFile('poster')) {
                // Log: Mengunggah file poster
                Log::debug('File poster terdeteksi, memulai proses penyimpanan.');
                $posterPath = $request->file('poster')->store('posters', 'public');
                $validated['poster'] = $posterPath;
                // Log: File poster berhasil diunggah
                Log::info('File poster berhasil diunggah.', ['poster_path' => $posterPath]);
            } else {
                // Log: Tidak ada file poster yang diunggah
                Log::debug('Tidak ada file poster yang diunggah.');
            }

            $validated['user_id'] = $userId;
            // Log: User ID ditambahkan ke data yang divalidasi
             Log::debug('User ID ' . $userId . ' ditambahkan ke data lowongan.');

            // Slug unik
            $slug = Str::slug($validated['nama_lowongan']);
            $originalSlug = $slug;
            $counter = 1;

            // Log: Memulai proses pembuatan slug unik
            Log::debug('Memulai pembuatan slug unik untuk lowongan.', ['original_slug' => $originalSlug]);
            while (JobListing::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
                // Log: Slug sudah ada, mencoba slug baru
                Log::debug('Slug "' . $slug . '" sudah ada, mencoba slug berikutnya: "' . $originalSlug . '-' . $counter . '"');
            }

            $validated['slug'] = $slug;
            // Log: Slug akhir berhasil dibuat
            Log::info('Slug unik berhasil dibuat untuk lowongan.', ['final_slug' => $slug]);

            // Log: Memulai proses pembuatan entri JobListing di database
            Log::info('Mencoba membuat entri JobListing di database.', ['data_to_create' => $validated]);
            JobListing::create($validated);
            // Log: Lowongan berhasil disimpan
            Log::info('Lowongan baru berhasil disimpan di database.', ['nama_lowongan' => $validated['nama_lowongan'], 'lowongan_slug' => $slug]);

            return redirect()->route('manajemen-lowongan.index')->with('success', 'Lowongan berhasil ditambahkan.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log: Menangani kesalahan validasi
            Log::warning('Kesalahan validasi saat menyimpan lowongan.', ['errors' => $e->errors(), 'input_data' => $request->all()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Log: Menangani kesalahan umum
            Log::error('Terjadi kesalahan tak terduga saat menyimpan lowongan.', [
                'error_message' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(), // Hanya sertakan trace jika benar-benar diperlukan untuk debugging mendalam
                'request_data' => $request->all() // Log data request yang menyebabkan error
            ]);
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.']);
        }
    }
   public function manajemenlowongan()
{
    // Ambil semua job listing beserta data user yang membuatnya
    $job_listings = JobListing::with('user')->latest()->get();

    return view('admin.manajemen_lowongan', ['joblisting' => $job_listings]);
}

    public function editlowongan($slug)
    {
        $lowongan = JobListing::where('slug', $slug)->firstOrFail();

        return view('admin.edit_lowongan', compact('lowongan'));
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
            'benefit'           => 'required|string|max:255',
            'responsibility'    => 'required|string|max:255',
            'detailkualifikasi' => 'required|string|max:255',
            'jenislowongan'     => 'required|string|max:100',
            'deadline'          => 'required|date',
            'poster'            => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $request->merge([
            'gaji' => str_replace(['Rp', '.', ' '], '', $request->gaji),
        ]);

        // Bersihkan nilai gaji
        $cleanedGaji = preg_replace('/\D/', '', $validated['gaji']);
        if (!$cleanedGaji) {
            return redirect()->back()->withErrors(['gaji' => 'Nilai gaji tidak valid.'])->withInput();
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

        return redirect()->route('admin.manajemen-lowongan')->with('success', 'Lowongan berhasil diperbarui.');
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

        return redirect()->route('admin.manajemen-lowongan')
            ->with('success', 'Lowongan berhasil dihapus.');
    }

    // app/Http/Controllers/AdminController.php

public function verifikasiEmployer()
{
    $users = User::where('role', 'employer')->get();
    return view('admin.Verifikasi_employer', compact('users'));
}

public function verifikasiEmployee()
{
    $users = User::where('role', 'employee')->get();
    return view('admin.Verifikasi_employee', compact('users'));
}

public function destroy($id)
{
    $user = User::findOrFail($id);

    // Cegah admin menghapus dirinya sendiri
    if (auth()->id() === $user->id) {
        return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
    }

    $user->delete();

    return redirect()->back()->with('success', 'Akun berhasil dihapus.');
}

public function create()
    {
        return view('admin.TambahAkun'); // arahkan ke blade form yang Anda tunjukkan
    }

    public function store(Request $request)
    {
        $request->validate([
            'nameCompany' => 'required|string|max:255',
            'business_registration_number' => 'nullable|string|max:255',
            'industry' => 'required|string',
            'website' => 'required|url',
            'organisasi' => 'required|string',
            'staff' => 'required|string',
            'negara' => 'required|string',
            'kota' => 'required|string',
            'profil_perusahaan' => 'required|string',
            'sapaan' => 'required|string',
            'nama_depan' => 'required|string',
            'nama_belakang' => 'required|string',
            'akhiran' => 'nullable|string',
            'pekerjaan' => 'required|string',
            'departemen' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'alamat_perusahaan' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employer',
            'is_active' => 1,

            // Informasi employer tambahan
            'nameCompany' => $request->nameCompany,
            'business_registration_number' => $request->business_registration_number,
            'industry' => $request->industry,
            'website' => $request->website,
            'organisasi' => $request->organisasi,
            'staff' => $request->staff,
            'negara' => $request->negara,
            'kota' => $request->kota,
            'profil_perusahaan' => $request->profil_perusahaan,
            'sapaan' => $request->sapaan,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'akhiran' => $request->akhiran,
            'pekerjaan' => $request->pekerjaan,
            'departemen' => $request->departemen,
            'phone' => $request->phone,
            'alamat_perusahaan' => $request->alamat_perusahaan,
        ]);

        return redirect()->route('admin.employer.create')->with('success', 'Akun employer berhasil dibuat.');
    }

}


