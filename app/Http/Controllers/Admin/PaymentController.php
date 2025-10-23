<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim($request->get('q',''));
        $status   = $request->get('status','');
        $method   = $request->get('method','');
        $gateway  = $request->get('gateway','');
        $from     = $request->get('date_from','');
        $to       = $request->get('date_to','');

        $payments = Payment::with(['booking.user','booking.room.hotel'])
            ->when($q, function($w) use ($q){
                $w->where('order_id','like',"%$q%")
                  ->orWhereHas('booking.user', fn($u)=>$u->where('email','like',"%$q%"));
            })
            ->when($status,  fn($w)=>$w->where('status',$status))
            ->when($method,  fn($w)=>$w->where('method',$method))
            ->when($gateway, fn($w)=>$w->where('gateway',$gateway))
            ->when($from,    fn($w)=>$w->whereDate('created_at','>=',$from))
            ->when($to,      fn($w)=>$w->whereDate('created_at','<=',$to))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $methods  = Payment::select('method')->distinct()->pluck('method')->filter()->values();
        $gateways = Payment::select('gateway')->distinct()->pluck('gateway')->values();

        return view('admin.payments.index', compact('payments','methods','gateways','q','status','method','gateway','from','to'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user','booking.room.hotel']);
        return view('admin.payments.show', compact('payment'));
    }

    public function markPaid(Payment $payment)
    {
        if ($payment->status !== 'success') {
            $payment->status  = 'success';
            $payment->paid_at = now();
            $payment->save();

            $booking = $payment->booking;
            if ($booking) {
                $booking->payment_status = 'paid';
                $booking->status         = 'confirmed';
                $booking->paid_at        = now();
                $booking->save();
            }
        }
        return back()->with('status','Transaksi ditandai sukses & booking dikonfirmasi.');
    }

    public function markFailed(Payment $payment)
    {
        if (!in_array($payment->status,['failed','refunded'])) {
            $payment->status = 'failed';
            $payment->save();

            $booking = $payment->booking;
            if ($booking && $booking->payment_status !== 'refunded') {
                $booking->payment_status = 'failed';
                $booking->save();
            }
        }
        return back()->with('status','Transaksi ditandai gagal.');
    }

    public function refund(Request $request, Payment $payment)
    {
        $request->validate(['amount'=>'required|integer|min:1']);
        $amount = (int) $request->input('amount');

        if ($amount > $payment->amount) {
            return back()->withErrors('Nominal refund melebihi amount.');
        }

        $payment->refunded_amount += $amount;
        if ($payment->refunded_amount >= $payment->amount) {
            $payment->status = 'refunded';
        }
        $payment->save();

        $booking = $payment->booking;
        if ($booking && $payment->status === 'refunded') {
            $booking->payment_status = 'refunded';
            $booking->save();
        }

        return back()->with('status','Refund tercatat.');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filename = 'payments_'.now()->format('Ymd_His').'.csv';

        $query = Payment::with(['booking.user','booking.room.hotel'])
            ->when($request->q,        fn($w)=>$w->where('order_id','like','%'.$request->q.'%')
                                               ->orWhereHas('booking.user', fn($u)=>$u->where('email','like','%'.$request->q.'%')))
            ->when($request->status,   fn($w)=>$w->where('status',$request->status))
            ->when($request->method,   fn($w)=>$w->where('method',$request->method))
            ->when($request->gateway,  fn($w)=>$w->where('gateway',$request->gateway))
            ->when($request->date_from,fn($w)=>$w->whereDate('created_at','>=',$request->date_from))
            ->when($request->date_to,  fn($w)=>$w->whereDate('created_at','<=',$request->date_to))
            ->latest();

        return response()->streamDownload(function() use ($query){
            $out = fopen('php://output', 'w');
            fputcsv($out, ['order_id','status','gateway','method','amount','user_email','hotel','room','created_at','paid_at','refunded_amount']);
            $query->chunk(500, function($rows) use ($out){
                foreach ($rows as $p) {
                    fputcsv($out, [
                        $p->order_id,
                        $p->status,
                        $p->gateway,
                        $p->method,
                        $p->amount,
                        $p->booking->user->email ?? '',
                        $p->booking->room->hotel->name ?? '',
                        $p->booking->room->name ?? '',
                        $p->created_at,
                        $p->paid_at,
                        $p->refunded_amount,
                    ]);
                }
            });
            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
