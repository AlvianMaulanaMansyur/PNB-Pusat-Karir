<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume;
use Illuminate\Support\Str;

class EducationForm extends Component
{
    public $resumeId;
    public $educations = [];

    public $showModal = false;
    public $editingEducationId = null;

    public $form = [
        'id' => null,
        'institution' => '',
        'sertifications' => '',
        'degrees' => '',
        'dicipline' => '',
        'end_date' => '',
        'description' => '',
    ];

    protected $listeners = [
        'refreshEducations' => 'loadEducations',
    ];

    public function mount($id)
    {
        $this->resumeId = $id;
        $this->loadEducations();
    }

    protected function rules()
    {
        return [
            'form.institution' => 'required|string|max:255',
            'form.sertifications' => 'nullable|string|max:255',
            'form.degrees' => 'nullable|string|max:255',
            'form.dicipline' => 'nullable|string|max:255',
            'form.end_date' => 'nullable|date',
            'form.description' => 'nullable|string|max:1000',
        ];
    }

    public function openModal($educationId = null)
    {
        $this->resetErrorBag();
        $this->resetForm();

        if ($educationId) {
            $this->editingEducationId = $educationId;
            $education = collect($this->educations)->firstWhere('id', $educationId);

            if ($education) {
                foreach ($this->form as $key => $defaultValue) {
                    $this->form[$key] = $education[$key] ?? $defaultValue;
                }
            } else {
                session()->flash('error', 'Education not found.');
                return;
            }
        } else {
            $this->editingEducationId = null;
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
            'institution' => '',
            'sertifications' => '',
            'degrees' => '',
            'dicipline' => '',
            'end_date' => '',
            'description' => '',
        ];
    }

    public function saveEducation()
    {
        $this->validate();

        if ($this->editingEducationId) {
            $index = collect($this->educations)->search(fn($item) => $item['id'] === $this->editingEducationId);
            if ($index !== false) {
                $this->educations[$index] = $this->form;
                session()->flash('success', 'Education updated.');
            }
        } else {
            $this->form['id'] = (string) Str::uuid();
            $this->educations[] = $this->form;
            session()->flash('success', 'Education added.');
        }

        $this->saveEducationsToDatabase();
        $this->loadEducations();
        $this->dispatch('educationsUpdated', $this->educations);
        $this->closeModal();
    }

    public function removeEducation($educationId)
    {
        $this->educations = collect($this->educations)->reject(fn($edu) => $edu['id'] === $educationId)->values()->all();
        $this->saveEducationsToDatabase();
        $this->loadEducations();
        $this->dispatch('educationsUpdated', $this->educations);
        session()->flash('success', 'Education deleted.');
    }

    public function duplicateEducation($educationId)
    {
        $original = collect($this->educations)->firstWhere('id', $educationId);
        if ($original) {
            $copy = $original;
            $copy['id'] = (string) Str::uuid();
            $copy['degrees'] .= ' (Copy)';
            $this->educations[] = $copy;

            $this->saveEducationsToDatabase();
            $this->loadEducations();
            $this->dispatch('educationsUpdated', $this->educations);
            session()->flash('success', 'Education duplicated.');
        }
    }

    public function loadEducations()
    {
        $resume = Resume::find($this->resumeId);
        $this->educations = collect($resume->resume_data['educations'] ?? [])->map(function ($entry) {
            $entry['id'] = $entry['id'] ?? (string) Str::uuid();
            return array_merge($this->form, $entry);
        })->all();
    }

    private function saveEducationsToDatabase()
    {
        $resume = Resume::find($this->resumeId);
        if ($resume) {
            $data = $resume->resume_data ?? [];
            $data['educations'] = $this->educations;
            $resume->resume_data = $data;
            $resume->save();
        }
    }

    public function render()
    {
        return view('livewire.resume.education-form');
    }
}
