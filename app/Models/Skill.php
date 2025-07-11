<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = ['name', 'created_at', 'updated_at'];

    public function employeeSkills(): HasMany
    {
        return $this->hasMany(employee_skill::class);
    }

    public function employees()
    {
        return $this->belongsToMany(employees::class, 'employee_skill', 'skill_id', 'employee_id')->withTimestamps();
    }
}
