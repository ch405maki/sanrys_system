<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'college',
        'college_course',
        'college_school_year',
        'secondary',
        'secondary_course',
        'secondary_school_year',
        'elementary',
        'elementary_course',
        'elementary_school_year',
    ];

    // Relationship: Each educational background belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
