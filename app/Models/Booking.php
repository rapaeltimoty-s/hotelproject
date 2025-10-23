<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','room_id','check_in','check_out','nights',
        'price_per_night','total_price','status',
        'subtotal','tax','discount','grand_total','payment_status','payment_deadline','paid_at'
    ];

    protected $casts = [
        'check_in'  => 'date',
        'check_out' => 'date',
        'paid_at'   => 'datetime',
        'payment_deadline' => 'datetime',
    ];

    public function user(){ return $this->belongsTo(User::class); }
    public function room(){ return $this->belongsTo(Room::class); }
    public function payments(){ return $this->hasMany(Payment::class); }

    /** Hitung ulang harga: subtotal/tax/discount/grand_total */
    public function recalcTotals(int $taxPercent = 11, int $discountRp = 0): void
    {
        $this->subtotal   = (int)($this->price_per_night * $this->nights);
        $this->tax        = (int) round($this->subtotal * ($taxPercent/100));
        $this->discount   = max(0, (int)$discountRp);
        $this->grand_total= max(0, $this->subtotal + $this->tax - $this->discount);
    }
}
