@extends('layouts.dashboard')

@section('title', 'Fabrics')
@section('page-title')
    {{ Auth::user()->name }}
@endsection


@section('content')

    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-cut me-2" aria-hidden="true"></i> Fabric List</h2>
        <a href="{{ route('fabrics.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Fabric
        </a>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label for="fabric_type" class="form-label">Fabric Type</label>
                    <input type="text" name="fabric_type" id="fabric_type" class="form-control rounded-pill"
                        value="{{ request(key: 'fabric_type') }}">
                </div>
                <div class="col-md-6 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('fabrics.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>


    <div class="table-container mt-4" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th class="rounded-start">ID</th>
                    <th>Fabric Type</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($fabrics as $fabric)
                    <tr>
                        <td>{{ $fabric->id }}</td>
                        <td>{{ $fabric->fabric_type }}</td>
                        <td>{{ $fabric->created_at ? $fabric->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-info btn-sm rounded-pill"><i
                                        class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('fabrics.destroy', $fabric) }}" method="POST"
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
                        <td colspan="4" class="text-center">No fabrics found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($fabrics->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $fabrics->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif
@endsection
