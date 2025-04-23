<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'password',
        'role',
        'is_active',
        'profile_photo',
        'phone_number',
        'address',
        'date_of_birth',
        'gender',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'last_login_at' => 'datetime',
            'date_of_birth' => 'date',
        ];
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return "{$this->firstName} {$this->lastName}";
    }

    /**
     * Get the profile photo URL attribute.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute(): string
    {
        if ($this->profile_photo) {
            return asset('storage/' . $this->profile_photo);
        }

        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Check if user has a specific role.
     *
     * @param string $role
     * @return bool
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Get the roles collection for the user.
     * This provides compatibility with the navigation template.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getRolesAttribute()
    {
        return collect([
            (object) ['name' => $this->role]
        ]);
    }

    /**
     * Get the bursar record associated with the user.
     */
    public function bursar(): HasOne
    {
        return $this->hasOne(Bursar::class);
    }

    /**
     * Get the teacher record associated with the user.
     */
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    /**
     * Get the headteacher record associated with the user.
     */
    public function headteacher(): HasOne
    {
        return $this->hasOne(Headteacher::class);
    }

    /**
     * Get the director of studies record associated with the user.
     */
    public function directorOfStudies(): HasOne
    {
        return $this->hasOne(DirectorOfStudies::class);
    }

    /**
     * Get all announcements created by this user.
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class, 'created_by');
    }

    /**
     * Get all reports created by this user.
     */
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class, 'created_by');
    }

    /**
     * Get all events created by this user.
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'created_by');
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to filter users by role.
     */
    public function scopeRole($query, $role)
    {
        return $query->where('role', $role);
    }
}
