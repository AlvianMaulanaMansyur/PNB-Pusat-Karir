<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PersonalDetailsController extends Controller
{
    /**
     * Update the personal details for the given resume.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resume  $resume
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Resume $resume)
    {
        try {
            $validated = $request->validate([
                'personal_details.name' => ['required', 'string', 'max:255'],
                'personal_details.email' => ['required', 'email', 'max:255'],
                'personal_details.phone' => ['nullable', 'string', 'regex:/^\d+$/', 'max:15'],
                'personal_details.address' => ['nullable', 'string'],
                'personal_details.summary' => ['nullable', 'string'],
                'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            ], [
                'personal_details.name.required' => 'Nama wajib diisi.',
                'personal_details.email.required' => 'Email wajib diisi.',
                'personal_details.email.email' => 'Format email tidak valid.',
                'profile_photo.image' => 'File harus berupa gambar.',
                'profile_photo.mimes' => 'Format gambar yang didukung adalah jpeg, png, jpg, gif, svg.',
                'profile_photo.max' => 'Ukuran gambar tidak boleh melebihi 2MB.',
            ]);

            $resumeData = $resume->resume_data ?? [];
            $currentProfilePhotoUrl = Arr::get($resumeData, 'personal_details.profile_photo');

            // Perbarui data personal terlebih dahulu
            Arr::set($resumeData, 'personal_details', array_merge(
                Arr::get($resumeData, 'personal_details', []),
                $validated['personal_details'] ?? []
            ));

            // Handle upload foto profil
            if ($request->hasFile('profile_photo')) {
                // Hapus foto lama jika ada
                if ($currentProfilePhotoUrl) {
                    $this->deleteProfilePhoto($currentProfilePhotoUrl);
                }

                $path = $request->file('profile_photo')->store('public/resume_profile_photos');
                $relativePath = str_replace('public/', '', $path);
                Arr::set($resumeData, 'personal_details.profile_photo', $relativePath);
                Log::info("New profile photo uploaded: {$relativePath}");
            }
            // Handle penghapusan foto profil
            elseif ($request->has('remove_profile_photo') && $request->input('remove_profile_photo')) {
                if ($currentProfilePhotoUrl) {
                    $this->deleteProfilePhoto($currentProfilePhotoUrl);
                }
                Arr::set($resumeData, 'personal_details.profile_photo', null);
            }

            $resume->resume_data = $resumeData;
            $resume->save();

            return response()->json([
                'message' => 'Profile updated successfully!',
                'personal_details' => $resumeData['personal_details']
            ], 200);
        } catch (ValidationException $e) {
            Log::warning("Validation failed", ['errors' => $e->errors()]);
            return response()->json(['message' => 'Validation failed', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error("Error updating profile", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Failed to update profile.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete profile photo from storage
     * 
     * @param string $photoUrl
     * @return void
     */
    protected function deleteProfilePhoto($photoPath)
    {
        try {
            // Pastikan path sudah relatif
            $storagePath = "public/{$photoPath}";

            if (Storage::exists($storagePath)) {
                Storage::delete($storagePath);
                Log::info("Profile photo deleted: {$storagePath}");
            } else {
                Log::warning("Profile photo not found: {$storagePath}");
            }
        } catch (\Exception $e) {
            Log::error("Error deleting profile photo", [
                'path' => $photoPath,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Extract photo path from URL
     * 
     * @param string $url
     * @return string|null
     */
    protected function extractPhotoPath($url)
    {
        if (str_contains($url, '/storage/resume_profile_photos/')) {
            $parts = explode('/storage/resume_profile_photos/', $url);
            return end($parts);
        }

        if (str_contains($url, '/public/resume_profile_photos/')) {
            $parts = explode('/public/resume_profile_photos/', $url);
            return end($parts);
        }

        if (str_contains($url, 'resume_profile_photos/')) {
            $parts = explode('resume_profile_photos/', $url);
            return end($parts);
        }

        return null;
    }
}
