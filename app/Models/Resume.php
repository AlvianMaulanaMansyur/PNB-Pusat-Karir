<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'title',
        'slug',
        'resume_data',
    ];

    protected $casts = [
        'resume_data' => 'array',
    ];

    /**
     * Dapatkan employee yang memiliki resume ini.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(employees::class);
    }

    /**
     * Dapatkan kunci rute untuk model.
     * Menggunakan slug untuk Route Model Binding.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resume) {
            $resume->slug = Str::slug($resume->title) . '-' . Str::random(6);
        });

        static::updating(function ($resume) {
            if ($resume->isDirty('title')) {
                $resume->slug = Str::slug($resume->title) . '-' . Str::random(6);
            }
        });
    }
}