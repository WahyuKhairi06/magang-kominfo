@include('navbar')

@php
use Carbon\Carbon;

// mapping agenda berdasarkan tanggal
$agendaMap = [];
foreach ($agendas as $a) {
    $agendaMap[$a->tanggal][] = $a;
}

// bulan sekarang
$month = Carbon::now()->month;
$year = Carbon::now()->year;

// jumlah hari di bulan ini
$totalDays = Carbon::create($year, $month)->daysInMonth;
@endphp

<main class="pt-20">

<!-- HERO -->
<section class="relative h-[300px] flex items-center">
    <div class="absolute inset-0 bg-gradient-to-r from-primary to-primary-container/80"></div>
    <div class="container mx-auto px-6 relative z-10">
        <h1 class="text-4xl font-bold text-white">Agenda Kegiatan</h1>
    </div>
</section>

<!-- CONTENT -->
<section class="container mx-auto px-6 py-10 grid grid-cols-1 lg:grid-cols-12 gap-8">

<!-- LEFT: CALENDAR -->
<div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow">

    <div class="flex justify-between mb-6">
        <h2 class="text-xl font-bold">
            {{ Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
        </h2>
    </div>

    <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold mb-2">
        <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
    </div>

    <div class="grid grid-cols-7 gap-2">

        @for($i = 1; $i <= $totalDays; $i++)
            @php
                $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                $hasAgenda = isset($agendaMap[$date]);
            @endphp

            <div
                onclick="openAgenda('{{ $date }}')"
                class="h-20 border rounded-lg p-2 cursor-pointer transition
                {{ $hasAgenda ? 'bg-green-100 border-green-500' : 'bg-white hover:bg-gray-50' }}"
            >
                <div class="font-bold">{{ $i }}</div>

                @if($hasAgenda)
                    <div class="text-[10px] text-green-700">
                        {{ count($agendaMap[$date]) }} agenda
                    </div>
                @endif
            </div>
        @endfor

    </div>
</div>

<!-- RIGHT: ALL AGENDA -->
<div class="lg:col-span-5 bg-white p-6 rounded-2xl shadow">

    <h2 class="text-xl font-bold mb-4">Semua Agenda</h2>

    <div class="space-y-4 max-h-[600px] overflow-y-auto">

        @foreach($agendas as $a)
        <div class="border rounded-xl p-4 hover:shadow cursor-pointer"
             onclick="openAgenda('{{ $a->tanggal }}')">

            <div class="flex justify-between">
                <div class="font-bold">{{ $a->judul_agenda }}</div>
                <div class="text-xs text-gray-500">{{ $a->tanggal }}</div>
            </div>

            <div class="text-sm text-gray-500">{{ $a->lokasi }}</div>
            <div class="text-xs text-blue-600 mt-1">
                {{ $a->jam_mulai }} - {{ $a->jam_selesai }}
            </div>

        </div>
        @endforeach

    </div>

</div>

</section>

</main>

<!-- MODAL -->
<div id="agendaModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
    <div class="bg-white w-[90%] max-w-lg rounded-xl p-6 relative">

        <button onclick="closeModal()" class="absolute right-3 top-3 text-xl">×</button>

        <h2 class="text-xl font-bold mb-4">Detail Agenda</h2>

        <div id="agendaContent" class="space-y-3"></div>

    </div>
</div>

<script>
const agendaData = @json($agendaMap);

function openAgenda(date){
    let modal = document.getElementById('agendaModal');
    let content = document.getElementById('agendaContent');

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    let data = agendaData[date];

    if(!data){
        content.innerHTML = `<p class="text-gray-500">Tidak ada agenda</p>`;
        return;
    }

    let html = '';

    data.forEach(a => {
        html += `
        <div class="p-4 border rounded-lg">
            <div class="font-bold">${a.judul_agenda}</div>
            <div class="text-sm text-gray-500">${a.lokasi}</div>
            <div class="text-xs mt-1">${a.deskripsi}</div>
            <div class="text-xs text-blue-600 mt-2">
                ${a.jam_mulai} - ${a.jam_selesai}
            </div>
        </div>`;
    });

    content.innerHTML = html;
}

function closeModal(){
    document.getElementById('agendaModal').classList.add('hidden');
}
</script>

@include('footer')