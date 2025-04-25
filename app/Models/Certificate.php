<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;

    protected $table = 'certificates';

    protected $fillable = [
        'provider_id',
        'title',
        'certificate_image_path',
        'certificate_link',
        'issued_by',
        'issued_at',
        'expires_at',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    /**
     * Get the provider that owns the certificate.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }
}
