@extends('layouts.client')

@section('content')
<div class="container my-4">
    {{-- 🏠 Welcome Header --}}
    <h2 class="mb-4 text-center">Welcome, {{ Auth::user()->name }}</h2>

    {{-- 💼 Project Summary Table (Desktop) --}}
    <div class="table-responsive d-none d-md-block mb-5">
        <table class="table table-hover align-middle custom-table">
            <thead class="table-dark text-center">
                <tr>
                    <th>Project</th>
                    <th>Status</th>
                    <th>Total Budget</th>
                    <th>Paid</th>
                    <th>Remaining</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                @php
                    $totalPaid = $project->payments->sum('amount');
                    $remaining = $project->budget - $totalPaid;
                @endphp
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>
                        <span class="badge 
                            @if($project->status === 'Completed') bg-success
                            @elseif($project->status === 'In Progress') bg-warning
                            @else bg-danger
                            @endif">
                            {{ $project->status }}
                        </span>
                    </td>
                    <td>₹{{ number_format($project->budget, 2) }}</td>
                    <td>₹{{ number_format($totalPaid, 2) }}</td>
                    <td class="{{ $remaining < 0 ? 'text-danger fw-semibold' : 'text-success fw-semibold' }}">
                        ₹{{ number_format($remaining, 2) }}
                        @if($remaining < 0)
                            <span class="badge bg-warning text-dark ms-2">
                                Update Payment
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- 📱 Mobile Card Layout --}}
    <div class="d-block d-md-none mb-5">
        @foreach($projects as $project)
        @php
            $totalPaid = $project->payments->sum('amount');
            $remaining = $project->budget - $totalPaid;
        @endphp
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">{{ $project->name }}</h5>
                <p>
                    Status:
                    <span class="badge 
                        @if($project->status === 'Completed') bg-success
                        @elseif($project->status === 'In Progress') bg-warning
                        @else bg-secondary
                        @endif">
                        {{ $project->status }}
                    </span>
                </p>
                <p>Total Budget: <strong>₹{{ number_format($project->budget, 2) }}</strong></p>
                <p>Paid: <strong>₹{{ number_format($totalPaid, 2) }}</strong></p>
                <p>
                    Remaining:
                    <strong class="{{ $remaining < 0 ? 'text-danger' : 'text-success' }}">
                        ₹{{ number_format($remaining, 2) }}
                    </strong>
                    @if($remaining < 0)
                        <span class="badge bg-warning text-dark ms-2">Update Payment</span>
                    @endif
                </p>
            </div>
        </div>
        @endforeach
    </div>

{{-- 🧭 Payment Filter Form --}}
<div class="mb-4 d-flex gap-2 flex-wrap align-items-center">
<form method="GET" action="{{ route('client.dashboard') }}" 
      class="d-flex flex-wrap align-items-center gap-2 mb-3">

    <div class="flex-grow-1" style="max-width: 160px;">
        <select name="payment_filter_type" 
                class="form-select form-select-sm w-100" 
                id="filterType">
            <option value="">Filter Type</option>
            <option value="date" {{ request('payment_filter_type') === 'date' ? 'selected' : '' }}>By Date</option>
            <option value="month" {{ request('payment_filter_type') === 'month' ? 'selected' : '' }}>By Month</option>
            <option value="year" {{ request('payment_filter_type') === 'year' ? 'selected' : '' }}>By Year</option>
        </select>
    </div>

    <div class="flex-grow-1" style="max-width: 200px;">
        <input 
            type="text" 
            name="payment_filter_value" 
            id="filterValue" 
            class="form-control form-control-sm w-100"
            placeholder="YYYY-MM-DD / YYYY-MM / YYYY"
            value="{{ request('payment_filter_value') }}"
        >
    </div>

    <div>
        <button class="btn btn-primary btn-sm w-100" style="min-width: 100px;">
            <i class="bi bi-filter"></i> Apply
        </button>
    </div>

    <div>
        <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm w-100" style="min-width: 100px;">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
    </div>
</form>



</div>

        {{-- 📊 Payment Details Section --}}
        @forelse($projects as $project)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>{{ $project->name }}</h5>
                <span class="badge bg-primary">Budget: ₹{{ number_format($project->budget, 2) }}</span>
            </div>
            <div class="card-body">

                <h6 class="mb-3">Payment Details</h6>

                @if($project->payments->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Amount</th>
                                <th>Payment Mode</th>
                                <th>Date</th>
                                <th>Invoice</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($project->payments as $index => $payment)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>₹{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst($payment->payment_mode) }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->date)->format('d M Y') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('payments.invoice', $payment->id) }}" 
                                    class="btn btn-outline-success btn-sm" 
                                    title="View Invoice" target="_blank">
                                            invoice
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <p class="text-muted">No payments recorded for this project yet.</p>
                @endif

            </div>
        </div>
        @empty
        <p class="text-center text-muted">No projects assigned to your account.</p>
        @endforelse

</div>

<style>
    .table-striped > tbody > tr:nth-of-type(odd) {
        background-color: #f1fdf7;
    }
    .table-hover > tbody > tr:hover {
        background-color: #e0f7e7;
    }
    h2 {
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.75em;
        text-transform: uppercase;
    }
    @media (max-width: 576px) {
        .card-body p {
            margin-bottom: 0.5rem;
        }
        .card {
            border-radius: 1rem;
        }
    }

        @media (max-width: 576px) {
        form.d-flex > div {
            flex: 1 1 100%;
            max-width: 100% !important;
        }
        .btn {
            width: 100% !important;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filterType');
    const filterValue = document.getElementById('filterValue');

    function updateInputType() {
        const type = filterType.value;

        if (type === 'date') {
            filterValue.type = 'date';
            filterValue.placeholder = 'Select Date';
        } else if (type === 'month') {
            filterValue.type = 'month';
            filterValue.placeholder = 'YYYY-MM';
        } else if (type === 'year') {
            filterValue.type = 'number';
            filterValue.placeholder = 'YYYY';
            filterValue.min = '1900';
            filterValue.max = new Date().getFullYear();
        } else {
            filterValue.type = 'text';
            filterValue.placeholder = 'YYYY-MM-DD / YYYY-MM / YYYY';
        }
    }

    filterType.addEventListener('change', updateInputType);
    updateInputType();
});
</script>



@endsection
