<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',

        'name',
        'phone',
        'address',
        'notes',
        'payment_method',
        'payment_proof',
        'total',
        'status'
    ];
    const STATUSES = [
        'pending',
        'waiting_verification',
        'paid',
        'processed',
        'completed',
        'rejected',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu Pembayaran',
            'waiting_verification' => 'Menunggu Verifikasi',
            'paid' => 'Sudah Dibayar',
            'processed' => 'Sedang Diproses',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => ucfirst($this->status),
        };
    }
}
