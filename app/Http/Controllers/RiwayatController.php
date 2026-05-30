<?php

namespace App\Http\Controllers;

use App\Models\KelasKamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        // Perbaikan 1: kelasKamar menggunakan 'k' kecil
        $query = Reservasi::with('kamar.kelasKamar')->whereIn('status_reservasi', ['Selesai', 'Batal']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                // Perbaikan 2 & 3: Ejaan 'search' dan menghapus simbol '$'
                $q->where('nama_tamu', 'like', '%' . $request->search . '%')
                    ->orWhere('no_reservasi', 'like', '%' . $request->search . '%');
            });
        }

        $perPage = $request->per_page ?? 10;

        // Perbaikan 4: Menambahkan huruf 'd' pada updated_at
        $riwayats = $query->latest('updated_at')->paginate($perPage)->appends($request->all());

        return view('dashboard.reservasilog', compact('riwayats'));
    }
}
