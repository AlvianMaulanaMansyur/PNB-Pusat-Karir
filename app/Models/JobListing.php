<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobListing extends Model
{
    protected $table = 'job_listings';


    protected $fillable = [
        'slug',
        'employer_id',
        'nama_lowongan',
        'deskripsi',
        'posisi',
        'gaji',
        'kualifikasi',
        'benefit',
        'responsibility',
        'detailkualifikasi',
        'jenislowongan',
        'deadline',
        'poster',
    ];

    public function employer()
    {
        return $this->belongsTo(employers::class, 'employer_id');
    }
}
