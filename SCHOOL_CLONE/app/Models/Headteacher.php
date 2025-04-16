<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Headteacher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'staffId',
        'qualification',
        'appointment_date'
    ];

    protected $casts = [
        'appointment_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}