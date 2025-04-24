<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['provider_id', 'title', 'file_path', 'issued_by', 'issued_at'];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
        //this provider_id belongs to table certificate; 
    }
}
