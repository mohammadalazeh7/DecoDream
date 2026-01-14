@extends('layouts.dashboard')

@section('title', 'Invoices')
@section('page-title', 'Invoices')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Invoice List</h2>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="invoice_id" class="form-label">Invoice ID</label>
                    <input type="text" name="invoice_id" id="invoice_id" class="form-control rounded-pill"
                        value="{{ request('invoice_id') }}">
                </div>
                <div class="col-md-4">
                    <label for="user_email" class="form-label">User Email</label>
                    <input type="text" name="user_email" id="user_email" class="form-control rounded-pill"
                        value="{{ request('user_email') }}">
                </div>
                {{-- <div class="col-md-3">
                    <label for="status" class="form-label">Invoice Status</label>
                    <select name="status" id="status" class="form-select rounded-pill">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>paid</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>cancelled</option>
                    </select>
                </div> --}}
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset </a>
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
                    <th>Location</th>
                    <th class="rounded-end text-center">Status</th>
                    <th class="rounded-end text-center">Order Status</th>
                    <th class="rounded-end text-center">Action</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->id }}</td>
                        <td>{{ $invoice->user->name ?? '-' }}</td>
                        <td>{{ $invoice->user->email ?? '-' }}</td>
                        <td>{{ $invoice->order->phone_number ?? '-' }}</td>
                        <td>{{ $invoice->order->location ?? '-' }}</td>
                        {{-- <td>{{ $invoice->order->location_name ?? '-' }}</td> --}}
                        <td class="text-center">
                            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            {{-- {{  $invoice->order->status }} --}}
                            <span class="badge bg-{{ $invoice->order->status == 'on_shipping' ? 'success' : 'warning' }}">
                                {{ ucfirst($invoice->order->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-info rounded-pill"><i
                                        class="fas fa-edit"></i> Edit</a>
                                @if ($invoice->order && $invoice->order->location)
                                    <a href="{{ route('map.order', $invoice->order->id) }}"
                                        class="btn btn-success  rounded-pill ms-1" target="_blank">
                                        View Map
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No Invoices found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($invoices->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $invoices->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif

@endsection
