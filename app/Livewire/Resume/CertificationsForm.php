<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str; // Untuk UUID
use Illuminate\Support\Facades\Log;

class CertificationsForm extends Component
{
    public $resumeId;
    public $certifications = [];

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingCertificationId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'title' => '',
        'issuer' => '',
        'date_issued' => '',
        'expiry_date' => '',
        'description' => '',
    ];

    protected $listeners = [
        'refreshCertifications' => 'loadCertifications', // Untuk memuat ulang dari database
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadCertifications(); // Muat data sertifikasi saat komponen diinisialisasi
    }

    protected function rules()
    {
        return [
            'form.title' => 'required|string|max:255',
            'form.issuer' => 'required|string|max:255',
            'form.date_issued' => 'required|date',
            'form.expiry_date' => 'nullable|date|after_or_equal:form.date_issued',
            'form.description' => 'nullable|string|max:1000',
        ];
    }

    protected function messages()
    {
        return [
            'form.title.required' => 'Title is required.',
            'form.issuer.required' => 'Issuer is required.',
            'form.date_issued.required' => 'Date Issued is required.',
            'form.expiry_date.after_or_equal' => 'Expiry Date must be after or equal to Date Issued.',
            'form.description.max' => 'Description is too long.',
        ];
    }

    public function openModal($certificationId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($certificationId) {
            $this->editingCertificationId = $certificationId;
            $certification = collect($this->certifications)->firstWhere('id', $certificationId);
            if ($certification) {
                // Populate form fields from existing certification
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $certification[$key] ?? $defaultValue;
                }
            } else {
                session()->flash('error', 'Certification entry not found for editing.');
                return;
            }
        } else {
            $this->editingCertificationId = null; // Menambah baru
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
            'title' => '',
            'issuer' => '',
            'date_issued' => '',
            'expiry_date' => '',
            'description' => '',
        ];
    }

    public function saveCertification()
    {
        $this->validate();

        Log::info('saveCertification: Memulai proses penyimpanan sertifikasi.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            if ($this->editingCertificationId) {
                // Update Certification
                $index = collect($this->certifications)->search(function ($item) {
                    return $item['id'] === $this->editingCertificationId;
                });
                if ($index !== false) {
                    $this->certifications[$index] = $this->form;
                    session()->flash('success', 'Certification entry updated successfully!');
                } else {
                    Log::warning('saveCertification: Entri sertifikasi tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingCertificationId]);
                }
            } else {
                // Add New Certification
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->certifications[] = $this->form;
                session()->flash('success', 'Certification entry added successfully!');
            }

            $this->saveCertificationsToDatabase(); // Simpan ke database
            $this->loadCertifications(); // Muat ulang properti dari DB
            $this->dispatch('certificationsUpdated', $this->certifications); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save certification: ' . $e->getMessage());
            Log::critical('saveCertification: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeCertification($certificationId)
    {
        Log::info('removeCertification: Menghapus entri sertifikasi.', ['resumeId' => $this->resumeId, 'certificationId' => $certificationId]);

        try {
            $originalCount = count($this->certifications);
            $this->certifications = collect($this->certifications)->filter(function ($certification) use ($certificationId) {
                return $certification['id'] !== $certificationId;
            })->values()->all(); // Reset keys

            if (count($this->certifications) < $originalCount) {
                $this->saveCertificationsToDatabase();
                $this->loadCertifications();
                $this->dispatch('certificationsUpdated', $this->certifications);
                session()->flash('success', 'Certification entry deleted successfully!');
            } else {
                session()->flash('error', 'Certification entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete certification: ' . $e->getMessage());
            Log::critical('removeCertification: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateCertification($certificationId)
    {
        Log::info('duplicateCertification: Menduplikasi entri sertifikasi.', ['resumeId' => $this->resumeId, 'certificationId' => $certificationId]);

        try {
            $originalCertification = collect($this->certifications)->firstWhere('id', $certificationId);

            if ($originalCertification) {
                $duplicatedCertification = $originalCertification;
                $duplicatedCertification['id'] = (string) Str::uuid();
                $duplicatedCertification['name'] = $originalCertification['name'] . ' (Copy)'; // Tambahkan (Copy) pada nama

                $this->certifications[] = $duplicatedCertification;

                $this->saveCertificationsToDatabase();
                $this->loadCertifications();
                $this->dispatch('certificationsUpdated', $this->certifications);

                session()->flash('success', 'Certification entry duplicated successfully!');
            } else {
                session()->flash('error', 'Certification entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate certification: ' . $e->getMessage());
            Log::critical('duplicateCertification: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function loadCertifications()
    {
        Log::info('loadCertifications: Memuat sertifikasi untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['certifications'])) {
                $loadedCertifications = $resume->resume_data['certifications'];
                $this->certifications = collect($loadedCertifications)->map(function ($certification) {
                    if (!isset($certification['id'])) {
                        $certification['id'] = (string) Str::uuid(); // Beri ID jika belum ada
                    }
                    // Pastikan semua field yang ada di $this->form diinisialisasi
                    foreach ($this->form as $key => $defaultValue) {
                        if (!isset($certification[$key])) {
                            $certification[$key] = $defaultValue;
                        }
                    }
                    return $certification;
                })->all();
            } else {
                $this->certifications = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadCertifications: Gagal memuat sertifikasi dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->certifications = [];
        }
    }

    private function saveCertificationsToDatabase()
    {
        Log::info('saveCertificationsToDatabase: Menyimpan properti sertifikasi ke database.', ['resumeId' => $this->resumeId, 'certifications' => $this->certifications]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveCertificationsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['certifications'] = $this->certifications; // Simpan seluruh array sertifikasi
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveCertificationsToDatabase: Gagal menyimpan sertifikasi ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save certification changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.certifications-form');
    }
}
