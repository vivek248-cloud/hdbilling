@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center"><i class="bi bi-briefcase-fill"></i> Admin Dashboard</h2>

    <div class="table-responsive shadow-sm rounded-4 mt-3">
    <table class="table table-striped table-hover align-middle mb-0">
        <thead class="table-dark text-center">
            <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Client</th>
                <th>Status</th>
                <th>Total Budget</th>
                <th>Total Paid</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            @forelse($projects as $index => $project)
            <tr class="text-center table-row" 
                style="cursor: pointer;" 
                onclick="window.location='{{ route('projects.payments', $project->id) }}'">
                
                <td>{{ $index + 1 }}</td>
                <td class="text-start fw-semibold">
                    <i class="bi bi-pin-angle-fill"></i> {{ $project->name }}
                </td>
                <td>{{ $project->user->name ?? '-' }}</td>
                <td>
                    @php
                        $statusClass = match($project->status) {
                            'Pending' => 'bg-danger text-white',
                            'In Progress' => 'bg-warning text-dark',
                            'Completed' => 'bg-success text-white',
                            default => 'bg-secondary',
                        };
                    @endphp
                    <span class="badge {{ $statusClass }} px-3 py-2 rounded-pill shadow-sm">
                        {{ $project->status }}
                    </span>
                </td>
                <td class="text-success fw-semibold">₹{{ number_format($project->budget, 2) }}</td>
                <td class="text-primary fw-semibold">₹{{ number_format($project->amount_paid, 2) }}</td>
                <td>
                    <span class="{{ $project->remaining_amount < 0 ? 'text-danger fw-semibold' : 'text-danger fw-semibold' }}">
                        ₹{{ number_format($project->remaining_amount, 2) }}
                    </span>
                    @if($project->remaining_amount < 0)
                        <span class="badge bg-warning text-dark ms-2">
                            Update Payment
                        </span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">
                    <i class="bi bi-exclamation-circle me-2"></i>No projects available.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>


</div>

<style>
/* Improve mobile responsiveness */
@media (max-width: 767px) {
    table.table thead {
        display: none;
    }
    table.table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
        padding: 0.5rem;
    }
    table.table tbody td {
        display: flex;
        justify-content: space-between;
        padding: 0.25rem 0.5rem;
        border: none;
    }
    table.table tbody td::before {
        content: attr(data-label);
        font-weight: 600;
    }
}
</style>
@endsection
