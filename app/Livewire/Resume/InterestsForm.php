<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str; // Untuk UUID
use Illuminate\Support\Facades\Log;

class InterestsForm extends Component
{
    public $resumeId;
    public $interests = [];

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingInterestId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'interest' => '', // Nama Minat/Hobi
    ];

    protected $listeners = [
        'refreshInterests' => 'loadInterests', // Untuk memuat ulang dari database
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadInterests(); // Muat data minat saat komponen diinisialisasi
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.interest' => 'required|string|max:255',
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'form.interest.required' => 'Interest/Hobby is required.',
        ];
    }

    // --- Metode Modal ---
    public function openModal($interestId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($interestId) {
            $this->editingInterestId = $interestId;
            $interest = collect($this->interests)->firstWhere('id', $interestId);
            if ($interest) {
                // Populate form fields from existing interest
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $interest[$key] ?? $defaultValue;
                }
            } else {
                session()->flash('error', 'Interest entry not found for editing.');
                return;
            }
        } else {
            $this->editingInterestId = null; // Menambah baru
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
            'interest' => '',
        ];
    }

    // --- Metode CRUD ---
    public function saveInterest()
    {
        $this->validate();

        Log::info('saveInterest: Memulai proses penyimpanan minat.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            if ($this->editingInterestId) {
                // Update Interest
                $index = collect($this->interests)->search(function ($item) {
                    return $item['id'] === $this->editingInterestId;
                });
                if ($index !== false) {
                    $this->interests[$index] = $this->form;
                    session()->flash('success', 'Interest entry updated successfully!');
                } else {
                    Log::warning('saveInterest: Entri minat tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingInterestId]);
                }
            } else {
                // Add New Interest
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->interests[] = $this->form;
                session()->flash('success', 'Interest entry added successfully!');
            }

            $this->saveInterestsToDatabase(); // Simpan ke database
            $this->loadInterests(); // Muat ulang properti dari DB
            $this->dispatch('interestsUpdated', $this->interests); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save interest: ' . $e->getMessage());
            Log::critical('saveInterest: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeInterest($interestId)
    {
        Log::info('removeInterest: Menghapus entri minat.', ['resumeId' => $this->resumeId, 'interestId' => $interestId]);

        try {
            $originalCount = count($this->interests);
            $this->interests = collect($this->interests)->filter(function ($interest) use ($interestId) {
                return $interest['id'] !== $interestId;
            })->values()->all(); // Reset keys

            if (count($this->interests) < $originalCount) {
                $this->saveInterestsToDatabase();
                $this->loadInterests();
                $this->dispatch('interestsUpdated', $this->interests);
                session()->flash('success', 'Interest entry deleted successfully!');
            } else {
                session()->flash('error', 'Interest entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete interest: ' . $e->getMessage());
            Log::critical('removeInterest: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateInterest($interestId)
    {
        Log::info('duplicateInterest: Menduplikasi entri minat.', ['resumeId' => $this->resumeId, 'interestId' => $interestId]);

        try {
            $originalInterest = collect($this->interests)->firstWhere('id', $interestId);

            if ($originalInterest) {
                $duplicatedInterest = $originalInterest;
                $duplicatedInterest['id'] = (string) Str::uuid();
                $duplicatedInterest['interest'] = $originalInterest['interest'] . ' (Copy)'; // Tambahkan (Copy) pada nama

                $this->interests[] = $duplicatedInterest;

                $this->saveInterestsToDatabase();
                $this->loadInterests();
                $this->dispatch('interestsUpdated', $this->interests);

                session()->flash('success', 'Interest entry duplicated successfully!');
            } else {
                session()->flash('error', 'Interest entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate interest: ' . $e->getMessage());
            Log::critical('duplicateInterest: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadInterests()
    {
        Log::info('loadInterests: Memuat minat untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['interests'])) {
                $loadedInterests = $resume->resume_data['interests'];
                $this->interests = collect($loadedInterests)->map(function ($interest) {
                    if (!isset($interest['id'])) {
                        $interest['id'] = (string) Str::uuid(); // Beri ID jika belum ada
                    }
                    // Pastikan semua field yang ada di $this->form diinisialisasi
                    foreach ($this->form as $key => $defaultValue) {
                         if (!isset($interest[$key])) {
                             $interest[$key] = $defaultValue;
                         }
                    }
                    return $interest;
                })->all();
            } else {
                $this->interests = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadInterests: Gagal memuat minat dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->interests = [];
        }
    }

    private function saveInterestsToDatabase()
    {
        Log::info('saveInterestsToDatabase: Menyimpan properti minat ke database.', ['resumeId' => $this->resumeId, 'interests' => $this->interests]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveInterestsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['interests'] = $this->interests; // Simpan seluruh array minat
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveInterestsToDatabase: Gagal menyimpan minat ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save interest changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.interests-form');
    }
}