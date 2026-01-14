<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('id', 'desc');

        if ($request->filled('order_id')) {
            $query->where('id', $request->order_id);
        }
        if ($request->filled('user_email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->user_email . '%');
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('invoice_status')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('status', 'like', '%' . $request->invoice_status . '%');
            });
        }


         if ($request->filled('order_id')) {
            return redirect()->route('orders.index')
                ->with('error', 'No results found according to your search');
        }
         if ($request->filled('user_email')) {
            return redirect()->route('orders.index')
                ->with('error', 'No results found according to your search');
        }

        $orders = $query->paginate(10)->appends($request->all());
        return view('admin.orders.index', compact('orders'));
    }


    public function edit($id)
    {
        $order = Order::with(['user', 'orderItems.product', 'invoice'])->findOrFail($id);
        // جلب الموظفين الذين لديهم الدور Shipping Representative
        $employees = Employee::whereHas('role', function($q) {
            $q->where('role_name', 'Shipping Representative');
        })->get();
        return view('admin.orders.edit', compact('order', 'employees'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:submitted,preparing,on_shipping,delivered,cancelled',
            'invoice_status' => 'nullable|in:pending,paid',
        ]);
        $order = Order::with('invoice')->findOrFail($id);

        // تحديث حالة الطلب فقط إذا كانت الحالة الحالية preparing
        if ($order->status === 'preparing' && in_array($request->status, ['submitted','preparing','on_shipping', 'delivered', 'cancelled'])) {
            $order->status = $request->status;
            $order->save();
        } elseif ($order->status !== 'preparing') {
            // يمكن تحديث الحالة لباقي الحالات بشكل اعتيادي
            $order->status = $request->status;
            $order->save();
        }

        // تحديث حالة الفاتورة إذا تم إرسالها
        if ($order->invoice && $request->filled('invoice_status')) {
            $order->invoice->status = $request->invoice_status;
            $order->invoice->save();
        }

        if ($order->invoice && $request->filled('invoice_status')) {
            $order->invoice->status = $request->invoice_status;
            $order->invoice->save();
        }

        if ($order->invoice && $request->filled('employee_id')) {
            $order->invoice->employee_id = $request->employee_id;
            $order->invoice->save();
        }

        return redirect()->route('orders.index')->with('success', 'Order and invoice updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Order cancelled successfully.');
    }
}
