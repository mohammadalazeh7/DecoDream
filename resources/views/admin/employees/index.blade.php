@extends('layouts.dashboard')

@section('title', 'Employees')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-users me-2"></i> Employee List</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Employee
        </a>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="user_search" class="form-label">Employee Name</label>
                    <input type="text" name="user_search" id="user_search" class="form-control rounded-pill"
                        value="{{ request('user_search') }}">
                </div>
                <div class="col-md-3">
                    <label for="email_search" class="form-label">Employee Email</label>
                    <input type="text" name="email_search" id="email_search" class="form-control rounded-pill"
                        value="{{ request('email_search') }}">
                </div>

                <div class="col-md-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select name="role_id" id="role_id" class="form-select rounded-pill">
                        <option value="">All Roles</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
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
                    <th>Role</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->role->role_name }}</td>
                        <td>{{ $employee->created_at ? $employee->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('employees.edit', $employee) }}" class="btn btn-info rounded-pill">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-danger  border: none  border-radius: 8px; rounded-pill"
                                        onclick="return confirm('هل أنت متأكد؟')"><i class="fas fa-trash"></i>
                                        Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No employees found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($employees->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $employees->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif

@endsection
