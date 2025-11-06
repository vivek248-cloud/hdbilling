@extends('layouts.admin')

@section('content')
<div class="container">
    <h4 class="fw-bold mb-3">Edit Room Type</h4>

    <form method="POST" action="{{ route('room-types.update', $roomType->id) }}">
        @csrf @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Room Name</label>
            <input type="text" name="name"
                   value="{{ $roomType->name }}"
                   class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('room-types.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
