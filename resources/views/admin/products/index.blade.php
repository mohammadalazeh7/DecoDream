@extends('layouts.dashboard')

@section('title', 'Products')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-couch me-2"></i> Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="product_id" class="form-label">Product ID</label>
                    <input type="text" name="product_id" id="product_id" class="form-control rounded-pill"
                        value="{{ request('product_id') }}">
                </div>
                <div class="col-md-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control rounded-pill"
                        value="{{ request('product_name') }}">
                </div>
                <div class="col-md-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control rounded-pill"
                        value="{{ request('category_name') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>
    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Fabric</th>
                    <th>Wood</th>
                    <th>Color</th>
                    <th>Price</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->photos->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->photos->first()->photo) }}"
                                    alt="{{ $product->name }}" height="30">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ Str::limit($product->description,20 )}}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ $product->fabric->fabric_type ?? '-' }}</td>
                        <td>{{ $product->wood->wood_type     ?? '-' }}</td>
                        <td>{{ $product->color->name ?? '-' }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->created_at ? $product->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-edit rounded-pill">
                                    <i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
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
                        <td colspan="7" class="text-center">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($products->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $products->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif
@endsection
