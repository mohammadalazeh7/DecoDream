<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardinvoicesController extends Controller
{

    public function index(Request $request)
    {
        $query = Invoice::with(['user', 'order'])
            ->where('employee_id', Auth::guard('employee')->id())
            ->where('status', 'Paid')
            ->whereHas('order', function ($q) {
                $q->where('status', 'on_shipping')
                    ->where('shipping_required', 1);
            })
            ->orderBy('id', 'desc');


        if ($request->filled('invoice_id')) {
            $query->where('id', $request->invoice_id);
        }


        if ($request->filled('user_email')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('email', 'like', '%' . $request->user_email . '%');
            });
        }

        if ($request->filled('invoice_id')) {
            return redirect()->route('invoices.index')
                ->with('error', 'No results found according to your search');
        }

        if ($request->filled('user_email')) {
            return redirect()->route('invoices.index')
                ->with('error', 'No results found according to your search');
        }

        $invoices = $query->paginate(10)->appends($request->all());

        return view('admin.invoices.index', compact('invoices'));
    }



    public function edit($id)
    {
        $invoice = Invoice::with(['user', 'orderItems.product', 'order'])->findOrFail($id);

        return view('admin.invoices.edit', compact('invoice'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'order_status' => 'required|in:on_shipping,delivered',
        ]);

        $invoice = Invoice::with('order')->findOrFail($id);
        $order = $invoice->order;
        if ($order && $order->status === 'on_shipping' && $request->order_status === 'delivered') {
            $order->status = 'delivered';
            $order->save();
        }
        return redirect()->route('invoices.index')->with('success', 'Order status updated successfully.');
    }


    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();
        return redirect()->route('invoices.index')->with('success', 'Invoice cancelled successfully.');
    }
}
