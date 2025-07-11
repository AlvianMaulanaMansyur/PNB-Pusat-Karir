<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str;

class ExperienceForm extends Component
{
    public $resumeId;
    public $experiences = [];

    public $showModal = false;
    public $editingExperienceId = null;

    public $form = [
        'id' => null,
        'position' => '',
        'company' => '',
        'description' => '',
        'start_date' => '',
        'end_date' => '',
        'is_current' => false,
    ];

    protected $listeners = [
        'refreshExperiences' => 'loadExperiences',
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadExperiences();
    }

    protected function rules()
    {
        return [
            'form.position' => 'required|string|max:255',
            'form.company' => 'required|string|max:255',
            'form.start_date' => 'required|date',
            'form.end_date' => 'nullable|date|after_or_equal:form.start_date',
            'form.is_current' => 'boolean',
            'form.description' => 'nullable|string|max:1000',
        ];
    }

    public function openModal($experienceId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($experienceId) {
            $this->editingExperienceId = $experienceId;
            $experience = collect($this->experiences)->firstWhere('id', $experienceId);

            if ($experience) {
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $experience[$key] ?? $defaultValue;
                }
                $this->form['is_current'] = (bool) ($experience['is_current'] ?? false);
            } else {
                session()->flash('error', 'Pengalaman tidak ditemukan.');
                return;
            }
        } else {
            $this->editingExperienceId = null;
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
            'position' => '',
            'company' => '',
            'description' => '',
            'start_date' => '',
            'end_date' => '',
            'is_current' => false,
        ];
    }

    public function updatedFormIsCurrent($value)
    {
        if ($value) {
            $this->form['end_date'] = '';
        }
    }

    public function saveExperience()
    {
        $rules = $this->rules();
        if ($this->form['is_current']) {
            unset($rules['form.end_date']);
        }
        $this->validate($rules);

        if ($this->editingExperienceId) {
            $index = collect($this->experiences)->search(fn($item) => $item['id'] === $this->editingExperienceId);
            if ($index !== false) {
                $this->experiences[$index] = $this->form;
                session()->flash('success', 'Pengalaman diperbarui.');
            }
        } else {
            $this->form['id'] = (string) Str::uuid();
            $this->experiences[] = $this->form;
            session()->flash('success', 'Pengalaman ditambahkan.');
        }

        $this->saveExperiencesToDatabase();
        $this->loadExperiences();
        $this->dispatch('experiencesUpdated', $this->experiences);
        $this->closeModal();
    }

    public function removeExperience($experienceId)
    {
        $this->experiences = collect($this->experiences)->reject(fn($exp) => $exp['id'] === $experienceId)->values()->all();
        $this->saveExperiencesToDatabase();
        $this->loadExperiences();
        $this->dispatch('experiencesUpdated', $this->experiences);
        session()->flash('success', 'Pengalaman dihapus.');
    }

    public function duplicateExperience($experienceId)
    {
        $original = collect($this->experiences)->firstWhere('id', $experienceId);
        if ($original) {
            $copy = $original;
            $copy['id'] = (string) Str::uuid();
            $copy['position'] .= ' (Copy)';
            $this->experiences[] = $copy;

            $this->saveExperiencesToDatabase();
            $this->loadExperiences();
            $this->dispatch('experiencesUpdated', $this->experiences);
            session()->flash('success', 'Pengalaman diduplikasi.');
        }
    }

    public function loadExperiences()
    {
        $resume = Resume::find($this->resumeId);
        $this->experiences = collect($resume->resume_data['experiences'] ?? [])->map(function ($entry) {
            $entry['id'] = $entry['id'] ?? (string) Str::uuid();
            $entry['is_current'] = (bool) ($entry['is_current'] ?? false);
            return array_merge($this->form, $entry);
        })->all();
    }

    private function saveExperiencesToDatabase()
    {
        $resume = Resume::find($this->resumeId);
        if ($resume) {
            $data = $resume->resume_data ?? [];
            $data['experiences'] = $this->experiences;
            $resume->resume_data = $data;
            $resume->save();
        }
    }

    public function render()
    {
        return view('livewire.resume.experience-form');
    }
}