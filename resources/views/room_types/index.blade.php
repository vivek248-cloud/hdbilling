@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Room Types</h4>
        <a href="{{ route('room-types.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle"></i> Add Room Type
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Room Type</th>
                    <th width="150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roomTypes as $index => $roomType)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td class="text-capitalize">{{ $roomType->name }}</td>
                    <td>
                        <a href="{{ route('room-types.edit', $roomType->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST" style="display:inline-block;">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Delete this room type?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
