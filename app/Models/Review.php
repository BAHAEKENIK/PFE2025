<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Provider;
use App\Models\ServiceRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    
    use HasFactory;
    protected $fillable = [
        'service_request_id', 'client_id', 'provider_id',
        'rating', 'comment'
    ];


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }
}
