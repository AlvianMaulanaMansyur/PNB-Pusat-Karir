<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class educations extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'employee_id',
        'institution',
        'degrees',
        'dicipline',
        'end_date',
        'description',

    ];

     public function employee(): BelongsTo
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }
}

