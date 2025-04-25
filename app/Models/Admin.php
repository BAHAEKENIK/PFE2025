<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        // Add any other admin-specific fields if they exist in the migration
    ];

    /**
     * Get the user record associated with the admin profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
