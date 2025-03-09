<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\OrderItem; // ✅ Tambahkan namespace yang benar

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number', 'buyer_email', 'status',
        'confirmed_at', 'processed_at', 'total_price',
        'shipping_address'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $casts = [
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
    ];
}
