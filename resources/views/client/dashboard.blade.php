@extends('layouts.client')

@section('content')
<div class="container my-4">
    {{-- 🏠 Welcome Header --}}
    <h2 class="mb-4 text-center">Welcome, {{ Auth::user()->name }} </h2>


    
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


<div class="container">

    {{-- 🔍 Expense Filter Section --}}
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3 col-6">
        <select name="filter_type" class="form-select" id="expenseFilterType">
            <option value="">Filter Type</option>
            <option value="date" {{ $filterType === 'date' ? 'selected' : '' }}>By Date</option>
            <option value="month" {{ $filterType === 'month' ? 'selected' : '' }}>By Month</option>
            <option value="year" {{ $filterType === 'year' ? 'selected' : '' }}>By Year</option>
        </select>
    </div>

    <div class="col-md-3 col-6" id="expenseFilterValueWrapper">
        <input 
            type="text" 
            name="filter_value" 
            id="expenseFilterValue" 
            class="form-control"
            placeholder="YYYY-MM-DD / YYYY-MM / YYYY"
            value="{{ $filterValue }}"
        >
    </div>

    <div class="col-md-2 col-6">
        <button class="btn btn-primary w-100">
            <i class="bi bi-filter"></i> Apply
        </button>
    </div>

    <div class="col-md-2 col-6">
        <a href="{{ route('client.dashboard') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
    </div>
</form>


<div class="card mb-4 shadow-sm">

            <div class="card-body">


            {{-- 📊 Expenses Table --}}
            <div class="table-responsive">
                <h5 class="mb-3">Expense Details</h5>
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Date</th>
                            <th>Floor Type</th>
                            <th>Room Type</th>
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
                                <td>{{ $expense->floorType->name ?? '-' }}</td>
                                <td>{{ $expense->roomType->name ?? '-' }}</td>
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
                                <td colspan="12" class="text-center text-muted">No expenses found.</td>
                            </tr>
                        @endforelse
                    </tbody>

                    @if($expenses->count() > 0)
                        <tfoot>
                            <tr class="table-secondary fw-bold">
                                <td colspan="11" class="text-end">Total</td>
                                <td>₹{{ number_format($totalExpense, 2) }}</td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>
</div>



{{-- 🧭 Payment Filter Form --}}
<div class="container my-4">
<form method="GET" action="{{ route('client.dashboard') }}" class="row g-2 mb-3">

    {{-- Filter Type --}}
    <div class="col-md-3 col-6">
        <select name="payment_filter_type" class="form-select" id="paymentFilterType">
            <option value="">Filter Type</option>
            <option value="date" {{ request('payment_filter_type') === 'date' ? 'selected' : '' }}>By Date</option>
            <option value="month" {{ request('payment_filter_type') === 'month' ? 'selected' : '' }}>By Month</option>
            <option value="year" {{ request('payment_filter_type') === 'year' ? 'selected' : '' }}>By Year</option>
        </select>
    </div>

    {{-- Filter Value --}}
    <div class="col-md-3 col-6" id="paymentFilterValueWrapper">
        <input 
            type="text" 
            name="payment_filter_value" 
            id="paymentFilterValue" 
            class="form-control"
            placeholder="YYYY-MM-DD / YYYY-MM / YYYY"
            value="{{ request('payment_filter_value') }}"
        >
    </div>

    {{-- Apply Button --}}
    <div class="col-md-2 col-6">
        <button class="btn btn-primary w-100">
            <i class="bi bi-filter"></i> Apply
        </button>
    </div>

    {{-- Reset Button --}}
    <div class="col-md-2 col-6">
        <a href="{{ route('client.dashboard') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-clockwise"></i> Reset
        </a>
    </div>
</form>






</div>

        {{-- 📊 Payment Details Section --}}
        @forelse($projects as $project)
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                @if($project->payments->isNotEmpty())
                <div class="table-responsive">
                    <h5 class="mb-3">Expense Details</h5>
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
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
    function initDynamicFilter(typeId, wrapperId, inputName) {
        const filterType = document.getElementById(typeId);
        const wrapper = document.getElementById(wrapperId);

        function createInput(type, placeholder, value = '') {
            const input = document.createElement('input');
            input.name = inputName;
            input.id = typeId + '_value';
            input.value = value;
            input.className = 'form-control';
            input.placeholder = placeholder;

            if (type === 'year') {
                input.type = 'number';
                input.min = '1900';
                input.max = new Date().getFullYear();
            } else {
                input.type = type;
            }

            return input;
        }

        function updateInputType() {
            const type = filterType.value;
            const existingInput = wrapper.querySelector('input');
            const currentValue = existingInput ? existingInput.value : '';

            wrapper.innerHTML = '';

            if (type === 'date') {
                wrapper.appendChild(createInput('date', 'Select Date', currentValue));
            } else if (type === 'month') {
                wrapper.appendChild(createInput('month', 'Select Month', currentValue));
            } else if (type === 'year') {
                wrapper.appendChild(createInput('year', 'YYYY', currentValue));
            } else {
                wrapper.appendChild(createInput('text', 'YYYY-MM-DD / YYYY-MM / YYYY', currentValue));
            }
        }

        if (filterType) {
            filterType.addEventListener('change', updateInputType);
            updateInputType();
        }
    }

    // 🧩 Initialize both filters independently
    initDynamicFilter('paymentFilterType', 'paymentFilterValueWrapper', 'payment_filter_value');
    initDynamicFilter('expenseFilterType', 'expenseFilterValueWrapper', 'filter_value');
});
</script>




@endsection
