@extends('layouts.admin')

@section('title', 'Add Payment')

@section('content')
<div class="container">
    <h2 class="mb-4 text-primary">Add Payment</h2>

    <form action="{{ route('payments.store') }}" method="POST" class="shadow p-4 rounded bg-white">
        @csrf

        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" class="form-select" required>
                <option value="">Select Project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">
                        {{ $project->name }} — {{ $project->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Payment Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="payment_mode" class="form-label">Payment Mode</label>
            <select name="payment_mode" class="form-select" required>
                <option value="">Select Payment Mode</option>
                <option value="Cash">Cash</option>
                <option value="Online">Online</option>
                <option value="Cheque">Cheque</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date" class="form-label">Payment Date</label>
            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Add Payment</button>
    </form>
</div>
@endsection
