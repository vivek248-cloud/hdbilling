@extends('layouts.admin')

@section('title', 'Add Expense')

@section('content')
<div class="container">
    <h2>Add Cost</h2>

    <form action="{{ route('expenses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" class="form-select" required>
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->name }} - {{ $project->user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input type="text" name="description" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="spec" class="form-label">Entity</label>
            <input type="text" name="spec" class="form-control">
        </div>

        <div class="mb-3">
            <label for="length" class="form-label">Length</label>
            <input type="number" step="0.01" name="length" id="length" class="form-control" placeholder="Enter length" required>
        </div>

        <div class="mb-3">
            <label for="width" class="form-label">Width</label>
            <input type="number" step="0.01" name="width" id="width" class="form-control" placeholder="Enter width" required>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area</label>
            <input type="number" step="0.01" name="area" id="area" class="form-control" placeholder="Auto calculated" readonly>
        </div>

        <div class="mb-3">
            <label for="unit" class="form-label">Unit</label>
            <input type="text" name="unit" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="rate" class="form-label">Rate/Unit</label>
            <input type="number" name="rate" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Cost</button>
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
