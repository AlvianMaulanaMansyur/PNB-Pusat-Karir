<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvWorkExperience extends Model
{
    use HasFactory;

    protected $table = 'cv_work_experiences';

    protected $fillable = [
        'cv_id', 'company_name', 'position', 'location',
        'company_profile', 'start_month', 'start_year',
        'end_month', 'end_year', 'currently_working',
        'portfolio_description'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
