<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomController extends Controller
{
    /**
     * List kamar per hotel + filter tanggal (sederhana)
     */
    public function index(Request $request, Hotel $hotel)
    {
        $check_in  = $request->get('check_in');
        $check_out = $request->get('check_out');

        $rooms = $hotel->rooms()
            ->available()
            // NOTE: kalau kamu mau cek ketersediaan by tanggal booking beneran,
            // kamu perlu join ke tabel bookings untuk exclude yang bentrok.
            // Untuk versi sederhana, kita pakai status 'available' saja.
            ->orderBy('price_per_night')
            ->paginate(12)
            ->withQueryString();

        return view('rooms.index', compact('hotel','rooms','check_in','check_out'));
    }
}
