@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Full / Semi Types</h2>

    <a href="{{ route('fullsemi.create') }}" class="btn btn-primary mb-3">
        <i class="bi bi-plus-circle"></i> Add New Type
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Rate (₹)</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fullSemiTypes as $index => $type)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $type->name }}</td>
                            <td>₹{{ number_format($type->rate, 2) }}</td>
                            <td>{{ $type->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('fullsemi.edit', $type->id) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('fullsemi.destroy', $type->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this type?')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No Full/Semi Types found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
