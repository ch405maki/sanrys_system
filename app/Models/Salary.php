<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rate_per_day',
        'overtime_rate',
        'holiday_rate'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
