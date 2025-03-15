<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;
    protected $fillable = ['width', 'depth', 'height'];

    public function variations()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
