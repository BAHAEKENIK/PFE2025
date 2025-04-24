<?php

namespace App\Models;

use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    public function ServiceRequests():HasMany
    {
        return $this->hasMany(ServiceRequest::class,"client_id");
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class,"client_id");
    }
}