<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bursary extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bursars';

    protected $fillable = [
        'user_id',
        'staffId',
        'qualification',
        'department'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function financialTransactions()
    {
        return $this->hasMany(FinancialTransaction::class, 'recorded_by');
    }
}