<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CvOtherExperience extends Model
{
    use HasFactory;

    protected $table = 'cv_other_experiences';

    protected $fillable = [
        'cv_id', 'category', 'year', 'description', 'document_path'
    ];

    public function cv()
    {
        return $this->belongsTo(Cv::class);
    }
}
