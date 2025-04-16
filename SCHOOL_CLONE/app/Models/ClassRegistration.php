<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'class_id',
        'term_id',
        'status',
        'registration_date',
    ];

    protected $casts = [
        'registration_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'registered' && 
               $this->term->is_current;
    }
}