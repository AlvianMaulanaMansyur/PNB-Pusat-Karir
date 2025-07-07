<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class employees extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'employees';

    protected $fillable = ['user_id', 'salutation', 'first_name', 'last_name', 'suffix', 'phone', 'photo_profile', 'country', 'city', 'highest_education', 'main_skill', 'current_or_previous_industry', 'current_or_previous_job_type', 'current_or_previous_position', 'employment_status', 'years_of_experience', 'availability', 'photo_profile'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class, 'employee_id');
    }
    
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    public function profile()
    {
        return $this->hasOne(EmployeeProfiles::class, 'employee_id');
    }
    public function educations()
    {
        return $this->hasMany(educations::class, 'employee_id');
    }

    public function reports(): HasMany
    {
        return $this->hasMany(report_job::class, 'employee_id');
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(work_experience::class, 'employee_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'employee_skill', 'employee_id', 'skill_id')->withTimestamps();
    }

    public function employeeSkills(): HasMany
    {
        return $this->hasMany(employee_skill::class, 'employee_id');
    }
}
