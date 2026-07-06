{{-- resources/views/admin/inovasisekre/index.blade.php --}}

@extends('template.layout')

@section('content')

<div class="p-4 md:p-6 bg-slate-50 min-h-screen">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>

            <h1 class="text-3xl font-black text-slate-800">
                Data Inovasi Sekre
            </h1>

            <p class="text-slate-500 mt-1">
                Daftar dokumen, file inovasi dan QR Code akses dokumen.
            </p>

        </div>

        <a href="{{ route('inovasisekre.create') }}"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700
                  text-white px-5 py-3 rounded-2xl shadow-lg transition">

            <span class="text-xl">＋</span>

            <span class="font-semibold">
                Tambah Data
            </span>

        </a>

    </div>

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full min-w-[1200px]">

                <thead class="bg-slate-100 border-b border-slate-200">

                    <tr>

                        <th class="px-5 py-4 text-left text-sm font-bold text-slate-700 w-[70px]">
                            No
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-slate-700">
                            File
                        </th>

                        <th class="px-5 py-4 text-left text-sm font-bold text-slate-700">
                            Keterangan
                        </th>

                        <th class="px-5 py-4 text-center text-sm font-bold text-slate-700 w-[360px]">
                            QR Code
                        </th>

                        <th class="px-5 py-4 text-center text-sm font-bold text-slate-700 w-[180px]">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $i => $d)

                    @php

                        $link = route(
                            'inovasisekre.show',
                            Crypt::encryptString($d->id)
                        );

                    @endphp

                    <tr class="border-b border-slate-100 hover:bg-slate-50 transition">

                        {{-- NO --}}
                        <td class="px-5 py-5 align-top">

                            <div class="w-10 h-10 rounded-2xl bg-blue-100
                                        text-blue-700 flex items-center justify-center
                                        font-bold shadow-sm">

                                {{ $i+1 }}

                            </div>

                        </td>

                        {{-- FILE --}}
                        <td class="px-5 py-5 align-top">

                            @if($d->file)

                                @php

                                    $ext = strtolower(
                                        pathinfo($d->file, PATHINFO_EXTENSION)
                                    );

                                    $url = asset('storage/'.$d->file);

                                    $imageExt = ['jpg','jpeg','png','webp'];

                                    $docExt = [
                                        'pdf',
                                        'doc',
                                        'docx',
                                        'xls',
                                        'xlsx',
                                        'ppt',
                                        'pptx'
                                    ];

                                @endphp

                                {{-- IMAGE --}}
                                @if(in_array($ext, $imageExt))

                                    <div class="space-y-4">

                                        <a href="{{ $url }}"
                                           target="_blank"
                                           class="block group">

                                            <img src="{{ $url }}"
                                                 class="w-32 h-32 object-cover rounded-3xl
                                                        border border-slate-200 shadow-md
                                                        group-hover:scale-105 transition duration-300">

                                        </a>

                                        <div class="flex items-center gap-2 flex-wrap">

                                            <span class="px-3 py-1 rounded-full
                                                         bg-purple-100 text-purple-700
                                                         text-xs font-bold uppercase">

                                                {{ $ext }}

                                            </span>

                                            <a href="{{ $url }}"
                                               target="_blank"
                                               class="text-blue-600 text-sm font-semibold hover:underline">

                                                👁 Lihat Gambar

                                            </a>

                                        </div>

                                    </div>

                                {{-- DOCUMENT --}}
                                @elseif(in_array($ext, $docExt))

                                    <div class="bg-slate-50 border border-slate-200
                                                rounded-3xl p-5 w-[240px]">

                                        <div class="flex items-center gap-4 mb-4">

                                            <div class="w-16 h-16 rounded-2xl
                                                        bg-blue-100 text-3xl
                                                        flex items-center justify-center">

                                                📄

                                            </div>

                                            <div>

                                                <div class="font-black text-slate-800 uppercase">
                                                    {{ $ext }}
                                                </div>

                                                <div class="text-sm text-slate-500">
                                                    Dokumen File
                                                </div>

                                            </div>

                                        </div>

                                        <a href="{{ $url }}"
                                           target="_blank"
                                           class="bg-blue-600 hover:bg-blue-700
                                                  text-white text-sm font-semibold
                                                  px-4 py-3 rounded-2xl
                                                  flex items-center justify-center gap-2
                                                  shadow">

                                            👁 Buka Dokumen

                                        </a>

                                    </div>

                                {{-- FILE LAIN --}}
                                @else

                                    <div class="space-y-3">

                                        <span class="px-4 py-2 rounded-full
                                                     bg-slate-100 text-slate-700
                                                     text-xs font-bold uppercase inline-block">

                                            {{ $ext }}

                                        </span>

                                        <div>

                                            <a href="{{ $url }}"
                                               target="_blank"
                                               class="bg-slate-700 hover:bg-slate-800
                                                      text-white px-5 py-3 rounded-2xl
                                                      inline-flex items-center gap-2 shadow">

                                                📁 Buka File

                                            </a>

                                        </div>

                                    </div>

                                @endif

                            @else

                                <span class="text-slate-400 italic">
                                    Tidak ada file
                                </span>

                            @endif

                        </td>

                        {{-- KETERANGAN --}}
                        <td class="px-5 py-5 align-top">

                            <div class="bg-slate-50 border border-slate-200
                                        rounded-3xl p-5 min-h-[180px]">

                                <div class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">

                                    {{ $d->keterangan ?? '-' }}

                                </div>

                            </div>

                        </td>

                        {{-- QR CODE --}}
                       <td class="px-4 py-4 text-sm text-gray-700">

