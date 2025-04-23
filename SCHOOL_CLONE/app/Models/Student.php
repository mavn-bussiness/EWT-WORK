<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'dateOfBirth',
        'gender',
        'nationality',
        'religion',
        'admissionNumber',
        'guardianContact',
        'address',
        'medical_conditions',
        'admission_date',
        'class_level',
    ];

    protected $casts = [
        'dateOfBirth' => 'date',
        'admission_date' => 'date',
        'medical_conditions' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Parent::class, 'parent_student')
                    ->withTimestamps();
    }

    public function fees(): HasMany
    {
        return $this->hasMany(Fee::class);
    }

    public function classRegistrations(): HasMany
    {
        return $this->hasMany(ClassRegistration::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function feeArrears(): HasMany
    {
        return $this->hasMany(FeeArrear::class);
    }

    public function scholarships(): HasMany
    {
        return $this->hasMany(Scholarship::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->firstName . ' ' . $this->user->lastName;
    }

    public function getAgeAttribute(): int
    {
        return now()->diffInYears($this->dateOfBirth);
    }

}
