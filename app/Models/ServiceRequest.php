<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Provider;
use App\Models\Review;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_id', 'provider_id', 'service_id',
        'full_name', 'address', 'budget',
        'service_date', 'status'
    ];

   
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class, 'provider_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

}
