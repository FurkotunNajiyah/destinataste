<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place; // Pastikan Model Place sudah di-import

class PlaceController extends Controller
{
    public function wisataIndex(Request $request)
    {
        $query = Place::where('type', 'wisata');

        // Gunakan $request->filled('search') agar lebih aman dari string kosong
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // withQueryString() agar saat pindah halaman pagination, pencarian tidak hilang
        $places = $query->with(['category', 'photos'])->latest()->paginate(9)->withQueryString();

        return view('frontend.wisata.index', compact('places'));
    }
}