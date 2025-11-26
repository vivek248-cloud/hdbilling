@extends('layouts.admin')

@section('content')
<div class="container">
    <h2> Quotations List</h2>
    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">+ Add Quotation</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Products Count</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone ?? '—' }}</td>
                <td>{{ $customer->email ?? '—' }}</td>
                <td>{{ $customer->products->count() }}</td>
                <td>
                    <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-sm btn-primary">View</a>
                    <form method="POST" action="{{ route('customers.destroy', $customer->id) }}" style="display:inline;">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this customer?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
