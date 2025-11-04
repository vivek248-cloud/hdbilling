@extends('layouts.admin')

@section('title', 'Edit Payment')

@section('content')
<div class="container">
    <h2>Edit Payment</h2>

    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Project Selection -->
        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" class="form-select" required>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}" {{ $payment->project_id == $project->id ? 'selected' : '' }}>
                        {{ $project->name }} - {{ $project->user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Payment Amount -->
        <div class="mb-3">
            <label for="amount" class="form-label">Payment Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01" value="{{ $payment->amount }}" required>
        </div>

        <!-- Payment Mode -->
        <div class="mb-3">
            <label for="payment_mode" class="form-label">Payment Mode</label>
            <select name="payment_mode" class="form-select" required>
                @foreach(['Cash', 'Online', 'Cheque'] as $mode)
                <option value="{{ $mode }}" {{ ($payment->payment_mode ?? 'Cash') == $mode ? 'selected' : '' }}>
                    {{ $mode }}
                </option>

                @endforeach
            </select>
        </div>

        <!-- Payment Date -->
        <div class="mb-3">
            <label for="date" class="form-label">Payment Date</label>
            <input type="date" name="date" class="form-control"
                   value="{{ \Carbon\Carbon::parse($payment->date)->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Payment</button>
    </form>
</div>
@endsection
