<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * List booking milik user login.
     */
    public function index()
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $bookings = $user->bookings()
            ->with('room.hotel')
            ->latest()
            ->paginate(12);

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Form create booking untuk room tertentu.
     */
    public function create(Request $request)
    {
        $roomId = (int) $request->get('room_id');

        $room = Room::with('hotel')->findOrFail($roomId);

        return view('bookings.create', compact('room'));
    }

    /**
     * Simpan booking (dengan cek bentrok tanggal).
     */
    public function store(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $userId = (int) $user->id;

        $data = $request->validate([
            'room_id'   => ['required', 'exists:rooms,id'],
            'check_in'  => ['required', 'date', 'after:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
        ]);

        $room = Room::findOrFail((int) $data['room_id']);

        $in  = Carbon::parse($data['check_in'])->startOfDay();
        $out = Carbon::parse($data['check_out'])->startOfDay();

        $nights = $in->diffInDays($out);
        if ($nights < 1) {
            return back()
                ->withErrors(['check_out' => 'Minimal 1 malam.'])
                ->withInput();
        }

        // Cek overlap (selain yang cancelled)
        $overlap = Booking::where('room_id', $room->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) use ($in, $out) {
                // overlap [in, out) dengan [ci, co)
                $q->whereBetween('check_in', [$in, $out->copy()->subDay()])
                  ->orWhereBetween('check_out', [$in->copy()->addDay(), $out])
                  ->orWhere(function ($qq) use ($in, $out) {
                      $qq->where('check_in', '<=', $in)
                         ->where('check_out', '>=', $out);
                  });
            })
            ->exists();

        if ($overlap) {
            return back()
                ->withErrors(['check_in' => 'Tanggal bentrok dengan booking lain.'])
                ->withInput();
        }

        $total = (float) $room->price_per_night * $nights;

        Booking::create([
            'user_id'     => $userId,
            'room_id'     => $room->id,
            'check_in'    => $in->toDateString(),
            'check_out'   => $out->toDateString(),
            'nights'      => $nights,
            'total_price' => $total,
            'status'      => 'pending',
        ]);

        return redirect()
            ->route('bookings.index')
            ->with('status', 'Booking dibuat. Menunggu konfirmasi admin.');
    }
}
