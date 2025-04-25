<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'providers';

    protected $fillable = [
        'user_id',
        'profession',
        'average_rating',
        'experience_years',
        'is_verified',
        // Add 'business_name', 'availability_details' etc. if added
    ];

    protected $casts = [
        'average_rating' => 'float',
        'experience_years' => 'float',
        'is_verified' => 'boolean',
    ];

    /**
     * Get the user record associated with the provider profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the services offered by the provider.
     */
    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'provider_services')
                    ->using(ProviderService::class) // Specify the pivot model
                    ->withTimestamps(); // If pivot table has timestamps
    }

    /**
     * Get the certificates associated with the provider.
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Get the service requests received by the provider.
     */
    public function serviceRequests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }

    /**
     * Get the reviews received by the provider.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
