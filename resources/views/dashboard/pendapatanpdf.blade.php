<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Fisa Hotel</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d97706;
        }

        .header h2 {
            margin: 0;
            color: #78350f;
            font-size: 20px;
            letter-spacing: 1px;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #92400e;
        }

        .summary-box {
            margin-bottom: 20px;
            background-color: #fef3c7;
            padding: 10px 15px;
            border: 1px solid #fde68a;
            border-radius: 4px;
        }

        .summary-box p {
            margin: 3px 0;
            font-weight: bold;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px 6px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .text-muted {
            color: #6b7280;
            font-size: 9px;
            margin-top: 2px;
        }

        .total-row {
            background-color: #fffbeb;
            font-weight: bold;
        }

        .total-amount {
            color: #1d4ed8;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>FISA HOTEL</h2>
        <p>Laporan Rekapitulasi Pendapatan dan Riwayat Kunjungan Tamu</p>
    </div>

    <div class="summary-box">
        <p>Periode Laporan: {{ $teksPeriode }}</p>
        <p>Total Pendapatan Terkumpul: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="3%">No</th>
                <th width="15%">Reservasi</th>
                <th width="20%">Data Tamu</th>
                <th width="20%">Kamar & Durasi</th>
                <th class="text-right" width="14%">Biaya Kamar</th>
                <th class="text-right" width="13%">Biaya Ekstra</th>
                <th class="text-right" width="15%">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasis as $index => $res)
                @php
                    // Logika Perhitungan Hari yang Benar (Midnight to Midnight)
                    $in = \Carbon\Carbon::parse($res->check_in)->startOfDay();
                    $out = \Carbon\Carbon::parse($res->check_out)->startOfDay();
                    $diffDays = max(1, (int) $in->diffInDays($out));

                    // Hitung Uang
                    $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;
                    $kamarTotal = $hargaKamar * $diffDays;

                    $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                    $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
                    $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;
                    $ekstraTotal = $bed + $selimut;

                    $totalBaris = $kamarTotal + $ekstraTotal;

                    // Tanggal Pelunasan / Checkout Aktual
                    $tglSelesai = \Carbon\Carbon::parse($res->updated_at)->format('d/m/Y');
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>

                    <!-- Kolom Reservasi -->
                    <td>
                        <div class="font-bold">{{ $res->no_reservasi }}</div>
                        <div class="text-muted">Tgl: {{ $tglSelesai }}</div>
                    </td>

                    <!-- Kolom Data Tamu (Nama & NIK) -->
                    <td>
                        <div class="font-bold">{{ $res->nama_tamu }}</div>
                        <div class="text-muted">NIK: {{ $res->no_ktp ?? '-' }}</div>
                    </td>

                    <!-- Kolom Kamar & Durasi -->
                    <td>
                        <div class="font-bold">{{ $res->kamar->kelasKamar->nama_kelas ?? 'Dihapus' }}
                            ({{ $res->kamar->nomor_ruangan ?? '-' }})
                        </div>
                        <div class="text-muted">{{ $diffDays }} Malam</div>
                    </td>

                    <!-- Kolom Biaya Kamar -->
                    <td class="text-right">
                        {{ number_format($kamarTotal, 0, ',', '.') }}
                    </td>

                    <!-- Kolom Biaya Ekstra -->
                    <td class="text-right">
                        @if ($ekstraTotal > 0)
                            {{ number_format($ekstraTotal, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <!-- Kolom Total Biaya -->
                    <td class="text-right font-bold total-amount">
                        {{ number_format($totalBaris, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 20px;">Tidak ada data pendapatan pada periode
                        yang dipilih.</td>
                </tr>
            @endforelse

            @if ($reservasis->count() > 0)
                <tr class="total-row">
                    <td colspan="6" class="text-right">GRAND TOTAL PENDAPATAN</td>
                    <td class="text-right total-amount">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>
