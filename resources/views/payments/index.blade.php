@extends('layouts.admin')

@section('title', 'Payments')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <i class="bi bi-cash-stack me-2"></i> Payments
        </h2>
        <a href="{{ route('payments.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Payment
        </a>
    </div>

    <!-- Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-6">
            <select name="user_id" class="form-select">
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
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-filter"></i> Filter
            </button>
        </div>

        <div class="col-md-3">
            <a href="{{ route('payments.index') }}" class="btn btn-secondary w-100">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
        </div>
    </form>



    <!-- Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 600px; overflow-y: auto;">
                <table class="table align-middle mb-0">
                    <thead class="table-primary">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Project</th>
                            <th scope="col">Client</th>
                            <th scope="col" class="text-end">Amount Paid</th>
                            <th scope="col" class="text-center">Date</th>
                            <th scope="col" class="text-center">Time</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $index => $payment)
                            <tr>
                                <td class="text-center fw-semibold">{{ $index + 1 }}</td>
                                <td>{{ $payment->project->name }}</td>
                                <td>{{ $payment->project->user->name ?? '-' }}</td>
                                <td class="text-end text-success fw-semibold">₹{{ number_format($payment->amount, 2) }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($payment->date)->format('d-m-Y') }}</td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($payment->updated_at)->format('h:i A') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('payments.edit', $payment->id) }}" 
                                       class="btn btn-sm btn-warning me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" 
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this payment?')" 
                                                title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-wallet-x fs-3 d-block mb-2"></i>
                                    No payments recorded yet.
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
        background-color: rgba(13, 110, 253, 0.05);
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
