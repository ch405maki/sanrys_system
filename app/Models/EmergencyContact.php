<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'address', 'contact', 'relation'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
