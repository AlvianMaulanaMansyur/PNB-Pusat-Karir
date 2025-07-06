<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class portofoliopathimg extends Model
{
    use HasFactory;
    protected $table = 'portofolioPathImg';
    protected $fillable = [
        'employee_id',
        'job_id',
        'portofolio_path',
        'file_name'
    ];

    public function employee()
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }

    public function jobApplications()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
    }
}
