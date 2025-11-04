@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <h2 class="fw-bold mb-3 mb-md-0">
            <i class="bi bi-people-fill me-2"></i> Users Management
        </h2>
        <a href="{{ route('users.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-person-plus me-1"></i> Add User
        </a>
    </div>

    <!-- Table Wrapper -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col" class="text-center">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Mobile</th>
                            <th scope="col">Role</th>
                            <th scope="col" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                            <tr class="border-bottom">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-semibold">{{ $user->name }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @else
                                        <span class="badge bg-success">Client</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.edit', $user->id) }}" 
                                       class="btn btn-sm btn-warning me-1">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" 
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <i class="bi bi-person-x fs-3 d-block mb-2"></i>
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styling -->
<style>
    .table th {
        white-space: nowrap;
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .table tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
    }
    .btn-warning i, .btn-danger i {
        vertical-align: middle;
    }
    @media (max-width: 768px) {
        .card {
            border-radius: 0;
        }
        h2 {
            font-size: 1.4rem;
        }
        .table th, .table td {
            font-size: 0.9rem;
        }
        .btn-sm {
            padding: 5px 8px;
        }
    }
</style>
@endsection
