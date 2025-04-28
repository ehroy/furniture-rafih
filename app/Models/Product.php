<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'name',
        'code_sku',
        'confirmed_at', 
        'processing_at',
        'width', 
        'depth', 
        'height',
        'image',
        'content',
        'price',
        'views',
        'active',
        'slug',
        'recomended'
    ];
    protected $dates = ['confirmed_at', 'processing_at'];
    /**
     * Get the subcategory that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class , 'sub_category_id' , 'id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public static function boot()
    {
        parent::boot();
    
        // Event: Saat model disimpan
        static::saving(function ($model) {
            if (is_array($model->image)) {
                // Jika gambar dalam bentuk array, ubah menjadi string JSON
                $model->image = json_encode($model->image);
            }
        });
    
        // Event: Saat model diupdate
        static::updating(function ($order) {
            if ($order->isDirty('status')) {
                switch ($order->status) {
                    case 'confirmed':
                        $order->confirmed_at = Carbon::now();
                        break;
                    case 'processing':
                        $order->processing_at = Carbon::now();
                        break;
                }
            }
        });
    }

    // Menangani data image ketika dibaca dari database
    public function getImageAttribute($value)
    {
        // Pastikan bahwa kita hanya memanggil json_decode jika nilai adalah string JSON
        return is_string($value) ? json_decode($value, true) : $value;
    }
    

}
