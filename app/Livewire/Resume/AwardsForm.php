<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str; // Untuk UUID
use Illuminate\Support\Facades\Log;

class AwardsForm extends Component
{
    public $resumeId;
    public $awards = [];

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingAwardId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'name' => '', // Nama Penghargaan
        'awarding_organization' => '', // Pemberi Penghargaan
        'date_received' => '', // Tanggal Diterima
        'description' => '', // Deskripsi (opsional)
    ];

    protected $listeners = [
        'refreshAwards' => 'loadAwards', // Untuk memuat ulang dari database
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadAwards(); // Muat data penghargaan saat komponen diinisialisasi
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.name' => 'required|string|max:255',
            'form.awarding_organization' => 'required|string|max:255',
            'form.date_received' => 'required|date',
            'form.description' => 'nullable|string',
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'form.name.required' => 'Award Name is required.',
            'form.awarding_organization.required' => 'Awarding Organization is required.',
            'form.date_received.required' => 'Date Received is required.',
        ];
    }

    // --- Metode Modal ---
    public function openModal($awardId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($awardId) {
            $this->editingAwardId = $awardId;
            $award = collect($this->awards)->firstWhere('id', $awardId);
            if ($award) {
                // Populate form fields from existing award
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $award[$key] ?? $defaultValue;
                }
            } else {
                session()->flash('error', 'Award entry not found for editing.');
                return;
            }
        } else {
            $this->editingAwardId = null; // Menambah baru
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
            'name' => '',
            'awarding_organization' => '',
            'date_received' => '',
            'description' => '',
        ];
    }

    // --- Metode CRUD ---
    public function saveAward()
    {
        $this->validate();

        Log::info('saveAward: Memulai proses penyimpanan penghargaan.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            if ($this->editingAwardId) {
                // Update Award
                $index = collect($this->awards)->search(function ($item) {
                    return $item['id'] === $this->editingAwardId;
                });
                if ($index !== false) {
                    $this->awards[$index] = $this->form;
                    session()->flash('success', 'Award entry updated successfully!');
                } else {
                    Log::warning('saveAward: Entri penghargaan tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingAwardId]);
                }
            } else {
                // Add New Award
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->awards[] = $this->form;
                session()->flash('success', 'Award entry added successfully!');
            }

            $this->saveAwardsToDatabase(); // Simpan ke database
            $this->loadAwards(); // Muat ulang properti dari DB
            $this->dispatch('awardsUpdated', $this->awards); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save award: ' . $e->getMessage());
            Log::critical('saveAward: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeAward($awardId)
    {
        Log::info('removeAward: Menghapus entri penghargaan.', ['resumeId' => $this->resumeId, 'awardId' => $awardId]);

        try {
            $originalCount = count($this->awards);
            $this->awards = collect($this->awards)->filter(function ($award) use ($awardId) {
                return $award['id'] !== $awardId;
            })->values()->all(); // Reset keys

            if (count($this->awards) < $originalCount) {
                $this->saveAwardsToDatabase();
                $this->loadAwards();
                $this->dispatch('awardsUpdated', $this->awards);
                session()->flash('success', 'Award entry deleted successfully!');
            } else {
                session()->flash('error', 'Award entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete award: ' . $e->getMessage());
            Log::critical('removeAward: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateAward($awardId)
    {
        Log::info('duplicateAward: Menduplikasi entri penghargaan.', ['resumeId' => $this->resumeId, 'awardId' => $awardId]);

        try {
            $originalAward = collect($this->awards)->firstWhere('id', $awardId);

            if ($originalAward) {
                $duplicatedAward = $originalAward;
                $duplicatedAward['id'] = (string) Str::uuid();
                $duplicatedAward['name'] = $originalAward['name'] . ' (Copy)'; // Tambahkan (Copy) pada nama

                $this->awards[] = $duplicatedAward;

                $this->saveAwardsToDatabase();
                $this->loadAwards();
                $this->dispatch('awardsUpdated', $this->awards);

                session()->flash('success', 'Award entry duplicated successfully!');
            } else {
                session()->flash('error', 'Award entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate award: ' . $e->getMessage());
            Log::critical('duplicateAward: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadAwards()
    {
        Log::info('loadAwards: Memuat penghargaan untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['awards'])) {
                $loadedAwards = $resume->resume_data['awards'];
                 $this->awards = collect($loadedAwards)->map(function ($award) {
                    if (!isset($award['id'])) {
                        $award['id'] = (string) Str::uuid(); // Beri ID jika belum ada
                    }
                    // Pastikan semua field yang ada di $this->form diinisialisasi
                    foreach ($this->form as $key => $defaultValue) {
                         if (!isset($award[$key])) {
                             $award[$key] = $defaultValue;
                         }
                    }
                    return $award;
                })->all();
            } else {
                $this->awards = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadAwards: Gagal memuat penghargaan dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->awards = [];
        }
    }

    private function saveAwardsToDatabase()
    {
        Log::info('saveAwardsToDatabase: Menyimpan properti penghargaan ke database.', ['resumeId' => $this->resumeId, 'awards' => $this->awards]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveAwardsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['awards'] = $this->awards; // Simpan seluruh array penghargaan
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveAwardsToDatabase: Gagal menyimpan penghargaan ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save award changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.awards-form');
    }
}