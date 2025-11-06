@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">Edit Floor Type</h4>

    <form method="POST" action="{{ route('floor-types.update', $floorType->id) }}">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Floor Type Name</label>
            <input type="text" name="name"
                   value="{{ $floorType->name }}"
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('floor-types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
