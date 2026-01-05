<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'client_id',
        'items',
        'total_amount',
        'payment_history',
        'remaining_amount',
        'payment_status',
        'decorations',
        'notes',
    ];

    protected $casts = [
        'items' => 'array',
        'decorations' => 'array',
        'payment_history' => 'array',
        'total_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // Generate order number automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . str_pad(Order::max('id') + 1, 3, '0', STR_PAD_LEFT);
            }
        });
    }

    // Calculate remaining amount
    public function calculateRemainingAmount()
    {
        $this->remaining_amount = $this->total_amount - $this->dp1 - $this->dp2 - $this->dp3;
        return $this->remaining_amount;
    }
}
