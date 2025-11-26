<?php

namespace App\Http\Controllers;

use App\Models\FullSemiType;
use Illuminate\Http\Request;

class FullSemiTypeController extends Controller
{
    /**
     * 🧾 Display all Full/Semi types
     */
public function index()
{
    $fullSemiTypes = FullSemiType::orderBy('id', 'asc')->get();
    return view('fullsemi.index', compact('fullSemiTypes'));
}


    /**
     * ➕ Show form to create a new type
     */
    public function create()
    {
        return view('fullsemi.create');
    }

    /**
     * 💾 Store a new Full/Semi type
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:full_semi_types,name',
            'rate' => 'required|numeric|min:0',
        ]);

        FullSemiType::create([
            'name' => ucfirst($request->name),
            'rate' => $request->rate,
        ]);

        return redirect()->route('fullsemi.index')->with('success', 'Full/Semi type added successfully!');
    }

    /**
     * ✏️ Show edit form
     */
public function edit($id)
{
    $fullSemiType = FullSemiType::findOrFail($id);
    return view('fullsemi.edit', compact('fullSemiType'));
}


    /**
     * 🔁 Update existing type
     */
    public function update(Request $request, $id)
    {
        $type = FullSemiType::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:50|unique:full_semi_types,name,' . $type->id,
            'rate' => 'required|numeric|min:0',
        ]);

        $type->update([
            'name' => ucfirst($request->name),
            'rate' => $request->rate,
        ]);

        return redirect()->route('fullsemi.index')->with('success', 'Full/Semi type updated successfully!');
    }

    /**
     * 🗑️ Delete type
     */
    public function destroy($id)
    {
        $type = FullSemiType::findOrFail($id);
        $type->delete();

        return redirect()->route('fullsemi.index')->with('success', 'Full/Semi type deleted successfully!');
    }
}
