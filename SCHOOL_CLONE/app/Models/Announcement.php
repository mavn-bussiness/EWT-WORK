<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'posted_by',
        'audience',
        'publish_date',
        'expiry_date',
        'attachment_path',
        'is_active'
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'expiry_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }
}