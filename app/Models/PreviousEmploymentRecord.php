<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreviousEmploymentRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'position',
        'date_employed',
        'salary',
        'reason_of_leaving',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
