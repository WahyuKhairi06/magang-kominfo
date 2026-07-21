<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengaduan Masyarakat - Puskesmas Marunggi</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2D6A4F;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            font-size: 16px;
            color: #2D6A4F;
            text-transform: uppercase;
        }
        .header h3 {
            margin: 3px 0 0 0;
            font-size: 13px;
            font-weight: normal;
            color: #555;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 10px;
            color: #777;
        }
        .meta-info {
            margin-bottom: 12px;
            font-size: 10px;
            background-color: #f8f9fa;
            padding: 8px 12px;
            border-radius: 4px;
            border-left: 3px solid #2D6A4F;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }
        th, td {
            border: 1px solid #dcdcdc;
            padding: 7px 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #2D6A4F;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #fcfcfc;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge-tinggi { background-color: #ffebe9; color: #cf222e; border: 1px solid #ffc1c0; }
        .badge-sedang { background-color: #fff8c5; color: #9a6700; border: 1px solid #d4a72c; }
        .badge-rendah { background-color: #dafbe1; color: #1a7f37; border: 1px solid #4ac26b; }
        
        .footer {
            margin-top: 30px;
            width: 100%;
        }
        .footer-table {
            width: 100%;
            border: none;
        }
        .footer-table td {
            border: none;
            padding: 0;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>PEMERINTAH KOTA PARIAMAN - DINAS KESEHATAN</h2>
        <h3>PUSKESMAS MARUNGGI</h3>
        <p>Jl. Raya Marunggi, Kec. Pariaman Selatan, Kota Pariaman | Telp/WA: (0751) XXX-XXX</p>
    </div>

    <h3 style="text-align: center; margin: 10px 0 5px 0; color: #111;">LAPORAN REKAPITULASI PENGADUAN MASYARAKAT</h3>
    
    <div class="meta-info">
        <strong>Periode Tanggal:</strong> 
        @if($startDate && $endDate)
            {{ \Carbon\Carbon::parse($startDate)->isoFormat('DD MMMM YYYY') }} s/d {{ \Carbon\Carbon::parse($endDate)->isoFormat('DD MMMM YYYY') }}
        @elseif($startDate)
            Mulai {{ \Carbon\Carbon::parse($startDate)->isoFormat('DD MMMM YYYY') }}
        @elseif($endDate)
            Sampai {{ \Carbon\Carbon::parse($endDate)->isoFormat('DD MMMM YYYY') }}
        @else
            Semua Data Terdaftar
        @endif
        <span style="float: right;"><strong>Total Data:</strong> {{ count($data) }} Pengaduan</span>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 4%; text-align: center;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 15%;">Pelapor</th>
                <th style="width: 11%;">No HP</th>
                <th style="width: 33%;">Isi Keluhan</th>
                <th style="width: 15%;">Kategori</th>
                <th style="width: 10%; text-align: center;">Urgensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->isoFormat('DD/MM/YYYY HH:mm') }}</td>
                    <td><strong>{{ $item->nama }}</strong></td>
                    <td>{{ $item->no_hp }}</td>
                    <td>{{ $item->isi_pengaduan }}</td>
                    <td>
                        {{ $item->kategori_final ?? $item->kategori_ai ?? 'Lainnya' }}
                        @if($item->is_overridden)
                            <br><small style="color: #666; font-style: italic;">(Di-override Admin)</small>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        @php
                            $urgensi = strtolower($item->urgensi_final ?? $item->urgensi_ai ?? 'rendah');
                        @endphp
                        <span class="badge badge-{{ $urgensi }}">
                            {{ ucfirst($urgensi) }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 20px; color: #888;">
                        Tidak ada data pengaduan untuk periode tanggal ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <table class="footer-table">
            <tr>
                <td style="width: 65%;"></td>
                <td style="width: 35%; text-align: center;">
                    <p>Pariaman, {{ \Carbon\Carbon::now()->isoFormat('DD MMMM YYYY') }}</p>
                    <p style="margin-bottom: 50px;">Petugas Admin Triage,</p>
                    <p><strong>( ________________________ )</strong></p>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
