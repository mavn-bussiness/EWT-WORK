<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'organizer_id',
        'is_approved',
    ];
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'event_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the organizer of the event.
     */
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    
    /**
     * Get the formatted start date and time.
     */
    public function getFormattedStartTimeAttribute()
    {
        return $this->start_time ? $this->start_time->format('h:i A') : null;
    }
    
    /**
     * Get the formatted end date and time.
     */
    public function getFormattedEndTimeAttribute()
    {
        return $this->end_time ? $this->end_time->format('h:i A') : null;
    }
    
    /**
     * Get the formatted event date.
     */
    public function getFormattedEventDateAttribute()
    {
        return $this->event_date->format('F d, Y');
    }
}