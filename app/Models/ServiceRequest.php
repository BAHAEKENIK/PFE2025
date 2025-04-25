<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class ServiceRequest extends Model
{
    use HasFactory;

    protected $table = 'service_requests';

    protected $fillable = [
        'client_id',
        'provider_id',
        'service_id',
        'full_name',
        'description',
        'address',
        'budget',
        'preferred_datetime',
        'status',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'preferred_datetime' => 'datetime',
        'status' => 'string', // Or use an Enum cast if you define a Status Enum (PHP 8.1+)
    ];

    /**
     * Get the client who made the request.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the provider the request was sent to.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    /**
     * Get the service requested.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Get the review associated with the service request.
     */
    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }
}
