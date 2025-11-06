@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">Add Floor Type</h4>

    <form method="POST" action="{{ route('floor-types.store') }}">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Floor Type Name</label>
            <input type="text" name="name" class="form-control" placeholder="e.g. Granite" required>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('floor-types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
