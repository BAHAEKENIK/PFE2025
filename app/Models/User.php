<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // Add if you implement email verification
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // If using Sanctum for API auth

class User extends Authenticatable // Optional: implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * Although 'users' is default, explicit is fine.
     * @var string
     */
    protected $table = 'users';

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
        'phone',
        'city',
        'profile_photo_path',
        'bio',
        'email_verified_at', // Add if using email verification
    ];

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed', // Use Laravel's built-in hashing
        'role' => 'string', // Or use an Enum cast if you define a Role Enum (PHP 8.1+)
    ];

    // Relationships

    /**
     * Get the client profile associated with the user.
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Get the provider profile associated with the user.
     */
    public function provider()
    {
        return $this->hasOne(Provider::class);
    }

    /**
     * Get the admin profile associated with the user.
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Get the messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get the conversations this user is part of (either user_one or user_two).
     */
    public function conversations()
    {
        // This requires querying the conversations table where either user_one_id or user_two_id matches this user's ID.
        // A direct relation is complex. Often handled by querying Conversation model directly.
        // Example placeholder:
        return Conversation::where('user_one_id', $this->id)
                           ->orWhere('user_two_id', $this->id);
        // Or define two separate hasMany relationships if needed:
        // return $this->hasMany(Conversation::class, 'user_one_id');
        // return $this->hasMany(Conversation::class, 'user_two_id');
    }

     /**
     * Get the contact messages replied to by this user (if admin).
     */
    public function contactReplies()
    {
        return $this->hasMany(ContactMessage::class, 'replied_by_user_id');
    }

    // Helper methods for roles (optional but useful)
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    public function isProvider(): bool
    {
        return $this->role === 'provider';
    }
}
