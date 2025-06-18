<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // Untuk UUID

class SkillsForm extends Component
{
    public $resumeId;
    public $skills = [
        'technical_skills' => [],
        'soft_skills' => [],
        'languages' => [],
    ];

    public $showModal = false;
    public $editingSkillId = null; // null for add, ID for edit

    public $form = [
        'id' => null,
        'category' => 'technical_skills', // <<< DEFAULT CATEGORY SAAT ADD BARU
        'name' => '',
        'level' => 'Proficient',
    ];

    // Daftar pilihan kategori skill
    public $skillCategories = [
        'technical_skills' => 'Technical Skill',
        'soft_skills' => 'Soft Skill',
        'languages' => 'Language',
    ];

    // Daftar pilihan level skill (termasuk untuk bahasa)
    public $allSkillLevels = [
        'Expert',
        'Proficient',
        'Intermediate',
        'Basic',
    ];

    public $languageLevels = [ // Pisahkan untuk validasi atau UI yang berbeda
        'Native',
        'Fluent',
        'Proficient',
        'Intermediate',
        'Basic',
    ];


    protected $listeners = [
        'refreshSkills' => 'loadSkills',
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadSkills();
    }

    // --- Validasi ---
    protected function rules()
    {
        // Aturan validasi dinamis berdasarkan kategori
        $rules = [
            'form.category' => 'required|in:' . implode(',', array_keys($this->skillCategories)),
            'form.name' => 'required|string|max:255',
        ];

        // Validasi level tergantung pada kategori yang dipilih
        if ($this->form['category'] === 'languages') {
            $rules['form.level'] = 'required|in:' . implode(',', $this->languageLevels);
        } else {
            $rules['form.level'] = 'required|in:' . implode(',', $this->allSkillLevels);
        }

        return $rules;
    }

