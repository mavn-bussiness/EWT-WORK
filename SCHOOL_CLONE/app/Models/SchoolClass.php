<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $fillable = [
        'name',
        'stream',
        'class_teacher_id',
        'capacity',
        'classroom_location',
    ];

    // Explicitly define the table name
    protected $table = 'classes';
}
