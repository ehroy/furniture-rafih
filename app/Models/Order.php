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
        'confirmed_at', 'processed_at','completed_at','canceled_at', 'total_price',
        'shipping_address'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    protected $casts = [
        'confirmed_at' => 'datetime',
        'processed_at' => 'datetime',
        'completed_at' =>  'datetime',
        'canceled_at' =>  'datetime',

    ];
    protected static function boot()
    {
        parent::boot();

        static::updating(function ($order) {
            if ($order->isDirty('status')) { // Jika status berubah
                
                // Update waktu berdasarkan status baru
                if ($order->status === 'confirmed' && is_null($order->confirmed_at)) {
                    $order->confirmed_at = now();
                }
                
                if ($order->status === 'processing' && is_null($order->processed_at)) {
                    $order->processed_at = now();
                }
                if ($order->status === 'completed' && is_null($order->confirmed_at)) {
                    $order->confirmed_at = now();
                }
                
                if ($order->status === 'cancelled' && is_null($order->processed_at)) {
                    $order->processed_at = now();
                }
                
            }
        });
    }
}
