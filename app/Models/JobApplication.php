<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobApplication extends Model
{
    // Jika tabel bernama job_applications, tidak perlu deklarasi $table

    protected $fillable = [
        'job_id',
        'slug',
        'employee_id',
        'applied_at',
        'status',
        'cover_letter',
        'cv_file',
        'employer_notes',
        'interview_status',
        'interview_date',
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'interview_date' => 'datetime',
    ];

    // Relasi ke JobListing (job)
    public function job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }

    public function jobs()
    {
        return $this->hasMany(JobListing::class, 'user_id');
    }


    // Relasi ke Employee
    public function employee(): BelongsTo
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }


}
