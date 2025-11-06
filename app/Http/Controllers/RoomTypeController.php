<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::all();
        return view('room_types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('room_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:room_types,name'
        ]);

        RoomType::create([
            'name' => $request->name
        ]);

        return redirect()->route('room-types.index')->with('success', 'Room type added successfully!');
    }

    public function edit(RoomType $roomType)
    {
        return view('room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $request->validate([
            'name' => 'required|unique:room_types,name,' . $roomType->id
        ]);

        $roomType->update(['name' => $request->name]);

        return redirect()->route('room-types.index')->with('success', 'Room type updated successfully!');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();

        return redirect()->route('room-types.index')->with('success', 'Room type deleted!');
    }
}
