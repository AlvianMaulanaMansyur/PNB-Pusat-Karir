<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'event_type',
        'description',
        'event_date',
        'event_time',
        'location',
        'max_participants',
        'registration_link',
        'flyer',
        'is_active',
        'posted_by',
    ];

    protected $casts = [
        'needs_registration' => 'boolean',
        'is_active' => 'boolean',
        'event_date' => 'date',
        'event_time' => 'datetime:H:i',
    ];
}
