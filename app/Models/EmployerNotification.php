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
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Relasi ke employer (jika diperlukan)
    public function employer()
    {
        return $this->belongsTo(employers::class);
    }
}
