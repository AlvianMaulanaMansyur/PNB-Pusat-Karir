<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str; // Untuk UUID
use Illuminate\Support\Facades\Log;

class ProjectsForm extends Component
{
    public $resumeId;
    public $projects = [];

    // Properti untuk modal dan form input
    public $showModal = false;
    public $editingProjectId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'project_name' => '',
        'role' => '', // Opsional
        'start_date' => '',
        'end_date' => '',
        'is_current' => false, // Untuk proyek yang sedang berjalan
        'description' => '',
        'technologies_used' => '', // Akan dipecah menjadi array jika perlu
        'project_url' => '', // Link ke live demo atau website
        'github_url' => '', // Link ke GitHub repo
    ];

    protected $listeners = [
        'refreshProjects' => 'loadProjects', // Untuk memuat ulang dari database
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadProjects(); // Muat data proyek saat komponen diinisialisasi
    }

    // --- Validasi ---
    protected function rules()
    {
        return [
            'form.project_name' => 'required|string|max:255',
            'form.role' => 'nullable|string|max:255',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.is_current' => 'boolean',
            'form.description' => 'nullable|string',
            'form.technologies_used' => 'nullable|string|max:1000', // Contoh: "PHP, Laravel, Vue.js, MySQL"
            'form.project_url' => 'nullable|url|max:255',
            'form.github_url' => 'nullable|url|max:255',
        ];
    }

    // Custom validation messages
    protected function messages()
    {
        return [
            'form.project_name.required' => 'Project Name is required.',
            'form.start_date.required' => 'Start Date is required for the project.',
            'form.end_date.after_or_equal' => 'End Date must be after or equal to Start Date.',
            'form.project_url.url' => 'Project URL must be a valid URL.',
            'form.github_url.url' => 'GitHub URL must be a valid URL.',
        ];
    }

    // --- Metode Modal ---
    public function openModal($projectId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($projectId) {
            $this->editingProjectId = $projectId;
            $project = collect($this->projects)->firstWhere('id', $projectId);
            if ($project) {
                // Populate form fields from existing project
                foreach ($this->form as $key => $defaultValue) {
                    // Handle 'is_current' checkbox to ensure it's boolean
                    if ($key === 'is_current') {
                        $this->form[$key] = (bool) ($project[$key] ?? false);
                    } else {
                        $this->form[$key] = $project[$key] ?? $defaultValue;
                    }
                }
            } else {
                session()->flash('error', 'Project entry not found for editing.');
                return;
            }
        } else {
            $this->editingProjectId = null; // Menambah baru
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
            'project_name' => '',
            'role' => '',
            'start_date' => '',
            'end_date' => '',
            'is_current' => false,
            'description' => '',
            'technologies_used' => '',
            'project_url' => '',
            'github_url' => '',
        ];
    }

    // Hook: Ketika properti form.is_current berubah, atur end_date menjadi kosong
    public function updatedFormIsCurrent($value)
    {
        if ($value) {
            $this->form['end_date'] = ''; // Kosongkan end_date jika proyek sedang berjalan
        }
    }

    // --- Metode CRUD ---
    public function saveProject()
    {
        // Validasi, kecuali end_date jika is_current true
        $rules = $this->rules();
        if ($this->form['is_current']) {
            unset($rules['form.end_date']);
        }
        $this->validate($rules);

        Log::info('saveProject: Memulai proses penyimpanan proyek.', ['resumeId' => $this->resumeId, 'form' => $this->form]);

        try {
            if ($this->editingProjectId) {
                // Update Project
                $index = collect($this->projects)->search(function ($item) {
                    return $item['id'] === $this->editingProjectId;
                });
                if ($index !== false) {
                    $this->projects[$index] = $this->form;
                    session()->flash('success', 'Project entry updated successfully!');
                } else {
                    Log::warning('saveProject: Entri proyek tidak ditemukan untuk diperbarui.', ['missingId' => $this->editingProjectId]);
                }
            } else {
                // Add New Project
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->projects[] = $this->form;
                session()->flash('success', 'Project entry added successfully!');
            }

            $this->saveProjectsToDatabase(); // Simpan ke database
            $this->loadProjects(); // Muat ulang properti dari DB
            $this->dispatch('projectsUpdated', $this->projects); // Informasikan komponen lain (misal: ResumePreview)

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save project: ' . $e->getMessage());
            Log::critical('saveProject: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function removeProject($projectId)
    {
        Log::info('removeProject: Menghapus entri proyek.', ['resumeId' => $this->resumeId, 'projectId' => $projectId]);

        try {
            $originalCount = count($this->projects);
            $this->projects = collect($this->projects)->filter(function ($project) use ($projectId) {
                return $project['id'] !== $projectId;
            })->values()->all(); // Reset keys

            if (count($this->projects) < $originalCount) {
                $this->saveProjectsToDatabase();
                $this->loadProjects();
                $this->dispatch('projectsUpdated', $this->projects);
                session()->flash('success', 'Project entry deleted successfully!');
            } else {
                session()->flash('error', 'Project entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete project: ' . $e->getMessage());
            Log::critical('removeProject: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateProject($projectId)
    {
        Log::info('duplicateProject: Menduplikasi entri proyek.', ['resumeId' => $this->resumeId, 'projectId' => $projectId]);

        try {
            $originalProject = collect($this->projects)->firstWhere('id', $projectId);

            if ($originalProject) {
                $duplicatedProject = $originalProject;
                $duplicatedProject['id'] = (string) Str::uuid();
                $duplicatedProject['project_name'] = $originalProject['project_name'] . ' (Copy)'; // Tambahkan (Copy) pada nama

                $this->projects[] = $duplicatedProject;

                $this->saveProjectsToDatabase();
                $this->loadProjects();
                $this->dispatch('projectsUpdated', $this->projects);

                session()->flash('success', 'Project entry duplicated successfully!');
            } else {
                session()->flash('error', 'Project entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate project: ' . $e->getMessage());
            Log::critical('duplicateProject: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadProjects()
    {
        Log::info('loadProjects: Memuat proyek untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['projects'])) {
                $loadedProjects = $resume->resume_data['projects'];
                $this->projects = collect($loadedProjects)->map(function ($project) {
                    if (!isset($project['id'])) {
                        $project['id'] = (string) Str::uuid(); // Beri ID jika belum ada
                    }
                    // Pastikan semua field yang ada di $this->form diinisialisasi
                    foreach ($this->form as $key => $defaultValue) {
                         if (!isset($project[$key])) {
                             $project[$key] = $defaultValue;
                         }
                    }
                    // Pastikan is_current adalah boolean
                    $project['is_current'] = (bool) ($project['is_current'] ?? false);
                    return $project;
                })->all();
            } else {
                $this->projects = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadProjects: Gagal memuat proyek dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->projects = [];
        }
    }

    private function saveProjectsToDatabase()
    {
        Log::info('saveProjectsToDatabase: Menyimpan properti proyek ke database.', ['resumeId' => $this->resumeId, 'projects' => $this->projects]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveProjectsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['projects'] = $this->projects; // Simpan seluruh array proyek
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveProjectsToDatabase: Gagal menyimpan proyek ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save project changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.projects-form');
    }
}