<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\FacilityBooking;
use App\Models\Vote;
use App\Models\Notification;


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
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'can_manage_facility',
        'is_super_admin',

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

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getProfilePhotoUrlAttribute(): string
    {
        return $this->profile_photo_path
            ? asset('storage/' . $this->profile_photo_path)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=random';
    }


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
            'can_manage_facility' => 'boolean',
            'is_super_admin' => 'boolean',

        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }


    // Relationship: User has many facility bookings
    public function facilityBookings()
    {
        return $this->hasMany(FacilityBooking::class);
    }

    // Relationship: User has many votes
    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    // Relationship: User has many notifications
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

}
