<?php

namespace App\Services\Payments;

use App\Models\{Booking,Payment};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class MidtransService
{
    protected string $serverKey;
    protected bool $isProduction;

    public function __construct()
    {
        $this->serverKey    = config('services.midtrans.server_key', '');
        $this->isProduction = (bool) config('services.midtrans.is_production', false);
    }

    /** Buat transaksi: kembalikan {payment, redirect_url, token} */
    public function createTransaction(Booking $booking): array
    {
        $orderId = 'BKG-'.$booking->id.'-'.Str::upper(Str::random(6));

        if (!$booking->grand_total || $booking->grand_total < 1) {
            $booking->recalcTotals();
            $booking->save();
        }

        // --- MOCK MODE ---
        if (empty($this->serverKey)) {
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'order_id'   => $orderId,
                'gateway'    => 'mock',
                'method'     => 'qris',
                'amount'     => $booking->grand_total,
                'currency'   => 'IDR',
                'status'     => 'pending',
                'expires_at' => now()->addMinutes(15),
            ]);

            return [
                'payment'      => $payment,
                'redirect_url' => route('payments.mock', ['order_id'=>$orderId]),
                'token'        => null,
            ];
        }

        // --- MIDTRANS SNAP MODE ---
        $baseUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';

        $payload = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $booking->grand_total,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name ?? 'Guest',
                'email'      => $booking->user->email ?? 'guest@example.com',
            ],
            'item_details' => [[
                'id'       => 'ROOM-'.$booking->room_id,
                'price'    => $booking->price_per_night,
                'quantity' => $booking->nights,
                'name'     => 'Room '.$booking->room->type,
            ]],
            'expiry' => [
                'start_time' => now()->format('Y-m-d H:i:s O'),
                'unit'       => 'minute',
                'duration'   => 15
            ],
            'callbacks' => [
                'finish' => route('payments.result', ['order_id'=>$orderId]),
            ],
            'credit_card' => ['secure' => true],
            'enabled_payments' => ['qris','bca_va','bni_va','bri_va','echannel','gopay','shopeepay']
        ];

        $response = Http::withBasicAuth($this->serverKey, '')
            ->acceptJson()
            ->post($baseUrl, $payload)
            ->throw();

        $data = $response->json();

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'order_id'   => $orderId,
            'gateway'    => 'midtrans',
            'amount'     => $booking->grand_total,
            'currency'   => 'IDR',
            'status'     => 'pending',
            'expires_at' => now()->addMinutes(15),
            'raw_payload'=> $data,
        ]);

        return [
            'payment'      => $payment,
            'redirect_url' => $data['redirect_url'] ?? null,
            'token'        => $data['token'] ?? null,
        ];
    }

    /** Verifikasi notifikasi (webhook) */
    public function verifyAndUpdate(array $payload): ?Payment
    {
        // MOCK MODE
        if (empty($this->serverKey)) {
            $orderId = $payload['order_id'] ?? null;
            $status  = $payload['transaction_status'] ?? 'pending';
            if (!$orderId) return null;
            $payment = Payment::where('order_id',$orderId)->first();
            if (!$payment) return null;

            $this->applyStatus($payment, $status, $payload['payment_type'] ?? null, $payload);
            return $payment;
        }

        // MIDTRANS
        $orderId = $payload['order_id'] ?? null;
        if (!$orderId) return null;
        $payment = Payment::where('order_id',$orderId)->first();
        if (!$payment) return null;

        $status = $payload['transaction_status'] ?? 'pending';
        $method = $payload['payment_type'] ?? null;

        $this->applyStatus($payment, $status, $method, $payload);

        return $payment;
    }

    protected function applyStatus(Payment $payment, string $status, ?string $method, array $raw): void
    {
        $map = [
            'settlement' => 'success',
            'capture'    => 'success',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'cancel'     => 'failed',
            'expire'     => 'expired',
            'refund'     => 'refunded',
        ];
        $norm = $map[$status] ?? 'pending';

        if ($payment->status !== $norm) {
            $payment->status   = $norm;
            $payment->method   = $method ?? $payment->method;
            $payment->raw_payload = $raw;
            if ($norm === 'success') {
                $payment->paid_at = now();
            }
            $payment->save();

            $booking = $payment->booking()->lockForUpdate()->first();
            if ($booking) {
                if ($norm === 'success') {
                    $booking->payment_status = 'paid';
                    $booking->status = 'confirmed';
                    $booking->paid_at = now();
                } elseif (in_array($norm, ['failed','expired'])) {
                    $booking->payment_status = $norm;
                } elseif ($norm === 'refunded') {
                    $booking->payment_status = 'refunded';
                }
                $booking->save();
            }
        }
    }
}
