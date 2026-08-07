<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KelasKamar;
use App\Models\Kamar;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Models\Pembayaran;
use App\Services\PakasirPaymentService;
use App\Notifications\ReservasiBerhasil;

class GuestReservationController extends Controller
{
    public function index(Request $request)
    {
        $kelasId = $request->kelas_id;
        $checkin = $request->filter_checkin ?? Carbon::now()->format('Y-m-d\TH:i');
        $checkout = $request->filter_checkout ?? Carbon::now()->addDays(1)->setTime(11, 0)->format('Y-m-d\TH:i');
        $kelasKamars = KelasKamar::all();

        $isMaintenance = false;
        if (Cache::get('maintenance_mode') === 'true' && Cache::get('main_online') === 'true') {
            $isMaintenance = true;
        }

        if (!Auth::check()) {
            return view('landing_page.hreservasi', [
                'isLoggedIn' => false,
                'user' => null,
                'kelasKamars' => $kelasKamars,
                'kelasId' => $kelasId,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'reservasiAktif' => collect(),
                'pesananAktifs' => collect(),
                'pembayaranAktifs' => collect(),
                'arsipReservasi' => Reservasi::where('id', 0)->paginate(10),
                'isMaintenance' => $isMaintenance
            ]);
        }

        $user = Auth::user();

        // 🛡️ ENGINE SUPER KETAT PENANGKAL BUG 🛡️
        $waktuSekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $batasBatal = \Carbon\Carbon::now('Asia/Jakarta')->subDays(3)->format('Y-m-d H:i:s');

        // 1. Amankan status jadi 'Terlewat' DULU
        Reservasi::where('status_reservasi', 'Menunggu Konfirmasi')
            ->where('check_in', '<', $waktuSekarang)
            ->where('check_in', '>', $batasBatal)
            ->update(['status_reservasi' => 'Terlewat']);

        // 2. Baru Batalkan jika BENAR-BENAR sudah lewat 3 hari
        Reservasi::whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terlewat'])
            ->where('check_in', '<=', $batasBatal)
            ->update(['status_reservasi' => 'Dibatalkan']);

        $pesananAktifs = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('dibuat_oleh_user_id', $user->id);
                if (!empty($user->no_hp) && $user->no_hp !== '-') {
                    $q->orWhere('no_hp', $user->no_hp);
                }
                if (!empty($user->no_ktp) && $user->no_ktp !== '-') {
                    $q->orWhere('no_ktp', $user->no_ktp);
                }
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In', 'Terlewat'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pembayaranAktifs = Pembayaran::whereIn('reservasi_id', $pesananAktifs->pluck('id'))->get()->keyBy('reservasi_id');

        $perPage = $request->input('per_page', 10);
        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('dibuat_oleh_user_id', $user->id);
                if (!empty($user->no_hp) && $user->no_hp !== '-') {
                    $q->orWhere('no_hp', $user->no_hp);
                }
                if (!empty($user->no_ktp) && $user->no_ktp !== '-') {
                    $q->orWhere('no_ktp', $user->no_ktp);
                }
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->query());

