<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str; // Needed for slug generation if done here

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name if not provided
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });

         static::updating(function ($category) {
            if ($category->isDirty('name') && empty($category->slug)) {
                 $category->slug = Str::slug($category->name);
            }
         });
    }


    /**
     * Get the services belonging to this category.
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
