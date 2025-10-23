<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    /**
     * List hotel + filter + sort
     */
    public function index(Request $request)
    {
        $q       = trim($request->get('q',''));
        $city    = trim($request->get('city',''));
        $stars   = $request->get('stars','');
        $sort    = $request->get('sort',''); // price_asc|price_desc|rating|name

        $hotels = Hotel::query()
            ->Q($q)
            ->city($city)
            ->stars($stars)
            ->withCount(['rooms as min_price' => function($r){
                $r->select(\DB::raw('MIN(price_per_night)'));
            }])
            ->when($sort === 'price_asc', fn($x)=>$x->orderBy('min_price','asc'))
            ->when($sort === 'price_desc', fn($x)=>$x->orderBy('min_price','desc'))
            ->when($sort === 'rating', fn($x)=>$x->orderBy('stars','desc'))
            ->when($sort === 'name', fn($x)=>$x->orderBy('name','asc'))
            ->orderBy('id','desc')
            ->paginate(12)
            ->withQueryString();

        // Ambil daftar kota unik untuk dropdown (opsional)
        $cities = Hotel::query()->select('city')->groupBy('city')->orderBy('city')->pluck('city');

        return view('hotels.index', compact('hotels','q','city','cities','stars','sort'));
    }

    /**
     * Detail hotel (tanpa list kamar penuh, biar cepat)
     */
    public function show(Hotel $hotel)
    {
        // contoh: hitung min/max harga
        $min = $hotel->rooms()->min('price_per_night');
        $max = $hotel->rooms()->max('price_per_night');

        return view('hotels.show', [
            'hotel' => $hotel->loadCount('rooms'),
            'minPrice' => $min,
            'maxPrice' => $max,
        ]);
    }
}
