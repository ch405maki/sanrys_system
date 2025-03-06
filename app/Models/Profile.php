<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'position',
        'branch',
        'age',
        'contact_number',
        'sex',
        'civil_status',
        'citizenship',
        'religion',
        'weight',
        'height',
        'date_of_birth',
        'place_of_birth',
        'present_address',
        'permanent_address',
        'profile_picture',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}