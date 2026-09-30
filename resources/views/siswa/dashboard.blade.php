@extends('layouts.student')

@section('title', 'Dashboard Siswa - SIM-BK')

@section('content')

<!-- GREETING SECTION -->
<div class="mb-8">
    <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">
        Selamat datang, {{ $student->nama ?? Auth::user()->username ?? 'Siswa' }} 👋
    </h2>
    <div class="flex items-center gap-2 text-[#64748B] mt-1 text-sm font-semibold">
        <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path></svg>
        <span>Kelas {{ $student->kelas ?? 'Kelas Belum Diatur' }} • NIS: {{ $student->nis ?? '-' }}</span>
    </div>
</div>

<!-- GRID SYSTEM UTAMA -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 bg-white">

    <!-- 1. HERO BANNER KONSELING (KIRI) -->
    <div class="lg:col-span-8 bg-gradient-to-r from-[#9FA1FF]/20 via-[#B5BAFF]/30 to-[#AEE2FF]/30 rounded-3xl p-5 sm:p-8 relative overflow-hidden shadow-xs flex flex-col justify-center border border-[#E2E8F0]">
        <div class="absolute -right-8 -top-8 w-48 h-48 bg-white/40 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute right-12 -bottom-10 w-36 h-36 bg-[#9FA1FF]/20 rounded-full blur-xl pointer-events-none"></div>

        <div class="inline-flex items-center gap-1.5 bg-white/90 backdrop-blur-sm text-[#1E1B4B] px-3.5 py-1 rounded-full text-xs font-bold w-fit mb-4 border border-[#E2E8F0] shadow-2xs">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
            Layanan Bimbingan Konseling Aktif
        </div>
        
        <h3 class="text-xl sm:text-2xl md:text-3xl font-extrabold text-[#1E1B4B] mb-2 relative z-10 leading-tight">Butuh Teman Cerita atau Bimbingan Karir?</h3>
        <p class="text-[#475569] text-xs sm:text-sm w-full md:w-5/6 leading-relaxed mb-6 relative z-10 font-medium">
            Bapak/Ibu Guru BK siap mendengarkan dan membantu perencanaan masa depan, gaya belajar, maupun konsultasi pribadi dengan kerahasiaan terjaga.
        </p>
        
        <div class="flex flex-wrap items-center gap-3 relative z-10">
            <a href="{{ route('siswa.counseling.index') }}" class="bg-[#1E1B4B] text-white hover:bg-[#312E81] active:scale-95 font-bold text-xs md:text-sm px-6 py-3 rounded-2xl flex items-center justify-center gap-2 transition-all shadow-xs cursor-pointer">
                <span>Ajukan Konseling</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
            <a href="{{ route('siswa.questionnaires.index') }}" class="bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs md:text-sm px-5 py-3 rounded-2xl transition-all shadow-2xs text-center cursor-pointer">
                Isi Kuisioner Siswa
            </a>
        </div>
    </div>

    <!-- 2. STATISTIK ANGKET & KONSELING (KANAN) -->
    <div class="lg:col-span-4 bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col justify-between">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-xl bg-[#9FA1FF]/20 flex items-center justify-center text-[#1E1B4B]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-base font-bold text-[#1E1B4B]">Status Partisipasi Siswa</h3>
        </div>
        
        <div class="space-y-3">
            <!-- Box Kuisioner Selesai -->
            <div class="bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-[#E2E8F0] flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1E1B4B] block">Kuisioner Diisi</span>
                        <span class="text-[11px] text-[#64748B]">Total respon Anda</span>
                    </div>
                </div>
                <span class="text-2xl font-extrabold text-[#1E1B4B]">{{ $totalAnswered }}</span>
            </div>
            
            <!-- Box Sesi Konseling Aktif -->
            <div class="bg-[#B5BAFF]/20 border border-[#B5BAFF] rounded-2xl p-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-white border border-[#B5BAFF] flex items-center justify-center shadow-2xs">
                        <svg class="w-5 h-5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-[#1E1B4B] block">Konseling Aktif</span>
                        <span class="text-[11px] text-[#64748B]">Menunggu / Terjadwal</span>
                    </div>
                </div>
                <span class="text-2xl font-extrabold text-[#1E1B4B]">{{ $pendingCounselingCount }}</span>
            </div>
        </div>

        <a href="{{ route('siswa.counseling.index') }}" class="mt-4 w-full py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] text-xs font-bold rounded-xl text-center block transition-all shadow-xs cursor-pointer">
            Kelola Konseling Saya
        </a>
    </div>

    <!-- 3. KUESIONER TERSEDIA UNTUK DIISI (KIRI) -->
    <div class="lg:col-span-6 bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-[#9FA1FF]/20 flex items-center justify-center text-[#1E1B4B]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-[#1E1B4B]">Angket & Asesmen Perlu Diisi</h3>
                </div>
                <a href="{{ route('siswa.questionnaires.index') }}" class="text-xs font-bold text-[#9FA1FF] hover:underline active:scale-95 transition-all cursor-pointer">Buka Semua</a>
            </div>

            @if($pendingQuestionnaires->count() > 0)
                <div class="space-y-3">
                    @foreach($pendingQuestionnaires as $q)
                        <div class="p-3.5 bg-[#F8FAFF] hover:bg-white border border-[#E2E8F0] rounded-2xl flex items-center justify-between gap-3 transition-colors">
                            <div class="min-w-0 flex-1">
                                <h4 class="font-bold text-xs text-[#1E1B4B] truncate">{{ $q->title ?? $q->judul }}</h4>
                                <p class="text-[11px] text-[#64748B] truncate">{{ $q->target_kelas }} • {{ $q->questions_count }} butir pertanyaan</p>
                            </div>
                            <a href="{{ route('siswa.questionnaires.show', $q->id) }}" class="px-3.5 py-1.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] text-[11px] font-bold rounded-xl shrink-0 transition-all shadow-2xs cursor-pointer">
                                Isi Sekarang
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-8 text-center">
                    <div class="w-12 h-12 bg-[#D9F9DF] text-[#14532D] rounded-full flex items-center justify-center mb-3 border border-[#BBF7D0]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <p class="text-xs font-bold text-[#1E1B4B]">Semua Angket Sudah Selesai!</p>
                    <p class="text-[11px] text-[#64748B] mt-0.5">Tidak ada angket aktif yang tertunda untuk Anda saat ini.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- 4. RIWAYAT & JADWAL KONSELING (KANAN) -->
    <div class="lg:col-span-6 bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col justify-between">
        <div>
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 rounded-lg bg-[#B5BAFF]/35 flex items-center justify-center text-[#1E1B4B]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-base font-bold text-[#1E1B4B]">Riwayat & Agenda Bimbingan</h3>
                </div>
                <a href="{{ route('siswa.counseling.index') }}" class="text-xs font-bold text-[#9FA1FF] hover:underline active:scale-95 transition-all cursor-pointer">Lihat Semua</a>
            </div>

            <div class="space-y-3">
                @forelse($counselingSessions as $session)
                    <div class="p-3.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl flex items-center justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-[10px] font-bold px-2 py-0.5 rounded-md uppercase border
                                    @if($session->status === 'disetujui') bg-[#D9F9DF] text-[#14532D] border-[#BBF7D0]
                                    @elseif($session->status === 'menunggu') bg-amber-50 text-amber-700 border-amber-200
                                    @elseif($session->status === 'selesai') bg-blue-50 text-blue-700 border-blue-200
                                    @elseif($session->status === 'dijadwalkan ulang') bg-purple-50 text-purple-700 border-purple-200
                                    @else bg-rose-50 text-rose-700 border-rose-200 @endif">
                                    {{ ucfirst($session->status) }}
                                </span>
                                <span class="text-[10px] text-[#64748B] font-semibold">
                                    {{ \Carbon\Carbon::parse($session->counseling_date)->translatedFormat('d M Y') }}
                                </span>
                            </div>
                            <h4 class="font-bold text-xs text-[#1E1B4B] truncate">{{ $session->topic }}</h4>
                            <p class="text-[11px] text-[#64748B] truncate">{{ $session->counseling_type }} • Jam {{ substr($session->counseling_time, 0, 5) }} WIB</p>
                        </div>
                        <a href="{{ route('siswa.counseling.index') }}" class="px-3 py-1.5 bg-white hover:bg-[#F8FAFF] border border-[#E2E8F0] text-[11px] font-bold text-[#1E1B4B] rounded-xl shrink-0 transition-all shadow-2xs">
                            Detail
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 text-center">
                        <div class="w-12 h-12 bg-[#F8FAFF] text-[#64748B] rounded-full flex items-center justify-center mb-3 border border-[#E2E8F0]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                        </div>
                        <p class="text-xs font-bold text-[#1E1B4B]">Belum Ada Pengajuan Konseling</p>
                        <p class="text-[11px] text-[#64748B] mt-0.5">Ajukan konseling pertama Anda jika butuh bimbingan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection