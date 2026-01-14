<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ["status", "user_id", "shipping_required", "location", "phone_number", "payment_method", "total_price"];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    /**
     * Check if the order can be cancelled.
     *
     * @return bool
     */
    public function canBeCancelled(): bool
    {
        return !in_array($this->status, ['shipped', 'completed', 'cancelled']);
    }

    /**
     * Mark the order as cancelled.
     *
     * @return bool
     */
    public function cancel(): bool
    {
        if ($this->canBeCancelled()) {
            return $this->update(['status' => 'cancelled']);
        }

        return false;
    }
}
