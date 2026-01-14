<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'user_id',
        'order_id',
        'employee_id',
        'card_number',
        'card_code',
        'invoice_status',
        'payment_method',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderItems()
    {
        return $this->hasManyThrough(
            OrderItem::class,
            Order::class,
            'id',           // Foreign key on orders
            'order_id',     // Foreign key on order_items
            'order_id',     // Local key on invoices
            'id'            // Local key on orders
        );
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


}
