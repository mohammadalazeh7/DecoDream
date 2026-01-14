@extends('layouts.dashboard')

@section('title', 'Edit Invoice')

@section('page-title', 'Edit Invoice')

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow border-5">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-file-invoice-dollar text-primary me-2"></i>
                            Edit Invoice {{ $invoice->user->email }}
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
                                    <strong>Name:</strong> {{ $invoice->user->name ?? '-' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <strong>Email:</strong> {{ $invoice->user->email ?? '-' }}
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <strong>Phone:</strong> {{ $invoice->user->phone_number ?? '-' }}
                                </li>
                                <li>
                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                    <strong>Location:</strong>
                                    @if ($invoice->order && $invoice->order->location)
                                        <a href="{{ route('map.order', $invoice->order->id) }}"
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

                            <strong>Order Status:</strong> <span
                                class="badge bg-info">{{ $invoice->order->status ?? '-' }}</span><br>
                            <strong>Payment Method:</strong>
                            {{ $invoice->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'مدفوع مسبقاً' }}
                        </div>

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
                                    @foreach ($invoice->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name ?? '-' }}</td>
                                            <td>{{ number_format($item->price, 2) }}
                                                {{ config('app.currency', 'SYP') }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->price * $item->quantity, 2) }}
                                                {{ config('app.currency', 'SYP') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 text-start">
                            <p class="fs-5 text-success fw-semibold">
                                <i class="fas fa-receipt me-2"></i>
                                Total Order Price:
                                <span>{{ number_format($invoice->total_price, 2) }} $</span>
                            </p>
                        </div>

                        <form action="{{ route('invoices.update', $invoice->id) }}" method="POST" class="mt-4">
                            @csrf
                            @method('PUT')
                            @if ($invoice->order && $invoice->order->status === 'on_shipping')
                                <div class="mb-3">
                                    <label for="order_status" class="form-label fw-bold">
                                        تحديث حالة الطلب:
                                    </label>
                                    <select name="order_status" id="order_status"
                                        class="form-select rounded-pill @error('order_status') is-invalid @enderror"
                                        required>
                                        <option value="on_shipping" selected>on_shipping</option>
                                        <option value="delivered">delivered</option>
                                    </select>
                                    {{-- @error('order_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror --}}
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('invoices.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                                        <i class="fas fa-arrow-left me-1"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-save me-1"></i> Save Changes
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-info">لا يمكن تعديل حالة الطلب إلا إذا كانت حالته الحالية
                                    "on_shipping".</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
