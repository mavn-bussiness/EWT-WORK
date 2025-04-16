<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeanOfStudent extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deans_of_students';

    protected $fillable = [
        'user_id',
        'staffId',
        'designation',
        'responsibilities'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}