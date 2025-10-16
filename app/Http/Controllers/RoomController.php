<?php

namespace App\Http\Controllers;

use App\Models\Hotel;

class RoomController extends Controller
{
    /**
     * Daftar kamar per hotel (hanya yang available).
     */
    public function index(Hotel $hotel)
    {
        $rooms = $hotel->rooms()
            ->where('status', 'available')
            ->orderBy('price_per_night')
            ->paginate(12);

        return view('rooms.index', compact('hotel', 'rooms'));
    }
}
