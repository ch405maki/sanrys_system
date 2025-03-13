<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function payrolls()
    {
        return $this->hasMany(Payroll::class);
    }
    public function salary()
    {
        return $this->hasOne(Salary::class);
    }
    public function deductions()
    {
        return $this->hasOne(Deduction::class);
    }
    public function deduction()
    {
        return $this->hasOne(Deduction::class);
    }
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    public function educationalBackground()
    {
        return $this->hasOne(EducationalBackground::class);
    }
    public function previousEmploymentRecords()
    {
        return $this->hasMany(PreviousEmploymentRecord::class);
    }
    public function references()
    {
        return $this->hasMany(Reference::class);
    }
    public function emergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class);
    }
    public function governmentBenefits()
    {
        return $this->hasOne(GovernmentBenefit::class);
    }
}
