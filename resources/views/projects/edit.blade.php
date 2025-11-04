@extends('layouts.admin')

@section('title', 'Edit Project')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Project</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Project Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $project->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Client</label>
                <select name="user_id" id="user_id" class="form-select" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ $project->user_id == $client->id ? 'selected' : '' }}>
                            {{ $client->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="budget" class="form-label">Budget</label>
                <input type="number" name="budget" id="budget" class="form-control" value="{{ old('budget', $project->budget) }}" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="Pending" {{ $project->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Ongoing" {{ $project->status == 'Ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="Completed" {{ $project->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Project</button>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
