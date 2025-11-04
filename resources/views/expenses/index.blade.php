@extends('layouts.admin')

@section('title', 'Expenses')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <i class="bi bi-receipt-cutoff me-2"></i> Project Cost
        </h2>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Cost
        </a>
    </div>


    <form method="GET" class="row g-2 mb-4">
    <div class="col-md-6">
        <select name="user_id" class="form-select" onchange="this.form.submit()">
            <option value="">Filter by Client</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}" 
                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                    {{ $user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <a href="{{ route('expenses.index') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
    </div>
</form>


    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table align-middle mb-0">
                    <thead class="table-success">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Project</th>
                            <th scope="col">Description</th>
                            <th scope="col" class="text-end">Entity</th>
                            <th scope="col" class="text-end">Amount</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $index => $expense)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $expense->project->name }}</div>
                                    <small class="text-muted">{{ $expense->project->user->name }}</small>
                                </td>
                                <td>{{ $expense->description }}</td>
                                <td class="text-end">{{ $expense->spec ?? '-' }}</td>
                                <td class="text-end text-success fw-semibold">₹{{ number_format($expense->amount) }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('expenses.edit', $expense->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('expenses.destroy', $expense->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this expense?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-wallet-x fs-3 d-block mb-2"></i>
                                    No expenses recorded yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .table th {
        white-space: nowrap;
    }
    .table tr:hover {
        background-color: rgba(25, 135, 84, 0.05);
        transition: 0.2s ease;
    }
    .btn-warning i, .btn-danger i {
        vertical-align: middle;
    }
    @media (max-width: 768px) {
        h2 {
            font-size: 1.4rem;
        }
        .table th, .table td {
            font-size: 0.9rem;
        }
        .btn-sm {
            padding: 4px 7px;
        }
    }
</style>
@endsection
