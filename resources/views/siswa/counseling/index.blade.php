@extends('layouts.student')

@section('title', 'Layanan & Pengajuan Konseling Siswa - SIM-BK')

@section('content')
<div x-data="{
        openCreateModal: false,
        activeFilter: '{{ request('status', 'all') }}',
        selectedCancelId: null,
        openCancelModal: false,

        formCategory: 'Pribadi',
        formTopic: '',
        formDate: '{{ date('Y-m-d', strtotime('+1 day')) }}',
        formTime: 'Istirahat 1 (09:45 - 10:15 WIB)',

        conflictWarning: '',
        isCheckingConflict: false,

        async checkStudentConflict() {
            if (!this.formDate || !this.formTime) {
                this.conflictWarning = '';
                return;
            }
            this.isCheckingConflict = true;
            try {
                const params = new URLSearchParams({
                    date: this.formDate,
                    start_time: this.formTime,
                });
                const res = await fetch(`/api/schedule/check-conflict?${params.toString()}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.has_conflict) {
                    this.conflictWarning = data.message;
                } else {
                    this.conflictWarning = '';
                }
            } catch (err) {
                console.error(err);
            } finally {
                this.isCheckingConflict = false;
            }
        },

        openCreate() {
            this.conflictWarning = '';
            this.openCreateModal = true;
            this.$nextTick(() => { this.checkStudentConflict(); });
        },

        confirmCancel(id) {
            this.selectedCancelId = id;
            this.openCancelModal = true;
        }
    }" class="space-y-6 pb-12">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Layanan & Jadwal Konseling</h2>
            <p class="text-xs md:text-sm text-[#64748B] mt-1 font-medium">Ajukan permohonan bimbingan dan pantau jadwal pertemuan konseling bersama Guru BK.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="openCreate()" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Ajukan Konseling Baru</span>
            </button>
        </div>
    </div>

    <!-- Alert Notifikasi -->
    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 font-bold">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <div class="flex flex-col gap-1">
                <span class="font-bold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    Terjadi kesalahan input:
                </span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 font-bold text-lg">&times;</button>
        </div>
    @endif

    <!-- Quick Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        <a href="{{ route('siswa.counseling.index') }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-[#9FA1FF] transition-all">
            <span class="text-[11px] font-bold text-[#64748B] block">Total Sesi</span>
            <span class="text-xl font-extrabold text-[#1E1B4B] mt-1 block">{{ $counts['total'] }}</span>
        </a>

        <a href="{{ route('siswa.counseling.index', ['status' => 'menunggu']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-amber-400 transition-all">
            <span class="text-[11px] font-bold text-amber-700 block">Menunggu Guru BK</span>
            <span class="text-xl font-extrabold text-amber-600 mt-1 block">{{ $counts['menunggu'] }}</span>
        </a>

        <a href="{{ route('siswa.counseling.index', ['status' => 'disetujui']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-emerald-400 transition-all">
            <span class="text-[11px] font-bold text-emerald-700 block">Disetujui / Terjadwal</span>
            <span class="text-xl font-extrabold text-emerald-600 mt-1 block">{{ $counts['disetujui'] }}</span>
        </a>

        <a href="{{ route('siswa.counseling.index', ['status' => 'dijadwalkan ulang']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-indigo-400 transition-all">
            <span class="text-[11px] font-bold text-indigo-700 block">Jadwal Ulang</span>
            <span class="text-xl font-extrabold text-indigo-600 mt-1 block">{{ $counts['dijadwalkan_ulang'] }}</span>
        </a>

        <a href="{{ route('siswa.counseling.index', ['status' => 'selesai']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-slate-400 transition-all">
            <span class="text-[11px] font-bold text-[#64748B] block">Selesai</span>
            <span class="text-xl font-extrabold text-[#1E1B4B] mt-1 block">{{ $counts['selesai'] }}</span>
        </a>
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-2 border-b border-[#E2E8F0] pb-3 overflow-x-auto flex-nowrap">
        <a href="{{ route('siswa.counseling.index') }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ !request('status') ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Semua ({{ $counts['total'] }})
        </a>
        <a href="{{ route('siswa.counseling.index', ['status' => 'menunggu']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') === 'menunggu' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Menunggu ({{ $counts['menunggu'] }})
        </a>
        <a href="{{ route('siswa.counseling.index', ['status' => 'disetujui']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') === 'disetujui' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Disetujui ({{ $counts['disetujui'] }})
        </a>
        <a href="{{ route('siswa.counseling.index', ['status' => 'dijadwalkan ulang']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') === 'dijadwalkan ulang' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Dijadwalkan Ulang ({{ $counts['dijadwalkan_ulang'] }})
        </a>
        <a href="{{ route('siswa.counseling.index', ['status' => 'selesai']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') === 'selesai' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Selesai ({{ $counts['selesai'] }})
        </a>
        <a href="{{ route('siswa.counseling.index', ['status' => 'ditolak']) }}"
           class="px-4 py-2 rounded-xl text-xs font-bold transition-all {{ request('status') === 'ditolak' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-2xs' : 'bg-white text-[#64748B] hover:bg-[#F8FAFF]' }}">
            Ditolak ({{ $counts['ditolak'] }})
        </a>
    </div>

    <!-- Sesi Konseling List -->
    <div class="space-y-4">
        @forelse($counselings as $c)
            <div class="bg-white border border-[#E2E8F0] rounded-3xl p-5 md:p-6 shadow-xs hover:border-[#9FA1FF] transition-all space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#E2E8F0]">
                    <div class="flex flex-wrap items-center gap-2">
                        <!-- Asal Layanan -->
                        @if(($c->initiated_by ?? 'siswa') === 'guru')
                            <span class="px-2.5 py-1 bg-[#EEF2FF] text-[#4338CA] border border-[#C7D2FE] text-[10px] font-extrabold rounded-lg flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <span>Inisiasi Guru BK</span>
                            </span>
                        @else
                            <span class="px-2.5 py-1 bg-[#F8FAFF] text-[#64748B] border border-[#E2E8F0] text-[10px] font-extrabold rounded-lg flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#64748B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                <span>Pengajuan Mandiri</span>
                            </span>
                        @endif

                        <!-- Kategori -->
                        <span class="px-2.5 py-1 bg-[#9FA1FF]/20 text-[#1E1B4B] border border-[#8E90FF]/30 text-[10px] font-extrabold rounded-lg">
                            Bidang {{ $c->category }}
                        </span>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if($c->status === 'menunggu')
                            <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Konfirmasi Guru BK
                            </span>
                        @elseif($c->status === 'disetujui')
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Disetujui / Terjadwal
                            </span>
                        @elseif($c->status === 'dijadwalkan ulang')
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-800 border border-indigo-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                Dijadwalkan Ulang oleh Guru BK
                            </span>
                        @elseif($c->status === 'selesai')
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 border border-slate-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                Selesai Dilaksanakan
                            </span>
                        @elseif($c->status === 'ditolak')
                            <span class="px-3 py-1 bg-rose-50 text-rose-800 border border-rose-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Pengajuan Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detail Pertemuan (Waktu & Ruang) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-[#F8FAFF] p-3.5 rounded-2xl border border-[#E2E8F0] text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Tanggal Sesi</span>
                        <span class="font-extrabold text-[#1E1B4B]">
                            {{ $c->preferred_date ? $c->preferred_date->format('d M Y') : '-' }}
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Waktu / Jam</span>
                        <span class="font-extrabold text-[#1E1B4B]">{{ $c->preferred_time ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Tempat / Ruang</span>
                        <span class="font-extrabold text-[#1E1B4B]">{{ $c->room_or_media ?? 'Ruang BK' }}</span>
                    </div>
                </div>

                <!-- Topik Permasalahan -->
                <div>
                    <span class="text-xs font-bold text-[#64748B] block mb-1">Topik / Permasalahan yang Dikonsultasikan:</span>
                    <p class="text-xs md:text-sm text-[#1E293B] font-medium leading-relaxed bg-white p-3.5 rounded-2xl border border-[#E2E8F0] whitespace-pre-line">
                        {{ $c->topic }}
                    </p>
                </div>

                <!-- Keterangan Khusus dari Guru BK (Reschedule / Penolakan) -->
                @if($c->status === 'dijadwalkan ulang' && $c->rescheduled_reason)
                    <div class="p-3.5 bg-indigo-50 border border-indigo-200 rounded-2xl text-xs text-indigo-900 space-y-1">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Catatan Perubahan Jadwal dari Guru BK:
                        </span>
                        <p class="text-indigo-800 font-medium">{{ $c->rescheduled_reason }}</p>
                    </div>
                @endif

                @if($c->status === 'ditolak' && $c->rejection_reason)
                    <div class="p-3.5 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-1">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Alasan Penolakan dari Guru BK:
                        </span>
                        <p class="text-rose-800 font-medium">{{ $c->rejection_reason }}</p>
                    </div>
                @endif

                <!-- Aksi Batalkan Pengajuan -->
                @if($c->status === 'menunggu')
                    <div class="flex justify-end pt-2">
                        <button type="button" @click="confirmCancel({{ $c->id }})" class="px-3.5 py-1.5 text-xs font-bold text-rose-600 hover:bg-rose-50 border border-rose-200 rounded-xl transition-all cursor-pointer">
                            Batalkan Pengajuan
                        </button>
                    </div>
                @endif

            </div>
        @empty
            <div class="py-12 px-6 text-center bg-white border border-dashed border-[#CBD5E1] rounded-3xl space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4338CA] mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h4 class="text-base font-extrabold text-[#1E1B4B]">Belum ada jadwal atau pengajuan konseling</h4>
                <p class="text-xs text-[#64748B] max-w-md mx-auto">
                    Jika Anda memiliki hal yang ingin didiskusikan terkait bimbingan pribadi, belajar, jurusan karir, atau sosial, silakan klik tombol di bawah untuk membuat pengajuan ke Guru BK.
                </p>
                <div>
                    <button type="button" @click="openCreateModal = true" class="px-4 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                        Ajukan Konseling Sekarang
                    </button>
                </div>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $counselings->links() }}
        </div>
    </div>

    <!-- MODAL PENGAJUAN KONSELING BARU -->
    <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openCreateModal = false" class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-5 shadow-2xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <div>
                    <h3 class="text-lg font-extrabold text-[#1E1B4B]">Pengajuan Jadwal Konseling</h3>
                    <p class="text-xs text-[#64748B]">Isi formulir bimbingan di bawah untuk diajukan ke Guru BK.</p>
                </div>
                <button type="button" @click="openCreateModal = false" class="text-[#64748B] hover:text-[#1E1B4B] text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('siswa.counseling.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Kategori Permasalahan -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Bidang Bimbingan <span class="text-rose-500">*</span></label>
                    <select name="category" x-model="formCategory" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                        <option value="Pribadi">Bimbingan Pribadi (Kepercayaan diri, emosi, penyesuaian diri)</option>
                        <option value="Belajar">Bimbingan Belajar (Motivasi, kesulitan pelajaran, manajemen waktu)</option>
                        <option value="Karir">Bimbingan Karir (Pilihan jurusan kuliah, prospek kerja, cita-cita)</option>
                        <option value="Sosial">Bimbingan Sosial (Hubungan dengan teman sebaya, keluarga, komunikasi)</option>
                    </select>
                </div>

                <!-- Tanggal & Waktu -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Tanggal yang Diinginkan <span class="text-rose-500">*</span></label>
                        <input type="date" name="preferred_date" x-model="formDate" @change="checkStudentConflict()" min="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                    </div>

                    <div>
                        <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Waktu / Jam yang Diinginkan <span class="text-rose-500">*</span></label>
                        <select name="preferred_time" x-model="formTime" @change="checkStudentConflict()" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                            <option value="Istirahat 1 (09:45 - 10:15 WIB)">Istirahat 1 (09:45 - 10:15 WIB)</option>
                            <option value="Istirahat 2 (12:00 - 12:45 WIB)">Istirahat 2 (12:00 - 12:45 WIB)</option>
                            <option value="Jam Pelajaran BK (Sesuai Jadwal Kelas)">Jam Pelajaran BK (Sesuai Jadwal Kelas)</option>
                            <option value="Setelah Jam Pulang Sekolah (15:00 - 16:00 WIB)">Setelah Pulang Sekolah (15:00 - 16:00 WIB)</option>
                        </select>
                    </div>
                </div>

                <!-- Topik / Permasalahan -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Topik / Gambaran Masalah yang Ingin Dikonsultasikan <span class="text-rose-500">*</span></label>
                    <textarea name="topic" x-model="formTopic" rows="4" placeholder="Ceritakan secara singkat hal yang ingin Anda konsultasikan dengan Guru BK..." class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-medium text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required></textarea>
                    <span class="text-[10px] text-[#64748B] mt-1 block">Catatan ini terjaga kerahasiaannya dan hanya dapat dilihat oleh Guru BK sekolah.</span>
                </div>

                <!-- Banner Peringatan Bentrok Real-Time -->
                <div x-show="conflictWarning" x-cloak class="p-4 bg-amber-50 border border-amber-300 rounded-2xl text-xs text-amber-900 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="space-y-1">
                        <span class="font-bold text-amber-950 block text-xs">Peringatan Jadwal Bentrok!</span>
                        <p class="font-medium text-amber-900" x-text="conflictWarning"></p>
                        <span class="text-[11px] text-amber-800 block">Guru BK sudah memiliki agenda/konseling lain di jam tersebut. Anda disarankan memilih waktu atau hari lain agar jadwal bimbingan dapat segera disetujui.</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openCreateModal = false" class="px-4 py-2.5 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL KONFIRMASI BATALKAN PENGAJUAN -->
    <div x-show="openCancelModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openCancelModal = false" class="bg-white rounded-3xl max-w-sm w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-xl border border-[#E2E8F0] text-center">
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-2xl flex items-center justify-center mx-auto text-xl font-bold">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h4 class="text-base font-extrabold text-[#1E1B4B]">Batalkan Pengajuan?</h4>
                <p class="text-xs text-[#64748B] mt-1">Pengajuan konseling ini akan dihapus dari antrean konfirmasi Guru BK.</p>
            </div>
            
            <div class="flex items-center justify-center gap-2 pt-2">
                <button type="button" @click="openCancelModal = false" class="px-4 py-2 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl transition-all">
                    Kembali
                </button>
                <form :action="'/siswa/counseling/' + selectedCancelId" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all">
                        Ya, Batalkan
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
