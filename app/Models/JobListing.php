<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class JobListing extends Model
{
    protected $table = 'job_listings';

    // Kolom-kolom yang bisa diisi secara mass-assignment
    protected $fillable = [
        'slug',
        'user_id',
        'nama_lowongan',
        'deskripsi',
        'posisi',
        'gaji',
        'kualifikasi',
        'benefit',
        'responsibility',
        'detailkualifikasi',
        'jenislowongan', // ✅ disesuaikan dengan input form
        'deadline',
        'poster'
    ];

    // Relasi ke tabel users (user yang membuat lowongan)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke employer jika kamu gunakan model employers terpisah
    public function employer()
    {
        return $this->belongsTo(employers::class, 'user_id', 'user_id');
    }

    // Relasi ke lamaran kerja (job applications)
    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'job_id');
    }

    // Relasi ke portofolio
    public function portofolio()
    {
        return $this->hasMany(portofoliopathimg::class, 'job_id');
    }

    public function reports()
    {
        return $this->hasMany(report_job::class, 'job_id');
    }
}
