<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * List hotel + filter & sort.
     */
    public function index(Request $request)
    {
        $q     = trim((string) $request->get('q', ''));
        $stars = (int) $request->get('stars', 0);
        $min   = $request->get('min_price');
        $max   = $request->get('max_price');
        $sort  = $request->get('sort', 'name_asc');

        $hotels = Hotel::query()
            ->when($q, function ($s) use ($q) {
                $s->where(function ($w) use ($q) {
                    $w->where('city', 'like', "%$q%")
                      ->orWhere('name', 'like', "%$q%");
                });
            })
            ->when($stars > 0, fn ($s) => $s->where('stars', $stars))
            ->when($min || $max, function ($s) use ($min, $max) {
                $s->whereHas('rooms', function ($w) use ($min, $max) {
                    if ($min !== null && $min !== '') $w->where('price_per_night', '>=', (float) $min);
                    if ($max !== null && $max !== '') $w->where('price_per_night', '<=', (float) $max);
                });
            });

        $hotels = $hotels->when(
                in_array($sort, ['price_asc', 'price_desc']),
                function ($q) use ($sort) {
                    $q->withMin('rooms', 'price_per_night');
                    return $sort === 'price_asc'
                        ? $q->orderBy('rooms_min_price_per_night', 'asc')
                        : $q->orderBy('rooms_min_price_per_night', 'desc');
                },
                function ($q) use ($sort) {
                    if ($sort === 'name_desc')  return $q->orderBy('name', 'desc');
                    if ($sort === 'stars_desc') return $q->orderBy('stars', 'desc')->orderBy('name');
                    return $q->orderBy('name', 'asc');
                }
            )
            ->paginate(12)
            ->withQueryString();

        return view('hotels.index', compact('hotels', 'q', 'stars', 'min', 'max', 'sort'));
    }

    /**
     * Detail hotel + kamar populer.
     */
    public function show(Hotel $hotel)
    {
        $hotel->load(['rooms' => fn ($q) => $q->where('status', 'available')->orderBy('price_per_night')->limit(6)]);
        $amenities = collect(explode(',', (string) $hotel->amenities))
            ->map(fn ($v) => trim($v))
            ->filter()
            ->values();

        return view('hotels.show', compact('hotel', 'amenities'));
    }
}
