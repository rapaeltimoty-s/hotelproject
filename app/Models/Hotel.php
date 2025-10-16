<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','city','address','stars','description','cover_url',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotel_id');
    }
}
