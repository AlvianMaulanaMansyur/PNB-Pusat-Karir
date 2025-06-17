<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume; // Asumsikan Anda memiliki model Resume
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Tambahkan ini untuk UUID

class ExperienceForm extends Component
{
    public $resumeId; // ID Resume dari komponen parent (Jobseeker.php)
    public $experiences = []; // Ini akan menampung array experience dari resume_data

    // Properti untuk modal dan form
    public $showModal = false;
    public $editingExperienceId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'title' => '',
        'company' => '',
        'start_date' => '',
        'end_date' => '',
        'is_current' => false, // <<< TAMBAHKAN INI: Untuk pengalaman yang sedang berjalan
        'description' => '',
    ];

    protected $listeners = [
        // 'personalDetailsUpdated', // Tidak perlu karena tidak berdampak langsung pada data pengalaman
        'refreshExperiences' => 'loadExperiences', // <<< UBAH INI: Untuk memuat ulang dari database
    ];

    // --- Lifecycle Hooks ---
    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadExperiences(); // <<< PANGGIL loadExperiences di mount
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.company' => 'required|string|max:255',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.is_current' => 'boolean', // <<< TAMBAHKAN INI
            'form.description' => 'nullable|string|max:1000',
        ];
    }

    // Custom validation messages (opsional, tetapi baik untuk konsistensi)
    protected function messages()
    {
        return [
            'form.title.required' => 'Job Title is required.',
            'form.company.required' => 'Company Name is required.',
            'form.start_date.required' => 'Start Date is required.',
            'form.end_date.after_or_equal' => 'End Date must be after or equal to Start Date.',
        ];
    }

    // --- Metode Modal ---
    public function openModal($experienceId = null)
    {
        $this->resetErrorBag(); // Bersihkan pesan error validasi
        $this->resetForm(); // Reset form setiap kali membuka

        if ($experienceId) {
            $this->editingExperienceId = $experienceId;
            // Temukan experience berdasarkan ID
            $experience = collect($this->experiences)->firstWhere('id', $experienceId);
            if ($experience) {
                // Isi form dengan data experience yang akan diedit
                // <<< UBAH INI: Iterasi dan pastikan is_current adalah boolean
                foreach ($this->form as $key => $defaultValue) {
                    if ($key === 'is_current') {
                        $this->form[$key] = (bool) ($experience[$key] ?? false);
                    } else {
                        $this->form[$key] = $experience[$key] ?? $defaultValue;
                    }
                }
                // >>>
            } else {
                session()->flash('error', 'Experience not found for editing.');
                return;
            }
        } else {
            $this->editingExperienceId = null; // Menambah baru
        }
        $this->showModal = true;
        // $this->dispatch('toggle-body-scroll', ['action' => 'hide']); // Tidak diperlukan jika modal Livewire 3 sudah mengurusnya
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetErrorBag();
        // $this->dispatch('toggle-body-scroll', ['action' => 'show']); // Tidak diperlukan
    }

    protected function resetForm()
    {
        $this->form = [
            'id' => null,
            'title' => '',
            'company' => '',
            'start_date' => '',
            'end_date' => '',
            'is_current' => false, // <<< TAMBAHKAN INI
            'description' => '',
        ];
    }

    // <<< TAMBAHKAN INI: Hook untuk is_current
    public function updatedFormIsCurrent($value)
    {
        if ($value) {
            $this->form['end_date'] = ''; // Kosongkan end_date jika sedang berjalan
        }
    }
    // >>>

    // --- Metode CRUD ---
    public function saveExperience()
    {
        // Validasi, kecuali end_date jika is_current true
        $rules = $this->rules();
        if ($this->form['is_current']) {
            unset($rules['form.end_date']);
        }
        $this->validate($rules); // <<< UBAH: Validasi dengan aturan yang sudah disesuaikan

        Log::info('saveExperience: Memulai proses penyimpanan pengalaman.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            // <<< UBAH INI: Logika penyimpanan yang lebih sederhana seperti ProjectsForm
            if ($this->editingExperienceId) {
                // Update Experience
                $index = collect($this->experiences)->search(function ($item) {
                    return $item['id'] === $this->editingExperienceId;
                });
                if ($index !== false) {
                    $this->experiences[$index] = $this->form;
                    session()->flash('success', 'Experience entry updated successfully!');
                } else {
                    Log::warning('saveExperience: Entri pengalaman tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingExperienceId]);
                }
            } else {
                // Add New Experience
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->experiences[] = $this->form;
                session()->flash('success', 'Experience entry added successfully!');
            }

            $this->saveExperiencesToDatabase(); // Simpan ke database
            $this->loadExperiences(); // Muat ulang properti dari DB
            $this->dispatch('experiencesUpdated', $this->experiences); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
            // >>>
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('saveExperience: Validasi gagal.', ['errors' => $e->errors()]);
            throw $e; // Lempar kembali exception agar validasi tetap tampil di frontend
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save experience: ' . $e->getMessage());
            Log::critical('saveExperience: Terjadi kesalahan fatal saat menyimpan pengalaman.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeExperience($experienceId)
    {
        Log::info('removeExperience: Menghapus entri pengalaman.', ['resumeId' => $this->resumeId, 'experienceId' => $experienceId]); // <<< Tambahkan logging

        try {
            $originalCount = count($this->experiences); // Ambil hitungan sebelum menghapus
            $this->experiences = collect($this->experiences)->filter(function ($exp) use ($experienceId) {
                return $exp['id'] !== $experienceId;
            })->values()->all(); // Reset keys after filtering

            if (count($this->experiences) < $originalCount) { // Cek apakah ada yang dihapus
                $this->saveExperiencesToDatabase(); // Simpan ke DB setelah perubahan
                $this->loadExperiences(); // Muat ulang properti dari DB
                $this->dispatch('experiencesUpdated', $this->experiences); // Informasikan komponen lain
                session()->flash('success', 'Experience deleted successfully!');
            } else {
                session()->flash('error', 'Experience entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete experience: ' . $e->getMessage());
            Log::critical('removeExperience: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateExperience($experienceId)
    {
        Log::info('duplicateExperience: Menduplikasi entri pengalaman.', ['resumeId' => $this->resumeId, 'experienceId' => $experienceId]); // <<< Tambahkan logging

        try {
            $originalExperience = collect($this->experiences)->firstWhere('id', $experienceId);

            if ($originalExperience) {
                $duplicatedExperience = $originalExperience;
                $duplicatedExperience['id'] = (string) Str::uuid(); // Berikan ID baru
                $duplicatedExperience['title'] = $originalExperience['title'] . ' (Copy)'; // Tambahkan (Copy) ke judul

                $this->experiences[] = $duplicatedExperience; // Tambahkan duplikat ke array

                $this->saveExperiencesToDatabase(); // Simpan ke DB setelah perubahan
                $this->loadExperiences(); // Muat ulang properti dari DB
                $this->dispatch('experiencesUpdated', $this->experiences); // Informasikan ResumePreview
                session()->flash('success', 'Experience duplicated successfully!');
            } else {
                session()->flash('error', 'Experience not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate experience: ' . $e->getMessage());
            Log::critical('duplicateExperience: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadExperiences() // <<< UBAH NAMA METODE ini
    {
        Log::info('loadExperiences: Memuat pengalaman untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['experiences'])) {
                $loadedExperiences = $resume->resume_data['experiences'];
                $this->experiences = collect($loadedExperiences)->map(function ($entry) {
                    if (!isset($entry['id'])) {
                        $entry['id'] = (string) Str::uuid(); // Beri ID jika belum ada
                    }
                    // Pastikan semua field yang ada di $this->form diinisialisasi
                    foreach ($this->form as $key => $defaultValue) {
                         if (!isset($entry[$key])) {
                             $entry[$key] = $defaultValue;
                         }
                    }
                    // Pastikan is_current adalah boolean
                    $entry['is_current'] = (bool) ($entry['is_current'] ?? false); // <<< Pastikan is_current boolean
                    return $entry;
                })->all();
            } else {
                $this->experiences = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadExperiences: Gagal memuat pengalaman dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->experiences = [];
        }
    }

    private function saveExperiencesToDatabase() // <<< UBAH NAMA METODE ini
    {
        Log::info('saveExperiencesToDatabase: Menyimpan properti pengalaman ke database.', ['resumeId' => $this->resumeId, 'experiences' => $this->experiences]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveExperiencesToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['experiences'] = $this->experiences; // Simpan seluruh array pengalaman
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveExperiencesToDatabase: Gagal menyimpan pengalaman ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save experience changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.experience-form');
    }
}