@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h3>Customer Details</h3>
    <div class="card p-3 mb-4">
        <p><strong>Name:</strong> {{ $customer->name }}</p>
        <p><strong>Phone:</strong> {{ $customer->phone ?? '—' }}</p>
        <p><strong>Email:</strong> {{ $customer->email ?? '—' }}</p>
    </div>

    <h5>Product Details</h5>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Full/Semi</th>
                <th>Core Material</th>
                <th>Finish Material</th>
                <th>Brand/Origin</th>
                <th>Specification</th>
                <th>Unit</th>
                <th>Length</th>
                <th>Width</th>
                <th>Area</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customer->products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $product->fullSemiType->name ?? '—' }}</td>
                    <td>{{ $product->core_material ?? '—' }}</td>
                    <td>{{ $product->finish_material ?? '—' }}</td>
                    <td>{{ $product->brand ?? '—' }}</td>
                    <td>{{ $product->specification ?? '—' }}</td>
                    <td>{{ $product->unit ?? '—' }}</td>
                    <td>{{ $product->length ?? 0 }}</td>
                    <td>{{ $product->width ?? 0 }}</td>
                    <td>{{ $product->area ?? 0 }}</td>
                    <td>{{ $product->price ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

<div class="d-flex gap-2 mt-3">
    <!-- EDIT CUSTOMER -->
    <a href="{{ route('customers.edit', $customer->id) }}" 
       class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit Customer
    </a>

    <!-- VIEW & PRINT QUOTATION -->
    <a href="{{ route('quotation.show', $customer->id) }}" 
       class="btn btn-primary" target="_blank">
        <i class="bi bi-eye"></i> View Quotation
    </a>
</div>
</div>
@endsection
