<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str; // Untuk UUID
use Illuminate\Support\Facades\Log;

class VolunteeringForm extends Component
{
    public $resumeId;
    public $volunteeringExperiences = [];

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingVolunteeringId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'organization_name' => '', // Nama Organisasi
        'role' => '', // Peran Anda
        'start_date' => '',
        'end_date' => '',
        'is_current' => false, // Untuk pengalaman sukarela yang sedang berjalan
        'description' => '', // Deskripsi tanggung jawab/pencapaian
    ];

    protected $listeners = [
        'refreshVolunteering' => 'loadVolunteeringExperiences', // Untuk memuat ulang dari database
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadVolunteeringExperiences(); // Muat data pengalaman sukarela saat komponen diinisialisasi
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.organization_name' => 'required|string|max:255',
            'form.role' => 'required|string|max:255',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.is_current' => 'boolean',
            'form.description' => 'nullable|string',
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'form.organization_name.required' => 'Organization Name is required.',
            'form.role.required' => 'Your Role is required.',
            'form.start_date.required' => 'Start Date is required.',
            'form.end_date.after_or_equal' => 'End Date must be after or equal to Start Date.',
        ];
    }

    // --- Metode Modal ---
    public function openModal($volunteeringId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($volunteeringId) {
            $this->editingVolunteeringId = $volunteeringId;
            $volunteering = collect($this->volunteeringExperiences)->firstWhere('id', $volunteeringId);
            if ($volunteering) {
                // Populate form fields from existing entry
                foreach ($this->form as $key => $defaultValue) {
                    // Handle 'is_current' checkbox to ensure it's boolean
                    if ($key === 'is_current') {
                        $this->form[$key] = (bool) ($volunteering[$key] ?? false);
                    } else {
                        $this->form[$key] = $volunteering[$key] ?? $defaultValue;
                    }
                }
            } else {
                session()->flash('error', 'Volunteering entry not found for editing.');
                return;
            }
        } else {
            $this->editingVolunteeringId = null; // Menambah baru
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetErrorBag();
    }

    protected function resetForm()
    {
        $this->form = [
            'id' => null,
            'organization_name' => '',
            'role' => '',
            'start_date' => '',
            'end_date' => '',
            'is_current' => false,
            'description' => '',
        ];
    }

    // Hook: Ketika properti form.is_current berubah, atur end_date menjadi kosong
    public function updatedFormIsCurrent($value)
    {
        if ($value) {
            $this->form['end_date'] = ''; // Kosongkan end_date jika sedang berjalan
        }
    }

    // --- Metode CRUD ---
    public function saveVolunteering()
    {
        // Validasi, kecuali end_date jika is_current true
        $rules = $this->rules();
        if ($this->form['is_current']) {
            unset($rules['form.end_date']);
        }
        $this->validate($rules);

        Log::info('saveVolunteering: Memulai proses penyimpanan pengalaman sukarela.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            if ($this->editingVolunteeringId) {
                // Update Volunteering Experience
                $index = collect($this->volunteeringExperiences)->search(function ($item) {
                    return $item['id'] === $this->editingVolunteeringId;
                });
                if ($index !== false) {
                    $this->volunteeringExperiences[$index] = $this->form;
                    session()->flash('success', 'Volunteering entry updated successfully!');
                } else {
                    Log::warning('saveVolunteering: Entri sukarela tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingVolunteeringId]);
                }
            } else {
                // Add New Volunteering Experience
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->volunteeringExperiences[] = $this->form;
                session()->flash('success', 'Volunteering entry added successfully!');
            }

            $this->saveVolunteeringExperiencesToDatabase(); // Simpan ke database
            $this->loadVolunteeringExperiences(); // Muat ulang properti dari DB
            $this->dispatch('volunteeringUpdated', $this->volunteeringExperiences); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save volunteering entry: ' . $e->getMessage());
            Log::critical('saveVolunteering: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeVolunteering($volunteeringId)
    {
        Log::info('removeVolunteering: Menghapus entri pengalaman sukarela.', ['resumeId' => $this->resumeId, 'volunteeringId' => $volunteeringId]);

        try {
            $originalCount = count($this->volunteeringExperiences);
            $this->volunteeringExperiences = collect($this->volunteeringExperiences)->filter(function ($volunteering) use ($volunteeringId) {
                return $volunteering['id'] !== $volunteeringId;
            })->values()->all(); // Reset keys

            if (count($this->volunteeringExperiences) < $originalCount) {
                $this->saveVolunteeringExperiencesToDatabase();
                $this->loadVolunteeringExperiences();
                $this->dispatch('volunteeringUpdated', $this->volunteeringExperiences);
                session()->flash('success', 'Volunteering entry deleted successfully!');
            } else {
                session()->flash('error', 'Volunteering entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete volunteering entry: ' . $e->getMessage());
            Log::critical('removeVolunteering: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateVolunteering($volunteeringId)
    {
        Log::info('duplicateVolunteering: Menduplikasi entri pengalaman sukarela.', ['resumeId' => $this->resumeId, 'volunteeringId' => $volunteeringId]);

        try {
            $originalVolunteering = collect($this->volunteeringExperiences)->firstWhere('id', $volunteeringId);

            if ($originalVolunteering) {
                $duplicatedVolunteering = $originalVolunteering;
                $duplicatedVolunteering['id'] = (string) Str::uuid();
                $duplicatedVolunteering['organization_name'] = $originalVolunteering['organization_name'] . ' (Copy)'; // Tambahkan (Copy) pada nama

                $this->volunteeringExperiences[] = $duplicatedVolunteering;

                $this->saveVolunteeringExperiencesToDatabase();
                $this->loadVolunteeringExperiences();
                $this->dispatch('volunteeringUpdated', $this->volunteeringExperiences);

                session()->flash('success', 'Volunteering entry duplicated successfully!');
            } else {
                session()->flash('error', 'Volunteering entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate volunteering entry: ' . $e->getMessage());
            Log::critical('duplicateVolunteering: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadVolunteeringExperiences()
    {
        Log::info('loadVolunteeringExperiences: Memuat pengalaman sukarela untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['volunteering'])) {
                $loadedVolunteering = $resume->resume_data['volunteering'];
                $this->volunteeringExperiences = collect($loadedVolunteering)->map(function ($entry) {
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
                    $entry['is_current'] = (bool) ($entry['is_current'] ?? false);
                    return $entry;
                })->all();
            } else {
                $this->volunteeringExperiences = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadVolunteeringExperiences: Gagal memuat pengalaman sukarela dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->volunteeringExperiences = [];
        }
    }

    private function saveVolunteeringExperiencesToDatabase()
    {
        Log::info('saveVolunteeringExperiencesToDatabase: Menyimpan properti pengalaman sukarela ke database.', ['resumeId' => $this->resumeId, 'volunteeringExperiences' => $this->volunteeringExperiences]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveVolunteeringExperiencesToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['volunteering'] = $this->volunteeringExperiences; // Simpan seluruh array pengalaman sukarela
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveVolunteeringExperiencesToDatabase: Gagal menyimpan pengalaman sukarela ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save volunteering changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.volunteering-form');
    }
}