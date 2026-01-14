@extends('layouts.dashboard')

@section('page-title', 'Edit Employee')

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
                            <i class="fas fa-exclamation-circle text-primary me-2"></i>
                            Edit Complaint From {{ $complaint->user->name }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('complaints.update', $complaint->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label fw-bold">User Name</label>
                                <input type="text" class="form-control " value="{{ $complaint->user->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <textarea class="form-control " rows="3" readonly>{{ $complaint->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Type</label>
                                <input type="text" class="form-control " value="{{ ucfirst($complaint->type) }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label fw-bold">Status</label>
                                <select class="form-select rounded-pill" id="status" name="status" required>
                                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>
                                        Resolved</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('complaints.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                    <i class="fas fa-save me-1"></i> Update Complaint
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
