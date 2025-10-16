<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id', 'name', 'type', 'capacity',
        'price_per_night', 'status', 'photo_url',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_id');
    }
}
