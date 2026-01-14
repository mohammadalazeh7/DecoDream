@extends('layouts.dashboard')

@section('title', 'Order Details')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-5">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-box text-primary me-2"></i>
                            Order for {{ $order->user->name }}
                        </h5>
                    </div>

                    <div class="card-body p-4">

                        {{-- User Info --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-user-circle me-2 text-secondary"></i>
                                User Information
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <strong>Name:</strong> {{ $order->user->name ?? '-' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <strong>Email:</strong> {{ $order->user->email ?? '-' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <strong>Phone:</strong> {{ $order->user->phone_number ?? '-' }}
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>Location:</strong>
                                    @if ($order->location)
                                        <a href="{{ route('map.order', $order->id) }}"
                                            class="btn btn-info btn-sm rounded-pill ms-2" target="_blank">
                                            عرض الموقع على الخريطة
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        {{-- Order Products --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-shopping-basket me-2 text-secondary"></i>
                                Order Items
                            </h5>

                            <div class="table-container mt-4" style="background: #fff;">
                                <table class="table mb-0" style=" overflow: hidden;">
                                    <thead style="background: #2F5D50; color: #fff;">
                                        <tr>
                                            <th><i class="fas fa-box me-1"></i> Product</th>
                                            <th><i class="fas fa-dollar-sign me-1"></i> Unit Price</th>
                                            <th><i class="fas fa-sort-numeric-up me-1"></i> Quantity</th>
                                            <th><i class="fas fa-equals me-1"></i> Total</th>
                                        </tr>
                                    </thead>
                                    <tbody style="color: #222;">
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <td>{{ $item->product->name ?? '-' }}</td>
                                                <td>{{ $item->product->price }} $</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->product->price * $item->quantity }} $</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3 text-start">
                                <p class="fs-5 text-success fw-semibold">
                                    <i class="fas fa-receipt me-2"></i>
                                    Total Order Price:
                                    <span>{{ $order->total_price }} $</span>
                                </p>
                            </div>
                        </div>

                        {{-- Payment & Status --}}
                        <div class="mb-4">
                            <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                                <i class="fas fa-file-invoice-dollar me-2 text-secondary"></i>
                                Payment & Status
                            </h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-3">
                                    <i class="fas fa-credit-card text-primary me-2"></i>
                                    <strong>Payment Method:</strong>
                                    {{ $order->payment_method == 'cod' ? 'Online Prepayment' : 'Pay on Pickup' }}
                                </li>
                                <li class="mb-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    <strong>Status:</strong>
                                    <span
                                        class="badge bg-{{ $order->status == 'submitted'
                                            ? 'info'
                                            : ($order->status == 'preparing'
                                                ? 'primary'
                                                : ($order->status == 'on_shipping'
                                                    ? 'warning'
                                                    : ($order->status == 'delivered'
                                                        ? 'success'
                                                        : 'danger'))) }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </li>
                                <li>
                                    <i class="fas fa-truck text-primary me-2"></i>
                                    <strong>Shipping Required:</strong>
                                    @if ($order->shipping_required)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </li>
                                @if ($order->invoice)
                                    <li class="mt-3">
                                        <i class="fas fa-file-invoice text-primary me-2"></i>
                                        <strong>Invoice Status:</strong>
                                        <span
                                            class="badge bg-{{ $order->invoice->status == 'paid' ? 'success' : 'warning' }}">
                                            {{ ucfirst($order->invoice->status) }}
                                        </span>
                                    </li>
                                @endif
                            </ul>
                        </div>

                        {{-- Update Status --}}
                        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="pt-3 border-top">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold text-dark">
                                    <i class="fas fa-sync-alt text-primary me-2"></i>
                                    Update Status
                                </label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    {{-- <option value="">Select status</option> --}}
                                    {{-- <option value="">{{ ucfirst($order->status) }} </option> --}}

                                    @php
                                        // $currentStatus = old('status', $order->status);
                                        $allowedStatuses = ['submitted','preparing','preparing', 'on_shipping', 'delivered', 'cancelled'];

                                        // if ($currentStatus === 'submitted') {
                                        //     // لو الحالة submitted، مش مسموح غير بـ preparing
                                        //     $allowedStatuses = ['preparing'];
                                        // } elseif ($currentStatus === 'preparing') {
                                        //     // لو الحالة preparing، مش مسموح غير بـ on_shipping, cancelled
                                        //     $allowedStatuses = ['on_shipping', 'cancelled'];
                                        // } elseif ($currentStatus === 'on_shipping') {
                                        //     // لو on_shipping، مسموح بـ delivered أو cancelled
                                        //     $allowedStatuses = ['delivered', 'cancelled'];
                                        // } else {
                                        //     // لو delivered أو cancelled، مش مسموح بأي تغيير عمليًا
                                        //     $allowedStatuses = [];
                                        // }

                                    @endphp

                                    @foreach (['submitted','preparing','on_shipping', 'delivered', 'cancelled'] as $status)
                                        @if (in_array($status, $allowedStatuses))
                                            <option value="{{ $status }}">
                                                {{-- {{ $currentStatus == $status ? 'selected' : '' }}> --}}
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($order->invoice)
                                <div class="mb-3">
                                    <label for="invoice_status" class="form-label fw-bold text-dark">
                                        <i class="fas fa-file-invoice text-primary me-2"></i>
                                        Update Invoice Status
                                    </label>
                                    <select name="invoice_status" id="invoice_status"
                                        class="form-select @error('invoice_status') is-invalid @enderror">
                                        <option value="pending"
                                            {{ old('invoice_status', $order->invoice->status) == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                        <option value="paid"
                                            {{ old('invoice_status', $order->invoice->status) == 'paid' ? 'selected' : '' }}>
                                            Paid</option>
                                    </select>
                                    {{-- @error('invoice_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror --}}
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="employee_id" class="form-label fw-bold text-dark">
                                    <i class="fas fa-file-invoice text-primary me-2"></i>
                                    Select employee
                                </label>
                                <select name="employee_id" id="employee_id"
                                    class="form-select @error('employee_id') is-invalid @enderror">
                                    <option value="">Select employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('orders.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-save me-1"></i> Update Order
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
