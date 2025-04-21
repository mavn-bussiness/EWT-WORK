<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bursar extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bursars';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'staffId',
        'role',
        'department',
        'phoneNumber',
        'transaction_limit',
        'can_approve_expenses',
    ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'transaction_limit' => 'decimal:2',
        'can_approve_expenses' => 'boolean',
    ];
    
    /**
     * Get the user associated with the bursar.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Scope a query to only include bursars with a specific role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithRole($query, $role)
    {
        return $query->where('role', $role);
    }
    
    /**
     * Check if bursar can approve the given expense amount.
     *
     * @param  float  $amount
     * @return bool
     */
    public function canApproveAmount($amount)
    {
        if (!$this->can_approve_expenses) {
            return false;
        }
        
        if ($this->transaction_limit === null) {
            return true;
        }
        
        return $amount <= $this->transaction_limit;
    }
    
    /**
     * Get the role name formatted for display.
     *
     * @return string
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            'chief_bursar' => 'Chief Bursar',
            'assistant_bursar' => 'Assistant Bursar',
            'accounts_clerk' => 'Accounts Clerk',
            'cashier' => 'Cashier',
        ];
        
        return $roles[$this->role] ?? ucfirst(str_replace('_', ' ', $this->role));
    }
}