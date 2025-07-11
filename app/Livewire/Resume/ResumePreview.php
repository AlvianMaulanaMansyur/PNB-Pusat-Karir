<?php

namespace App\Livewire\Resume;

use Livewire\Component;

class ResumePreview extends Component
{
    public $resumeData;

    // Tambahkan properti untuk foto profil dan preview
    public $profilePhotoUrl; // Ini akan menyimpan URL lengkap foto profil

    // Tambahkan listener untuk event 'personal-details-updated'
    // Nama metode harus 'namaEventCamelCase'
    protected $listeners = [
        'personalDetailsUpdated' => 'updatePersonalDetails',
        'experiencesUpdated' => 'updateExperiences', // Listener baru
        'educationsUpdated' => 'updateEducations',
        'skillsUpdated' => 'updateSkills',
        'projectsUpdated' => 'updateProjects',
        'certificationsUpdated' => 'updateCertifications',
        'awardsUpdated' => 'updateAwards',
        'volunteeringUpdated' => 'updateVolunteering',
        'interestsUpdated' => 'updateInterests',
    ];

    public function mount(array $resumeData = [])
    {
        $this->resumeData = $resumeData;

        if (isset($this->resumeData['personal_details']['profile_photo']) && !empty($this->resumeData['personal_details']['profile_photo'])) {
            $this->profilePhotoUrl = $this->resumeData['personal_details']['profile_photo'];
        } else {
            $this->profilePhotoUrl = null;
        }

        // Pastikan experiences diinisialisasi saat mount
        if (!isset($this->resumeData['experiences'])) {
            $this->resumeData['experiences'] = [];
        }

        if (!isset($this->resumeData['educations'])) {
            $this->resumeData['educations'] = [];
        }

        if (!isset($this->resumeData['skills'])) {
            $this->resumeData['skills'] = [];   
        }

        if (!isset($this->resumeData['projects'])) {
            $this->resumeData['projects'] = [];
        }

        if (!isset($this->resumeData['certifications'])) {
            $this->resumeData['certifications'] = [];
        }

        if (!isset($this->resumeData['awards'])) {
            $this->resumeData['awards'] = [];
        }

        if (!isset($this->resumeData['volunteering'])) {
            $this->resumeData['volunteering'] = [];
        }

        if (!isset($this->resumeData['interests'])) {
            $this->resumeData['interests'] = [];
        }
    }

    // Metode ini akan dipanggil ketika event 'personal-details-updated' diterima
    public function updatePersonalDetails($updatedPersonalDetails)
    {
        // Pastikan resumeData adalah array atau objek yang bisa dimanipulasi
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }

        // Perbarui hanya bagian personal_details dari resumeData
        $this->resumeData['personal_details'] = $updatedPersonalDetails;

        // Perbarui juga profilePhotoUrl
        if (isset($updatedPersonalDetails['profile_photo']) && !empty($updatedPersonalDetails['profile_photo'])) {
            $this->profilePhotoUrl = $updatedPersonalDetails['profile_photo'];
        } else {
            $this->profilePhotoUrl = null;
        }
    }

    public function updateExperiences($updatedExperiences)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['experiences'] = $updatedExperiences;
    }

    public function updateEducations($updatedEducations)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['educations'] = $updatedEducations;
    }

    public function updateSkills($updatedSkills)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['skills'] = $updatedSkills;
    }

    public function updateProjects($updatedProjects)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['projects'] = $updatedProjects;
    }

    public function updateCertifications($updatedCertifications)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['certifications'] = $updatedCertifications;
    }

    public function updateAwards($updatedAwards)
    {
         if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['awards'] = $updatedAwards;
    }

    public function updateVolunteering($updatedVolunteering)
    {
        if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['volunteering'] = $updatedVolunteering;
    }

    public function updateInterests($updatedInterests)
    {
         if (!is_array($this->resumeData)) {
            $this->resumeData = [];
        }
        $this->resumeData['interests'] = $updatedInterests;
    }
    public function render()
    {
        return view('livewire.resume.resume-preview');
    }
}