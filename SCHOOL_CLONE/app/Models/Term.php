<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Term extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'academic_year_id',
        'name',
        'start_date',
        'end_date',
        'is_current',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    /**
     * Get the current active term.
     *
     * @return \App\Models\Term|null
     */
    public static function current()
    {
        // First try to find a term explicitly marked as current
        $term = self::where('is_current', true)->first();
        
        // If no term is explicitly marked as current, try to determine based on date
        if (!$term) {
            $term = self::where('start_date', '<=', Carbon::now())
                      ->where('end_date', '>=', Carbon::now())
                      ->first();
        }
        
        // If still no term found, fall back to the most recent term
        if (!$term) {
            $term = self::orderBy('end_date', 'desc')->first();
        }
        
        return $term;
    }

    /**
     * Get the academic year that this term belongs to.
     */
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    
    /**
     * Get the fee structures associated with this term.
     */
    public function feeStructures()
    {
        return $this->hasMany(FeeStructure::class);
    }
    
    /**
     * Get the fees associated with this term.
     */
    public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}