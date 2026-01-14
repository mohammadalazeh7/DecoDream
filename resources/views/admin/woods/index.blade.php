@extends('layouts.dashboard')

@section('title', 'Woods')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title mb-0"><i class="fas fa-tree me-2" aria-hidden="true"></i> Wood List</h2>
        <a href="{{ route('woods.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Add Wood
        </a>
    </div>
    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="wood_type" class="form-label">Wood Type</label>
                    <input type="text" name="wood_type" id="wood_type" class="form-control rounded-pill"
                        value="{{ request('wood_type') }}">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('woods.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>Wood Type</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($woods as $wood)
                    <tr>
                        <td>{{ $wood->id }}</td>
                        <td>{{ $wood->wood_type }}</td>
                        <td>{{ $wood->created_at ? $wood->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('woods.edit', $wood) }}" class="btn btn-info  rounded-pill"><i
                                        class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('woods.destroy', $wood) }}" method="POST" style="display: inline;">
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
                        <td colspan="4" class="text-center text-muted">No woods found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if ($woods->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $woods->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif
@endsection
