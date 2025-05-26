<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvOrganizationExperience extends Model
{
    use HasFactory;

    protected $table = 'cv_organization_experiences';

    protected $fillable = [
        'cv_id', 'organization_name', 'position', 'organization_description',
        'location', 'start_month', 'start_year', 'end_month', 'end_year',
        'is_active', 'job_description'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
