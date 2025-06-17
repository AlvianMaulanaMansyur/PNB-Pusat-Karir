<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use App\Models\employees;
use Dompdf\Dompdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ResumeController extends Controller
{
    /**
     * Helper function to get the authenticated Employee profile.
     *
     * @return \App\Models\employees
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    protected function getAuthenticatedEmployee(): employees // Pastikan type hint-nya singular: Employee
    {
        $user = Auth::user();

        // 1. Pastikan user login.
        if (!$user) {
            // Ini sebenarnya sudah ditangani oleh middleware 'auth', tapi sebagai safety check.
            abort(403, 'Anda tidak terautentikasi.');
        }

        $employeeProfile = $user->employee()->first();

        if (!$employeeProfile) {
            abort(403, 'Profil employee Anda tidak ditemukan.');
        }

        return $employeeProfile;
    }

    /**
     * Display a listing of the employee's resumes.
     */
    public function index()
    {
        $employee = $this->getAuthenticatedEmployee();
        $resumes = $employee->resumes()->orderBy('updated_at', 'desc')->get();
        return view('resume.index', compact('resumes'));
    }

    /**
     * Show the form for creating a new resume.
     */
    public function create()
    {
        return view('resume.create');
    }

    /**
     * Store a newly created resume in storage.
     */
    public function store(Request $request)
    {
        $employee = $this->getAuthenticatedEmployee();

        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('resumes')->where(fn($query) => $query->where('employee_id', $employee->id))
            ],
        ]);

        $resumeData = [
            'personal_details' => [],
            'experiences' => [],
            'educations' => [],
            'skills' => [],
            'organizations' => [],
            'projects' => [],
        ];

        $resume = $employee->resumes()->create([
            'title' => $validatedData['title'],
            'resume_data' => $resumeData,
        ]);
        
        return redirect()->route('resumes.edit', ['resume' => $resume->slug])
            ->with('success', 'Resume created successfully! Now, let\'s fill in the details.');
    }

    /**
     * Display the specified resume.
     */
    public function show(Resume $resume)
    {
        if ($resume->employee_id !== $this->getAuthenticatedEmployee()->id) {
            abort(403);
        }
        return view('resume.show', compact('resume'));
    }

    /**
     * Show the form for editing the specified resume.
     */
    public function edit(Resume $resume)
    {
        if ($resume->employee_id !== $this->getAuthenticatedEmployee()->id) {
            abort(403);
        }
        return view('resume.edit', compact('resume'));
    }

    /**
     * Update the specified resume in storage.
     */
    public function update(Request $request, Resume $resume)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($resume->employee_id !== $employee->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('resumes')->ignore($resume->id)->where(fn($query) => $query->where('employee_id', $employee->id))
            ],
        ]);

        $resume->update($validatedData);

        return redirect()->route('resumes.edit', ['resume' => $resume->slug])
            ->with('success', 'Resume updated successfully!');
    }

    /**
     * Remove the specified resume from storage.
     */
    public function destroy(Resume $resume)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($resume->employee_id !== $employee->id) {
            abort(403);
        }

        $resume->delete();

        return redirect()->route('resumes.index')->with('success', 'Resume deleted successfully!');
    }

    // Metode Tambahan untuk Mengelola Bagian-bagian Resume dalam JSON
    public function updatePersonalDetails(Request $request, Resume $resume)
    {
        $employee = $this->getAuthenticatedEmployee();

        if ($resume->employee_id !== $employee->id) {
            abort(403);
        }

        $validatedData = $request->validate([
            'personal_details.name' => 'required|string|max:255',
            'personal_details.email' => 'required|email|max:255',
        ]);

        $currentResumeData = $resume->resume_data;
        $currentResumeData['personal_details'] = $validatedData['personal_details'];
        $resume->resume_data = $currentResumeData;
        $resume->save();

        return redirect()->back()->with('success', 'Personal details updated successfully!');
    }

    public function exportJson(Resume $resume): JsonResponse
    {
        if ($resume->employee_id !== $this->getAuthenticatedEmployee()->id) {
            abort(403);
        }

        // Pastikan resume_data adalah array/object sebelum diencode
        $resumeData = $resume->resume_data;

        return response()->json($resumeData, 200, [], JSON_PRETTY_PRINT)
            ->header('Content-Disposition', 'attachment; filename="resume-' . $resume->slug . '.json"');
    }

    /**
     * Export resume as PDF.
     */
    public function exportPdf(Resume $resume)
    {
        if ($resume->employee_id !== $this->getAuthenticatedEmployee()->id) {
            abort(403);
        }

        $resumeData = $resume->resume_data;
        $profilePhotoUrl = null; // Inisialisasi variabel untuk gambar

        // Tangani gambar profil untuk Dompdf
        if (!empty($resumeData['personal_details']['profile_photo'])) {
            // Hapus '/storage/' dari awal path jika ada
            $relativePath = str_replace('storage/', '', $resumeData['personal_details']['profile_photo']);

            // Dapatkan path lengkap di sistem file (storage/app/public/...)
            $absolutePath = Storage::disk('public')->path($relativePath);

            // Periksa apakah file ada sebelum mencoba membacanya
            if (file_exists($absolutePath)) {
                // Rekomendasi: Konversi gambar ke Base64 untuk keandalan Dompdf
                $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
                $data = file_get_contents($absolutePath);
                $profilePhotoUrl = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
        // Render view preview resume sebagai HTML
        $html = view('resume.partials.pdf', compact('resumeData', 'profilePhotoUrl'))->render();

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Opsional) Konfigurasi ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF
        $dompdf->render();

        // Stream PDF ke browser sebagai download
        return $dompdf->stream('resume-' . $resume->slug . '.pdf', ["Attachment" => true]);
    }

    public function showPdf(Resume $resume)
    {
        $resumeData = $resume->resume_data;
        $profilePhotoUrl = null; // Inisialisasi variabel untuk gambar

        // Tangani gambar profil untuk Dompdf
        if (!empty($resumeData['personal_details']['profile_photo'])) {
            // Hapus '/storage/' dari awal path jika ada
            $relativePath = str_replace('storage/', '', $resumeData['personal_details']['profile_photo']);

            // Dapatkan path lengkap di sistem file (storage/app/public/...)
            $absolutePath = Storage::disk('public')->path($relativePath);

            // Periksa apakah file ada sebelum mencoba membacanya
            if (file_exists($absolutePath)) {
                // Rekomendasi: Konversi gambar ke Base64 untuk keandalan Dompdf
                $type = pathinfo($absolutePath, PATHINFO_EXTENSION);
                $data = file_get_contents($absolutePath);
                $profilePhotoUrl = 'data:image/' . $type . ';base64,' . base64_encode($data);
            }
        }
       
        return view('resume.partials.pdf', compact('resumeData', 'profilePhotoUrl'));
    }
}