@php

    $link = route(
        'inovasisekre.show',
        Crypt::encryptString($d->id)
    );

@endphp

<div class="flex items-center gap-4">

    {{-- QR CODE --}}
    <div class="bg-white border rounded-2xl p-3 shadow-sm">

        <div id="qr-wrapper-{{ $d->id }}">

            {!! QrCode::format('svg')
                ->size(180)
                ->margin(1)
                ->generate($link) !!}

        </div>

    </div>

    {{-- ACTION --}}
    <div class="space-y-2 w-[170px]">

        {{-- OPEN --}}
        <a href="{{ $link }}"
           target="_blank"
           class="bg-green-600 hover:bg-green-700
                  text-white px-4 py-2 rounded-xl
                  block text-center text-sm font-semibold shadow transition">

            🔗 Open File

        </a>

        {{-- DOWNLOAD PNG --}}
        <button
            onclick="downloadQR{{ $d->id }}()"
            class="bg-blue-600 hover:bg-blue-700
                   text-white px-4 py-2 rounded-xl
                   w-full text-sm font-semibold shadow transition">

            ⬇ Download PNG HD

        </button>

        {{-- PRINT --}}
        <button
            onclick="printQR{{ $d->id }}()"
            class="bg-slate-700 hover:bg-slate-800
                   text-white px-4 py-2 rounded-xl
                   w-full text-sm font-semibold shadow transition">

            🖨 Print QR

        </button>

    </div>

</div>

{{-- SCRIPT --}}
<script>

/*
|--------------------------------------------------------------------------
| DOWNLOAD PNG SUPER HD
|--------------------------------------------------------------------------
*/

function downloadQR{{ $d->id }}() {

    const svg = document.querySelector(
        '#qr-wrapper-{{ $d->id }} svg'
    );

    const svgData =
        new XMLSerializer().serializeToString(svg);

    const canvas =
        document.createElement('canvas');

    /*
    |--------------------------------------------------------------------------
    | SUPER FULL HD
    |--------------------------------------------------------------------------
    */

    canvas.width  = 4000;
    canvas.height = 4000;

    const ctx =
        canvas.getContext('2d');

    /*
    |--------------------------------------------------------------------------
    | BACKGROUND PUTIH
    |--------------------------------------------------------------------------
    */

    ctx.fillStyle = "#ffffff";
    ctx.fillRect(
        0,
        0,
        canvas.width,
        canvas.height
    );

    const img = new Image();

    img.onload = function () {

        /*
        |--------------------------------------------------------------------------
        | QR BESAR DAN TAJAM
        |--------------------------------------------------------------------------
        */

        ctx.drawImage(
            img,
            200,
            200,
            3600,
            3600
        );

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PNG
        |--------------------------------------------------------------------------
        */

        const a =
            document.createElement('a');

        a.download =
            'qrcode-inovasi-{{ $d->id }}.png';

        a.href =
            canvas.toDataURL(
                'image/png',
                1.0
            );

        a.click();

    };

    img.src =
        'data:image/svg+xml;base64,' +
        btoa(
            unescape(
                encodeURIComponent(svgData)
            )
        );

}

