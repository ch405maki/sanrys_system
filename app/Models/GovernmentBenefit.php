<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentBenefit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sss_no', 'pag_ibig_no', 'philhealth_no', 'tin_no', 'employee_no', 'date_employed'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
