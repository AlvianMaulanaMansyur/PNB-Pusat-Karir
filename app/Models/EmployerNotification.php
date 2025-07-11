<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'employer_id',
        'title',
        'message',
        'is_read',
        'sent_at', // <-- pastikan ini ada
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'sent_at' => 'datetime', // <-- Tambahkan ini untuk memastikan formatnya benar
    ];

    // Relasi ke employer (jika diperlukan)
    public function employer()
    {
        return $this->belongsTo(employers::class);
    }
}