/*
|--------------------------------------------------------------------------
| PRINT QR
|--------------------------------------------------------------------------
*/

function printQR{{ $d->id }}() {

    const svg =
        document.querySelector(
            '#qr-wrapper-{{ $d->id }} svg'
        ).outerHTML;

    const printWindow =
        window.open(
            '',
            '',
            'width=1000,height=1000'
        );

    printWindow.document.write(`

        <html>

        <head>

            <title>
                Print QR Code
            </title>

            <style>

                *{
                    box-sizing:border-box;
                }

                body{

                    margin:0;
                    padding:40px;

                    font-family:Arial,sans-serif;

                    display:flex;
                    justify-content:center;
                    align-items:center;

                    background:#ffffff;
                }

                .wrapper{

                    width:100%;
                    max-width:800px;

                    text-align:center;
                }

                h1{

                    font-size:28px;
                    margin-bottom:10px;

                    color:#111827;
                }

                p{

                    font-size:16px;
                    color:#6b7280;

                    margin-bottom:30px;
                }

                .qr-box{

                    border:2px solid #e5e7eb;

                    border-radius:20px;

                    padding:30px;

                    display:inline-block;

                    background:#fff;
                }

                .qr-box svg{

                    width:600px;
                    height:600px;
                }

                .footer{

                    margin-top:25px;

                    font-size:13px;
                    color:#9ca3af;

                    word-break:break-all;
                }

                @media print {

                    body{
                        padding:0;
                    }

                    .wrapper{
                        max-width:none;
                    }

                }

            </style>

        </head>

        <body>

            <div class="wrapper">

                <h1>
                    QR CODE INOVASI SEKRE
                </h1>

                <p>
                    Scan QR Code untuk membuka dokumen
                </p>

                <div class="qr-box">

                    ${svg}

                </div>

                <div class="footer">

                    {{ $link }}

                </div>

            </div>

        </body>

        </html>

    `);

    printWindow.document.close();

    printWindow.focus();

    setTimeout(() => {

        printWindow.print();

    }, 700);

}

</script>

</td>

                        {{-- AKSI --}}
                        <td class="px-5 py-5 align-top">

                            <div class="flex flex-col gap-3">

                                {{-- EDIT --}}
                                <a href="{{ route('inovasisekre.edit',$d->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500
                                          text-white text-center px-4 py-3
                                          rounded-2xl text-sm font-semibold shadow">

                                    ✏️ Edit

                                </a>

                                {{-- DELETE --}}
                                <form id="delete{{ $d->id }}"
                                      action="{{ route('inovasisekre.delete',$d->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            onclick="hapus({{ $d->id }})"
                                            class="w-full bg-red-500 hover:bg-red-600
                                                   text-white px-4 py-3
                                                   rounded-2xl text-sm font-semibold shadow">

                                        🗑 Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="5"
                            class="text-center py-16 text-slate-500">

                            <div class="flex flex-col items-center gap-3">

                                <div class="text-6xl">
                                    📂
                                </div>

                                <div class="text-lg font-semibold">
                                    Belum ada data inovasi
                                </div>

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

{{-- SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

function hapus(id){

    Swal.fire({

        title: 'Yakin hapus data?',
        text: 'File dan QR Code akan ikut terhapus!',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',

        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if(result.isConfirmed){

            document.getElementById('delete'+id).submit();

        }

    });

}

</script>

@endsection