@extends('layouts.admin')

@section('title', 'Edit Expense')

@section('content')
<div class="container">
    <h2>Edit Cost</h2>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" class="form-select" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $expense->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }} - {{ $project->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="group" class="form-label">Floor Type</label>
            <select name="group" class="form-select">
                @foreach($floorTypes as $type)
                    <option value="{{ $type->id }}" {{ $expense->group == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="group2" class="form-label">Room Type</label>
            <select name="group2" class="form-select">
                @foreach($roomTypes as $type)
                    <option value="{{ $type->id }}" {{ $expense->group2 == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" value="{{ $expense->description }}" required>
        </div>

        <div class="mb-3">
            <label for="spec" class="form-label">Entity</label>
            <input type="text" name="spec" class="form-control" value="{{ $expense->spec }}">
        </div>


        <div class="mb-3">
            <label for="length" class="form-label">Length</label>
            <input type="number" step="0.01" name="length" id="length" class="form-control" placeholder="Enter length" required>
        </div>

                <div class="mb-3">
            <label for="area" class="form-label"> height or Width</label>
            <input type="number" step="0.01" name="width" id="width" class="form-control" placeholder="Enter width" required>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area</label>
            <input type="number" step="0.01" name="area" id="area" class="form-control" placeholder="Auto calculated" readonly>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" value="{{ $expense->unit }}" required>
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label">Rate/Unit</label>
            <input type="number" name="rate" class="form-control" step="0.01" value="{{ $expense->rate }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Cost</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const lengthInput = document.getElementById('length');
    const widthInput = document.getElementById('width');
    const areaInput = document.getElementById('area');

    function calculateArea() {
        const length = parseFloat(lengthInput.value) || 0;
        const width = parseFloat(widthInput.value) || 0;
        const area = length * width;
        areaInput.value = area.toFixed(2);
    }

    lengthInput.addEventListener('input', calculateArea);
    widthInput.addEventListener('input', calculateArea);
});
</script>
@endsection
