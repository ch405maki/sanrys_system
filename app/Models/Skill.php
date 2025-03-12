<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'skill_name',
        'proficiency_level',
        'description',
    ];

    /**
     * Get the user that owns the skill.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}