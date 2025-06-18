<?php

namespace App\Livewire\Resume;

use Livewire\Component;
use App\Models\Resume; // Import model Resume

class ResumeBuilder extends Component
{
    public Resume $resume;
    public $resumeId;
    public $resumeData = []; // Untuk menyimpan seluruh data resume (termasuk personal_details)

    // Properti untuk panel resizable (sesuai Alpine.js Anda)
    public $showLeftPanel = true;
    public $showRightPanel = true;
    public $leftWidth = 320; // Default width
    public $rightWidth = 280; // Default width
    public $minLeftWidth = 250;
    public $minRightWidth = 250;
    public $minMainContentWidth = 400; // Minimum for central preview
    public $isResizingLeft = false;
    public $isResizingRight = false;
    protected $listeners = [
        'updatePersonalDetails',
        'refreshResumeBuilder' => '$refresh', 
    ];

    public function mount($resume) 
    {
        $this->resume = $resume;
        $this->resumeId = $resume->id;
        $this->resumeData = $resume->resume_data;
        if (!is_array($this->resumeData)) {$this->resumeData = (array) $this->resumeData;}
    }

    public function updatePersonalDetails($updatedPersonalDetails)
    {
        $this->resumeData['personal_details'] = $updatedPersonalDetails;
    }

    public function startResize($panel)
    {
        if ($panel === 'left') {
            $this->isResizingLeft = true;
        } elseif ($panel === 'right') {
            $this->isResizingRight = true;
        }
    }

    public function stopResize()
    {
        $this->isResizingLeft = false;
        $this->isResizingRight = false;
    }

    public function toggleLeftPanel()
    {
        $this->showLeftPanel = !$this->showLeftPanel;
        if (!$this->showLeftPanel && !$this->showRightPanel) {
            $this->dispatchBrowserEvent('toggle-body-scroll', ['action' => 'show']);
        } else {
            $this->dispatchBrowserEvent('toggle-body-scroll', ['action' => 'hide']);
        }
    }

    public function toggleRightPanel()
    {
        $this->showRightPanel = !$this->showRightPanel;
        if (!$this->showLeftPanel && !$this->showRightPanel) {
            $this->dispatchBrowserEvent('toggle-body-scroll', ['action' => 'show']);
        } else {
            $this->dispatchBrowserEvent('toggle-body-scroll', ['action' => 'hide']);
        }
    }

    public function render()
    {
        return view('livewire.resume.resume-builder'); 
    }
}