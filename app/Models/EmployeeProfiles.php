<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeProfiles extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'summary',
        'linkedin',
        'website'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }
}
