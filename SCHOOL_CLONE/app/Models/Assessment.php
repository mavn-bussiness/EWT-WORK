<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Assessment extends Model
{
    protected $fillable = [
        'name',
        'subject_id',
        'class_id',
        'term_id',
        'assessment_date',
        'max_score',
        'type',
        'description',
    ];

    protected $casts = [
        'assessment_date' => 'date',
        'max_score' => 'integer',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function marks(): HasMany
    {
        return $this->hasMany(Mark::class);
    }

    public function averageScore(): float
    {
        return $this->marks()->avg('score') ?? 0;
    }
}