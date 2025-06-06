<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use App\Models\CvOtherExperience;
use App\Models\CvPersonalInformation;
use App\Models\CvWorkExperience;
use Carbon\Carbon;
use PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Str;

class CvGeneratorController extends Controller
{
    public function index(Request $request)
    {

        // $request->session()->flush();

        Log::info('----- Memulai index (CvController) - Menampilkan daftar CV pengguna -----');

        $user = auth()->user();

        $employeeId = $user->employee->id; // Ambil ID user yang sedang login
        $userCvs = [];

        if ($employeeId) {
            // Mengambil daftar CV yang sudah dibuat oleh user ini
            $userCvs = Cv::where('employee_id', $employeeId)->orderBy('updated_at', 'desc')->get();
        } else {
            // Jika tidak ada user yang login, Anda bisa memutuskan apakah akan menampilkan CV yang disimpan di sesi
            // Untuk kesederhanaan, kita anggap hanya user login yang bisa melihat daftar CV.
            Log::info('Tidak ada user login. Daftar CV mungkin kosong.');
        }

        // Batas maksimal CV (contoh: 2)
        $maxCvLimit = 2; // Sesuaikan dengan logika paket berlangganan Anda jika ada
        $canCreateNewCv = $employeeId && ($userCvs->count() < $maxCvLimit); // Hanya bisa buat jika login dan belum mencapai limit

        // Mendapatkan pesan dari session
        $sessionMessage = $request->session()->get('status');
        $sessionError = $request->session()->get('error');
        $sessionWarning = $request->session()->get('warning');

        return view('cv-generator.dashboard', [ // View ini akan menampilkan daftar CV
            'userCvs' => $userCvs,
            'canCreateNewCv' => $canCreateNewCv,
            'maxCvLimit' => $maxCvLimit,
            'sessionMessage' => $sessionMessage,
            'sessionError' => $sessionError,
            'sessionWarning' => $sessionWarning,
        ]);
    }

