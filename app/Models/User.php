<?php
namespace App\Models;

use App\Models\Certificate;
use App\Models\Client;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'role',
        'phone', 'city', 'profile_photo', 'bio',
    ];

    protected $hidden = ['password'];

    // Relations selon le rôle

    public function client ():HasOne
    {
        return $this->hasOne(Client::class);
    }

    public function provider ():HasOne
    {
        return $this->hasOne(Provider::class);
    }
    
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class, 'provider_id');
        //this provider_id belongs to table certificate; 
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
