@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit Customer & Products</h2>

    <form method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" value="{{ $customer->name }}" required>
        </div>

        <div class="mb-3">
            <label>Phone:</label>
            <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
        </div>

        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" value="{{ $customer->email }}">
        </div>

        <h4>Product Details</h4>
        <div class="table-responsive  table-dark" style="max-width: 100%; overflow-x: auto;">
        <table class="table" id="productTable" style="min-width: 1400px;">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th style="width: 180px;">Full/Semi</th>
                    <th>Core Material</th>
                    <th>Finish Material</th>
                    <th>Brand/Origin</th>
                    <th style="width: 200px;">Specification</th>
                    <th style="width: 100px;">Unit</th>
                    <th style="width: 100px;">Length</th>
                    <th style="width: 100px;">Width/Height</th>
                    <th style="width:100px;">Area</th>
                    <th style="width: 120px;">Rate</th>
                    <th style="width: 130px;">Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customer->products as $index => $product)
                <tr>
                    <input type="hidden" name="products[{{ $index }}][id]" value="{{ $product->id }}">
                    <td><input type="text" name="products[{{ $index }}][product_name]" class="form-control" value="{{ $product->product_name }}" required></td>

                    {{-- 🟩 Full/Semi Dropdown --}}
                    <td style="width: 130px;">
                        <select name="products[{{ $index }}][type]" class="form-select fullSemiSelect" required>
                            <option value="">Select</option>
                            @foreach($fullSemiTypes as $type)
                                <option value="{{ $type->id }}" data-rate="{{ $type->rate }}"
                                    {{ $product->type == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} (₹{{ number_format($type->rate, 2) }})
                                </option>
                            @endforeach
                        </select>
                    </td>

                    <td><input type="text" name="products[{{ $index }}][core_material]" class="form-control" value="{{ $product->core_material }}"></td>
                    <td><input type="text" name="products[{{ $index }}][finish_material]" class="form-control" value="{{ $product->finish_material }}"></td>
                    <td><input type="text" name="products[{{ $index }}][brand]" class="form-control" value="{{ $product->brand }}"></td>
                    <td><input type="text" name="products[{{ $index }}][specification]" class="form-control" value="{{ $product->specification }}"></td>
                    <td><input type="text" name="products[{{ $index }}][unit]" class="form-control" value="{{ $product->unit }}"></td>
                    <td><input type="number" name="products[{{ $index }}][length]" class="form-control length" value="{{ $product->length }}" step="0.01"></td>
                    <td><input type="number" name="products[{{ $index }}][width]" class="form-control width" value="{{ $product->width }}" step="0.01"></td>
                    <td><input type="number" name="products[{{ $index }}][area]" class="form-control area" value="{{ $product->area }}" step="0.01" readonly></td>
                    
                    {{-- 🟦 Price Field (auto-filled) --}}
                    <td>
                        <input type="number" 
                            name="products[{{ $index }}][price]" 
                            class="form-control price" 
                            value="{{ $product->price }}" 
                            step="0.01"
                            readonly>
                    </td>

                    <td>
                        <input type="number" 
                            name="products[{{ $index }}][total]" 
                            class="form-control total" 
                            value="{{ $product->area * $product->price }}" 
                            step="0.01"
                            readonly>
                    </td>

                    <td><button type="button" class="btn btn-danger removeRow">X</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>

        <button type="button" class="btn btn-secondary" id="addRow">+ Add Product</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    let rowCount = {{ count($customer->products) }};
    const addRowBtn = document.getElementById("addRow");
    const tableBody = document.querySelector("#productTable tbody");

    // ✅ Function to calculate Area & Total
    function calculateRowValues(row) {
        const length = parseFloat(row.querySelector(".length")?.value || 0);
        const width = parseFloat(row.querySelector(".width")?.value || 0);
        const rate = parseFloat(row.querySelector(".price")?.value || 0);
        const area = length * width;
        const total = area * rate;

        const areaField = row.querySelector(".area");
        if (areaField) areaField.value = area.toFixed(2);

        const totalField = row.querySelector(".total");
        if (totalField) totalField.value = total.toFixed(2);
    }

    // ✅ Add new row dynamically
    if (addRowBtn) {
        addRowBtn.addEventListener("click", function () {
            const options = `@foreach($fullSemiTypes as $type)
                <option value="{{ $type->id }}" data-rate="{{ $type->rate }}">
                    {{ $type->name }} (₹{{ number_format($type->rate, 2) }})
                </option>
            @endforeach`;

            const newRow = `
                <tr>
                    <td><input type="text" name="products[${rowCount}][product_name]" class="form-control" required></td>
                    <td>
                        <select name="products[${rowCount}][type]" class="form-select fullSemiSelect">
                            <option value="">Select</option>
                            ${options}
                        </select>
                    </td>
                    <td><input type="text" name="products[${rowCount}][core_material]" class="form-control" placeholder="Eg: Plywood"></td>
                    <td><input type="text" name="products[${rowCount}][finish_material]" class="form-control" placeholder="Eg: Laminate"></td>
                    <td><input type="text" name="products[${rowCount}][brand]" class="form-control" placeholder="Eg: Greenply"></td>
                    <td><input type="text" name="products[${rowCount}][specification]" class="form-control"></td>
                    <td><input type="text" name="products[${rowCount}][unit]" class="form-control"></td>
                    <td><input type="number" name="products[${rowCount}][length]" class="form-control length" step="0.01"></td>
                    <td><input type="number" name="products[${rowCount}][width]" class="form-control width" step="0.01"></td>
                    <td><input type="number" name="products[${rowCount}][area]" class="form-control area" step="0.01" readonly></td>
                    <td><input type="number" name="products[${rowCount}][price]" class="form-control price" step="0.01" readonly></td>
                    <td><input type="number" name="products[${rowCount}][total]" class="form-control total" step="0.01" readonly></td>
                    <td><button type="button" class="btn btn-danger removeRow">X</button></td>
                </tr>`;
            tableBody.insertAdjacentHTML("beforeend", newRow);
            rowCount++;
        });
    }

    // ✅ When Full/Semi changes → Auto-fill price + recalc total
    document.addEventListener("change", (e) => {
        if (e.target.classList.contains("fullSemiSelect")) {
            const row = e.target.closest("tr");
            const selectedOption = e.target.selectedOptions[0];
            const rate = parseFloat(selectedOption.getAttribute("data-rate")) || 0;

            const priceInput = row.querySelector(".price");
            priceInput.value = rate.toFixed(2);

            calculateRowValues(row);
        }
    });

    // ✅ Auto-update area/total when numbers change
    document.addEventListener("input", (e) => {
        if (
            e.target.classList.contains("length") ||
            e.target.classList.contains("width") ||
            e.target.classList.contains("price")
        ) {
            const row = e.target.closest("tr");
            calculateRowValues(row);
        }
    });

    // ✅ Remove row
    document.addEventListener("click", (e) => {
        if (e.target.classList.contains("removeRow")) {
            e.target.closest("tr").remove();
        }
    });

    // ✅ Initialize all rows on page load (for edit page)
    document.querySelectorAll("#productTable tbody tr").forEach((row) => {
        calculateRowValues(row);
    });
});
</script>

@endsection