        return view('landing_page.hreservasi', [
            'isLoggedIn' => true,
            'user' => $user,
            'kelasKamars' => $kelasKamars,
            'kelasId' => $kelasId,
            'checkin' => $checkin,
            'checkout' => $checkout,
            'reservasiAktif' => $pesananAktifs,
            'pesananAktifs' => $pesananAktifs,
            'pembayaranAktifs' => $pembayaranAktifs,
            'arsipReservasi' => $arsipReservasi,
            'isMaintenance' => $isMaintenance
        ]);
    }

    public function riwayat(Request $request)
    {
        if (!Auth::check()) {
            return view('landing_page.hriwayat', [
                'isLoggedIn' => false,
                'pesananAktifs' => collect(),
                'pembayaranAktifs' => collect(),
                'arsipReservasi' => collect(),
                'kelasKamars' => collect()
            ]);
        }

        $user = Auth::user();

        // 🛡️ ENGINE SUPER KETAT PENANGKAL BUG 🛡️
        $waktuSekarang = \Carbon\Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $batasBatal = \Carbon\Carbon::now('Asia/Jakarta')->subDays(3)->format('Y-m-d H:i:s');

        // 1. Amankan status jadi 'Terlewat' DULU
        Reservasi::where('status_reservasi', 'Menunggu Konfirmasi')
            ->where('check_in', '<', $waktuSekarang)
            ->where('check_in', '>', $batasBatal)
            ->update(['status_reservasi' => 'Terlewat']);

        // 2. Baru Batalkan jika BENAR-BENAR sudah lewat 3 hari
        Reservasi::whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terlewat'])
            ->where('check_in', '<=', $batasBatal)
            ->update(['status_reservasi' => 'Dibatalkan']);

        $pesananAktifs = Reservasi::with(['kamar.kelasKamar'])
            ->where(function ($q) use ($user) {
                $q->where('dibuat_oleh_user_id', $user->id);
                if (!empty($user->no_hp) && $user->no_hp !== '-') {
                    $q->orWhere('no_hp', $user->no_hp);
                }
                if (!empty($user->no_ktp) && $user->no_ktp !== '-') {
                    $q->orWhere('no_ktp', $user->no_ktp);
                }
            })
            ->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In', 'Terlewat'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pembayaranAktifs = Pembayaran::whereIn('reservasi_id', $pesananAktifs->pluck('id'))->get()->keyBy('reservasi_id');
        $perPage = $request->input('per_page', 10);

        $arsipReservasi = Reservasi::with('kamar.kelasKamar')
            ->where(function ($q) use ($user) {
                $q->where('dibuat_oleh_user_id', $user->id);
                if (!empty($user->no_hp) && $user->no_hp !== '-') {
                    $q->orWhere('no_hp', $user->no_hp);
                }
                if (!empty($user->no_ktp) && $user->no_ktp !== '-') {
                    $q->orWhere('no_ktp', $user->no_ktp);
                }
            })
            ->whereIn('status_reservasi', ['Selesai', 'Batal', 'Dibatalkan'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)->appends($request->query());

        $kelasKamars = KelasKamar::all();

        return view('landing_page.hriwayat', [
            'isLoggedIn' => true,
            'pesananAktifs' => $pesananAktifs,
            'pembayaranAktifs' => $pembayaranAktifs,
            'arsipReservasi' => $arsipReservasi,
            'kelasKamars' => $kelasKamars,
            'perPage' => $perPage
        ]);
    }

    public function store(Request $request, PakasirPaymentService $pakasirService)
    {
        $user = Auth::user();

        $rules = [
            'kelas_kamar_id' => 'required|exists:kelas_kamars,id',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
        ];

        if (empty($user->no_ktp) || empty($user->no_hp)) {
            $rules['no_ktp'] = 'required|regex:/^[0-9]+$/|min:16|max:16';
            $rules['no_hp'] = 'required|regex:/^[0-9]+$/|min:10|max:15';
        }

        $request->validate($rules);
        $noKtp = $request->no_ktp ?? $user->no_ktp;
        $noHp = $request->no_hp ?? $user->no_hp;

        if (substr($noHp, 0, 1) === '0') {
            $noHp = '62' . substr($noHp, 1);
        }

        if (empty($user->no_ktp) || empty($user->no_hp)) {
            $user->no_ktp = $noKtp;
            $user->no_hp = $noHp;
            $user->save();
        }

        $activeReservationsCount = Reservasi::where(function ($q) use ($user, $noKtp, $noHp) {
            $q->where('dibuat_oleh_user_id', $user->id);
            if (!empty($noHp) && $noHp !== '-') {
                $q->orWhere('no_hp', $noHp);
            }
            if (!empty($noKtp) && $noKtp !== '-') {
                $q->orWhere('no_ktp', $noKtp);
            }
        })->whereIn('status_reservasi', ['Menunggu Konfirmasi', 'Terkonfirmasi', 'Check-In', 'Terlewat'])->count();

        if ($activeReservationsCount >= 4) {
            return back()->withInput()->with('error', 'Batas maksimal tercapai! Anda hanya dapat memiliki 4 reservasi aktif.');
        }

        $namaTamu = $user->name;
        $checkIn = Carbon::parse($request->check_in)->format('Y-m-d H:i:s');
        $checkOut = Carbon::parse($request->check_out)->format('Y-m-d H:i:s');

        $reservedIds = Reservasi::whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in', '<', $checkOut)->where('check_out', '>', $checkIn);
            })->pluck('kamar_id');

        $kamarBebas = Kamar::where('kelas_kamar_id', $request->kelas_kamar_id)
            ->where('status', '!=', 'Maintenance')->whereNotIn('id', $reservedIds)->inRandomOrder()->first();

        if (!$kamarBebas) {
            return back()->withInput()->with('error', 'Kamar penuh pada tanggal tersebut.');
        }

        $noReservasi = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));
        $noInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $diffTime = strtotime($checkOut) - strtotime($checkIn);
        $diffDays = ceil($diffTime / (60 * 60 * 24));
        if ($diffDays <= 0) $diffDays = 1;

        $kelasKamar = KelasKamar::find($request->kelas_kamar_id);
        $hargaKamar = $kelasKamar->harga * $diffDays;
        $hargaEkstra = ((int)$request->extra_bed * 50000);
        $totalBayar = $hargaKamar + $hargaEkstra;

        $ekstra = [
            'Jumlah Anggota' => (int) $request->jumlah_anggota,
            'Extra Bed' => (int) $request->extra_bed,
            'Pesan Tambahan' => $request->pesan_tambahan ?? '-',
            'Metode Pembayaran' => $request->metode_pembayaran,
            'Total Bayar' => $totalBayar,
            'Detail Pembayaran' => $request->metode_pembayaran === 'QRIS' ? 'Menunggu Pembayaran QRIS' : 'Bayar di Tempat'
        ];

        $id = Reservasi::create([
            'no_reservasi' => $noReservasi,
            'dibuat_oleh_user_id' => $user->id,
            'nama_tamu' => $namaTamu,
            'no_ktp' => $noKtp,
            'no_hp' => $noHp,
            'kamar_id' => $kamarBebas->id,
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'ekstra' => $ekstra,
            'tipe_reservasi' => 'Online',
            'status_reservasi' => 'Menunggu Konfirmasi'
        ]);

        Pembayaran::create([
            'reservasi_id' => $id->id,
            'invoice' => $noInvoice,
            'total' => $totalBayar,
            'status' => 'pending',
            'expired_at' => $checkIn,
        ]);

        if ($user) {
            $user->notify(new ReservasiBerhasil($noReservasi, $kelasKamar->nama_kelas, $request->jumlah_anggota));
        }

        return redirect()->route('riwayat.tamu')->with('success', "Reservasi berhasil dibuat! Silakan cek rincian pembayaran.");
    }

    public function generateQris($id, \App\Services\PakasirPaymentService $pakasirService)
    {
        $reservasi = Reservasi::with('kamar.kelasKamar')->findOrFail($id);
        $pembayaran = \App\Models\Pembayaran::where('reservasi_id', $reservasi->id)->first();

        if ($pembayaran && $pembayaran->qr_image) {
            return response()->json(['success' => true, 'qr_image' => $pembayaran->qr_image, 'status' => $pembayaran->status, 'invoice' => $pembayaran->invoice, 'expired_at' => $pembayaran->expired_at]);
        }

        $totalBayar = $reservasi->ekstra['Total Bayar'] ?? 0;
        $pembayaranBaru = $pakasirService->createQrisPayment($pembayaran->invoice, $totalBayar);

        if ($pembayaranBaru && $pembayaranBaru->qr_image) {
            return response()->json(['success' => true, 'qr_image' => $pembayaranBaru->qr_image, 'status' => $pembayaranBaru->status, 'invoice' => $pembayaranBaru->invoice, 'expired_at' => $pembayaranBaru->expired_at]);
        }

        return response()->json(['success' => false, 'message' => 'Gagal terhubung ke server Payment Gateway.']);
    }

    public function update(Request $request, $id)
    {
        $reservasi = Reservasi::with('pembayaran')->findOrFail($id);

        // Kunci jika QRIS sudah pernah diminta
        if ($reservasi->pembayaran && $reservasi->pembayaran->qr_image) {
            return redirect()->route('riwayat.tamu')->with('error', 'Penjadwalan ulang dikunci! Anda sudah membuat kode pembayaran QRIS.');
        }

        // Ambil input dan bersihkan huruf 'T' dari input HTML datetime-local
        $rawCheckIn = str_replace('T', ' ', $request->check_in);
        $rawCheckOut = str_replace('T', ' ', $request->check_out);

        // Parse ke Carbon agar mudah divalidasi dan diformat
        $checkInCarbon = \Carbon\Carbon::parse($rawCheckIn, 'Asia/Jakarta');
        $checkOutCarbon = \Carbon\Carbon::parse($rawCheckOut, 'Asia/Jakarta');

        // Validasi Manual Waktu Mundur
        if ($checkInCarbon->isPast()) {
            return redirect()->route('riwayat.tamu')->with('error', 'Waktu check-in tidak valid! Anda tidak dapat memilih waktu di masa lalu.');
        }

        // Validasi Manual Check-out harus setelah Check-in
        if ($checkOutCarbon->lte($checkInCarbon)) {
            return redirect()->route('riwayat.tamu')->with('error', 'Waktu check-out harus setelah waktu check-in.');
        }

        // Format baku untuk MySQL (Y-m-d H:i:s)
        $checkInStr = $checkInCarbon->format('Y-m-d H:i:s');
        $checkOutStr = $checkOutCarbon->format('Y-m-d H:i:s');

        // Pengecekan Tabrakan Jadwal
        $isTabrakan = Reservasi::where('kamar_id', $reservasi->kamar_id)
            ->where('id', '!=', $id)
            ->whereIn('status_reservasi', ['Terkonfirmasi', 'Check-In'])
            ->where(function ($q) use ($checkInStr, $checkOutStr) {
                $q->where('check_in', '<', $checkOutStr)
                    ->where('check_out', '>', $checkInStr);
            })->exists();

        if ($isTabrakan) {
            return redirect()->route('riwayat.tamu')->with('error', 'Kamar pilihan sudah terisi oleh tamu lain pada jadwal tersebut.');
        }

        // EKSEKUSI UPDATE
        // Gunakan fungsi update langsung agar casting di Model berjalan sempurna
        $reservasi->update([
            'check_in' => $checkInStr,
            'check_out' => $checkOutStr,
            'status_reservasi' => 'Menunggu Konfirmasi'
        ]);

        if ($reservasi->pembayaran) {
            $reservasi->pembayaran->update([
                'expired_at' => $checkInStr
            ]);
        }

        // Menggunakan redirect->route() yang absolut, BUKAN back(), agar tidak pernah nyasar.
        return redirect()->route('riwayat.tamu')->with('success', 'Jadwal menginap Anda berhasil diperbarui! Silakan klik "Generate QRIS" untuk membayar.');
    }

    public function batal($id)
    {
        $res = Reservasi::findOrFail($id);
        $res->update(['status_reservasi' => 'Dibatalkan']);
        return back()->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function destroy($id)
    {
        $reservasi = Reservasi::with('pembayaran')->findOrFail($id);

        // Validasi pengaman: Tolak jika sudah generate QRIS atau dibayar
        if ($reservasi->pembayaran && $reservasi->pembayaran->qr_image) {
            return redirect()->route('riwayat.tamu')->with('error', 'Reservasi tidak dapat dihapus karena kode pembayaran QRIS sudah dibuat.');
        }

        // Hapus data pembayaran terkait terlebih dahulu (jika ada)
        if ($reservasi->pembayaran) {
            $reservasi->pembayaran->delete();
        }

        // Hapus data reservasi
        $reservasi->delete();

        return redirect()->route('riwayat.tamu')->with('success', 'Reservasi berhasil dihapus dari daftar.');
    }
}
