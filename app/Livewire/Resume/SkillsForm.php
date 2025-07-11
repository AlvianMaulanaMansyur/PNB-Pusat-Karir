<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SkillsForm extends Component
{
    public $resumeId;
    public $skills = [];

    public $showModal = false;
    public $editingSkillId = null;

    public $form = [
        'id' => null,
        'name' => '',
    ];

    protected $listeners = [
        'refreshSkills' => 'loadSkills',
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadSkills();
    }

    protected function rules()
    {
        return [
            'form.name' => 'required|string|max:255',
        ];
    }

    public function openModal($skillId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($skillId) {
            $this->editingSkillId = $skillId;
            $skill = collect($this->skills)->firstWhere('id', $skillId);

            if ($skill) {
                $this->form['id'] = $skill['id'];
                $this->form['name'] = $skill['name'];
            } else {
                session()->flash('error', 'Skill not found.');
                return;
            }
        } else {
            $this->editingSkillId = null;
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
        ];
    }

    public function saveSkill()
    {
        $this->validate();

        try {
            if ($this->editingSkillId) {
                $index = collect($this->skills)->search(fn($skill) => $skill['id'] === $this->editingSkillId);

                if ($index !== false) {
                    $this->skills[$index]['name'] = $this->form['name'];
                    session()->flash('success', 'Skill updated.');
                } else {
                    session()->flash('error', 'Skill not found for editing.');
                    return;
                }
            } else {
                $this->form['id'] = (string) Str::uuid();
                $this->skills[] = [
                    'id' => $this->form['id'],
                    'name' => $this->form['name'],
                ];
                session()->flash('success', 'Skill added.');
            }

            $this->saveSkillsToDatabase();
            $this->loadSkills();
            $this->dispatch('skillsUpdated', $this->skills);
            $this->closeModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving skill: ' . $e->getMessage());
            Log::critical('saveSkill error', ['error' => $e->getMessage()]);
        }
    }

    public function removeSkill($skillId)
    {
        try {
            $originalCount = count($this->skills);
            $this->skills = collect($this->skills)->filter(fn($skill) => $skill['id'] !== $skillId)->values()->all();

            if (count($this->skills) < $originalCount) {
                $this->saveSkillsToDatabase();
                $this->loadSkills();
                $this->dispatch('skillsUpdated', $this->skills);
                session()->flash('success', 'Skill deleted.');
            } else {
                session()->flash('error', 'Skill not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting skill: ' . $e->getMessage());
            Log::critical('removeSkill error', ['error' => $e->getMessage()]);
        }
    }

    public function duplicateSkill($skillId)
    {
        try {
            $original = collect($this->skills)->firstWhere('id', $skillId);

            if ($original) {
                $copy = $original;
                $copy['id'] = (string) Str::uuid();
                $copy['name'] .= ' (Copy)';
                $this->skills[] = $copy;

                $this->saveSkillsToDatabase();
                $this->loadSkills();
                $this->dispatch('skillsUpdated', $this->skills);
                session()->flash('success', 'Skill duplicated.');
            } else {
                session()->flash('error', 'Skill not found.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error duplicating skill: ' . $e->getMessage());
            Log::critical('duplicateSkill error', ['error' => $e->getMessage()]);
        }
    }

    public function loadSkills()
    {
        try {
            $resume = Resume::find($this->resumeId);
            if ($resume && is_array($resume->resume_data) && isset($resume->resume_data['skills'])) {
                $this->skills = collect($resume->resume_data['skills'])->map(function($skill) {
                    if (!isset($skill['id'])) $skill['id'] = (string) Str::uuid();
                    if (!isset($skill['name'])) $skill['name'] = '';
                    return $skill;
                })->all();
            } else {
                $this->skills = [];
            }
        } catch (\Exception $e) {
            Log::critical('loadSkills error', ['error' => $e->getMessage()]);
            $this->skills = [];
        }
    }

    private function saveSkillsToDatabase()
    {
        try {
            $resume = Resume::find($this->resumeId);
            if (!$resume) {
                session()->flash('error', 'Resume not found.');
                return;
            }

            $resumeData = is_array($resume->resume_data) ? $resume->resume_data : [];
            $resumeData['skills'] = $this->skills;
            $resume->resume_data = $resumeData;
            $resume->save();
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving skills.');
            Log::critical('saveSkillsToDatabase error', ['error' => $e->getMessage()]);
        }
    }

    public function render()
    {
        return view('livewire.resume.skills-form');
    }
}
