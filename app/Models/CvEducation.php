<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvEducation extends Model
{
    use HasFactory;

    protected $table = 'cv_educations';

    protected $fillable = [
        'cv_id', 'school_name', 'location', 'start_month', 'start_year',
        'graduation_month', 'graduation_year', 'degree_level', 'description',
        'gpa', 'gpa_max', 'activities'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
