<?php

namespace App\Livewire\Resume;

use App\Models\Resume;
use Livewire\Component;
use Livewire\WithFileUploads; // Penting untuk upload file
use Illuminate\Support\Facades\Storage; // Untuk menghapus file lama
use Illuminate\Support\Str; // Tambahkan ini jika digunakan untuk hal lain (misal: UUID, tapi tidak di sini)
use Illuminate\Support\Facades\Log; // Untuk logging

class PersonalDetailsForm extends Component
{
    use WithFileUploads;

    public $resumeId;

    public $form = [ 
        'name' => '',
        'email' => '',
        'phone' => '',
        'address' => '',
        'summary' => '',
        'profile_photo' => '', 
    ];

    public $profilePhotoFile; 
    public $profilePhotoPreview;
    public $removeProfilePhoto = false;

    protected function rules()
    {
        return [
            'form.name' => 'nullable|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.address' => 'nullable|string|max:500',
            'form.summary' => 'nullable|string|max:1000',
            'profilePhotoFile' => 'nullable|image|max:1024', // 1MB Max
        ];
    }

    protected function messages()
    {
        return [
            'form.name.required' => 'Your full name is required.',
            'form.email.required' => 'Email address is required.',
            'form.email.email' => 'Please enter a valid email address.',
            'profilePhotoFile.image' => 'The file must be an image.',
            'profilePhotoFile.max' => 'The profile photo may not be larger than 1MB.',
        ];
    }

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadPersonalDetails();
    }

    public function updated($propertyName)
    {
        if (str_starts_with($propertyName, 'form.')) {
            $this->validateOnly($propertyName);
            $this->savePersonalDetails();
        } elseif ($propertyName === 'profilePhotoFile') {
            $this->uploadPhoto();
        }
    }

    public function uploadPhoto()
    {
        $this->resetErrorBag('profilePhotoFile');

        if ($this->profilePhotoFile) {
            try {
                $this->validate(['profilePhotoFile' => $this->rules()['profilePhotoFile']]);

                // Hapus foto lama jika ada
                if (!empty($this->form['profile_photo'])) {
                    $oldPhotoPath = str_replace('/storage/', '', $this->form['profile_photo']);
                    if (Storage::disk('public')->exists($oldPhotoPath)) {
                        Storage::disk('public')->delete($oldPhotoPath);
                        Log::info('Foto lama berhasil dihapus.', ['path' => $oldPhotoPath]);
                    } else {
                        Log::warning('Foto lama tidak ditemukan untuk dihapus.', ['path' => $oldPhotoPath]);
                    }
                }

                // Simpan foto baru
                $path = $this->profilePhotoFile->store('resume_profile_photos', 'public');
                $this->form['profile_photo'] = str_replace('public/', '', $path);

                // Update pratinjau
                $this->profilePhotoPreview = $this->form['profile_photo'];

                // Auto-save data setelah upload berhasil
                $this->savePersonalDetails();
                session()->flash('success', 'Profile photo uploaded successfully!');
                Log::info('Foto profil berhasil diunggah dan disimpan.', ['url' => $this->form['profile_photo']]);

            } catch (\Illuminate\Validation\ValidationException $e) {
                // Livewire secara otomatis akan menampilkan error validasi
                Log::error('Validasi upload foto gagal.', ['errors' => $e->errors()]);
                // $this->errorMessage = 'Gagal mengunggah foto: ' . implode(', ', $e->errors()['profilePhotoFile'] ?? ['Unknown error']); // Hapus ini
                throw $e; // Re-throw agar error bag tetap terisi
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to upload photo: ' . $e->getMessage());
                Log::critical('Terjadi kesalahan fatal saat mengunggah foto.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            }
        }
    }

    public function removePhoto()
    {
        if (!empty($this->form['profile_photo'])) {
            $oldPhotoPath = str_replace('/storage/', '', $this->form['profile_photo']);
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
                Log::info('Foto profil berhasil dihapus dari storage.', ['path' => $oldPhotoPath]);
                session()->flash('success', 'Profile photo removed successfully!');
            } else {
                Log::warning('Gagal menghapus foto: File tidak ditemukan di storage.', ['path' => $oldPhotoPath]);
                session()->flash('error', 'Failed to remove photo: File not found.');
            }
            $this->form['profile_photo'] = null;
            $this->profilePhotoPreview = null;
            $this->profilePhotoFile = null; // Reset input file
            $this->savePersonalDetails(); // Simpan perubahan setelah foto dihapus
        }
    }

    public function loadPersonalDetails()
    {
        Log::info('loadPersonalDetails: Memuat detail personal untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['personal_details'])) {
                $loadedDetails = $resume->resume_data['personal_details'];
                // Pastikan semua field yang ada di $this->form diinisialisasi dari data yang dimuat
                foreach ($this->form as $key => $defaultValue) {
                     if (isset($loadedDetails[$key])) {
                         $this->form[$key] = $loadedDetails[$key];
                     } else {
                         $this->form[$key] = $defaultValue; // Set default jika tidak ada di data lama
                     }
                }
                // Set preview foto jika ada
                if (!empty($this->form['profile_photo'])) {
                    $this->profilePhotoPreview = $this->form['profile_photo'];
                }
                Log::info('Detail personal berhasil dimuat.', ['data' => $this->form]);
            } else {
                // Jika tidak ada data di DB, gunakan nilai default dari $this->form
                Log::info('Tidak ada detail personal di database atau data tidak valid, menggunakan default.');
            }
        } catch (\Exception $e) {
            Log::critical('loadPersonalDetails: Gagal memuat detail personal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to load personal details.');
            // Biarkan $this->form tetap pada nilai default-nya
        }
    }

    // --- Metode untuk Menyimpan Data Personal Details ke DB ---
    public function savePersonalDetails()
    {
        $this->validate([
            'form.name' => 'nullable|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.address' => 'nullable|string|max:500',
            'form.summary' => 'nullable|string|max:1000',
        ]);

        Log::info('savePersonalDetails: Memulai proses penyimpanan detail personal.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            $resume = Resume::find($this->resumeId);

            if (!$resume) {
                session()->flash('error', 'Resume not found.');
                Log::error('savePersonalDetails: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['personal_details'] = $this->form;

            $resume->resume_data = $resumeData;
            $resume->save();

            session()->flash('success', 'Personal details saved successfully!');

            $this->dispatch('personalDetailsUpdated', $this->form); // Mengirim $this->form (data personal details)
            Log::info('Detail personal berhasil disimpan dan event didispatch.', ['data' => $this->form]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('savePersonalDetails: Validasi gagal.', ['errors' => $e->errors()]);
            throw $e; // Lempar kembali exception agar validasi tetap tampil di frontend
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save personal details: ' . $e->getMessage());
            // $this->errorMessage = 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage(); // Hapus ini
            // session()->flash('personal_details_success', null); // Hapus ini
            Log::critical('savePersonalDetails: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function render()
    {
        return view('livewire.resume.personal-details-form');
    }
}