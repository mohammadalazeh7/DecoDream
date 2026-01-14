@extends('layouts.dashboard')

@section('title', 'Orders')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title">Orders List</h2>
    </div>
    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="order_id" class="form-label">Order ID</label>
                    <input type="text" name="order_id" id="order_id" class="form-control rounded-pill"
                        value="{{ request('order_id') }}">
                </div>
                <div class="col-md-3">
                    <label for="user_email" class="form-label">User Email</label>
                    <input type="text" name="user_email" id="user_email" class="form-control rounded-pill"
                        value="{{ request('user_email') }}">
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label">Order Status</label>
                    <select name="status" id="status" class="form-select rounded-pill">
                        <option value="">All</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>submitted
                        </option>
                        <option value="preparing" {{ request('status') == 'preparing' ? 'selected' : '' }}>preparing
                        </option>
                        <option value="on_shipping" {{ request('status') == 'on_shipping' ? 'selected' : '' }}>on_shipping
                        </option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>delivered
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>cancelled
                        </option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="invoice_status" class="form-label">Invoice Status</label>
                    <select name="invoice_status" id="invoice_status" class="form-select rounded-pill">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>paid</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>cancelled
                        </option>
                    </select>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th class="rounded-start">ID</th>
                    <th>User Name</th>
                    <th>User Email</th>
                    <th>User Phone</th>
                    <th>Shipping Required</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Total Price</th>
                    <th>Invoice Status</th>
                    <th>representative</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>{{ $order->user->email }}</td>
                        <td>{{ $order->user->phone_number }}</td>
                        <td>{{ $order->shipping_required ? 'Yes' : 'No' }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->payment_method }}</td>
                        <td>{{ $order->total_price }} $</td>
                        <td class="text-center">
                            @if ($order->invoice)
                                <span class="badge bg-{{ $order->invoice->status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->invoice->status) }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                        {{ ucfirst($order->invoice->employee->name ?? '-') }}
                        </td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('orders.edit', $order->id) }}"
                                    class="btn btn-info btn-sm rounded-pill">View</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($orders->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $orders->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif

@endsection
