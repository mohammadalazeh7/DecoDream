<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Http\Resources\ApiResponse;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->getUserOrders(Auth::id());
        return OrderResource::collection($orders);
    }



    public function store(CreateOrderRequest $request)
    {
        $validated = $request->validated();

        $order = $this->orderService->createOrder(Auth::id(), $validated);
        return ApiResponse::success("Added successfully", 200);
    }


    public function cancel(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer|exists:orders,id'
        ]);
        $order = Order::where('id',$request->order_id)->first();
        try {
            $this->orderService->cancelOrder($order);
            return ApiResponse::success('Order cancelled successfully.', 200);
        } catch (Exception $e) {
            return ApiResponse::error($e->getMessage(), 403);
        }
    }
}
