<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    // Sederhana: berdasarkan kolom status
    public function scopeAvailable($q)
    {
        return $q->where('status','available');
    }
}
