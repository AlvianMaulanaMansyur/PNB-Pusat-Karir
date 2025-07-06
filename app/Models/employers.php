<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class employers extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'slug',
        'company_name',
        'alamat_perusahaan',
        'business_registration_number',
        'industry',
        'company_website',
        'organization_type',
        'staff_strength',
        'country',
        'city',
        'company_profile',
        'salutation',
        'first_name',
        'last_name',
        'suffix',
        'job_title',
        'department',
        'photo_profile',
        'phone',
        'photo_profile',
        // 'password',
    ];

    protected $hidden = [
        'business_registration_number',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function jobs()
    {
        return $this->hasMany(JobListing::class, 'user_id');
    }
    public function jobListings()
    {
        return $this->hasMany(JobListing::class, 'user_id', 'user_id');
    }
    public function skills()
{
    return $this->belongsToMany(Skill::class, 'employee_skill', 'employee_id', 'skill_id');
}

};

