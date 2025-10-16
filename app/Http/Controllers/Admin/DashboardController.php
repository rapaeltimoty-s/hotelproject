<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Booking, Hotel, Room};

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'hotels'    => Hotel::count(),
            'rooms'     => Room::count(),
            'pending'   => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
        ];

        $pending = Booking::with(['user', 'room.hotel'])
            ->where('status', 'pending')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'pending'));
    }
}
