<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show(Request $request, Booking $booking)
    {
        if (!Auth::check() || (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin')) {
            return redirect()->route('login');
        }

        if (!$booking->grand_total || $booking->grand_total < 1) {
            $booking->recalcTotals();
            $booking->save();
        }

        if (!$booking->payment_deadline) {
            $booking->payment_deadline = now()->addMinutes(15);
            $booking->save();
        }

        return view('checkout.show', compact('booking'));
    }
}
