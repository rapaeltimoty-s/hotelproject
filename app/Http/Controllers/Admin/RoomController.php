<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Hotel, Room};
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')->latest()->paginate(12);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::orderBy('name')->get();
        return view('admin.rooms.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id'        => 'required|exists:hotels,id',
            'name'            => 'required|string|max:255',
            'type'            => 'required|in:Standard,Deluxe,Suite',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status'          => 'nullable|string',
            'photo'           => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('status', 'Kamar ditambahkan.');
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::orderBy('name')->get();
        return view('admin.rooms.edit', compact('room', 'hotels'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'hotel_id'        => 'required|exists:hotels,id',
            'name'            => 'required|string|max:255',
            'type'            => 'required|in:Standard,Deluxe,Suite',
            'capacity'        => 'required|integer|min:1',
            'price_per_night' => 'required|numeric|min:0',
            'status'          => 'nullable|string',
            'photo'           => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('rooms', 'public');
        }

        $room->update($data);

        return back()->with('status', 'Kamar diperbarui.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return back()->with('status', 'Kamar dihapus.');
    }
}
