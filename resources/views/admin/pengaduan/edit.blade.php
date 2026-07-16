@extends('template.layout')

@section('content')

<div class="max-w-5xl mx-auto p-4 md:p-6 space-y-6">

    {{-- HEADER --}}
    <div class="flex items-center gap-4 border-b border-slate-100 pb-5">
        <a href="{{ route('pengaduan.index') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white border border-slate-200 hover:border-slate-300 text-slate-600 hover:text-slate-800 hover:bg-slate-50 transition shadow-sm">
            <span class="material-symbols-outlined text-xl">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-800 tracking-tight">Detail Pengaduan</h1>
            <p class="text-sm text-slate-500 font-medium">Keluhan Warga & Sistem Triage Otomatis AI</p>
        </div>
    </div>

    {{-- GRID SYSTEM --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- LEFT COLUMN: DETAIL CONTENT --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- REPORT CARD --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
                
                {{-- CARD HEADER --}}
                <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#2D6A4F] text-2xl">description</span>
                    <h3 class="font-bold text-slate-800">Isi Laporan Masuk</h3>
                </div>

                {{-- CARD BODY --}}
                <div class="p-6 space-y-6">
                    
                    {{-- SENDER PROFILE & DATE --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b border-slate-100 pb-5">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Pelapor</span>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-lg">person</span>
                                <p class="text-base font-bold text-slate-800">{{ $pengaduan->nama }}</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Masuk</span>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-slate-400 text-lg">calendar_today</span>
                                <p class="text-sm text-slate-600 font-medium">{{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d F Y - H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- WHATSAPP CONTACT --}}
                    <div class="space-y-2 border-b border-slate-100 pb-5">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor HP / Kontak</span>
                        <div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pengaduan->no_hp) }}" target="_blank" class="inline-flex items-center gap-2 bg-emerald-50 text-emerald-700 px-4 py-2.5 rounded-2xl hover:bg-emerald-100 transition border border-emerald-100/50 text-sm font-semibold">
                                <i class="bi bi-whatsapp text-base"></i>
                                <span>Hubungi via WhatsApp</span>
                                <span class="text-emerald-400 font-normal">({{ $pengaduan->no_hp }})</span>
                            </a>
                        </div>
                    </div>

                    {{-- COMPLAINT TEXT --}}
                    <div class="space-y-2">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Isi Keluhan Warga</span>
                        <div class="bg-slate-50 border border-slate-100 rounded-2xl p-5 text-slate-700 leading-relaxed text-sm whitespace-pre-wrap font-medium">{{ trim($pengaduan->isi_pengaduan) }}</div>
                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT COLUMN: AI TRIAGE --}}
        <div class="lg:col-span-1">
            
            {{-- CLASSIFICATION CARD --}}
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden sticky top-24">
                
                {{-- HEADER --}}
                <div class="px-6 py-5 border-b border-slate-50 bg-slate-50/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#2D6A4F] text-2xl">analytics</span>
                    <h3 class="font-bold text-slate-800">Triage & Klasifikasi</h3>
                </div>

                {{-- BODY --}}
                <div class="p-6">
                    @include('admin.pengaduan._klasifikasi_chip', ['pengaduan' => $pengaduan])
                </div>

            </div>

        </div>

    </div>

</div>

@endsection