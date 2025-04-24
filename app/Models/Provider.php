<?php

namespace App\Models;

use App\Models\ProviderService;
use App\Models\Review;
use App\Models\ServiceRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;
    public function ReceiveRequests():HasMany
    {
        return $this->hasMany(ServiceRequest::class,"provider_id");
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviews():HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function ProviderServices():HasMany
    {
        return $this->hasMany(ProviderService::class);
    }
}