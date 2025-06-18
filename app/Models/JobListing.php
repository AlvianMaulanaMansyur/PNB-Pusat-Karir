<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $table = 'job_listings';

    protected $fillable = ['slug', 'user_id', 'nama_lowongan', 'deskripsi', 'posisi', 'gaji', 'kualifikasi', 'benefit', 'responsibility', 'detailkualifikasi', 'jenislowongan', 'deadline', 'poster'];

    public function employer()
    {
        return $this->belongsTo(employers::class, 'user_id', 'user_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }
}
