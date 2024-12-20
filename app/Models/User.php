<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\ClubSubAdmin;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
    ];

     protected $casts = [
        'role' => 'string',
    ];
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }

        // Return default avatar if none is uploaded
        return "https://ui-avatars.com/api/?name=" . urlencode($this->name);
    }
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }
    public function hasAnyRole(array $roles): bool
    {
        return in_array($this->role, $roles);
    }
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }
    public function isSubAdmin(): bool
    {
        return $this->hasRole('subadmin');
    }
    public function isUser(): bool
    {
        return $this->hasRole('user');
    }

     public function clubs(): BelongsToMany
    {
        return $this->belongsToMany(Club::class, 'club_user')
            ->withTimestamps();
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_user')
            ->withTimestamps();
    }

    public function subAdminClub(): HasOneThrough
    {
        return $this->hasOneThrough(
            Club::class,
            ClubSubAdmin::class,
            'user_id', // Foreign key on club_subadmin table
            'id', // Foreign key on clubs table (primary key)
            'id', // Local key on users table (primary key)
            'club_id' // Local key on club_subadmin table
        );
    }



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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
        ];
    }
}
