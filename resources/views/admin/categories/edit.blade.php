@extends('layouts.dashboard')

@section('page-title', 'Edit Category')

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
                        <i class="fas fa-list-alt me-2"></i>
                        Edit Category: {{ $category->name }}
                    </h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="icon" class="form-label fw-bold">Category Icon</label>
                            @if($category->icon)
                                <div class="mb-2">
                                    <label class="form-label">Current Icon:</label>
                                    <img src="{{ $category->icon_url }}" alt="{{ $category->name }} icon" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('icon') is-invalid @enderror" id="icon" name="icon" accept="image/*">
                            <div class="form-text">Upload a new icon for this category (PNG, JPG, GIF, SVG - max 2MB)</div>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('categories.index') }}" class="btn btn-outline-dark px-4 rounded-pill">
                                <i class="fas fa-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                                <i class="fas fa-save me-1 "></i> Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
