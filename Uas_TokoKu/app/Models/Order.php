<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'total_amount',
        'shipping_cost',
        'shipping_method',
        'status',
        'rating',
        'shipping_address',
        'payment_method',
        'notes',
    ];

    /**
     * Mendapatkan pengguna yang memiliki pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendapatkan item pesanan untuk pesanan ini
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Menghasilkan nomor pesanan unik
     */
    public static function generateOrderNumber()
    {
        $prefix = 'TKU';
        $dateCode = date('ymd');
        $randomCode = strtoupper(substr(uniqid(mt_rand(), true), -4));
        $counter = str_pad(static::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);
        
        return $prefix . '-' . $dateCode . '-' . $randomCode . '-' . $counter;
    }

    /**
     * Scope untuk pesanan yang masih pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for processing orders
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    /**
     * Mendapatkan informasi metode pembayaran dalam format yang lebih bersahabat
     */
    public function getPaymentMethodInfo()
    {
        switch ($this->payment_method) {
            case 'transfer':
                return [
                    'name' => 'Transfer Bank',
                    'icon' => 'fa-university',
                    'instructions' => 'Silahkan transfer ke rekening BCA 1234567890 a/n TokoKU Official'
                ];
            case 'wallet':
                return [
                    'name' => 'E-Wallet',
                    'icon' => 'fa-wallet',
                    'instructions' => 'Silahkan lakukan pembayaran melalui DANA/OVO/GoPay ke nomor 081234567890'
                ];
            case 'cod':
                return [
                    'name' => 'Bayar di Tempat (COD)',
                    'icon' => 'fa-hand-holding-usd',
                    'instructions' => 'Siapkan uang tunai saat pesanan tiba'
                ];
            default:
                return [
                    'name' => 'Metode Pembayaran',
                    'icon' => 'fa-money-bill',
                    'instructions' => 'Hubungi customer service untuk informasi lebih lanjut'
                ];
        }
    }

    /**
     * Mendapatkan status pesanan dalam format yang lebih bersahabat
     */
    public function getStatusInfo()
    {
        switch ($this->status) {
            case 'pending':
                return [
                    'name' => 'Menunggu Pembayaran',
                    'color' => 'warning',
                    'icon' => 'fa-clock'
                ];
            case 'processing':
                return [
                    'name' => 'Diproses',
                    'color' => 'info',
                    'icon' => 'fa-cogs'
                ];
            case 'shipped':
                return [
                    'name' => 'Dikirim',
                    'color' => 'primary',
                    'icon' => 'fa-shipping-fast'
                ];
            case 'delivered':
                return [
                    'name' => 'Diterima',
                    'color' => 'success',
                    'icon' => 'fa-check-circle'
                ];
            case 'cancelled':
                return [
                    'name' => 'Dibatalkan',
                    'color' => 'danger',
                    'icon' => 'fa-times-circle'
                ];
            default:
                return [
                    'name' => 'Status Tidak Diketahui',
                    'color' => 'secondary',
                    'icon' => 'fa-question-circle'
                ];
        }
    }
    
    /**
     * Get shipping method information
     */
    public function getShippingMethodInfo()
    {
        $methods = [
            'regular' => [
                'name' => 'Reguler',
                'description' => 'Estimasi pengiriman 3-5 hari kerja',
                'price' => 10000,
                'icon' => 'fa-truck'
            ],
            'express' => [
                'name' => 'Ekspres',
                'description' => 'Estimasi pengiriman 1-2 hari kerja',
                'price' => 20000,
                'icon' => 'fa-shipping-fast'
            ]
        ];
        
        return $methods[$this->shipping_method ?? 'regular'] ?? $methods['regular'];
    }
}
