@extends('layouts.admin')

@section('title', 'Projects')

@section('content')
<div class="container mb-4">
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2><i class="bi bi-box-fill"></i> Projects</h2>
    <a href="{{ route('projects.create') }}" class="btn btn-primary">  <i class="bi bi-plus-circle me-1"></i>Add Project</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="table-responsive" style="height: 600px; overflow-y: auto;">
<table class="table table-bordered table-striped" style="width: 100%;">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>Project Name</th>
            <th>Client Name</th>
            <th>Status</th>
            <th>Budget</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($projects as $index => $project)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $project->name }}</td>
            <td>{{ $project->user->name ?? 'N/A' }}</td>
            <td>{{ $project->status }}</td>
            <td>₹{{ number_format($project->budget, 2) }}</td>
            <td>
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No projects found.</td>
        </tr>
        @endforelse
    </tbody>
</table>
</div>
</div>
@endsection
