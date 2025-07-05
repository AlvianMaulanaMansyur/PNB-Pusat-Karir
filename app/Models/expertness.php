<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class expertness extends Model
{
    use HasFactory;

    protected $table = 'expertness';
    protected $fillable = [
        'employee_id',
        'skill_name',
        'created_at',
        'updated_at',
    ];
    public function employee()
    {
        return $this->belongsTo(employees::class, 'employee_id');
    }
}
