@extends('layouts.dashboard')

@section('title', 'Add New Wood')

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
                            <i class="fas fa-tree text-primary me-2"></i>
                            Add New Wood
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('woods.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="wood_type" class="form-label fw-bold">Wood Type</label>
                                <input type="text"
                                    class="form-control rounded-pill @error('wood_type') is-invalid @enderror"
                                    id="wood_type" name="wood_type" value="{{ old('wood_type') }}" required>
                                @error('wood_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('woods.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary rounded-pill px-4">
                                    <i class="fas fa-plus me-1"></i> Create Wood
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
