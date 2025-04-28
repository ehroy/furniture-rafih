<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $fillable = ['name','image'];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if (is_array($model->image)) {
                // Jika gambar dalam bentuk array, ubah menjadi string JSON
                $model->image = json_encode($model->image);
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
