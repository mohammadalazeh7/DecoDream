@extends('layouts.dashboard')

@section('page-title', 'Add New Fabric')

@section('page-title')
    {{ Auth::user()->name }}
@endsection


@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow  border-5">
                   <div class="card-header d-flex align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-couch text-primary me-2"></i>
                            Add New Fabric
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('fabrics.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="fabric_type" class="form-label fw-bold">Fabric Type</label>
                                <input type="text"
                                    class="form-control  @error('fabric_type') is-invalid @enderror"
                                    id="fabric_type" name="fabric_type" required>
                                @error('fabric_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('fabrics.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-plus me-1"></i> Create Fabric
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
