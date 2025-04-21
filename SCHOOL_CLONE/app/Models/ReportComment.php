<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportComment extends Model
{
    protected $fillable = [
        'report_id',
        'user_id',
        'comment',
        'status_change',
    ];

    public function report(): BelongsTo
    {
        return $this->belongsTo(StaffReport::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}