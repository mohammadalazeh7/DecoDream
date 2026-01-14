@extends('layouts.dashboard')

@section('page-title', 'Add New Employee')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container-fluid py-4 ">
        <div class="row justify-content-center ">
            <div class="col-lg-8 ">
                <div class="card shadow border-5 ">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Employee
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('employees.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold">Password</label>
                                <input type="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror" id="password"
                                    name="password" value="{{ old('password') }}" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="role_id" class="form-label fw-bold">Role</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" id="role_id" name="role_id">
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-plus me-1"></i> Create Employee
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
