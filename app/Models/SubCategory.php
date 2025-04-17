<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = 
    [
    'category_id',
    'name',
    'image',
    'active'
    ];

    /**
     * Get the category that owns the SubCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    protected static function booted()
    {
        static::creating(function ($subcategory) {
            $subcategory->slug = Str::slug($subcategory->name);
        });

        static::updating(function ($subcategory) {
            $subcategory->slug = Str::slug($subcategory->name);
        });
    }
    
}
