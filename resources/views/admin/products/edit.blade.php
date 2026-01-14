@extends('layouts.dashboard')

@section('title', 'Edit Product')

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
                            <i class="fas fa-couch me-2"></i>
                            Edit Product: {{ $product->name }}
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="photos_to_delete" id="photos_to_delete" value="">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Price</label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="available_quantity" class="form-label fw-bold">Available Quantity</label>
                                <input type="number" class="form-control @error('available_quantity') is-invalid @enderror"
                                    id="available_quantity" name="available_quantity"
                                    value="{{ old('available_quantity', $product->available_quantity) }}" required>
                                @error('available_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-bold">Category</label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="color_id" class="form-label fw-bold">Color</label>
                                <select class="form-select rounded-pill @error('color_id') is-invalid @enderror"
                                    id="color_id" name="color_id" required>
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}"
                                            {{ old('color_id', $product->color_id) == $color->id ? 'selected' : '' }}>
                                            {{ $color->name }}</option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="fabric_id" class="form-label fw-bold">Fabric</label>
                                <select class="form-select rounded-pill @error('fabric_id') is-invalid @enderror"
                                    id="fabric_id" name="fabric_id" required>
                                    <option value="">Select Fabric</option>
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{ $fabric->id }}"
                                            {{ old('fabric_id', $product->fabric_id) == $fabric->id ? 'selected' : '' }}>
                                            {{ $fabric->fabric_type }}</option>
                                    @endforeach
                                </select>
                                @error('fabric_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="wood_id" class="form-label fw-bold">Wood</label>
                                <select class="form-select rounded-pill @error('wood_id') is-invalid @enderror"
                                    id="wood_id" name="wood_id" required>
                                    <option value="">Select Wood</option>
                                    @foreach ($woods as $wood)
                                        <option value="{{ $wood->id }}"
                                            {{ old('wood_id', $product->wood_id) == $wood->id ? 'selected' : '' }}>
                                            {{ $wood->wood_type }}</option>
                                    @endforeach
                                </select>
                                @error('wood_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label fw-bold">Product Images</label>
                                <input type="file" name="images[]" id="images"
                                    class="form-control rounded-pill @error('images.*') is-invalid @enderror" multiple>
                                <small class="text-muted">You can select multiple images. Supported formats: JPEG, PNG, JPG,
                                    GIF. Max size: 2MB per image.</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if ($product->photos->isEmpty())
                                    <p class="text-muted mt-2">No photo for this Product</p>
                                @else
                                    <div class="row g-2 mt-2" id="photos-container">
                                        @foreach ($product->photos as $photo)
                                            <div class="col-md-3 mb-2 position-relative photo-item"
                                                data-photo-id="{{ $photo->id }}">
                                                <img src="{{ asset('storage/' . $photo->photo) }}" alt="Product Image"
                                                    style="max-width: 100px;" class="photo-image rounded">
                                                <button type="button"
                                                    class="btn btn-danger btn-sm position-absolute top-0 start-100 translate-middle delete-photo-btn"
                                                    onclick="markPhotoForDeletion({{ $photo->id }})"
                                                    title="Mark for deletion">&times;</button>
                                                <div class="deletion-overlay" style="display: none;">
                                                    <div class="deletion-text">سيتم الحذف</div>
                                                    <button type="button"
                                                        class="btn btn-sm btn-success restore-photo-btn"
                                                        onclick="restorePhoto({{ $photo->id }})"
                                                        title="Restore photo">استعادة</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-dark px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="fas fa-save me-1"></i> Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .photo-item {
            transition: all 0.3s ease;
        }

        .photo-item.marked-for-deletion {
            opacity: 0.5;
            position: relative;
        }

        .photo-item.marked-for-deletion .photo-image {
            filter: grayscale(100%);
        }

        .deletion-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(220, 53, 69, 0.8);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 4px;
            z-index: 10;
        }

        .deletion-text {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .restore-photo-btn {
            font-size: 0.75rem;
            padding: 2px 6px;
        }
    </style>

    <script>
        let photosToDelete = [];

        function markPhotoForDeletion(photoId) {
            if (!photosToDelete.includes(photoId)) {
                photosToDelete.push(photoId);
                updatePhotosToDeleteInput();

                const photoItem = document.querySelector(`[data-photo-id="${photoId}"]`);
                photoItem.classList.add('marked-for-deletion');
                photoItem.querySelector('.delete-photo-btn').style.display = 'none';
                photoItem.querySelector('.deletion-overlay').style.display = 'flex';
            }
        }

        function restorePhoto(photoId) {
            const index = photosToDelete.indexOf(photoId);
            if (index > -1) {
                photosToDelete.splice(index, 1);
                updatePhotosToDeleteInput();

                const photoItem = document.querySelector(`[data-photo-id="${photoId}"]`);
                photoItem.classList.remove('marked-for-deletion');
                photoItem.querySelector('.delete-photo-btn').style.display = 'block';
                photoItem.querySelector('.deletion-overlay').style.display = 'none';
            }
        }

        function updatePhotosToDeleteInput() {
            document.getElementById('photos_to_delete').value = photosToDelete.join(',');
        }

        function confirmCancel() {
            if (photosToDelete.length > 0) {
                return confirm('لديك صور محددة للحذف. هل تريد إلغاء كل التغييرات والعودة؟');
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            photosToDelete = [];
            updatePhotosToDeleteInput();
        });
    </script>
@endsection
