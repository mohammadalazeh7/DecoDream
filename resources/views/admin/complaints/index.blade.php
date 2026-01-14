@extends('layouts.dashboard')

@section('title', 'Complaint')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title"><i class="fas fa-comment-dots" aria-hidden="true"></i> Complaint List</h2>
    </div>

    <div class="card shadow border-0 mb-4" style="border-radius: 30px; background: #fff;">
        <div class="card-body">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="complaint_id" class="form-label">Complaint ID</label>
                    <input type="text" name="complaint_id" id="complaint_id" class="form-control rounded-pill"
                        value="{{ request('complaint_id') }}">
                </div>
                <div class="col-md-3">
                    <label for="user_name" class="form-label">User Name</label>
                    <input type="text" name="user_name" id="user_name" class="form-control rounded-pill"
                        value="{{ request('user_name') }}">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Complaints Status</label>
                    <select name="status" id="status" class="form-select rounded-pill">
                        <option value="">All Status</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>resolved</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>pending</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill flex-grow-1">Search</button>
                    <a href="{{ route('complaints.index') }}" class="btn btn-secondary rounded-pill flex-grow-1">Reset</a>
                </div>
            </form>
        </div>
    </div>
    {{-- Main --}}
    <div class="table-container mt-2" style="background: #fff; border-radius: 30px;">
        <table class="table mb-0" style="border-radius: 30px; overflow: hidden;">
            <thead style="background: #2F5D50; color: #fff;">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Created Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody style="color: #222;">
                @forelse($complaints as $complaint)
                    <tr>
                        <td>{{ $complaint->id }}</td>
                        <td>{{ $complaint->user->name }}</td>
                        <td>{{ Str::limit($complaint->description, 20) }}</td>
                        <td>
                            <span class="badge bg-{{ $complaint->status == 'pending' ? 'warning' : 'success' }}">
                                {{ $complaint->status }}
                            </span>
                        </td>
                        <td>{{ $complaint->type }}</td>
                        <td>{{ $complaint->created_at->format('d-M-Y') }}</td>
                        <td class="text-center">
                            <div class="action-button">
                                <a href="{{ route('complaints.edit', $complaint->id) }}"
                                    class="btn btn-info rounded-pill"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('complaints.destroy', $complaint->id) }}" method="post"
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
                        <td colspan="7" class="text-center">No complaints found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($complaints->hasPages())
        <div class="d-flex justify-content-start mt-3">
            {{ $complaints->links('pagination::simple-bootstrap-5') }}
        </div>
    @endif

@endsection
