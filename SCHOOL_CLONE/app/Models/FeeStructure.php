<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeStructure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'term_id',
        'class_level',
        'tuition',
        'boarding',
        'development',
        'uniform',
        'meals',
        'other_charges',
        'description'
    ];

    protected $casts = [
        'tuition' => 'decimal:2',
        'development' => 'decimal:2',
        'uniform' => 'decimal:2',
        'meals' => 'decimal:2',
        'other_charges' => 'decimal:2'
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
