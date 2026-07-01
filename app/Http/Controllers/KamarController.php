<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\KelasKamar;
use App\Models\Reservasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class KamarController extends Controller
{
    public function landingPage(Request $request)
    {
        $checkin = $request->input('filter_checkin', date('Y-m-d\TH:i'));
        $checkout = $request->input('filter_checkout', date('Y-m-d\TH:i', strtotime('+1 day')));
        $jumlahTamu = (int) $request->input('filter_tamu', 1);
        $checkinDate = Carbon::parse($checkin);
        $checkoutDate = Carbon::parse($checkout);
        $isSearched = $request->has('filter_checkin');
        $semuaKelas = KelasKamar::all();
        $kelasKamars = collect();

        foreach ($semuaKelas as $kelas) {
            // Filter Berdasarkan Kapasitas yang baru
            if ($isSearched && $kelas->kapasitas < $jumlahTamu) {
                continue; // Skip jika kapasitas kelas tidak muat untuk jumlah tamu
            }

            $totalKamar = Kamar::where('kelas_kamar_id', $kelas->id)->where('status', '!=', 'Maintenance')->count();
            $terpakai = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
                ->whereHas('kamar', fn($q) => $q->where('kelas_kamar_id', $kelas->id))
                ->where('check_in', '<', $checkoutDate)
                ->where('check_out', '>', $checkinDate)
                ->distinct('kamar_id')->count('kamar_id');

            $sisa = max(0, $totalKamar - $terpakai);

            if ($sisa > 0) {
                $kelas->kamars_count = $sisa;
                $kelasKamars->push($kelas);
            }
        }

        $searchData = ['checkin' => $checkin, 'checkout' => $checkout, 'tamu' => $jumlahTamu];
        return view('landing_page.home', compact('kelasKamars', 'searchData'));
    }

    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'kelas';
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
        $kelasKamars = $kelasQuery->paginate($kelasPerPage, ['*'], 'kelas_page')->appends($request->all());

        $kamarQuery = Kamar::with('kelasKamar');

        if ($request->filled('ruangan_search')) $kamarQuery->where('nomor_ruangan', 'like', '%' . $request->ruangan_search . '%');
        if ($request->filled('ruangan_kelas')) $kamarQuery->where('kelas_kamar_id', $request->ruangan_kelas);
        if ($request->filled('ruangan_status')) $kamarQuery->where('status', $request->ruangan_status);

        $ruanganPerPage = $request->ruangan_per_page ?? 5;
        $kamars = $kamarQuery->latest()->paginate($ruanganPerPage, ['*'], 'ruangan_page')->appends($request->all());

        $semuaKelas = KelasKamar::orderBy('nama_kelas', 'asc')->get();

        return view('dashboard.kamar', compact('kelasKamars', 'kamars', 'semuaKelas', 'activeTab'));
    }

    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1', // Validasi Kapasitas
            'fasilitas' => 'required|array',
            'foto_1' => 'nullable|image|max:5120',
            'foto_2' => 'nullable|image|max:5120',
            'foto_3' => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['foto_1', 'foto_2', 'foto_3']);

        if ($request->hasFile('foto_1')) $data['foto_1'] = $request->file('foto_1')->store('kamar', 'public');
        if ($request->hasFile('foto_2')) $data['foto_2'] = $request->file('foto_2')->store('kamar', 'public');
        if ($request->hasFile('foto_3')) $data['foto_3'] = $request->file('foto_3')->store('kamar', 'public');

        $data['thumbnail'] = $data['foto_1'] ?? ($data['foto_2'] ?? ($data['foto_3'] ?? 'default-kamar.jpg'));

        KelasKamar::create($data);
        return back()->with('success', 'Kelas kamar baru berhasil dibuat!');
    }

    public function updateKelas(Request $request, $id)
    {
        $kelas = KelasKamar::findOrFail($id);

        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1', // Validasi Kapasitas
            'fasilitas' => 'required|array',
            'foto_1' => 'nullable|image|max:5120',
            'foto_2' => 'nullable|image|max:5120',
            'foto_3' => 'nullable|image|max:5120',
        ]);

        $data = $request->except(['foto_1', 'foto_2', 'foto_3', 'thumbnail_selection']);
        $fotos = ['foto_1', 'foto_2', 'foto_3'];
        $currentPhotos = [];

        foreach ($fotos as $foto) {
            if ($request->hasFile($foto)) {
                if ($kelas->$foto) Storage::disk('public')->delete($kelas->$foto);
                $path = $request->file($foto)->store('kamar', 'public');
                $data[$foto] = $path;
                $currentPhotos[$foto] = $path;
            } else {
                $currentPhotos[$foto] = $kelas->$foto;
            }
        }

        if ($request->has('thumbnail_selection')) {
            $selectedField = $request->thumbnail_selection;
            if (isset($currentPhotos[$selectedField]) && $currentPhotos[$selectedField] != null) {
                $data['thumbnail'] = $currentPhotos[$selectedField];
            }
        }

        $kelas->update($data);
        return back()->with('success', 'Katalog kelas kamar berhasil diperbarui!');
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

    public function destroyKamar($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();
        return back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
