<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Reservasi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            color: #4338ca;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0 0 0;
            color: #555;
        }

        table {
            w-full: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
            color: #333;
            font-weight: bold;
        }

        .badge-selesai {
            color: green;
            font-weight: bold;
        }

        .badge-batal {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>FISA HOTEL</h1>
        <p>Laporan Riwayat Transaksi Tamu & Reservasi</p>
        <p>Tanggal Cetak: {{ \Carbon\Carbon::now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>No Reservasi</th>
                <th>Nama Tamu (KTP/WA)</th>
                <th>Ruangan</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayats as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $log->no_reservasi }}</td>
                    <td>
                        <strong>{{ $log->nama_tamu }}</strong><br>
                        NIK: {{ $log->no_ktp }}<br>
                        WA: {{ $log->no_hp }}
                    </td>
                    <td>
                        Kamar #{{ $log->kamar->nomor_ruangan }}<br>
                        <small>{{ $log->kamar->kelasKamar->nama_kelas }}</small>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($log->check_in)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($log->check_out)->format('d/m/Y') }}</td>
                    <td class="{{ $log->status_reservasi == 'Selesai' ? 'badge-selesai' : 'badge-batal' }}">
                        {{ $log->status_reservasi }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align:center;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>

</html>
