<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee_skill extends Model
{
    protected $table = 'employee_skill';

    // Tidak pakai kolom 'id'
    public $incrementing = false;
    // public $timestamps = false;

    protected $primaryKey = null;

    protected $fillable = [
        'employee_id',
        'skill_id',
        'created_at',
        'updated_at',
    ];

    public function employee()
    {
        return $this->belongsTo(employees::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
