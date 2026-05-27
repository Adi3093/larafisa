<?php

namespace App\Http\Controllers;

use App\Models\kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $perPage = $request->per_page ?? 5;

        $query = Kamar::query();

        if ($search) {
            $query->where('kelas_kamar', 'like', "%{$search}%")
                ->orWhere('nomor_ruangan', 'like', "%{$search}%");
        }

        $kamars = $query->latest()->paginate($perPage)->appends($request->all());

        return view('dashboard.kamar', compact('kamars', 'search', 'perPage'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'kelas_kamar' => 'required|string|max:255',
            'nomor_ruangan' => 'required|string|unique:kamars,nomor_ruangan',
            'harga' => 'required|numeric|min:0',
            'fasilitas' => 'required|array',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('kamar', 'public');
        if ($request->hasFile('foto_1')) $data['foto_1'] = $request->file('foto_1')->store('kamar', 'public');
        if ($request->hasFile('foto_2')) $data['foto_2'] = $request->file('foto_2')->store('kamar', 'public');
        if ($request->hasFile('foto_3')) $data['foto_3'] = $request->file('foto_3')->store('kamar', 'public');

        Kamar::create($data);

        return back()->with('success', 'Kamar nomor ' . $request->nomor_ruangan . ' berhasil ditambahkan!');
    }

    // 3. Simpan Perubahan Edit Data
    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);

        $request->validate([
            'kelas_kamar' => 'required|string|max:255',
            // Pengecualian unique untuk ID yang sedang diedit agar tidak error jika nomor ruangannya tidak diganti
            'nomor_ruangan' => 'required|string|unique:kamars,nomor_ruangan,' . $id,
            'harga' => 'required|numeric|min:0',
            'fasilitas' => 'required|array',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->except(['thumbnail', 'foto_1', 'foto_2', 'foto_3']);

        // Logika memperbarui foto: Jika ada foto baru diunggah, hapus yang lama, simpan yang baru
        $fotos = ['thumbnail', 'foto_1', 'foto_2', 'foto_3'];
        foreach ($fotos as $foto) {
            if ($request->hasFile($foto)) {
                if ($kamar->$foto) {
                    Storage::disk('public')->delete($kamar->$foto);
                }
                $data[$foto] = $request->file($foto)->store('kamar', 'public');
            }
        }

        $kamar->update($data);

        return back()->with('success', 'Data kamar ' . $request->nomor_ruangan . ' berhasil diperbarui!');
    }

    // 4. Hapus Data
    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);

        // Hapus semua foto dari folder storage sebelum menghapus data dari database
        $fotos = ['thumbnail', 'foto_1', 'foto_2', 'foto_3'];
        foreach ($fotos as $foto) {
            if ($kamar->$foto) {
                Storage::disk('public')->delete($kamar->$foto);
            }
        }

        $kamar->delete();

        return back()->with('success', 'Kamar berhasil dihapus permanen!');
    }
    //
}
