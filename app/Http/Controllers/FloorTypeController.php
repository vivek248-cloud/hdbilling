<?php

namespace App\Http\Controllers;

use App\Models\FloorType;
use Illuminate\Http\Request;

class FloorTypeController extends Controller
{
    public function index()
    {
        $floorTypes = FloorType::all();
        return view('floor_types.index', compact('floorTypes'));
    }

    public function create()
    {
        return view('floor_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:floor_types,name'
        ]);

        FloorType::create([
            'name' => $request->name
        ]);

        return redirect()->route('floor-types.index')->with('success', 'Floor type added successfully!');
    }

    public function edit(FloorType $floorType)
    {
        return view('floor_types.edit', compact('floorType'));
    }

    public function update(Request $request, FloorType $floorType)
    {
        $request->validate([
            'name' => 'required|unique:floor_types,name,' . $floorType->id
        ]);

        $floorType->update(['name' => $request->name]);

        return redirect()->route('floor-types.index')->with('success', 'Floor type updated successfully!');
    }

    public function destroy(FloorType $floorType)
    {
        $floorType->delete();

        return redirect()->route('floor-types.index')->with('success', 'Floor type deleted!');
    }
}
