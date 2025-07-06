<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class work_experience extends Model
{
    use HasFactory;

    protected $table = 'work_experiences';
    protected $fillable = [
        'employee_id',
        'company',
        'position',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    public function employee()
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }
}
