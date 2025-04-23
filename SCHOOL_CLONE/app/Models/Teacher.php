<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'staffId',
        'qualification',
        'phoneNumber',
        'employment_date',
        'specialization',
        'department',
        'is_dos',
        'dos_department'
    ];

    protected $casts = [
        'employment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subjects(): HasMany
    {
        return $this->hasMany(TeacherSubject::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    public function timetables(): HasMany
    {
        return $this->hasMany(Timetable::class);
    }

    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    public function salaryPayments(): HasMany
    {
        return $this->hasMany(SalaryPayment::class, 'user_id', 'user_id');
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->firstName . ' ' . $this->user->lastName;
    }

    public function getYearsOfServiceAttribute(): int
    {
        return $this->employment_date ? now()->diffInYears($this->employment_date) : 0;
    }
}
