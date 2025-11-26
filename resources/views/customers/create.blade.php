@extends('layouts.admin')

@section('content')
<div class="container" style="width: 100%;">
    <h2>Add New Customer & Products</h2>

    <form method="POST" action="{{ route('customers.store') }}">
        @csrf

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control">
        </div>

        <h4>Product Details</h4>

        <div class="table-responsive  table-dark" style="max-width: 100%; overflow-x: auto;">
        <table class="table table-bordered align-middle text-center table-striped" id="productTable" style="min-width: 1400px;">
            <thead>
                <tr class="table-secondary  table-dark bg-dark">
                    <th style="width: 120px;">Item Name</th>
                    <th style="width: 155px;">Full/Semi</th>
                    <th>Core Material</th>
                    <th>Finish Material</th>
                    <th>Brand/Origin</th>
                    <th style="width: 130px;">Specification</th>
                    <th style="width: 100px;">Unit</th>
                    <th style="width: 100px;">Length</th>
                    <th>Width/Height</th>
                    <th style="width: 120px;">Area</th>
                    <th style="width: 120px;">Price</th>
                    <th>Total (Auto)</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="text" name="products[0][product_name]" class="form-control" required></td>

                {{-- 🟩 Full/Semi Dropdown --}}
                <td style="width: 130px;">
                    <select name="products[0][type]" class="form-select fullSemiSelect" required>
                        <option value="">Select</option>
                        @foreach($fullSemiTypes as $type)
                            <option value="{{ $type->id }}" data-rate="{{ $type->rate }}">
                                {{ $type->name }} (₹{{ number_format($type->rate, 2) }})
                            </option>
                        @endforeach
                    </select>
                </td>


                    <td><input type="text" name="products[0][core_material]" class="form-control" placeholder="Eg: Plywood"></td>
                    <td><input type="text" name="products[0][finish_material]" class="form-control" placeholder="Eg: Laminate"></td>
                    <td><input type="text" name="products[0][brand]" class="form-control" placeholder="Eg: Greenply"></td>
                    <td><input type="text" name="products[0][specification]" class="form-control"></td>
                    <td><input type="text" name="products[0][unit]" class="form-control"></td>
                    <td><input type="number" name="products[0][length]" class="form-control length" step="0.01"></td>
                    <td><input type="number" name="products[0][width]" class="form-control width" step="0.01"></td>
                    <td><input type="number" name="products[0][area]" class="form-control area" step="0.01" readonly></td>
                    {{-- 💰 Price (Auto-filled when Full/Semi selected) --}}
                    <td><input type="number" name="products[0][price]" class="form-control price" step="0.01" readonly></td>
                    <td><input type="number" name="products[0][total]" class="form-control total" step="0.01" readonly></td>
                    <td><button type="button" class="btn btn-danger removeRow">X</button></td>
                </tr>
            </tbody>
        </table>

        </div>
        <button type="button" class="btn btn-secondary" id="addRow">+ Add Product</button>
        <button type="submit" class="btn btn-primary">Save</button>
        <a href="{{ route('fullsemi.index') }}" class="btn btn-info" target="_blank">
            <i class="bi bi-list-check me-1"></i> Full / Semi Types
        </a>
    </form>
</div>

{{-- 🧠 Smart JS Calculation --}}
<script>
let rowCount = 1;

// ✅ Function to calculate area & total
function calculateRowValues(row) {
    const length = parseFloat(row.querySelector('.length')?.value || 0);
    const width = parseFloat(row.querySelector('.width')?.value || 0);
    const price = parseFloat(row.querySelector('.price')?.value || 0);

    const area = length * width;
    const total = area * price;

    row.querySelector('.area').value = area.toFixed(2);
    row.querySelector('.total').value = total.toFixed(2);
}

// ✅ Add new row dynamically
document.getElementById('addRow').addEventListener('click', () => {
    const tbody = document.querySelector('#productTable tbody');
    const options = `@foreach($fullSemiTypes as $type)
                        <option value="{{ $type->id }}" data-rate="{{ $type->rate }}">
                            {{ $type->name }} (₹{{ $type->rate }})
                        </option>
                    @endforeach`;

    const newRow = `
        <tr>
            <td><input type="text" name="products[${rowCount}][product_name]" class="form-control" required></td>

            {{-- 🟩 Full/Semi dropdown --}}
            <td>
                <select name="products[${rowCount}][full_semi_id]" class="form-select fullSemiSelect">
                    <option value="">Select Type</option>
                    ${options}
                </select>
            </td>

            

            <td><input type="text" name="products[${rowCount}][core_material]" class="form-control" placeholder="Eg: Plywood"></td>
            <td><input type="text" name="products[${rowCount}][finish_material]" class="form-control" placeholder="Eg: Laminate"></td>
            <td><input type="text" name="products[${rowCount}][brand]" class="form-control" placeholder="Eg: Greenply"></td>
            <td><input type="text" name="products[${rowCount}][specification]" class="form-control" placeholder="Eg: Glossy Finish"></td>
            <td><input type="text" name="products[${rowCount}][unit]" class="form-control" placeholder="Sqft / Meter"></td>
            <td><input type="number" name="products[${rowCount}][length]" class="form-control length" step="0.01"></td>
            <td><input type="number" name="products[${rowCount}][width]" class="form-control width" step="0.01"></td>
            <td><input type="number" name="products[${rowCount}][area]" class="form-control area" step="0.01" readonly></td>
            {{-- 💰 Auto Price --}}
            <td><input type="number" name="products[${rowCount}][price]" class="form-control price" step="0.01" readonly></td>
            <td><input type="number" name="products[${rowCount}][total]" class="form-control total" step="0.01" readonly></td>
            <td><button type="button" class="btn btn-danger removeRow">X</button></td>
        </tr>
    `;
    tbody.insertAdjacentHTML('beforeend', newRow);
    rowCount++;
});

// ✅ When Full/Semi is changed → Auto-fill price and recalculate total
document.addEventListener('change', (e) => {
    if (e.target.classList.contains('fullSemiSelect')) {
        const row = e.target.closest('tr');
        const selectedOption = e.target.selectedOptions[0];
        const rate = parseFloat(selectedOption.getAttribute('data-rate')) || 0;

        // Auto-fill price field
        const priceInput = row.querySelector('.price');
        priceInput.value = rate.toFixed(2);

        // Recalculate total
        calculateRowValues(row);
    }
});

// ✅ Auto-calculate on length, width, or price change
document.addEventListener('input', (e) => {
    if (
        e.target.classList.contains('length') ||
        e.target.classList.contains('width') ||
        e.target.classList.contains('price')
    ) {
        const row = e.target.closest('tr');
        calculateRowValues(row);
    }
});

// ✅ Remove row button
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('removeRow')) {
        e.target.closest('tr').remove();
    }
});
</script>

@endsection
