<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Room,Hotel};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('hotel')->latest()->paginate(12);
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        $hotels = Hotel::orderBy('name')->get(['id','name','city']);
        return view('admin.rooms.create', compact('hotels'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'hotel_id'        => ['required','exists:hotels,id'],
            'name'            => ['required','string','max:120'],
            'type'            => ['required','in:Standard,Deluxe,Suite'],
            'capacity'        => ['required','integer','min:1'],
            'price_per_night' => ['required','integer','min:0'],
            'status'          => ['nullable','in:available,unavailable'],
            'photo_url'       => ['nullable','url'],
            'photo_file'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
        ]);
        if ($request->hasFile('photo_file')) {
            $data['photo_path'] = $request->file('photo_file')->store('rooms','public');
        }
        $data['status'] = $data['status'] ?? 'available';
        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('status','Kamar ditambahkan.');
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::orderBy('name')->get(['id','name','city']);
        return view('admin.rooms.edit', compact('room','hotels'));
    }

    public function update(Request $request, Room $room)
    {
        $data = $request->validate([
            'hotel_id'        => ['required','exists:hotels,id'],
            'name'            => ['required','string','max:120'],
            'type'            => ['required','in:Standard,Deluxe,Suite'],
            'capacity'        => ['required','integer','min:1'],
            'price_per_night' => ['required','integer','min:0'],
            'status'          => ['required','in:available,unavailable'],
            'photo_url'       => ['nullable','url'],
            'photo_file'      => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'remove_photo'    => ['nullable','boolean'],
        ]);

        if ($request->boolean('remove_photo') && $room->photo_path) {
            Storage::disk('public')->delete($room->photo_path);
            $data['photo_path'] = null;
        }
        if ($request->hasFile('photo_file')) {
            if ($room->photo_path) Storage::disk('public')->delete($room->photo_path);
            $data['photo_path'] = $request->file('photo_file')->store('rooms','public');
        }
        $room->update($data);

        return redirect()->route('admin.rooms.index')->with('status','Kamar diupdate.');
    }

    public function destroy(Room $room)
    {
        if ($room->photo_path) Storage::disk('public')->delete($room->photo_path);
        $room->delete();
        return back()->with('status','Kamar dihapus.');
    }
}
