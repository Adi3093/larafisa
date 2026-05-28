<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\KelasKamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KamarController extends Controller
{
    public function index(Request $request)
    {
        // 1. Deteksi Tab Aktif (Default: kelas)
        $activeTab = $request->tab ?? 'kelas';

        // 2. DATA KATALOG (KELAS KAMAR)
        $kelasQuery = KelasKamar::withCount('kamars');

        if ($request->filled('kelas_search')) {
            $kelasQuery->where('nama_kelas', 'like', '%' . $request->kelas_search . '%');
        }

        if ($request->filled('kelas_harga')) {
            if ($request->kelas_harga == 'murah') $kelasQuery->orderBy('harga', 'asc');
            elseif ($request->kelas_harga == 'mahal') $kelasQuery->orderBy('harga', 'desc');
        } else {
            $kelasQuery->latest();
        }

        $kelasPerPage = $request->kelas_per_page ?? 5;
        // Gunakan nama pagination 'kelas_page' agar tidak bentrok dengan tabel ruangan
        $kelasKamars = $kelasQuery->paginate($kelasPerPage, ['*'], 'kelas_page')->appends($request->all());


        // 3. DATA FISIK (RUANGAN)
        $kamarQuery = Kamar::with('kelasKamar');

        if ($request->filled('ruangan_search')) {
            $kamarQuery->where('nomor_ruangan', 'like', '%' . $request->ruangan_search . '%');
        }

        if ($request->filled('ruangan_kelas')) {
            $kamarQuery->where('kelas_kamar_id', $request->ruangan_kelas);
        }

        if ($request->filled('ruangan_status')) {
            $kamarQuery->where('status', $request->ruangan_status);
        }

        $ruanganPerPage = $request->ruangan_per_page ?? 5;
        // Gunakan nama pagination 'ruangan_page'
        $kamars = $kamarQuery->latest()->paginate($ruanganPerPage, ['*'], 'ruangan_page')->appends($request->all());

        // 4. Data Master Kelas Kamar untuk Dropdown Filter dan Form Modal
        $semuaKelas = KelasKamar::orderBy('nama_kelas', 'asc')->get();

        return view('dashboard.kamar', compact('kelasKamars', 'kamars', 'semuaKelas', 'activeTab'));
    }
    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'fasilitas' => 'required|array',
            'thumbnail' => 'required|image|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('thumbnail')) $data['thumbnail'] = $request->file('thumbnail')->store('kamar', 'public');
        if ($request->hasFile('foto_1')) $data['foto_1'] = $request->file('foto_1')->store('kamar', 'public');
        if ($request->hasFile('foto_2')) $data['foto_2'] = $request->file('foto_2')->store('kamar', 'public');
        if ($request->hasFile('foto_3')) $data['foto_3'] = $request->file('foto_3')->store('kamar', 'public');

        KelasKamar::create($data);
        return back()->with('success', 'Kelas kamar baru berhasil dibuat!');
    }

    public function destroyKelas($id)
    {
        $kelas = KelasKamar::findOrFail($id);
        $fotos = ['thumbnail', 'foto_1', 'foto_2', 'foto_3'];
        foreach ($fotos as $foto) {
            if ($kelas->$foto) Storage::disk('public')->delete($kelas->$foto);
        }
        $kelas->delete();
        return back()->with('success', 'Kelas kamar dan semua ruangannya berhasil dihapus!');
    }

    // LOGIKA RUANGAN FISIK (KAMAR)
    public function storeKamar(Request $request)
    {
        $request->validate([
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'nomor_ruangan' => 'required|string|unique:kamars,nomor_ruangan',
            'status' => 'required|in:Tersedia,Terpakai,Dibooking,Maintenance',
        ]);

        Kamar::create($request->all());
        return back()->with('success', 'Ruangan nomor ' . $request->nomor_ruangan . ' berhasil ditambahkan!');
    }

    public function updateKamar(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        $request->validate([
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'nomor_ruangan' => 'required|string|unique:kamars,nomor_ruangan,' . $id,
            'status' => 'required|in:Tersedia,Terpakai,Dibooking,Maintenance',
        ]);

        $kamar->update($request->all());
        return back()->with('success', 'Status ruangan ' . $request->nomor_ruangan . ' berhasil diperbarui!');
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = KelasKamar::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'fasilitas' => 'required|array',
            // Saat edit, foto tidak wajib (nullable) agar admin bisa mempertahankan foto lama
            'thumbnail' => 'nullable|image|max:2048',
            'foto_1' => 'nullable|image|max:2048',
            'foto_2' => 'nullable|image|max:2048',
            'foto_3' => 'nullable|image|max:2048',
        ]);

        $data = $request->except(['thumbnail', 'foto_1', 'foto_2', 'foto_3']);

        // Logika hapus foto lama dan simpan foto baru jika ada file yang diunggah
        $fotos = ['thumbnail', 'foto_1', 'foto_2', 'foto_3'];
        foreach ($fotos as $foto) {
            if ($request->hasFile($foto)) {
                if ($kelas->$foto) {
                    Storage::disk('public')->delete($kelas->$foto);
                }
                $data[$foto] = $request->file($foto)->store('kamar', 'public');
            }
        }

        $kelas->update($data);
        return back()->with('success', 'Katalog kelas kamar berhasil diperbarui!');
    }

    public function destroyKamar($id)
    {
        Kamar::findOrFail($id)->delete();
        return back()->with('success', 'Ruangan berhasil dihapus!');
    }
    //
}
