@extends('layouts.dashboard')

@section('page-title', 'My Profile')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow border-5">
                    <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>
                            My Profile
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name:</label>
                            <div class="form-control bg-light">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email:</label>
                            <div class="form-control bg-light">{{ auth()->user()->email }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Role:</label>
                            <div class="form-control bg-light">{{ auth()->user()->role->role_name }}</div>
                        </div>

                        {{-- <div class="text-end mt-4">
                            <a href="{{ route('employees.edit') }}" class="btn btn-primary px-4 rounded-pill">
                                <i class="fas fa-edit me-1"></i> Edit Profile
                            </a>
                        </div> --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('employees.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <a
                                href="{{ route('employees.edit', auth()->user()->id) }} "class="btn btn-primary px-4 rounded-pill">
                                <i class="fas fa-edit me-1"></i> Edit Profile</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
