<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume; // Pastikan Anda mengimpor model Resume
use App\Models\Experience; // Pastikan Anda mengimpor model Experience
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str; // Untuk UUID

class ExperienceController extends Controller
{
    /**
     * Store a newly created experience in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Resume $resume)
    {
        try {
            // Validasi data yang masuk
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'description' => 'nullable|string',
            ]);

            // Ambil resume_data, inisialisasi jika null
            $resumeData = $resume->resume_data ?? [];

            // Pastikan 'experiences' adalah array
            if (!isset($resumeData['experiences']) || !is_array($resumeData['experiences'])) {
                $resumeData['experiences'] = [];
            }

            // Buat ID unik untuk pengalaman baru (UUID direkomendasikan)
            $newExperienceId = (string) Str::uuid();

            // Tambahkan pengalaman baru ke array experiences
            $resumeData['experiences'][] = array_merge(
                ['id' => $newExperienceId], // Tambahkan ID
                $validatedData
            );

            // Simpan kembali resume_data yang sudah diperbarui
            $resume->resume_data = $resumeData;
            $resume->save();

            return response()->json([
                'message' => 'Experience added successfully!',
                'experience' => array_merge(['id' => $newExperienceId], $validatedData) // Kirim data pengalaman baru
            ], 201); // 201 Created
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422); // 422 Unprocessable Entity
        } catch (\Exception $e) {
            Log::error("Error adding experience: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Failed to add experience.',
                'error' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }

    /**
     * Display the specified experience.
     * Digunakan oleh fungsi editExperience di frontend untuk mengambil data lengkap.
     *
     * @param  \App\Models\Resume  $resume
     * @param  string  $experienceId  ID pengalaman (bukan model Experience jika disimpan dalam JSON)
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Resume $resume, string $experienceId)
    {
        Log::info("Attempting to fetch experience details.", [
            'resume_slug' => $resume->slug,
            'requested_experience_id' => $experienceId
        ]);

        $resumeData = $resume->resume_data ?? [];
        $experiences = $resumeData['experiences'] ?? [];

        Log::debug("Resume data for slug '{$resume->slug}': ", ['resume_data_full' => $resumeData]);
        Log::debug("Parsed experiences array: ", ['experiences_array' => $experiences]);


        foreach ($experiences as $index => $experience) {
            Log::debug("Checking experience at index {$index}: ", ['experience_item' => $experience]);

            if (isset($experience['id']) && $experience['id'] === $experienceId) {
                Log::info("Experience found for ID: {$experienceId}", ['found_experience' => $experience]);
                return response()->json(['experience' => $experience], 200);
            }
        }

        Log::warning("Experience not found for ID: {$experienceId} in resume: {$resume->slug}");
        return response()->json(['message' => 'Experience not found.'], 404);
    }

    /**
     * Update the specified experience in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resume  $resume
     * @param  string  $experienceId  ID pengalaman yang akan diupdate
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Resume $resume, string $experienceId)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'company' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'description' => 'nullable|string',
            ]);

            $resumeData = $resume->resume_data ?? [];
            $experiences = $resumeData['experiences'] ?? [];
            $found = false;

            foreach ($experiences as $key => $experience) {
                if (isset($experience['id']) && $experience['id'] === $experienceId) {
                    // Perbarui data pengalaman
                    $experiences[$key] = array_merge($experience, $validatedData);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                return response()->json(['message' => 'Experience not found.'], 404);
            }

            $resumeData['experiences'] = $experiences;
            $resume->resume_data = $resumeData;
            $resume->save();

            return response()->json([
                'message' => 'Experience updated successfully!',
                'experience' => $experiences[$key] // Kirim data yang diperbarui
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error("Error updating experience: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Failed to update experience.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified experience from storage.
     *
     * @param  \App\Models\Resume  $resume
     * @param  string  $experienceId  ID pengalaman yang akan dihapus
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Resume $resume, string $experienceId)
    {
        try {
            $resumeData = $resume->resume_data ?? [];
            $experiences = $resumeData['experiences'] ?? [];
            $initialCount = count($experiences);

            // Filter pengalaman yang tidak sesuai dengan ID yang akan dihapus
            $experiences = array_values(array_filter($experiences, function ($experience) use ($experienceId) {
                return !isset($experience['id']) || $experience['id'] !== $experienceId;
            }));

            if (count($experiences) === $initialCount) {
                return response()->json(['message' => 'Experience not found.'], 404);
            }

            $resumeData['experiences'] = $experiences;
            $resume->resume_data = $resumeData;
            $resume->save();

            return response()->json(['message' => 'Experience deleted successfully!'], 200);
        } catch (\Exception $e) {
            Log::error("Error deleting experience: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json([
                'message' => 'Failed to delete experience.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
