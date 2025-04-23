<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
    'order_id','order_type', 'product_id', 'price', 'quantity', 'status',
    'confirmed_at', 'processing_at', 'completed_at', 'cancelled_at'
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    protected $casts = [
        'confirmed_at' => 'datetime',
        'processing_at' => 'datetime',
        'completed_at'  => 'datetime',
        'cancelled_at'  => 'datetime',
    ];
    public function updateStatus($newStatus)
    {
        $timestamps = [
            'confirmed'  => 'confirmed_at',
            'processing' => 'processing_at',
            'completed'  => 'completed_at',
            'cancelled'  => 'cancelled_at',
        ];

        $updateData = ['status' => $newStatus];

        // Jika status baru ada dalam daftar timestamp, isi dengan waktu sekarang
        if (array_key_exists($newStatus, $timestamps)) {
            $updateData[$timestamps[$newStatus]] = now();
        }

        return $this->update($updateData);
    }
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;

        switch ($value) {
            case 'confirmed':
                $this->attributes['confirmed_at'] = now();
                break;
            case 'processing':
                $this->attributes['processing_at'] = now();
                break;
            case 'completed':
                $this->attributes['completed_at'] = now();
                break;
            case 'cancelled':
                $this->attributes['cancelled_at'] = now();
                break;
        }
    }

    /**
     * Format waktu agar lebih rapi saat ditampilkan.
     */
    public function getConfirmedAtFormattedAttribute()
    {
        return $this->confirmed_at ? $this->confirmed_at->format('d M Y H:i') : 'Belum dikonfirmasi';
    }

    public function getProcessingAtFormattedAttribute()
    {
        return $this->processing_at ? $this->processing_at->format('d M Y H:i') : 'Belum diproses';
    }

    public function getCompletedAtFormattedAttribute()
    {
        return $this->completed_at ? $this->completed_at->format('d M Y H:i') : 'Belum selesai';
    }

    public function getCancelledAtFormattedAttribute()
    {
        return $this->cancelled_at ? $this->cancelled_at->format('d M Y H:i') : 'Tidak dibatalkan';
    }
}
