<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'wood_id', 'color_id', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function wood()
    {
        return $this->belongsTo(Wood::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }
   
    // protected $hidden = [
    //     'id',
    //     'product_id',
    //     'wood_id',
    //     'color_id',
    //     'updated_at',
    //     'created_at'
    // ];
}
