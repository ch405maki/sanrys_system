<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'rate_per_day',
        'basic_salary',
        'overtime_pay',
        'holiday_pay',
        'allowance',
        'deductions',
        'gross_pay',
        'net_pay',
        'pay_period_start',
        'pay_period_end',
        'cut_off_period',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
