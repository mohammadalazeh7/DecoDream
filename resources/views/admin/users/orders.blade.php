@extends('layouts.dashboard')

@section('title', 'User Orders')

@section('page-title')
    Orders for {{ $user->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-list me-2"></i> Orders for {{ $user->name }}</h2>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back to Users</a>
    </div>

    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>Status</th>
                    <th>Total Price</th>
                    <th>Created Date</th>
                    <th>Order Items</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->status }}</td>
                        <td>{{ $order->total_price }}</td>
                        <td>{{ $order->created_at ? $order->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td>
                            <ul>
                                @foreach($order->orderItems as $item)
                                    <li>{{ $item->product->name ?? 'N/A' }} x {{ $item->quantity }} ({{ $item->price }})</li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No orders found for this user</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
