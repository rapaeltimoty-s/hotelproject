<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::latest()->paginate(12);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create(){ return view('admin.hotels.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'city'        => ['required','string','max:120'],
            'stars'       => ['required','integer','min:1','max:5'],
            'address'     => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'cover_url'   => ['nullable','url'],
            'cover_file'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_files.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'base_price'  => ['required','integer','min:0'],
            'features'    => ['nullable','string'],
        ]);

        $data['features'] = $this->features($data['features'] ?? '');

        if ($request->hasFile('cover_file')) {
            $data['cover_path'] = $request->file('cover_file')->store('hotels','public');
        }

        $gallery = [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $f) {
                $gallery[] = $f->store('hotels/gallery','public');
            }
        }
        if ($gallery) $data['gallery'] = $gallery;

        Hotel::create($data);
        return redirect()->route('admin.hotels.index')->with('status','Hotel berhasil ditambahkan.');
    }

    public function edit(Hotel $hotel){ return view('admin.hotels.edit', compact('hotel')); }

    public function update(Request $request, Hotel $hotel)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:255'],
            'city'        => ['required','string','max:120'],
            'stars'       => ['required','integer','min:1','max:5'],
            'address'     => ['nullable','string','max:255'],
            'description' => ['nullable','string'],
            'cover_url'   => ['nullable','url'],
            'cover_file'  => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'gallery_files.*' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:4096'],
            'base_price'  => ['required','integer','min:0'],
            'features'    => ['nullable','string'],
            'remove_cover'=> ['nullable','boolean'],
        ]);

        $data['features'] = $this->features($data['features'] ?? '');

        if ($request->boolean('remove_cover') && $hotel->cover_path) {
            Storage::disk('public')->delete($hotel->cover_path);
            $data['cover_path'] = null;
        }
        if ($request->hasFile('cover_file')) {
            if ($hotel->cover_path) Storage::disk('public')->delete($hotel->cover_path);
            $data['cover_path'] = $request->file('cover_file')->store('hotels','public');
        }

        $gallery = is_array($hotel->gallery) ? $hotel->gallery : [];
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $f) {
                $gallery[] = $f->store('hotels/gallery','public');
            }
        }
        if ($gallery) $data['gallery'] = array_values(array_unique($gallery));

        $hotel->update($data);
        return redirect()->route('admin.hotels.index')->with('status','Hotel diupdate.');
    }

    public function destroy(Hotel $hotel)
    {
        if ($hotel->cover_path) Storage::disk('public')->delete($hotel->cover_path);
        if (is_array($hotel->gallery)) foreach ($hotel->gallery as $p) Storage::disk('public')->delete($p);
        $hotel->delete();
        return back()->with('status','Hotel dihapus.');
    }

    private function features(string $raw): array {
        return array_values(array_unique(array_filter(array_map('trim', explode(',', $raw)))));
    }
}
