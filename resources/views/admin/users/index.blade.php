@extends('layouts.dashboard')

@section('title', 'Users')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-users me-2"></i> User List</h2>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="name" class="form-label">User Name</label>
                    <input type="text" name="name" id="name" class="form-control rounded-pill"
                        value="{{ request('name') }}">
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">User Email</label>
                    <input type="text" name="email" id="email" class="form-control rounded-pill"
                        value="{{ request('email') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ $user->location }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('users.orders', $user) }}" class="btn btn-info rounded-pill">
                                    <i class="fas fa-list"></i> Orders</a>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger rounded-pill"
                                        onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash"></i> Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $users->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif
@endsection
