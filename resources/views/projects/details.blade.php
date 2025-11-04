@extends('layouts.admin')

@section('title', 'Project Payments - ' . $project->name . ' (' . $user->name . ')')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold mb-0"><i class="bi bi-box-fill"></i> {{ $project->name }} ({{ $user->name }})</h3>
        <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

{{-- 🔍 Expense Filter Section --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3 col-6">
        <select name="filter_type" class="form-select" id="filterType">
            <option value="">Filter Type</option>
            <option value="date" {{ request('filter_type') === 'date' ? 'selected' : '' }}>By Date</option>
            <option value="month" {{ request('filter_type') === 'month' ? 'selected' : '' }}>By Month</option>
            <option value="year" {{ request('filter_type') === 'year' ? 'selected' : '' }}>By Year</option>
        </select>
    </div>

    <div class="col-md-3 col-6">
        <input 
            type="text" 
            name="filter_value" 
            id="filterValue" 
            class="form-control"
            placeholder="YYYY-MM-DD / YYYY-MM / YYYY"
            value="{{ request('filter_value') }}"
        >
    </div>

    <div class="col-md-2 col-6">
        <button class="btn btn-primary w-100">
            <i class="bi bi-filter"></i> Apply
        </button>
    </div>

    <div class="col-md-2 col-6">
        <a href="{{ route('projects.payments', $project->id) }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
    </div>
</form>


    {{-- Expenses Table --}}
    <div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Description</th>
                <th>Spec</th>
                <th>Length</th>
                <th>Width</th>
                <th>Area</th>
                <th>Unit</th>
                <th>Rate</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($expenses as $index => $expense)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-m-Y') }}</td>
                    <td>{{ $expense->description }}</td>
                    <td>{{ $expense->spec ?? '-' }}</td>
                    <td>{{ $expense->length }}</td>
                    <td>{{ $expense->width }}</td>
                    <td>{{ number_format($expense->area, 2) }}</td>
                    <td>{{ $expense->unit }}</td>
                    <td>₹{{ number_format($expense->rate, 2) }}</td>
                    <td>₹{{ number_format($expense->area * $expense->rate, 2) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No expenses found.</td>
                </tr>
            @endforelse
        </tbody>
        @if($expenses->count() > 0)
        <tfoot>
            <tr class="table-secondary fw-bold">
                <td colspan="9" class="text-end">Total</td>
                <td>₹{{ number_format($totalExpense, 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

</div>



    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title text-secondary mb-3">Payment History</h5>

            {{-- 🔍 Filter Section --}}
            {{-- 🔸 Payments Filter --}}
            <form method="GET" action="{{ route('projects.payments', $project->id) }}" class="row g-2 mb-3">
                <div class="col-md-3 col-6">
                    <select name="payment_filter_type" class="form-select" id="paymentFilterType">
                        <option value="">Filter Type</option>
                        <option value="date" {{ request('payment_filter_type') === 'date' ? 'selected' : '' }}>By Date</option>
                        <option value="month" {{ request('payment_filter_type') === 'month' ? 'selected' : '' }}>By Month</option>
                        <option value="year" {{ request('payment_filter_type') === 'year' ? 'selected' : '' }}>By Year</option>
                    </select>
                </div>

                <div class="col-md-3 col-6">
                    <input 
                        type="text" 
                        name="payment_filter_value" 
                        id="paymentFilterValue" 
                        class="form-control"
                        placeholder="YYYY-MM-DD / YYYY-MM / YYYY"
                        value="{{ request('payment_filter_value') }}"
                    >
                </div>

                <div class="col-md-2 col-6">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-filter"></i> Apply
                    </button>
                </div>

                <div class="col-md-2 col-6">
                    <a href="{{ route('projects.payments', $project->id) }}" class="btn btn-secondary w-100">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </a>
                </div>
            </form>


            {{-- 💰 Payments Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Mode</th>
                            <th>Amount Paid (Now)</th>
                            <th>Cumulative (Before)</th>
                            <th>Remaining (After)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $cumulative = 0; @endphp
                        @forelse($payments as $index => $payment)
                            @php
                                $before = $cumulative;
                                $cumulative += $payment->amount;
                                $remaining = $project->budget - $cumulative;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($payment->date ?? $payment->created_at)->format('d M Y') }}</td>
                                
                                @php
                                    $modeClass = match($payment->payment_mode) {
                                        'Cash' => 'bg-success text-light',
                                        'Online' => 'bg-primary text-light',
                                        'Cheque' => 'bg-warning text-dark',
                                        'Card' => 'bg-secondary text-light',
                                        default => 'bg-dark text-light',
                                    };
                                @endphp

                                <td>
                                    <span class="badge {{ $modeClass }}">
                                        {{ $payment->payment_mode ?? 'N/A' }}
                                    </span>
                                </td>

                                <td class="text-success fw-bold">₹{{ number_format($payment->amount, 2) }}</td>
                                <td>₹{{ number_format($before, 2) }}</td>
                                <td class="text-danger fw-semibold">₹{{ number_format($remaining, 2) }}</td>
                                <td>
                                    <a href="{{ route('payments.invoice', $payment->id) }}" class="btn btn-outline-success btn-sm me-1" title="View Invoice" target="_blank">
                                        <i class="bi bi-receipt"></i>
                                    </a>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-outline-primary btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                        @php
                                            // ✅ Non-expiring invoice link
                                            $permanentLink = route('payments.invoice', $payment->id);

                                            $message = "*Invoice Details* 🧾\n"
                                                . "Project: *{$project->name}*\n"
                                                . "Amount: *₹" . number_format($payment->amount, 2) . "*\n"
                                                . "Date: " . \Carbon\Carbon::parse($payment->date ?? $payment->created_at)->format('d M Y') . "\n\n"
                                                . "Click below to view your invoice 👇\n"
                                                . "<" . $permanentLink . ">\n\n"
                                                . "_This link will not expire._";
                                        @endphp

                                        <a href="https://wa.me/?text={{ urlencode($message) }}"
                                        target="_blank"
                                        class="btn btn-outline-success btn-sm"
                                        title="Share Invoice via WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                        </a>


                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">
                                    <i class="bi bi-exclamation-circle me-2"></i>No payments found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


{{-- Bootstrap Icons --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
.card { border-radius: 16px; }
.badge { font-size: 0.8rem; }
.btn-sm i { font-size: 1rem; }
@media (max-width: 768px) {
    table { font-size: 0.85rem; }
    .btn-sm { padding: 0.25rem 0.4rem; }
}
</style>

{{-- JS to change input type dynamically --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('filterType');
    const filterValue = document.getElementById('filterValue');

    function updateInputType() {
        const type = filterType.value;
        filterValue.type = type === 'date' ? 'date' : (type === 'month' ? 'month' : 'text');
        filterValue.placeholder = type === 'year' ? 'YYYY' : (type === 'month' ? 'YYYY-MM' : 'Select Date');
    }

    filterType.addEventListener('change', updateInputType);
    updateInputType();
});


document.addEventListener('DOMContentLoaded', function() {
    const filterType = document.getElementById('paymentFilterType');
    const filterValue = document.getElementById('paymentFilterValue');

    function updateInputType() {
        const type = filterType.value;
        filterValue.type = type === 'date' ? 'date' : (type === 'month' ? 'month' : 'text');
        filterValue.placeholder = type === 'year' ? 'YYYY' : (type === 'month' ? 'YYYY-MM' : 'Select Date');
    }

    filterType.addEventListener('change', updateInputType);
    updateInputType();
});

</script>
@endsection
