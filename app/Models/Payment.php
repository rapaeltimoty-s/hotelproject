<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id','order_id','gateway','method','amount','currency','status',
        'provider_transaction_id','signature','raw_payload','expires_at','paid_at','refunded_amount'
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'expires_at'  => 'datetime',
        'paid_at'     => 'datetime',
    ];

    public function booking(){ return $this->belongsTo(Booking::class); }
}
