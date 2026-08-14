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
    // =====================================================================
    // MODULE 1: LANDING PAGE (SISI TAMU)
    // Menampilkan daftar kelas kamar beserta ketersediaannya di halaman depan
    // =====================================================================
    public function landingPage(Request $request)
    {
        $checkin = $request->input('filter_checkin', date('Y-m-d\TH:i'));
        $checkout = $request->input('filter_checkout', date('Y-m-d\T11:00', strtotime('+1 day')));
        $jumlahTamu = (int) $request->input('filter_tamu', 1);
        $checkinDate = Carbon::parse($checkin);
        $checkoutDate = Carbon::parse($checkout);
        $isSearched = $request->has('filter_checkin');
        $semuaKelas = KelasKamar::all();
        $kelasKamars = collect();

        foreach ($semuaKelas as $kelas) {
            // Menghitung jumlah ruangan fisik yang ada untuk kelas ini (kecuali yang Maintenance)
            $totalKamar = Kamar::where('kelas_kamar_id', $kelas->id)->where('status', '!=', 'Maintenance')->count();
            
            // Menghitung ruangan yang sedang terpakai/dibooking pada rentang tanggal tersebut
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

    // =====================================================================
    // MODULE 2: DASHBOARD MANAJEMEN KAMAR (SISI ADMIN & RESEPSIONIS)
    // Mengambil data Kelas Kamar dan Ruangan dengan filter, pencarian, & paginasi
    // =====================================================================
    public function index(Request $request)
    {
        $activeTab = $request->tab ?? 'kelas';
        
        // --- LOGIKA TAB: KELAS KAMAR ---
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

        // Default pagination menjadi 10 (Sesuai Permintaan)
        $kelasPerPage = $request->kelas_per_page ?? 10;
        $kelasKamars = $kelasQuery->paginate($kelasPerPage, ['*'], 'kelas_page')->appends($request->all());

        // --- LOGIKA TAB: RUANGAN FISIK ---
        $kamarQuery = Kamar::with('kelasKamar');

        if ($request->filled('ruangan_search')) $kamarQuery->where('nomor_ruangan', 'like', '%' . $request->ruangan_search . '%');
        if ($request->filled('ruangan_kelas')) $kamarQuery->where('kelas_kamar_id', $request->ruangan_kelas);
        if ($request->filled('ruangan_status')) $kamarQuery->where('status', $request->ruangan_status);

        // Default pagination menjadi 10 (Sesuai Permintaan)
        $ruanganPerPage = $request->ruangan_per_page ?? 10;
        $kamars = $kamarQuery->latest()->paginate($ruanganPerPage, ['*'], 'ruangan_page')->appends($request->all());

        $semuaKelas = KelasKamar::orderBy('nama_kelas', 'asc')->get();

        return view('dashboard.kamar', compact('kelasKamars', 'kamars', 'semuaKelas', 'activeTab'));
    }

    // =====================================================================
    // MODULE 3: FUNGSI CRUD KELAS KAMAR (HANYA ADMIN)
    // Menambah, Memperbarui, dan Menghapus Katalog Kelas Kamar
    // =====================================================================
    public function storeKelas(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kapasitas' => 'required|integer|min:1',
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
            'kapasitas' => 'required|integer|min:1',
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

    // =====================================================================
    // MODULE 4: FUNGSI CRUD RUANGAN FISIK (HANYA ADMIN)
    // Menambah, Memperbarui, dan Menghapus unit Ruangan Fisik
    // =====================================================================
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