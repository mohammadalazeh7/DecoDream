<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getUserOrders($userId)
    {
        return Order::with('orderItems')->where('user_id', $userId)->get();
    }


    public function createOrder($userId, array $orderData)
    {
        // Calculate total price from order items
        $totalPrice = 0;
        foreach ($orderData['order_items'] as $item) {
            $totalPrice += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'user_id' => $userId,
            'status' => 'submitted',
            'location' => $orderData['location'] ?? null,
            'phone_number' => $orderData['phone_number'],
            'shipping_required' => $orderData['shipping_required'],
            'payment_method' => $orderData['payment_method'] ?? 'pay_on_pickup',
            'total_price' => $totalPrice,
        ]);
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'user_id' => $userId,
            'status' => 'pending',
            'card_number' => $orderData['card_number'] ?? null,
            'card_code' => $orderData['card_code'] ?? null,

        ]);
        foreach ($orderData['order_items'] as $item) {
            $order->orderItems()->create($item);
        }
        return $order->load('orderItems');
    }


    /**
     * Cancel an existing order.
     *
     * @param Order $order
     * @return void
     * @throws \Exception
     */
    public function cancelOrder(Order $order): void
    {
        $user = Auth::user();

        // Ensure the user owns the order
        if ($order->user_id !== $user->id) {
            // Log the IDs for debugging purposes
            \Illuminate\Support\Facades\Log::warning('Permission denied to cancel order.', [
                'order_id' => $order->id,
                'order_owner_id' => $order->user_id,
                'attempted_by_user_id' => $user->id
            ]);
            throw new \Exception('You do not have permission to cancel this order.');
        }

        // Check if the order is already in a state that cannot be cancelled
        if (in_array($order->status, ['preparing', 'on_shipping', 'delivered', 'cancelled'])) {
            throw new \Exception('Order can no longer be cancelled.');
        }

        $canCancel = false;

        // Rule 1: Shipping required
        if ($order->shipping_required == true) {
            if ($order->status === 'submitted') {
                $canCancel = true;
            }
        }
        // Rule 2: Shipping not required
        else {
            if ($order->payment_method === 'online_prepayment' && $order->status === 'submitted') {
                $canCancel = true;
            } elseif ($order->payment_method === 'pay_on_pickup') {
                // User can cancel within 48 hours
                if ($order->created_at->gt(now()->subHours(48))) {
                    $canCancel = true;
                }
            }
        }

        if (!$canCancel) {
            throw new \Exception('The conditions for cancelling this order have not been met.');
        }

        $order->cancel();
        
    }
}
