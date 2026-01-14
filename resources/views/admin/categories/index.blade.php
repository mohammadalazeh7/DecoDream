@extends('layouts.dashboard')

@section('title', 'Categories')

@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-list-alt me-2"></i> Category List</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" name="category_name" id="category_name" class="form-control rounded-pill"
                        value="{{ request('category_name') }}">
                </div>

                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if ($category->icon)
                                <img src="{{ $category->icon_url }}" alt="{{ $category->name }} icon" class="img-thunbnail"
                                    style="max-width: 50px; max-height: 50px;">
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format('d-m-Y') : 'No Date' }}</td>
                       <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('categories.edit', $category) }}"class="btn btn-info rounded-pill"><i
                                        class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
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
                        <td colspan="5" class="text-center">No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($categories->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $categories->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif

@endsection
