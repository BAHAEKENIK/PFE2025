<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// *** Use Pivot for pivot models ***
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Keep this

// *** Extend Pivot ***
class ProviderService extends Pivot
{
    use HasFactory;

    // *** Specify the table explicitly for clarity with Pivot models ***
    protected $table = 'provider_services';

    // *** Remove $timestamps = false; as the migration uses timestamps() ***
    // public $timestamps = false; // REMOVE THIS LINE

    // Fillable should include foreign keys and any extra pivot columns
    protected $fillable = ['provider_id', 'service_id'];

    // No need for primary key or incrementing if it's just a standard pivot

    /**
     * Indicates if the IDs are auto-incrementing.
     * Pivot tables usually don't have auto-incrementing IDs unless specified.
     * @var bool
     */
    public $incrementing = true; // Set to true because the migration uses ->id()

    // Relationships (optional on Pivot, but can be useful)
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class); // Foreign key 'provider_id' is inferred
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class); // Foreign key 'service_id' is inferred
    }
}
