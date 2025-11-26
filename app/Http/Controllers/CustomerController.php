<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Product;
use App\Models\FullSemiType;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display all customers
     */
    public function index()
    {
        $customers = Customer::with('products')->latest()->get();
        return view('customers.index', compact('customers'));
    }

    /**
     * Show form to create a new customer and their products
     */
    public function create()
    {
        $fullSemiTypes = FullSemiType::orderBy('name', 'asc')->get();
        return view('customers.create', compact('fullSemiTypes'));
    }

    /**
     * Display single customer
     */
    public function show($id)
    {
        $customer = Customer::with('products')->findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Store a new customer and products
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:255',
            'products' => 'required|array|min:1',

            // Product validation
            'products.*.product_name'   => 'required|string|max:255',
            'products.*.type'           => 'nullable|exists:full_semi_types,id', // store id here
            'products.*.brand'          => 'nullable|string|max:255',
            'products.*.specification'  => 'nullable|string|max:255',
            'products.*.unit'           => 'nullable|string|max:255',
            'products.*.length'         => 'nullable|numeric|min:0',
            'products.*.width'          => 'nullable|numeric|min:0',
            'products.*.area'           => 'nullable|numeric|min:0',
            'products.*.total'          => 'nullable|numeric|min:0',
            'products.*.core_material'  => 'nullable|string|max:255',
            'products.*.finish_material'=> 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::create([
                'name'  => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'] ?? null,
            ]);

            foreach ($validated['products'] as $productData) {
                $productData['customer_id'] = $customer->id;

                $length = $productData['length'] ?? 0;
                $width  = $productData['width'] ?? 0;
                $productData['area'] = $length * $width;

                // Auto-fill price using selected type (Full/Semi)
                if (!empty($productData['type'])) {
                    $type = FullSemiType::find($productData['type']);
                    $productData['price'] = $type?->rate ?? 0;
                }

                Product::create($productData);
            }

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Customer and products added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error saving data: ' . $e->getMessage());
        }
    }

    /**
     * Edit customer & products
     */
    public function edit($id)
    {
        $customer = Customer::with('products')->findOrFail($id);
        $fullSemiTypes = FullSemiType::orderBy('name', 'asc')->get();
        return view('customers.edit', compact('customer', 'fullSemiTypes'));
    }

    /**
     * Update customer + product details
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:255',
            'products' => 'required|array|min:1',
            'products.*.id' => 'nullable|exists:products,id',
            'products.*.product_name' => 'required|string|max:255',
            'products.*.type'           => 'nullable|exists:full_semi_types,id',
            'products.*.brand'          => 'nullable|string|max:255',
            'products.*.specification'  => 'nullable|string|max:255',
            'products.*.unit'           => 'nullable|string|max:255',
            'products.*.length'         => 'nullable|numeric|min:0',
            'products.*.width'          => 'nullable|numeric|min:0',
            'products.*.area'           => 'nullable|numeric|min:0',
            'products.*.total'          => 'nullable|numeric|min:0',
            'products.*.core_material'  => 'nullable|string|max:255',
            'products.*.finish_material'=> 'nullable|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::findOrFail($id);
            $customer->update([
                'name'  => $validated['name'],
                'phone' => $validated['phone'] ?? null,
                'email' => $validated['email'] ?? null,
            ]);

            $existingIds = $customer->products->pluck('id')->toArray();
            $updatedIds = [];

            foreach ($validated['products'] as $productData) {
                $productData['customer_id'] = $customer->id;
                $length = $productData['length'] ?? 0;
                $width  = $productData['width'] ?? 0;
                $productData['area'] = $length * $width;

                if (!empty($productData['type'])) {
                    $type = FullSemiType::find($productData['type']);
                    $productData['price'] = $type?->rate ?? 0;
                }

                if (!empty($productData['id'])) {
                    $product = Product::find($productData['id']);
                    $product->update($productData);
                    $updatedIds[] = $product->id;
                } else {
                    $new = Product::create($productData);
                    $updatedIds[] = $new->id;
                }
            }

            $toDelete = array_diff($existingIds, $updatedIds);
            Product::whereIn('id', $toDelete)->delete();

            DB::commit();
            return redirect()->route('customers.index')->with('success', 'Customer updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete a customer and their related products
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->products()->delete();
            $customer->delete();

            return redirect()->route('customers.index')->with('success', 'Customer and related products deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', '❌ Failed to delete customer: ' . $e->getMessage());
        }
    }


    /**
     * Quotation View (HTML)
     */
    public function showQuotation($id)
    {
        $customer = Customer::with('products')->findOrFail($id);
        $totalAmount = $customer->products->sum(fn($p) => ($p->area ?? 0) * ($p->price ?? 0));

        $now = Carbon::now();
        $clientCode = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $customer->name), 0, 2));
        $customerIdLast = str_pad($customer->id, 2, '0', STR_PAD_LEFT);
        $month = $now->format('m');
        $year = $now->format('y');
        $quotation_number = "QTN-{$clientCode}{$customerIdLast}{$month}{$year}";
        $quotation_date = $now->format('d-m-Y');

        $logo = public_path('images/logo.png');
        $qr = public_path('images/QR2.png');
        $signature = public_path('images/signature.png');
        $wave = public_path('images/wave-top.png');

        foreach (['logo', 'qr', 'signature', 'wave'] as $var) {
            if (!file_exists($$var)) $$var = null;
        }

        return view('customers.quotation', compact(
            'customer', 'totalAmount', 'quotation_number', 'quotation_date',
            'logo', 'qr', 'signature', 'wave'
        ));
    }
}
