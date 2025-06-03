<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cv extends Model
{
    use HasFactory;

    protected $table = 'cvs';

    protected $fillable = ['user_id', 'title', 'status', 'slug'];

    public function personalInformation()
    {
        return $this->hasOne(CvPersonalInformation::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(CvWorkExperience::class);
    }

    public function educations()
    {
        return $this->hasMany(CvEducation::class);
    }

    public function organizationExperiences()
    {
        return $this->hasMany(CvOrganizationExperience::class);
    }

    public function otherExperiences()
    {
        return $this->hasMany(CvOtherExperience::class);
    }
}
