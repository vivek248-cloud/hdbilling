@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Full / Semi Type</h2>

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
            <form method="POST" action="{{ route('fullsemi.update', $fullSemiType->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Type Name</label>
                    <select name="name" id="name" class="form-select" required>
                        <option value="Full" {{ $fullSemiType->name == 'Full' ? 'selected' : '' }}>Full</option>
                        <option value="Semi" {{ $fullSemiType->name == 'Semi' ? 'selected' : '' }}>Semi</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rate" class="form-label">Rate (₹)</label>
                    <input type="number" name="rate" id="rate" class="form-control" value="{{ $fullSemiType->rate }}" step="0.01" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Update
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
