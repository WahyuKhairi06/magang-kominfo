{{--
    Partial: Badge Kategori & Urgensi untuk baris list pengaduan
    Include di tabel list admin, contoh:
        @include('admin.pengaduan._badge_klasifikasi', ['pengaduan' => $pengaduan])
--}}

@php
    $urgensiColor = match ($pengaduan->urgensi_final) {
        'tinggi' => 'bg-red-100 text-red-700',
        'sedang' => 'bg-yellow-100 text-yellow-700',
        'rendah' => 'bg-green-100 text-green-700',
        default => 'bg-gray-100 text-gray-500',
    };

    $statusIcon = match (true) {
        $pengaduan->status_klasifikasi === 'pending' => '⏳',
        $pengaduan->status_klasifikasi === 'gagal' => '⚠️',
        $pengaduan->is_overridden => '✏️',
        default => '✓',
    };
@endphp

<div class="flex items-center gap-2 text-sm">
    @if ($pengaduan->kategori_final)
        <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-700">{{ $pengaduan->kategori_final }}</span>
        <span class="px-2 py-0.5 rounded {{ $urgensiColor }} capitalize">{{ $pengaduan->urgensi_final }}</span>
    @else
        <span class="text-gray-400 italic">Belum diklasifikasi</span>
    @endif
    <span title="{{ $pengaduan->status_klasifikasi }}">{{ $statusIcon }}</span>
</div>
