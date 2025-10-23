<?php

namespace App\Http\Controllers;

use App\Models\{Booking, Room};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class BookingController extends Controller
{
    /**
     * Riwayat booking user
     */
    public function index()
    {
        $user = Auth::user();

        // Jika relasi bookings() ada (sesuai revisi User), pakai ini:
        if (method_exists($user, 'bookings')) {
            $bookings = $user->bookings()
                ->with('room.hotel')
                ->latest()
                ->paginate(12);
        } else {
            // Fallback aman kalau relasi belum ditambahkan
            $bookings = Booking::with('room.hotel')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(12);
        }

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Form create booking
     */
    public function create(Request $request)
    {
        $request->validate([
            'room_id' => ['required','exists:rooms,id'],
        ]);

        $room = Room::with('hotel')->findOrFail($request->room_id);
        return view('bookings.create', compact('room'));
    }

    /**
     * Simpan booking
     * - Validasi tanggal
     * - Hitung harga (subtotal, tax 11%, discount 0, grand_total)
     * - Set status booking & payment_status = pending
     * - Redirect ke checkout
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'   => ['required','exists:rooms,id'],
            'check_in'  => ['required','date'],
            'check_out' => ['required','date','after:check_in'],
        ]);

        $room = Room::with('hotel')->findOrFail($data['room_id']);

        $in  = Carbon::parse($data['check_in'])->startOfDay();
        $out = Carbon::parse($data['check_out'])->startOfDay();

        $nights = $in->diffInDays($out);
        if ($nights < 1) {
            return back()->withErrors(['check_out'=>'Minimal 1 malam.'])->withInput();
        }

        // Harga
        $pricePerNight = (int) $room->price_per_night;
        $subtotal      = $pricePerNight * $nights;
        $tax           = (int) round($subtotal * 0.11);  // 11%
        $discount      = 0;                              // bisa diubah kalau ada voucher
        $grandTotal    = max(0, $subtotal + $tax - $discount);

        $booking = Booking::create([
            'user_id'         => Auth::id(),
            'room_id'         => $room->id,
            'check_in'        => $in,
            'check_out'       => $out,
            'nights'          => $nights,
            'price_per_night' => $pricePerNight,
            'total_price'     => $subtotal,      // legacy, tetap isi
            'status'          => 'pending',      // pending sampai bayar sukses / admin konfirm

            // kolom baru untuk pembayaran
            'subtotal'        => $subtotal,
            'tax'             => $tax,
            'discount'        => $discount,
            'grand_total'     => $grandTotal,
            'payment_status'  => 'pending',
            'payment_deadline'=> now()->addMinutes(15),
        ]);

        // Arahkan user ke halaman checkout (langsung bayar)
        return redirect()
            ->route('checkout.show', $booking->id)
            ->with('status','Booking dibuat. Silakan lanjutkan pembayaran.');
    }
}
