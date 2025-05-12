<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class JobSeeker extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'salutation',
        'first_name',
        'last_name',
        'suffix',
        'phone',
        'country',
        'city',
        'highest_education',
        'main_skill',
        'current_or_previous_industry',
        'current_or_previous_job_type',
        'current_or_previous_position',
        'employment_status',
        'year_of_experience',
        'availability',
    ];
}
