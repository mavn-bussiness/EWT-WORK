<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Parents extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'relationship',
        'phoneNumber',
        'alternativePhoneNumber',
        'address',
        'occupation',
        'employer',
        'employer_address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'parent_student')
                    ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return $this->user->firstName . ' ' . $this->user->lastName;
    }

    public function getPrimaryContactAttribute(): string
    {
        return $this->phoneNumber ?? $this->user->email;
    }

    public function getChildrenCountAttribute(): int
    {
        return $this->students()->count();
    }
}