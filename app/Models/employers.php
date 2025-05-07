<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class employers extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'company_name',
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
        'phone',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'business_registration_number',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', 
    ];
};
