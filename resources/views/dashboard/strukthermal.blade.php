<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran #{{ $reservasi->no_reservasi }}</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            margin: 0;
            padding: 10px;
            width: 58mm;
            color: #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .font-bold {
            font-weight: bold;
        }

        .mb-1 {
            margin-bottom: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .dashed-line {
            border-bottom: 1px dashed #000;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            vertical-align: top;
            padding: 2px 0;
        }

        .total-box {
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
            padding: 5px 0;
            margin-top: 5px;
        }

        @media print {
            body {
                width: 100%;
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print(); setTimeout(function(){ window.close(); }, 500);">

    <div class="text-center mb-2">
        <h2 style="margin:0; font-size: 16px;">FISA HOTEL</h2>
        <p style="margin:0; font-size: 10px;">Jl. Lingkar Selatan Km.02, Bumiayu</p>
        <p style="margin:0; font-size: 10px;">Telp: 0812-3456-7890</p>
    </div>

    <div class="dashed-line"></div>

    <table class="mb-1">
        <tr>
            <td>Kasir</td>
            <td class="text-right">{{ explode(' ', trim($kasir))[0] }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="text-right">{{ date('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>No. Res</td>
            <td class="text-right">#{{ $reservasi->no_reservasi }}</td>
        </tr>
    </table>

    <div class="dashed-line"></div>

    <div class="font-bold mb-1">Tamu: {{ explode('&', $reservasi->nama_tamu)[0] }}</div>
    <div class="mb-2">Kamar: {{ $reservasi->kamar?->nomor_ruangan ?? '-' }}
        ({{ $reservasi->kamar?->kelasKamar?->nama_kelas ?? '-' }})</div>

    <table>
        <tr>
            <td colspan="2">{{ $diffDays }} Malam x Rp {{ number_format($hargaKamar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td class="text-right font-bold">Rp {{ number_format($totalKamar, 0, ',', '.') }}</td>
        </tr>

        @if ($qtyBed > 0)
            <tr>
                <td colspan="2">Ex. Bed ({{ $qtyBed }}x)</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td class="text-right">Rp {{ number_format($totalBed, 0, ',', '.') }}</td>
            </tr>
        @endif
    </table>

    <div class="total-box text-right font-bold" style="font-size: 14px;">
        TOTAL: Rp {{ number_format($totalAkhir, 0, ',', '.') }}
    </div>

    <table class="mt-1">
        <tr>
            <td>Status</td>
            <td class="text-right font-bold">LUNAS</td>
        </tr>
        <tr>
            <td>Metode</td>
            <td class="text-right">{{ $ekstra['Detail Pembayaran'] ?? 'Cash' }}</td>
        </tr>
    </table>

    <div class="dashed-line"></div>

    <div class="text-center" style="font-size: 10px;">
        <p style="margin: 2px 0;">Terima kasih telah menginap di</p>
        <p style="margin: 2px 0;">FISA HOTEL</p>
        <p style="margin: 2px 0;">Semoga perjalanan Anda menyenangkan!</p>
    </div>

</body>

</html>