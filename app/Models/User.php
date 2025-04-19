<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use Notifiable;use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'city', 'profile_photo', 'bio',
    ];

    protected $hidden = ['password'];

    // Relations selon le rôle
    public function providerServices(): HasMany
    {
        return $this->hasMany(ProviderService::class, 'provider_id');
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'provider_id');
    }

    public function serviceRequestsSent(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'client_id');
    }

    public function serviceRequestsReceived(): HasMany
    {
        return $this->hasMany(ServiceRequest::class, 'provider_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function conversationsAsUserOne(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_one_id');
    }

    public function conversationsAsUserTwo(): HasMany
    {
        return $this->hasMany(Conversation::class, 'user_two_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
}
