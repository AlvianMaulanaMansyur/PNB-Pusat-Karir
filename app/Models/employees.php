<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class employees extends Model
{

    use HasFactory, Notifiable;

    // protected $table = 'employees';

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
        'years_of_experience',
        'availability',
    ];
}
