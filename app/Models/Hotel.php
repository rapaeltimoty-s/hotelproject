<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hotel extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Opsional: scope untuk filter dasar
    public function scopeCity($q, $city)
    {
        if ($city) $q->where('city','like',"%{$city}%");
        return $q;
    }

    public function scopeStars($q, $stars)
    {
        if ($stars) $q->where('stars',$stars);
        return $q;
    }

    public function scopeQ($q, $term)
    {
        if ($term) {
            $q->where(function($w) use($term){
                $w->where('name','like',"%{$term}%")
                  ->orWhere('city','like',"%{$term}%")
                  ->orWhere('address','like',"%{$term}%");
            });
        }
        return $q;
    }
}
