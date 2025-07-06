<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class report_job extends Model
{
    use HasFactory;

    protected $table = 'report_job';

    protected $fillable = [
        'job_id',
        'employee_id',
        'report_reason',
        'detail_reason',
    ];

    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_id');
        
    }
    public function employee()
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }
}
