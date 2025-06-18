<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume; // Pastikan Anda mengimpor model Resume
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Untuk UUID

class EducationForm extends Component
{
    public $resumeId;
    public $educations = []; // Properti publik untuk menampung data pendidikan

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingEducationId = null; // null for add, ID for edit

    public $form = [
        'id' => null, // Akan diisi dengan UUID saat menambah baru
        'institution' => '',
        'degree' => '',
        'field_of_study' => '',
        'start_date' => '',
        'end_date' => '',
        'is_current' => false, // <<< TAMBAHKAN INI
        'description' => '', // Untuk deskripsi tambahan atau penghargaan
        'gpa' => '', // Opsional: untuk IPK
    ];

    protected $listeners = [
        'refreshEducations' => 'loadEducations', // Untuk memuat ulang dari database
    ];

    // --- Lifecycle Hook ---
    public function mount($id) // Perbaiki parameter mount
    {
        $this->resumeId = $id;
        $this->loadEducations(); // Muat data pendidikan saat komponen diinisialisasi
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.institution' => 'required|string|max:255',
            'form.degree' => 'required|string|max:255',
            'form.field_of_study' => 'required|string|max:255',
            'form.start_date' => 'required|date',
            // Jika is_current true, end_date tidak diperlukan dan akan diabaikan
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.is_current' => 'boolean', // <<< TAMBAHKAN INI
            'form.description' => 'nullable|string|max:1000',
            'form.gpa' => 'nullable|numeric|min:0|max:4.0',
        ];
    }

    // Custom validation messages (opsional)
    protected function messages()
    {
        return [
            'form.institution.required' => 'Institution name is required.',
            'form.degree.required' => 'Degree is required.',
            'form.field_of_study.required' => 'Field of study is required.',
            'form.start_date.required' => 'Start date is required.',
            'form.start_date.date' => 'Start date must be a valid date.',
            'form.end_date.date' => 'End date must be a valid date.',
            'form.end_date.after_or_equal' => 'End date cannot be before start date.',
            'form.is_current.boolean' => 'Invalid value for "Currently Studying" field.', // <<< TAMBAHKAN INI
            'form.gpa.numeric' => 'GPA must be a number.',
            'form.gpa.min' => 'GPA cannot be negative.',
            'form.gpa.max' => 'GPA cannot exceed 4.0.',
        ];
    }

    // --- Pembaruan Properti (untuk interaksi checkbox) ---
    public function updatedFormIsCurrent($value)
    {
        // Jika 'is_current' diatur ke true, kosongkan end_date
        if ($value) {
            $this->form['end_date'] = null;
        }
    }

    // --- Metode Modal ---
    public function openModal($educationId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($educationId) {
            $this->editingEducationId = $educationId;
            $education = collect($this->educations)->firstWhere('id', $educationId);
            if ($education) {
                // Pastikan 'is_current' diinisialisasi dengan benar
                // Jika end_date kosong dan is_current tidak ada, anggap is_current true
                $education['is_current'] = $education['is_current'] ?? empty($education['end_date']);
                $this->form = $education;
                Log::info('openModal: Mengedit entri pendidikan.', ['educationId' => $educationId, 'form' => $this->form]);
            } else {
                session()->flash('error', 'Education entry not found for editing.');
                Log::warning('openModal: Entri pendidikan tidak ditemukan.', ['missingId' => $educationId, 'educations' => $this->educations]);
                return;
            }
        } else {
            $this->editingEducationId = null;
            Log::info('openModal: Menambah entri pendidikan baru.');
        }
        $this->showModal = true;
        $this->dispatch('toggle-body-scroll', ['action' => 'hide']);
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
        $this->resetErrorBag();
        $this->dispatch('toggle-body-scroll', ['action' => 'show']);
    }

    protected function resetForm()
    {
        $this->form = [
            'id' => null,
            'institution' => '',
            'degree' => '',
            'field_of_study' => '',
            'start_date' => '',
            'end_date' => '',
            'is_current' => false, // <<< RESET INI JUGA
            'description' => '',
            'gpa' => '',
        ];
    }

    // --- Metode CRUD ---
    public function saveEducation()
    {
        $this->validate();

        Log::info('saveEducation: Memulai proses penyimpanan pendidikan.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            // Jika "is_current" true, set end_date menjadi null sebelum disimpan
            if ($this->form['is_current']) {
                $this->form['end_date'] = null;
            }

            if ($this->editingEducationId) {
                $index = collect($this->educations)->search(function ($item) {
                    return $item['id'] === $this->editingEducationId;
                });
                if ($index !== false) {
                    $this->educations[$index] = $this->form;
                    session()->flash('success', 'Education entry updated successfully!');
                    Log::info('saveEducation: Entri pendidikan berhasil diperbarui.', ['updatedId' => $this->editingEducationId, 'newData' => $this->form]);
                } else {
                    session()->flash('error', 'Failed to update: Education entry not found.');
                    Log::warning('saveEducation: Entri pendidikan tidak ditemukan untuk diperbarui (setelah validasi).', ['missingId' => $this->editingEducationId]);
                    return;
                }
            } else {
                $this->form['id'] = (string) Str::uuid();
                $this->educations[] = $this->form;
                session()->flash('success', 'Education entry added successfully!');
                Log::info('saveEducation: Entri pendidikan baru berhasil ditambahkan.', ['newId' => $this->form['id'], 'newData' => $this->form]);
            }

            $this->saveEducationsToDatabase();
            // Tidak perlu loadEducations di sini, karena array $this->educations sudah terupdate
            $this->dispatch('educationsUpdated', $this->educations);

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('saveEducation: Validasi gagal.', ['errors' => $e->errors()]);
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save education: ' . $e->getMessage());
            Log::critical('saveEducation: Terjadi kesalahan fatal saat menyimpan.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeEducation($educationId)
    {
        Log::info('removeEducation: Menghapus entri pendidikan.', ['resumeId' => $this->resumeId, 'educationId' => $educationId]);
        try {
            $originalCount = count($this->educations);
            $this->educations = collect($this->educations)->filter(function ($edu) use ($educationId) {
                return $edu['id'] !== $educationId;
            })->values()->all();

            if (count($this->educations) < $originalCount) {
                $this->saveEducationsToDatabase();
                $this->dispatch('educationsUpdated', $this->educations);
                session()->flash('success', 'Education entry deleted successfully!');
                Log::info('removeEducation: Entri pendidikan berhasil dihapus.', ['deletedId' => $educationId]);
            } else {
                session()->flash('error', 'Education entry not found for deletion.');
                Log::warning('removeEducation: Entri pendidikan tidak ditemukan untuk dihapus.', ['missingId' => $educationId]);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete education: ' . $e->getMessage());
            Log::critical('removeEducation: Terjadi kesalahan fatal saat menghapus.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateEducation($educationId)
    {
        Log::info('duplicateEducation: Menduplikasi entri pendidikan.', ['resumeId' => $this->resumeId, 'educationId' => $educationId]);

        try {
            $originalEducation = collect($this->educations)->firstWhere('id', $educationId);

            if ($originalEducation) {
                $duplicatedEducation = $originalEducation;
                $duplicatedEducation['id'] = (string) Str::uuid();
                $duplicatedEducation['degree'] = ($originalEducation['degree'] ?? 'Degree') . ' (Copy)';
                // Pastikan status "is_current" juga diduplikasi atau diatur sesuai kebutuhan (misal: direset ke false)
                // Jika ingin duplikat selalu tidak "current", uncomment baris ini:
                // $duplicatedEducation['is_current'] = false;

                $this->educations[] = $duplicatedEducation;

                $this->saveEducationsToDatabase();
                $this->dispatch('educationsUpdated', $this->educations);

                session()->flash('success', 'Education entry duplicated successfully!');
                Log::info('duplicateEducation: Entri pendidikan berhasil diduplikasi.', ['originalId' => $educationId, 'newId' => $duplicatedEducation['id']]);
            } else {
                session()->flash('error', 'Education entry not found for duplication.');
                Log::warning('duplicateEducation: Entri pendidikan tidak ditemukan untuk duplikasi.', ['missingId' => $educationId]);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate education: ' . $e->getMessage());
            Log::critical('duplicateEducation: Terjadi kesalahan fatal saat menduplikasi.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadEducations()
    {
        Log::info('loadEducations: Memuat pendidikan untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['educations'])) {
                $loadedEducations = $resume->resume_data['educations'];
                // Pastikan 'is_current' diinisialisasi jika tidak ada di data lama
                $this->educations = array_map(function($edu) {
                    $edu['is_current'] = $edu['is_current'] ?? empty($edu['end_date']); // Set default true if end_date is empty
                    return $edu;
                }, $loadedEducations);
                Log::info('loadEducations: Pendidikan berhasil dimuat.', ['count' => count($this->educations)]);
            } else {
                $this->educations = [];
                Log::info('loadEducations: Tidak ada pendidikan di database atau data tidak valid, menginisialisasi kosong.');
            }
        } catch (\Exception $e) {
            Log::critical('loadEducations: Gagal memuat pendidikan dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->educations = [];
            session()->flash('error', 'Failed to load educations.');
        }
    }

    private function saveEducationsToDatabase()
    {
        Log::info('saveEducationsToDatabase: Menyimpan properti pendidikan ke database.', ['resumeId' => $this->resumeId, 'educationsCount' => count($this->educations)]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveEducationsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['educations'] = $this->educations;
            $resume->resume_data = $resumeData;
            $resume->save();

            Log::info('saveEducationsToDatabase: Pendidikan berhasil disimpan ke database.');
        } catch (\Exception $e) {
            Log::critical('saveEducationsToDatabase: Gagal menyimpan pendidikan ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save education changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.education-form');
    }
}