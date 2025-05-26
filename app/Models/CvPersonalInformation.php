<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvPersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'cv_personal_information';

    protected $fillable = [
        'cv_id', 'full_name', 'phone_number', 'email',
        'linkedin_url', 'portfolio_url', 'address', 'summary',
        'profile_photo'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}

