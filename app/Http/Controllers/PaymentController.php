<?php

namespace App\Http\Controllers;

use App\Models\{Booking,Payment};
use App\Services\Payments\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function create(Request $request, Booking $booking, MidtransService $svc)
    {
        if (!Auth::check() || (Auth::id() !== $booking->user_id && Auth::user()->role !== 'admin')) {
            return redirect()->route('login');
        }
        if ($booking->payment_status === 'paid') {
            return redirect()->route('payments.result', ['order_id'=>$booking->payments()->latest()->value('order_id')])
                ->with('status','Booking sudah dibayar.');
        }

        $result = $svc->createTransaction($booking);
        if (!empty($result['redirect_url'])) {
            return redirect()->away($result['redirect_url']);
        }

        return back()->withErrors('Gagal membuat transaksi.');
    }

    public function result(Request $request)
    {
        $orderId = $request->get('order_id');
        $payment = Payment::where('order_id',$orderId)->with('booking.room.hotel','booking.user')->firstOrFail();
        return view('checkout.result', compact('payment'));
    }

    public function mock(Request $request)
    {
        $orderId = $request->get('order_id');
        $payment = Payment::where('order_id',$orderId)->firstOrFail();
        return view('checkout.mock', compact('payment'));
    }

    public function mockNotify(Request $request, MidtransService $svc)
    {
        $orderId = $request->input('order_id');
        $status  = $request->input('status','settlement');
        $payload = [
            'order_id'            => $orderId,
            'transaction_status'  => $status,
            'payment_type'        => 'qris',
        ];
        $payment = $svc->verifyAndUpdate($payload);
        return redirect()->route('payments.result', ['order_id'=>$orderId])
            ->with('status','Status mock: '.($payment->status ?? 'unknown'));
    }

    public function notify(Request $request, MidtransService $svc)
    {
        $payload = $request->all();
        $payment = $svc->verifyAndUpdate($payload);

        return response()->json([
            'ok' => (bool) $payment,
            'status' => $payment->status ?? null,
        ]);
    }
}
