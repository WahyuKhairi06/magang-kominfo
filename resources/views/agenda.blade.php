@include('navbar')

@php
use Carbon\Carbon;

$agendaMap = [];
foreach ($agendas as $a) {
    $agendaMap[$a->tanggal][] = $a;
}
$month = Carbon::now()->month;
$year = Carbon::now()->year;
$totalDays = Carbon::create($year, $month)->daysInMonth;
@endphp

<header class="pt-28 md:pt-32 pb-14 md:pb-16 bg-secondary">
    <div class="max-w-7xl mx-auto px-6 text-center">
        <span class="text-white/60 font-bold tracking-[0.14em] text-xs uppercase">Kalender</span>
        <h1 class="font-serif text-3xl md:text-5xl text-white mt-3">Agenda Kegiatan</h1>
        <p class="text-white/70 mt-4 max-w-xl mx-auto">Jadwal kegiatan dan program Puskesmas Marunggi bulan ini.</p>
    </div>
</header>

<main class="max-w-7xl mx-auto px-6 -mt-8 relative z-10 pb-24">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">

        <!-- CALENDAR -->
        <div class="lg:col-span-7 bg-white p-5 md:p-8 rounded-2xl shadow-lg border border-border">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg md:text-xl font-bold text-secondary">
                    {{ Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}
                </h2>
            </div>

            <div class="grid grid-cols-7 gap-1.5 md:gap-2 text-center text-[10px] md:text-xs font-bold text-muted mb-2">
                <div>Min</div><div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div>Sab</div>
            </div>

            <div class="grid grid-cols-7 gap-1.5 md:gap-2">
                @for($i = 1; $i <= $totalDays; $i++)
                    @php
                        $date = sprintf('%04d-%02d-%02d', $year, $month, $i);
                        $hasAgenda = isset($agendaMap[$date]);
                    @endphp
                    <div onclick="openAgenda('{{ $date }}')"
                         class="h-12 sm:h-16 md:h-20 border rounded-md md:rounded-lg p-1.5 md:p-2 cursor-pointer transition text-left
                         {{ $hasAgenda ? 'bg-primary/5 border-primary' : 'bg-white border-border hover:bg-surface' }}">
                        <div class="font-bold text-xs md:text-sm text-secondary">{{ $i }}</div>
                        @if($hasAgenda)
                            <div class="hidden sm:block text-[9px] md:text-[10px] text-primary font-semibold mt-0.5">{{ count($agendaMap[$date]) }} agenda</div>
                            <div class="sm:hidden w-1.5 h-1.5 rounded-full bg-primary mt-1"></div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        <!-- LIST -->
        <div class="lg:col-span-5 bg-white p-5 md:p-8 rounded-2xl shadow-lg border border-border">
            <h2 class="text-lg md:text-xl font-bold text-secondary mb-4">Semua Agenda</h2>
            <div class="space-y-3 max-h-[420px] md:max-h-[600px] overflow-y-auto pr-1">
                @forelse($agendas as $a)
                <div class="border border-border rounded-lg p-4 hover:border-primary cursor-pointer transition"
                     onclick="openAgenda('{{ $a->tanggal }}')">
                    <div class="flex justify-between gap-3">
                        <div class="font-bold text-sm text-secondary">{{ $a->judul_agenda }}</div>
                        <div class="text-xs text-muted whitespace-nowrap">{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}</div>
                    </div>
                    <div class="text-sm text-muted mt-1">{{ $a->lokasi }}</div>
                    <div class="text-xs text-primary font-semibold mt-1">{{ $a->jam_mulai }} - {{ $a->jam_selesai }}</div>
                </div>
                @empty
                <p class="text-sm text-muted">Belum ada agenda terjadwal.</p>
                @endforelse
            </div>
        </div>
    </div>
</main>

<!-- MODAL -->
<div id="agendaModal" class="fixed inset-0 bg-secondary/60 hidden items-center justify-center z-50 px-6">
    <div class="bg-white w-full max-w-lg rounded-2xl p-6 relative">
        <button onclick="closeModal()" class="absolute right-4 top-4 text-muted hover:text-secondary text-xl">&times;</button>
        <h2 class="text-lg font-bold text-secondary mb-4">Detail Agenda</h2>
        <div id="agendaContent" class="space-y-3"></div>
    </div>
</div>

<script>
const agendaData = @json($agendaMap);

function openAgenda(date){
    const modal = document.getElementById('agendaModal');
    const content = document.getElementById('agendaContent');
    modal.classList.remove('hidden');
    modal.classList.add('flex');

    const data = agendaData[date];
    if(!data){
        content.innerHTML = `<p class="text-muted text-sm">Tidak ada agenda pada tanggal ini.</p>`;
        return;
    }
    let html = '';
    data.forEach(a => {
        html += `
        <div class="p-4 border border-border rounded-lg">
            <div class="font-bold text-secondary">${a.judul_agenda}</div>
            <div class="text-sm text-muted">${a.lokasi}</div>
            <div class="text-xs mt-1 text-muted">${a.deskripsi ?? ''}</div>
            <div class="text-xs text-primary font-semibold mt-2">${a.jam_mulai} - ${a.jam_selesai}</div>
        </div>`;
    });
    content.innerHTML = html;
}
function closeModal(){
    document.getElementById('agendaModal').classList.add('hidden');
    document.getElementById('agendaModal').classList.remove('flex');
}
window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
</script>

@include('footer')