    public function updateCvTitle(Request $request, $slug)
    {
        try {
            // Validasi input
            $request->validate([
                'title' => 'nullable|string|max:255'
            ]);

            // Dapatkan CV berdasarkan slug
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $employeeId = auth()->user()->employee->id;

            // Validasi kepemilikan
            if ($cv->employee_id !== $employeeId) {
                return response()->json([
                    'error' => 'Anda tidak memiliki izin untuk mengupdate CV ini'
                ], 403);
            }

            // Update data
            $cv->title = $request->input('title');
            $cv->save();

            return response()->json([
                'success' => true,
                'message' => 'Judul CV berhasil diperbarui'
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'CV tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Gagal update judul CV: ' . $e->getMessage());
            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    // CvController.php
    public function createNewCV(Request $request)
    {
        // Validasi input 'title'
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $user = auth()->user();
        
        // Validasi user sudah login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Cek apakah user memiliki data employee
        if (!$user->employee) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'Data employee tidak ditemukan!');
        }
        
        $employeeId = $user->employee->id; // Ambil ID user yang sedang login

        // Cek limit CV
        $currentCvCount = Cv::where('employee_id', $employeeId)->count();
        $maxCvLimit = 2;

        if ($currentCvCount >= $maxCvLimit) {
            return redirect()->route('cv.dashboard')
                ->with('error', "Anda sudah mencapai batas maksimal $maxCvLimit CV");
        }

        // Buat CV baru dengan employee_id dan title dari request
        $newCV = Cv::create([
            'employee_id' => $user->employee->id,
            'title' => $request->title, // Gunakan title dari hasil validasi
            'slug' => Str::uuid(),
            'status' => 'draft'
        ]);

        return redirect()->route('cv.personal-info', ['slug' => $newCV->slug]);
    }

    public function showPersonalInformationForm(Request $request, $slug)
    {
        $employeeId = auth()->user()->employee->id;

        if (!$employeeId) {
            return redirect()->route('login');
        }

        if ($slug) {
            $cv = Cv::with('personalInformation')
                ->where('slug', $slug)
                ->first();

            if (!$cv || $cv->employee_id !== $employeeId) {
                return redirect()->route('cv.dashboard')
                    ->with('error', 'CV tidak ditemukan atau tidak memiliki akses');
            }

            $sessionKey = "cv_data.{$slug}.informasi_pribadi";

            // Opsional: Log session sebelum manipulasi (jika ingin melihat keadaan awal)
            Log::info("Session sebelum manipulasi untuk slug: {$slug}", [
                'session_informasi_pribadi_sebelum' => $request->session()->get($sessionKey),
                'session_foto_profil_sebelum' => $request->session()->get("cv_data.{$slug}.informasi_pribadi.foto_profil")
            ]);

            // Jika Anda mengaktifkan ini untuk mengosongkan session, maka log di atas akan menampilkan null/kosong
            // $request->session()->forget($sessionKey);

            if (!$request->session()->has($sessionKey) && $cv->personalInformation) {
                $request->session()->put(
                    $sessionKey,
                    $cv->personalInformation->toArray()
                );
                Log::info("Data informasi pribadi dari DB disisipkan ke session untuk slug: {$slug}");
            }

            $sessionPhotoKey = "cv_data.{$slug}.informasi_pribadi.foto_profil";
            if ($cv->personalInformation && $cv->personalInformation->profile_photo) {
                if (!$request->session()->has($sessionPhotoKey)) {
                    $request->session()->put(
                        $sessionPhotoKey,
                        $cv->personalInformation->profile_photo
                    );
                    Log::info("Data foto profil dari DB disisipkan ke session untuk slug: {$slug}");
                }
            }

            // Log session setelah manipulasi
            Log::info("Session setelah manipulasi untuk slug: {$slug}", [
                'session_informasi_pribadi_setelah' => $request->session()->get($sessionKey),
                'session_foto_profil_setelah' => $request->session()->get($sessionPhotoKey)
            ]);

            // Untuk melihat semua isi session (hati-hati jika session sangat besar)
            // Log::debug('Semua isi session:', $request->session()->all());

            return view('cv-generator.informasi-pribadi', [
                'activeStep' => 'informasi-pribadi',
                'currentCv' => $cv,
                'personalInfo' => $cv->personalInformation
            ]);
        }

        return redirect()->route('cv.create-new');
    }

    public function savePersonalInformation(Request $request, $slug)
    {
        Log::info('----- Memulai savePersonalInformation (Controller) -----');
        // Log the incoming request data for debugging
        Log::info('Request data:', $request->all());

        try {
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $existingData = CvPersonalInformation::where('cv_id', $cv->id)->first();

            // Validasi data yang langsung dari $request (JSON body)
            $validator = Validator::make($request->all(), [
                'nama' => 'nullable|string|max:255',
                'no_handphone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'linkedin' => 'nullable|url|max:255', // Validasi URL untuk linkedin
                'portofolio' => 'nullable|url|max:255', // Validasi URL untuk portofolio
                'alamat' => 'nullable|string|max:500',
                'deskripsi' => 'nullable|string|max:1000',
                'foto_profil' => 'nullable|string|max:255', // Ini akan menjadi path string, bukan file upload
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed:', $validator->errors()->toArray());
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Data untuk disimpan, langsung dari $request
            $dataToSave = [
                'full_name' => $request->input('nama'),
                'phone_number' => $request->input('no_handphone'),
                'email' => $request->input('email'),
                'linkedin_url' => $request->input('linkedin'),
                'portfolio_url' => $request->input('portofolio'),
                'address' => $request->input('alamat'),
                'summary' => $request->input('deskripsi'),
                'profile_photo' => $request->input('foto_profil'), // Ambil langsung dari request
                'cv_id' => $cv->id
            ];

            // Simpan/update data personal information
            if ($existingData) {
                $existingData->update($dataToSave);
                Log::info('Personal information updated successfully.');
            } else {
                CvPersonalInformation::create($dataToSave);
                Log::info('Personal information created successfully.');
            }

            return response()->json([
                'success' => true,
                'redirect_url' => route('cv.experiences', $slug)
            ]);
        } catch (ModelNotFoundException $e) {
            Log::error('CV not found:', ['slug' => $slug, 'error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'error' => 'CV tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Server error during savePersonalInformation:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan server: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadPersonalInformations(Cv $cv)
    {
        return response()->json([
            'personal_information' => $cv->personalInformation()->get()
        ]);
    }


    public function showWorkExperienceForm(Request $request, $slug)
    {

        try {
            // Dapatkan CV berdasarkan slug
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $employeeId = auth()->user()->employee->id;

            // Validasi kepemilikan CV
            if ($cv->employee_id !== $employeeId) {
                abort(403, 'Anda tidak memiliki akses ke CV ini');
            }

            // Kunci session untuk informasi pribadi
            $sessionKey = "cv_data.{$slug}.pengalaman_kerja";

            // $request->session()->forget();
            // Jika session untuk informasi pribadi kosong, isi dengan data dari database
            if (!$request->session()->has($sessionKey) && $cv->workExperiences) {
                $request->session()->put(
                    $sessionKey,
                    $cv->workExperiences->toArray() // Simpan semua data personal information
                );
                Log::info("------------------------------------------------------------------");
                Log::info("Data informasi pribadi dari DB disisipkan ke session untuk slug: {$slug}");
            }
            Log::info("------------------------------------------------------------------");

            // Log session setelah manipulasi
            Log::info("Session setelah manipulasi untuk slug: {$slug}", [
                'session_pengalaman_kerja_setelah' => $request->session()->get($sessionKey),
            ]);

            return view('cv-generator.profesional', [
                'activeStep' => 'profesional',
                'pengalamanKerja' => $cv->workExperience,
                'currentCv' => $cv // Kirim seluruh data CV ke view
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'CV tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeWorkExperiences(Request $request, Cv $cv)
    {
        try {
            // 1. Validate incoming data
            $validatedData = $request->validate([
                'work_experiences' => 'nullable|array', // Ensure it's an array of work experiences
                'work_experiences.*.company_name' => 'nullable|string|max:255',
                'work_experiences.*.position' => 'nullable|string|max:255',
                'work_experiences.*.location' => 'nullable|string|max:255',
                'work_experiences.*.company_profile' => 'nullable|string',
                'work_experiences.*.start_month' => 'nullable|string|max:50',
                'work_experiences.*.start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
                'work_experiences.*.end_month' => 'nullable|string|max:50',
                'work_experiences.*.end_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
                'work_experiences.*.currently_working' => 'boolean',
                'work_experiences.*.portfolio' => 'nullable|string|max:255', // Assuming this is a description/link, not strictly a URL
            ]);

            // Start database transaction
            DB::beginTransaction();

            // 2. Delete all existing work experiences for this CV
            $cv->workExperiences()->delete();

            // 3. Save new work experiences
            foreach ($validatedData['work_experiences'] as $data) {
                // Prepare data for saving, mapping from input names to database column names
                $dataToSave = [
                    'company_name' => $data['company_name'],
                    'position' => $data['position'],
                    'location' => $data['location'] ?? null,
                    'company_profile' => $data['company_profile'] ?? null,
                    'start_month' => $data['start_month'] ?? null,
                    'start_year' => $data['start_year'] ?? null,
                    'end_month' => $data['end_month'] ?? null,
                    'end_year' => $data['end_year'] ?? null,
                    'currently_working' => (bool)($data['currently_working'] ?? false), // Ensure boolean
                    'portfolio_description' => $data['portfolio'] ?? null, // Mapped 'portfolio' input to 'portfolio_description' column
                ];

                // Create new entry in work_experiences table and associate with this CV
                $cv->workExperiences()->create($dataToSave);
            }

            // Commit transaction if all operations are successful
            DB::commit();

            // 4. Return success response
            $nextStepUrl = route('cv.educations', $cv->slug); // Example: redirect to education step
            return response()->json([
                'success' => true,
                'message' => 'Work experience successfully saved.',
                'redirect_url' => $nextStepUrl
            ]);
        } catch (ValidationException $e) {
            // Rollback transaction if there's a validation error
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Rollback transaction if there's any other error
            DB::rollBack();
            \Log::error("Failed to save work experience for CV {$cv->slug}: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'A server error occurred while saving work experience: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadWorkExperiences(Cv $cv)
    {
        $pengalamanKerja = $cv->workExperiences()->get();
        return response()->json(['pengalaman_kerja' => $pengalamanKerja]);
    }

    public function showStep(string $step)
    {
        $allowedSteps = ['informasi-pribadi', 'profesional', 'pendidikan', 'organisasi', 'lainnya', 'review'];

        abort_unless(in_array($step, $allowedSteps), 404);

        return view("cv-generator.$step", [
            'activeStep' => $step
        ]);
    }

    public function uploadDokumen(Request $request)
    {
        Log::info('Memulai proses upload dokumen. Request dari IP: ' . $request->ip());

        try {
            // Validasi input
            $request->validate([
                'dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
                'index' => 'nullable|integer|min:0',
                'slug' => 'nullable|string|exists:cvs,slug',
            ]);

            $index = (int) $request->input('index');
            $itemOrder = $index + 1;
            Log::debug("Validasi berhasil. Slug: {$request->slug}, Index: {$index}, item_order: {$itemOrder}");

            // Ambil CV berdasarkan slug
            $cv = Cv::where('slug', $request->slug)->firstOrFail();
            Log::debug("CV ditemukan. ID: {$cv->id}");

            // Simpan file ke storage
            $file = $request->file('dokumen');
            $path = Storage::disk('public')->putFile('dokumen', $file);
            $filename = basename($path);
            Log::info("File berhasil disimpan: {$filename} di path: {$path}");

            // Cek apakah data dengan item_order tersebut sudah ada
            $experience = CvOtherExperience::where('cv_id', $cv->id)
                ->where('item_order', $itemOrder)
                ->first();

            if (!$experience) {
                // Tambah data baru jika belum ada
                $experience = CvOtherExperience::create([
                    'cv_id' => $cv->id,
                    'item_order' => $itemOrder,
                    'document_path' => $filename,
                ]);
                Log::info("Entri baru dibuat dengan item_order: {$itemOrder} dan file: {$filename}");
            } else {
                // Hapus file lama jika ada
                if ($experience->document_path && Storage::disk('public')->exists("dokumen/{$experience->document_path}")) {
                    Storage::disk('public')->delete("dokumen/{$experience->document_path}");
                    Log::info("Dokumen lama dihapus: dokumen/{$experience->document_path}");
                }

                // Update hanya document_path
                $experience->update([
                    'document_path' => $filename,
                ]);
                Log::info("Dokumen diperbarui untuk pengalaman ID: {$experience->id} dengan file: {$filename}");
            }

            // Simpan path ke session
            $sessionKey = 'pengalaman_lain';
            $sessionData = session()->get($sessionKey, []);
            $sessionData[$index] = $sessionData[$index] ?? [];
            $sessionData[$index]['dokumen'] = $filename;
            session()->put($sessionKey, $sessionData);
            Log::debug("document_path disimpan ke session untuk index {$index}: {$filename}");

            return response()->json([
                'success' => true,
                'filename' => $filename,
            ]);
        } catch (ValidationException $e) {
            Log::warning("Validasi gagal: " . $e->getMessage(), ['errors' => $e->errors()]);
            return response()->json([
                'error' => $e->getMessage(),
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            Log::error("Kesalahan server: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);
            return response()->json([
                'error' => 'Server error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadProfilePhoto(Request $request)
    {
        Log::info('----- Memulai Upload Foto Profil -----');
        Log::info('Request Diterima:', $request->all());

        try {
            $request->validate([
                'dokumen' => 'required|file|image|mimes:jpg,jpeg,png,gif|max:2048',
                'field' => 'required|string|in:informasi_pribadi', // Validasi khusus foto profil
                'slug' => 'required|string|exists:cvs,slug',
            ]);

            Log::info('Validasi berhasil.');

            $file = $request->file('dokumen');
            $slug = $request->input(key: 'slug');
            $field = $request->input(key: 'field');
            $sessionKey = "cv_data.{$slug}.{$field}.foto_profil";

            // Ambil data sesi yang ada
            $existingData = $request->session()->get($sessionKey, null);

            // Generate nama file unik
            $filename = 'profile_' . $employeeId . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage
            $path = Storage::disk('public')->putFileAs('profile_photos', $file, $filename);

            Log::info('File berhasil disimpan:', [
                'original_name' => $file->getClientOriginalName(),
                'stored_path' => $path,
                'full_url' => asset(Storage::url($path))
            ]);

            // Hapus file lama jika ada
            if ($existingData && Storage::disk('public')->exists($existingData)) {
                Storage::disk('public')->delete($existingData);
                Log::info('File lama dihapus:', ['deleted_path' => $existingData]);
            }

            // Update sesi dengan path baru
            $request->session()->put($sessionKey, $path);

            Log::info('Sesi diperbarui:', [
                'session_key' => $sessionKey,
                'new_value' => $path
            ]);

            return response()->json([
                'success' => true,
                'filename' => $path,
                'url' => asset(Storage::url($path))
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validasi gagal:', [
                'errors' => $e->errors(),
                'request' => $request->all()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Invalid file format. Hanya menerima gambar (JPEG, PNG, JPG, GIF) maks 2MB'
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error upload foto profil:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Gagal mengupload foto profil: ' . $e->getMessage()
            ], 500);
        }
    }


    public function showEducationForm(Request $request, $slug)
    {
        try {
            // Dapatkan CV berdasarkan slug
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $employeeId = auth()->user()->employee->id;

            // Validasi kepemilikan CV
            if ($cv->employee_id !== $employeeId) {
                abort(403, 'Anda tidak memiliki akses ke CV ini');
            }

            // Kunci session untuk informasi pribadi
            $sessionKey = "cv_data.{$slug}.edukasi";

            // $request->session()->forget($sessionKey);
            // Jika session untuk informasi pribadi kosong, isi dengan data dari database
            if (!$request->session()->has($sessionKey) && $cv->educations) {
                $request->session()->put(
                    $sessionKey,
                    $cv->educations->toArray() // Simpan semua data personal information
                );
            }
            return view('cv-generator.pendidikan', [
                'activeStep' => 'pendidikan',
                'edukasi' => $cv->educations,
                'currentCv' => $cv // Kirim seluruh data CV ke view
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'CV tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeEducations(Request $request, Cv $cv)
    {
        // Adjust validation rules to match the new 'name' attributes in the view
        $validated = $request->validate([
            'educations' => 'nullable|array', // The array name from frontend is 'educations'
            'educations.*.school_name' => 'nullable|string|max:255',
            'educations.*.location' => 'nullable|string|max:255',
            'educations.*.start_month' => 'nullable|string|max:50',
            'educations.*.start_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5), // Added max year for consistency
            'educations.*.graduation_month' => 'nullable|string|max:50',
            'educations.*.graduation_year' => 'nullable|integer|min:1900|max:' . (date('Y') + 5), // Added max year for consistency
            'educations.*.degree_level' => 'nullable|string|max:255',
            'educations.*.description' => 'nullable|string',
            'educations.*.gpa' => 'nullable|numeric|between:0,4.00',
            'educations.*.gpa_max' => 'nullable|numeric|between:0,4.00',
            'educations.*.activities' => 'nullable|string'
        ]);

        try {
            // Transform incoming data to match database column names
            // The request now contains 'educations' array directly
            $transformedData = collect($request->educations)->map(function ($item) {
                return [
                    'school_name' => $item['school_name'],
                    'location' => $item['location'],
                    'start_month' => $item['start_month'],
                    'start_year' => $item['start_year'],
                    'graduation_month' => $item['graduation_month'],
                    'graduation_year' => $item['graduation_year'],
                    'degree_level' => $item['degree_level'],
                    'description' => $item['description'],
                    'gpa' => $item['gpa'] ?? null, // Use null if 'gpa' is not provided (it's optional)
                    'gpa_max' => $item['gpa_max'],
                    'activities' => $item['activities']
                ];
            })->toArray();

            // Delete existing educations and create new ones in a single transaction
            DB::beginTransaction();
            $cv->educations()->delete();
            $cv->educations()->createMany($transformedData);
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data pendidikan berhasil disimpan',
                'redirect_url' => route('cv.organizations', $cv->slug) // Ensure this route exists
            ]);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error menyimpan pendidikan:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage(),
                'errors' => 'Server Error'
            ], 500);
        }
    }

    public function loadEducations(Cv $cv)
    {
        return response()->json([
            'pendidikan' => $cv->educations()->latest()->get()
        ]);
    }

    public function showOrganizationForm(Request $request, $slug)
    {
        try {
            // Dapatkan CV berdasarkan slug
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $employeeId = auth()->user()->employee->id;

            // Validasi kepemilikan CV
            if ($cv->employee_id !== $employeeId) {
                abort(403, 'Anda tidak memiliki akses ke CV ini');
            }

            // Kunci session untuk informasi pribadi
            $sessionKey = "cv_data.{$slug}.pengalaman_organisasi";

            // $request->session()->forget($sessionKey);
            // Jika session untuk informasi pribadi kosong, isi dengan data dari database
            if (!$request->session()->has($sessionKey) && $cv->organizationExperiences) {
                $request->session()->put(
                    $sessionKey,
                    $cv->organizationExperiences->toArray() // Simpan semua data personal information
                );
            }

            return view('cv-generator.organisasi', [
                'activeStep' => 'organisasi',
                'pengalamanOrganisasi' => $cv->organizationExperiences,
                'currentCv' => $cv // Kirim seluruh data CV ke view
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'CV tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeOrganizations(Request $request, Cv $cv)
    {
        $validated = $request->validate([
            'organizations.*.organization_name' => 'nullable|string|max:255',
            'organizations.*.position' => 'nullable|string|max:255',
            'organizations.*.start_month' => 'nullable|string|max:50',
            'organizations.*.start_year' => 'nullable|integer|min:1900',
            'organizations.*.end_month' => 'nullable|string|max:50',
            'organizations.*.end_year' => 'nullable|integer|min:1900',
            'organizations.*.is_active' => 'sometimes|boolean',
            'organizations.*.job_description' => 'nullable|string'
        ]);

        try {
            $cv->organizationExperiences()->delete();
            $cv->organizationExperiences()->createMany($request->organizations);

            return response()->json([
                'message' => 'Data organisasi berhasil disimpan',
                'redirect_url' => route('cv.other-experiences', $cv->slug)
            ]);
        } catch (\Exception $e) {
            \Log::error('Error menyimpan organisasi:', ['error' => $e->getMessage()]);
            return response()->json([
                'message' => 'Terjadi kesalahan sistem',
                'errors' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadOrganizations(Cv $cv)
    {
        return response()->json([
            'organizations' => $cv->organizationExperiences()->latest()->get()
        ]);
    }

    public function showOtherExperienceForm(Request $request, $slug)
    {
        try {
            // Dapatkan CV berdasarkan slug
            $cv = Cv::where('slug', $slug)->firstOrFail();
            $employeeId = auth()->user()->employee->id;

            // Validasi kepemilikan CV
            if ($cv->employee_id !== $employeeId) {
                abort(403, 'Anda tidak memiliki akses ke CV ini');
            }

            // Kunci session untuk informasi pribadi
            $sessionKey = "cv_data.{$slug}.pengalaman_lainnya";

            // $request->session()->forget($sessionKey);
            // Jika session untuk informasi pribadi kosong, isi dengan data dari database
            if (!$request->session()->has($sessionKey) && $cv->otherExperiences) {
                $request->session()->put(
                    $sessionKey,
                    $cv->otherExperiences->toArray() // Simpan semua data personal information
                );
            }

            return view('cv-generator.lainnya', [
                'activeStep' => 'lainnya',
                'pengalamanLainnya' => $cv->otherExperiences,
                'currentCv' => $cv // Kirim seluruh data CV ke view
            ]);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'CV tidak ditemukan');
        } catch (\Exception $e) {
            return redirect()->route('cv.dashboard')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function storeOtherExperiences(Request $request, Cv $cv)
    {
        $validated = $request->validate([
            'other_experiences.*.category' => 'nullable|string|max:255',
            'other_experiences.*.year' => 'nullable|integer|min:1900',
            'other_experiences.*.description' => 'nullable|string',
            'other_experiences.*.document_path' => 'nullable|url|max:500', // Validasi URL opsional
        ]);

        try {
            // Hapus semua data existing dan buat yang baru
            $cv->otherExperiences()->delete();

            // Tambahkan data baru
            $cv->otherExperiences()->createMany($request->other_experiences);

            return response()->json([
                'message' => 'Data pengalaman berhasil disimpan',
                'redirect_url' => route('cv.review', $cv->slug),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error menyimpan pengalaman:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Terjadi kesalahan sistem',
                'errors' => 'Server Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function loadOtherExperiences(Cv $cv)
    {
        return response()->json([
            'other_experiences' => $cv->otherExperiences()->latest()->get()
        ]);
    }

    public function showReviewPage(Cv $cv)
    {
        return view('cv-generator.review', [
            'activeStep' => 'review',
            'currentCv' => $cv // Kirim seluruh data CV ke view
        ]);
    }

    public function downloadCv(Request $request, $slug)
    {
        Log::info('----- Memulai Download CV -----');
        Log::info('Permintaan Download untuk Slug:', ['slug' => $slug]);

        try {
            // Ambil data CV lengkap berdasarkan slug
            $cv = Cv::where('slug', $slug)
                ->with([
                    'personalInformation',
                    'workExperiences', // Ganti 'experiences' menjadi 'workExperiences'
                    'educations',
                    'organizationExperiences', // Relasi baru
                    'otherExperiences',        // Relasi baru
                ])
                ->firstOrFail();

            // Pastikan data informasi pribadi ada
            if (!$cv->personalInformation) {
                return redirect()->back()->with('error', 'Data informasi pribadi tidak lengkap untuk CV ini.');
            }

            // Siapkan data untuk view
            $data = [
                'cv' => $cv, // Mengirim objek CV secara keseluruhan
                'personalInformation' => $cv->personalInformation,
                'workExperiences' => $cv->workExperiences,
                'educations' => $cv->educations,
                'organizationExperiences' => $cv->organizationExperiences,
                'otherExperiences' => $cv->otherExperiences,
            ];

            // Render view ke HTML
            $html = view('cv-generator.download_template', $data)->render();

            // Buat instance PDF dari HTML
            $pdf = PDF::loadHtml($html);

            // Set ukuran kertas dan orientasi
            $pdf->setPaper('A4', 'portrait');

            // Set nama file untuk download
            // Menggunakan title CV jika ada, jika tidak, pakai nama lengkap
            $filename = ($cv->title ?? $cv->personalInformation->full_name ?? 'CV') . '_' . Carbon::now()->format('YmdHis') . '.pdf';
            $filename = str_replace(' ', '_', $filename); // Ganti spasi dengan underscore

            Log::info('CV Berhasil Dibuat. Nama file:', ['filename' => $filename]);

            // Unduh file PDF
            return $pdf->download($filename);
        } catch (ModelNotFoundException $e) {
            Log::error('CV tidak ditemukan saat mencoba download:', ['slug' => $slug, 'error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'CV yang diminta tidak ditemukan.');
        } catch (\Exception $e) {
            Log::error('Gagal mendownload CV:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mendownload CV: ' . $e->getMessage());
        }
    }

    public function saveSessionRealtime(Request $request)
    {
        $validated = $request->validate([
            'field' => 'nullable|string',
            'value' => 'nullable',
            'slug' => 'nullable|string|exists:cvs,slug' // Tambahkan validasi slug
        ]);

        $field = $validated['field'];
        $value = $validated['value'];
        $slug = $validated['slug'];

        // Struktur session key berdasarkan slug
        $sessionKey = "cv_data.{$slug}.{$field}";

        Log::info('Memproses session untuk CV:', ['slug' => $slug]);

        // Handle berdasarkan tipe field
        switch ($field) {

            case 'informasi_pribadi':
                $existingData = session()->get('informasi_pribadi', []);

                $mergedInformasiPribadi = [
                    'full_name' => $value['full_name'] ?? null,
                    'phone_number' => $value['phone_number'] ?? null,
                    'email' => $value['email'] ?? null,
                    'linkedin_url' => $value['linkedin_url'] ?? null,
                    'portfolio_url' => $value['portfolio_url'] ?? null,
                    'address' => $value['address'] ?? null,
                    'summary' => $value['summary'] ?? null,
                    'profile_photo' => !empty($value['profile_photo']) ? $value['profile_photo'] : ($existingData['profile_photo'] ?? null),
                ];
                session([$sessionKey => $mergedInformasiPribadi]);
                Log::info('Informasi pribadi di sesi setelah update (saveSessionRealtime):', session()->get($sessionKey, []));
                break;

            default:
                session([$sessionKey => $value]);
                break;
        }

        Log::info('Session setelah update:', [
            'key' => $sessionKey,
            'data' => session()->get($sessionKey)
        ]);

        return response()->json(['status' => 'success']);
    }

    public function loadSessionData(Request $request, $slug)
    {
        try {
            // Struktur session key berdasarkan slug
            $sessionKey = "cv_data.{$slug}";

            // Ambil data session spesifik untuk CV ini
            $sessionData = [
                'pengalaman_lain' => session("{$sessionKey}.pengalaman_lain", []),
                'informasi_pribadi' => session("{$sessionKey}.informasi_pribadi", []),
                'edukasi' => session("{$sessionKey}.edukasi", []),
                'pengalaman_organisasi' => session("{$sessionKey}.pengalaman_organisasi", []),
                'pengalaman_kerja' => session("{$sessionKey}.pengalaman_kerja", []),
            ];

            Log::info('Session data loaded for CV:', [
                'slug' => $slug,
                'data' => $sessionData
            ]);

            return response()->json($sessionData);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'CV tidak ditemukan'
            ], 404);
        } catch (\Exception $e) {
            Log::error('Error loading session data:', [
                'error' => $e->getMessage(),
                'slug' => $slug
            ]);

            return response()->json([
                'error' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function edit($slug)
    {
        $cv = Cv::where('slug', $slug)->firstOrFail();
        $employeeId = auth()->user()->employee->id;

        // Validasi kepemilikan CV
        if ($cv->employee_id !== $employeeId) {
            abort(403, 'Anda tidak memiliki akses ke CV ini');
        }

        // Redirect ke form informasi pribadi dengan menyertakan slug
        return redirect()->route('cv.personal-info', $cv->slug);
    }

    public function destroy($slug)
    {
        $cv = Cv::where('slug', $slug)->firstOrFail();
        $employeeId = auth()->user()->employee->id;

        if ($cv->employee_id !== $employeeId) {
            abort(403);
        }

        $cv->delete();

        return redirect()->route('cv.dashboard')
            ->with('status', 'CV berhasil dihapus');
    }

    public function download($slug)
    {
        $cv = Cv::where('slug', $slug)->firstOrFail();
        $employeeId = auth()->user()->employee->id;

        if ($cv->employee_id !== $employeeId) {
            abort(403);
        }

        // Logika download disini
        // ...
    }
}
