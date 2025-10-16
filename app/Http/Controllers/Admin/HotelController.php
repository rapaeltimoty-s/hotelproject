<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::latest()->paginate(12);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'stars'       => 'nullable|integer|min:1|max:5',
            'amenities'   => 'array',
            'amenities.*' => 'string',
            'photo'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        $data['amenities'] = isset($data['amenities']) ? implode(', ', $data['amenities']) : null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('hotels', 'public');
        }

        Hotel::create($data);

        return redirect()->route('admin.hotels.index')->with('status', 'Hotel ditambahkan.');
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'city'        => 'required|string|max:255',
            'address'     => 'required|string|max:255',
            'description' => 'nullable|string',
            'stars'       => 'nullable|integer|min:1|max:5',
            'amenities'   => 'array',
            'amenities.*' => 'string',
            'photo'       => 'nullable|image|mimes:jpg,png,webp|max:2048',
        ]);

        $data['amenities'] = isset($data['amenities']) ? implode(', ', $data['amenities']) : null;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('hotels', 'public');
        }

        $hotel->update($data);

        return back()->with('status', 'Hotel diperbarui.');
    }

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return back()->with('status', 'Hotel dihapus.');
    }
}
