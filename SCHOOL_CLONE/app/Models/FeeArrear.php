<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeeArrear extends Model
{
    protected $fillable = [
        'student_id',
        'term_id',
        'amount',
        'notes',
        'is_cleared',
        'cleared_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_cleared' => 'boolean',
        'cleared_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    public function clearArrear(): void
    {
        $this->update([
            'is_cleared' => true,
            'cleared_date' => now(),
        ]);
    }
}