    // --- Metode Modal ---
    public function openModal($skillId = null, $category = null)
    {
        $this->resetErrorBag();
        $this->resetForm(); // Reset form ke default

        if ($skillId && $category && isset($this->skills[$category])) {
            $this->editingSkillId = $skillId;
            $skill = collect($this->skills[$category])->firstWhere('id', $skillId);

            if ($skill) {
                // Populate form fields from existing skill
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $skill[$key] ?? $defaultValue;
                }
                $this->form['category'] = $category; // Pastikan kategori juga diset saat edit
            } else {
                session()->flash('error', 'Skill entry not found for editing.');
                return;
            }
        } else {
            $this->editingSkillId = null; // Menambah baru
            // Set default category dan level saat menambahkan
            $this->form['category'] = 'technical_skills'; // Default
            $this->form['level'] = 'Proficient'; // Default
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
            'category' => 'technical_skills', // Reset ke default
            'name' => '',
            'level' => 'Proficient', // Reset ke default
        ];
    }

    // Metode untuk mendapatkan daftar level yang sesuai berdasarkan kategori yang dipilih
    public function getAvailableLevelsProperty()
    {
        return $this->form['category'] === 'languages' ? $this->languageLevels : $this->allSkillLevels;
    }

    // Hook: Ketika properti form.category berubah (via wire:model), set default level
    public function updatedFormCategory($value)
    {
        if ($value === 'languages') {
            $this->form['level'] = 'Fluent'; // Default level untuk bahasa
        } else {
            $this->form['level'] = 'Proficient'; // Default level untuk skill lainnya
        }
    }


    // --- Metode CRUD ---
    public function saveSkill()
    {
        $this->validate();

        $selectedCategory = $this->form['category'];
        Log::info('saveSkill: Memulai proses penyimpanan skill.', ['resumeId' => $this->resumeId, 'form' => $this->form, 'category' => $selectedCategory]);

        try {
            // Hapus skill lama jika ada perubahan kategori saat editing
            if ($this->editingSkillId) {
                // Cari skill di semua kategori untuk dihapus
                foreach ($this->skills as $catKey => $catSkills) {
                    $index = collect($catSkills)->search(function ($item) {
                        return $item['id'] === $this->editingSkillId;
                    });
                    if ($index !== false) {
                        // Jika skill ditemukan di kategori lain, hapus dari sana
                        if ($catKey !== $selectedCategory) {
                             $this->skills[$catKey] = collect($catSkills)->filter(function($skill) use ($index) {
                                return $skill['id'] !== $this->editingSkillId;
                             })->values()->all();
                             Log::info('saveSkill: Skill dipindahkan dari kategori lama.', ['old_category' => $catKey, 'skillId' => $this->editingSkillId]);
                        } else {
                            // Jika kategori sama, update di tempat
                            $this->skills[$selectedCategory][$index] = [
                                'id' => $this->form['id'], // Pertahankan ID
                                'name' => $this->form['name'],
                                'level' => $this->form['level'],
                            ];
                            session()->flash('success', 'Skill entry updated successfully!');
                        }
                        break; // Berhenti setelah menemukan dan memproses skill
                    }
                }
                 // Jika skill tidak ditemukan atau dipindahkan, tambahkan saja ke kategori baru jika belum ada
                if (collect($this->skills[$selectedCategory])->firstWhere('id', $this->form['id']) === null) {
                    $this->skills[$selectedCategory][] = [
                        'id' => $this->form['id'],
                        'name' => $this->form['name'],
                        'level' => $this->form['level'],
                    ];
                    session()->flash('success', 'Skill entry updated and moved to new category successfully!');
                }

            } else {
                // Add New Skill
                $this->form['id'] = (string) Str::uuid(); // Beri ID unik
                $this->skills[$selectedCategory][] = [
                    'id' => $this->form['id'],
                    'name' => $this->form['name'],
                    'level' => $this->form['level'],
                ];
                session()->flash('success', 'Skill entry added successfully!');
            }

            $this->saveSkillsToDatabase();
            $this->loadSkills();
            $this->dispatch('skillsUpdated', $this->skills);

            $this->closeModal();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save skill: ' . $e->getMessage());
            Log::critical('saveSkill: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }


    public function removeSkill($skillId, $category)
    {
        Log::info('removeSkill: Menghapus entri skill.', ['resumeId' => $this->resumeId, 'skillId' => $skillId, 'category' => $category]);
        if (!isset($this->skills[$category])) {
            session()->flash('error', 'Invalid skill category for deletion.');
            return;
        }

        try {
            $originalCount = count($this->skills[$category]);
            $this->skills[$category] = collect($this->skills[$category])->filter(function ($skill) use ($skillId) {
                return $skill['id'] !== $skillId;
            })->values()->all();

            if (count($this->skills[$category]) < $originalCount) {
                $this->saveSkillsToDatabase();
                $this->loadSkills();
                $this->dispatch('skillsUpdated', $this->skills);
                session()->flash('success', 'Skill entry deleted successfully!');
            } else {
                session()->flash('error', 'Skill entry not found for deletion.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete skill: ' . $e->getMessage());
            Log::critical('removeSkill: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function duplicateSkill($skillId, $category)
    {
        Log::info('duplicateSkill: Menduplikasi entri skill.', ['resumeId' => $this->resumeId, 'skillId' => $skillId, 'category' => $category]);
        if (!isset($this->skills[$category])) {
            session()->flash('error', 'Invalid skill category for duplication.');
            return;
        }

        try {
            $originalSkill = collect($this->skills[$category])->firstWhere('id', $skillId);

            if ($originalSkill) {
                $duplicatedSkill = $originalSkill;
                $duplicatedSkill['id'] = (string) Str::uuid();
                $duplicatedSkill['name'] = $originalSkill['name'] . ' (Copy)';

                $this->skills[$category][] = $duplicatedSkill;

                $this->saveSkillsToDatabase();
                $this->loadSkills();
                $this->dispatch('skillsUpdated', $this->skills);

                session()->flash('success', 'Skill entry duplicated successfully!');
            } else {
                session()->flash('error', 'Skill entry not found for duplication.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to duplicate skill: ' . $e->getMessage());
            Log::critical('duplicateSkill: Terjadi kesalahan fatal.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    // --- Metode Bantuan untuk Memuat/Menyimpan ---
    public function loadSkills()
    {
        Log::info('loadSkills: Memuat skill untuk resume.', ['resumeId' => $this->resumeId]);
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['skills'])) {
                $loadedSkills = $resume->resume_data['skills'];

                foreach (['technical_skills', 'soft_skills', 'languages'] as $category) {
                    if (isset($loadedSkills[$category]) && is_array($loadedSkills[$category])) {
                        $this->skills[$category] = collect($loadedSkills[$category])->map(function($skill) use ($category) {
                            if (!isset($skill['id'])) {
                                $skill['id'] = (string) Str::uuid();
                            }
                            if (!isset($skill['name'])) $skill['name'] = '';
                            if (!isset($skill['level'])) $skill['level'] = 'Proficient';
                            $skill['category'] = $category; // Tambahkan category ke data skill
                            return $skill;
                        })->all();
                    } else {
                        $this->skills[$category] = [];
                    }
                }
            } else {
                $this->skills = [
                    'technical_skills' => [],
                    'soft_skills' => [],
                    'languages' => [],
                ];
            }
        } catch (\Exception $e) {
            Log::critical('loadSkills: Gagal memuat skill dari database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            $this->skills = [
                'technical_skills' => [],
                'soft_skills' => [],
                'languages' => [],
            ];
        }
    }

    private function saveSkillsToDatabase()
    {
        Log::info('saveSkillsToDatabase: Menyimpan properti skill ke database.', ['resumeId' => $this->resumeId, 'skills' => $this->skills]);
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                Log::error('saveSkillsToDatabase: Resume tidak ditemukan.', ['resumeId' => $this->resumeId]);
                session()->flash('error', 'Failed to save: Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['skills'] = $this->skills;
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            Log::critical('saveSkillsToDatabase: Gagal menyimpan skill ke database.', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            session()->flash('error', 'Failed to save skill changes.');
        }
    }

    public function render()
    {
        return view('livewire.resume.skills-form');
    }
}