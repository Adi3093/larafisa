<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan Fisa Hotel</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 2px solid #d97706;
        }

        .header h2 {
            margin: 0;
            color: #78350f;
            font-size: 20px;
        }

        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            color: #92400e;
        }

        .summary-box {
            margin-bottom: 20px;
            background-color: #fef3c7;
            padding: 10px 15px;
            border: 1px solid #fde68a;
        }

        .summary-box p {
            margin: 0;
            font-weight: bold;
            font-size: 14px;
        }

        table {
            w-full;
            border-collapse: collapse;
            margin-top: 10px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #fef3c7;
            color: #92400e;
            font-weight: bold;
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

        .total-row {
            background-color: #fffbeb;
            font-weight: bold;
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
                <th class="text-center">No</th>
                <th>ID Reservasi</th>
                <th>Tgl Keluar</th>
                <th>Nama Tamu</th>
                <th>Kamar</th>
                <th class="text-center">Durasi</th>
                <th class="text-right">Pemasukan (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservasis as $index => $res)
                @php
                    $in = \Carbon\Carbon::parse($res->check_in);
                    $out = \Carbon\Carbon::parse($res->check_out);
                    $diffDays = max(1, $in->diffInDays($out));
                    $hargaKamar = $res->kamar->kelasKamar->harga ?? 0;

                    $ekstra = is_array($res->ekstra) ? $res->ekstra : json_decode($res->ekstra, true) ?? [];
                    $bed = ($ekstra['Extra Bed'] ?? 0) * 100000;
                    $selimut = ($ekstra['Extra Selimut'] ?? 0) * 25000;

                    $totalBaris = $hargaKamar * $diffDays + $bed + $selimut;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $res->no_reservasi }}</td>
                    <td>{{ $out->format('d/m/Y') }}</td>
                    <td>{{ $res->nama_tamu }}</td>
                    <td>Kamar {{ $res->kamar->nomor_ruangan ?? '-' }}</td>
                    <td class="text-center">{{ $diffDays }} mlm</td>
                    <td class="text-right">{{ number_format($totalBaris, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pendapatan pada periode yang dipilih.</td>
                </tr>
            @endforelse

            @if ($reservasis->count() > 0)
                <tr class="total-row">
                    <td colspan="6" class="text-right">GRAND TOTAL PENDAPATAN</td>
                    <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

</body>

</html>
