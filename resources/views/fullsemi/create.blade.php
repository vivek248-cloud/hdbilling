@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Add New Full / Semi Type</h2>

    <a href="{{ route('fullsemi.index') }}" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Back
    </a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>There were some problems with your input:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('fullsemi.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Type Name</label>
                    <select name="name" id="name" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="Full">Full</option>
                        <option value="Semi">Semi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rate" class="form-label">Rate (₹)</label>
                    <input type="number" name="rate" id="rate" class="form-control" placeholder="Enter rate in ₹" required step="0.01">
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle"></i> Save
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
