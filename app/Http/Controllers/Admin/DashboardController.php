<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Hotel,Room,Booking};

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalHotels'     => Hotel::count(),
            'totalRooms'      => Room::count(),
            'pendingBookings' => Booking::where('status','pending')->count(),
        ]);
    }
}
