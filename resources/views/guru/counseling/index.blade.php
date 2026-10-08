@extends('layouts.app')

@section('title', 'Layanan & Manajemen Jadwal Konseling - SIM-BK')

@section('content')
<div x-data="{
        openInitiateModal: {{ request()->filled('open_initiate') ? 'true' : 'false' }},
        openApproveModal: false,
        openRescheduleModal: false,
        openRejectModal: false,
        openCompleteModal: false,

        selectedCounselingId: null,
        selectedStudentName: '',
        selectedDate: '{{ date('Y-m-d') }}',
        selectedTime: 'Istirahat 1 (09:45 - 10:15 WIB)',
        selectedRoom: 'Ruang Konseling BK 1',
        rescheduleReason: '',
        rejectionReason: '',
        counselorNotes: '',
        followUpNotes: 'Pemantauan berkala perkembangan siswa.',

        // Inisiasi form
        initiateStudentId: '{{ $preselectedStudentId ?? '' }}',
        initiateCategory: 'Pribadi',
        initiateTopic: '',
        initiateDate: '{{ date('Y-m-d', strtotime('+1 day')) }}',
        initiateTime: 'Istirahat 1 (09:45 - 10:15 WIB)',
        initiateRoom: 'Ruang Konseling BK 1',

        conflictWarning: '',
        isCheckingConflict: false,

        formatDateForInput(dStr) {
            if (!dStr) return '{{ date('Y-m-d') }}';
            if (typeof dStr === 'string') {
                return dStr.split('T')[0].split(' ')[0];
            }
            return '{{ date('Y-m-d') }}';
        },

        async checkCounselingConflict(date, time, excludeCounselingId = null) {
            if (!date || !time) {
                this.conflictWarning = '';
                return;
            }
            this.isCheckingConflict = true;
            try {
                const params = new URLSearchParams({
                    date: date,
                    start_time: time,
                });
                if (excludeCounselingId) {
                    params.append('exclude_counseling_id', excludeCounselingId);
                }
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

        openApprove(c) {
            this.selectedCounselingId = c.id;
            this.selectedStudentName = c.student ? c.student.nama : 'Siswa';
            this.selectedDate = this.formatDateForInput(c.preferred_date);
            this.selectedTime = c.preferred_time || 'Istirahat 1 (09:45 - 10:15 WIB)';
            this.selectedRoom = c.room_or_media || 'Ruang Konseling BK 1';
            this.conflictWarning = '';
            this.openApproveModal = true;
            this.$nextTick(() => { this.checkCounselingConflict(this.selectedDate, this.selectedTime, this.selectedCounselingId); });
        },

        openReschedule(c) {
            this.selectedCounselingId = c.id;
            this.selectedStudentName = c.student ? c.student.nama : 'Siswa';
            this.selectedDate = this.formatDateForInput(c.preferred_date);
            this.selectedTime = c.preferred_time || 'Istirahat 1 (09:45 - 10:15 WIB)';
            this.selectedRoom = c.room_or_media || 'Ruang Konseling BK 1';
            this.rescheduleReason = c.rescheduled_reason || '';
            this.conflictWarning = '';
            this.openRescheduleModal = true;
            this.$nextTick(() => { this.checkCounselingConflict(this.selectedDate, this.selectedTime, this.selectedCounselingId); });
        },

        openReject(c) {
            this.selectedCounselingId = c.id;
            this.selectedStudentName = c.student ? c.student.nama : 'Siswa';
            this.rejectionReason = '';
            this.openRejectModal = true;
        },

        openComplete(c) {
            this.selectedCounselingId = c.id;
            this.selectedStudentName = c.student ? c.student.nama : 'Siswa';
            this.counselorNotes = c.counselor_notes || '';
            this.followUpNotes = 'Pemantauan berkala dan tindak lanjut perkembangan siswa.';
            this.openCompleteModal = true;
        }
    }" class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto space-y-6 pb-16 bg-white">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Manajemen Layanan & Jadwal Konseling</h2>
            <p class="text-xs md:text-sm text-[#64748B] mt-1 font-medium">Kelola pengajuan bimbingan dari siswa dan inisiasi sesi konseling terjadwal.</p>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" @click="openInitiateModal = true" class="w-full sm:w-auto justify-center px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Inisiasi Konseling Baru</span>
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
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        <a href="{{ route('guru.counseling.index') }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-[#9FA1FF] transition-all">
            <span class="text-[11px] font-bold text-[#64748B] block">Total Sesi</span>
            <span class="text-xl font-extrabold text-[#1E1B4B] mt-1 block">{{ $counts['total'] }}</span>
        </a>

        <a href="{{ route('guru.counseling.index', ['status' => 'menunggu']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-amber-400 transition-all">
            <span class="text-[11px] font-bold text-amber-700 block">Pengajuan Masuk</span>
            <span class="text-xl font-extrabold text-amber-600 mt-1 block">{{ $counts['menunggu'] }}</span>
        </a>

        <a href="{{ route('guru.counseling.index', ['status' => 'disetujui']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-emerald-400 transition-all">
            <span class="text-[11px] font-bold text-emerald-700 block">Jadwal Terjadwal</span>
            <span class="text-xl font-extrabold text-emerald-600 mt-1 block">{{ $counts['disetujui'] }}</span>
        </a>

        <a href="{{ route('guru.counseling.index', ['status' => 'dijadwalkan ulang']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-indigo-400 transition-all">
            <span class="text-[11px] font-bold text-indigo-700 block">Dijadwalkan Ulang</span>
            <span class="text-xl font-extrabold text-indigo-600 mt-1 block">{{ $counts['dijadwalkan_ulang'] }}</span>
        </a>

        <a href="{{ route('guru.counseling.index', ['status' => 'selesai']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-slate-400 transition-all">
            <span class="text-[11px] font-bold text-[#64748B] block">Selesai Dilayani</span>
            <span class="text-xl font-extrabold text-[#1E1B4B] mt-1 block">{{ $counts['selesai'] }}</span>
        </a>

        <a href="{{ route('guru.counseling.index', ['status' => 'ditolak']) }}" class="p-4 bg-white rounded-2xl border border-[#E2E8F0] shadow-2xs hover:border-rose-400 transition-all">
            <span class="text-[11px] font-bold text-rose-700 block">Ditolak/Batal</span>
            <span class="text-xl font-extrabold text-rose-600 mt-1 block">{{ $counts['ditolak'] }}</span>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white border border-[#E2E8F0] rounded-3xl p-4 md:p-5 shadow-xs space-y-4">
        <form action="{{ route('guru.counseling.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa, NIS, kelas, atau topik masalah..." class="w-full pl-10 pr-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]">
                <svg class="w-4 h-4 text-[#94A3B8] absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <div class="sm:col-span-3">
                <select name="initiated_by" class="w-full px-3 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]">
                    <option value="">Semua Asal Layanan</option>
                    <option value="siswa" {{ request('initiated_by') === 'siswa' ? 'selected' : '' }}>Pengajuan Siswa</option>
                    <option value="guru" {{ request('initiated_by') === 'guru' ? 'selected' : '' }}>Inisiasi Guru BK</option>
                </select>
            </div>

            <div class="sm:col-span-3">
                <select name="status" class="w-full px-3 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]">
                    <option value="">Semua Status Sesi</option>
                    <option value="menunggu" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="disetujui" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui / Terjadwal</option>
                    <option value="dijadwalkan ulang" {{ request('status') === 'dijadwalkan ulang' ? 'selected' : '' }}>Dijadwalkan Ulang</option>
                    <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="sm:col-span-1 flex items-center gap-1">
                <button type="submit" class="w-full py-2.5 bg-[#1E1B4B] hover:bg-[#2E2976] text-white font-bold text-xs rounded-xl transition-all shadow-xs cursor-pointer flex items-center justify-center">
                    Cari
                </button>
            </div>
        </form>

        <!-- Status Filter Tabs -->
        <div class="flex flex-wrap items-center gap-2 pt-2 border-t border-[#E2E8F0]">
            <a href="{{ route('guru.counseling.index') }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ !request('status') ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Semua ({{ $counts['total'] }})
            </a>
            <a href="{{ route('guru.counseling.index', ['status' => 'menunggu']) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('status') === 'menunggu' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Pengajuan Masuk ({{ $counts['menunggu'] }})
            </a>
            <a href="{{ route('guru.counseling.index', ['status' => 'disetujui']) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('status') === 'disetujui' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Terjadwal ({{ $counts['disetujui'] }})
            </a>
            <a href="{{ route('guru.counseling.index', ['status' => 'dijadwalkan ulang']) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('status') === 'dijadwalkan ulang' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Jadwal Ulang ({{ $counts['dijadwalkan_ulang'] }})
            </a>
            <a href="{{ route('guru.counseling.index', ['status' => 'selesai']) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('status') === 'selesai' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Selesai ({{ $counts['selesai'] }})
            </a>
            <a href="{{ route('guru.counseling.index', ['status' => 'ditolak']) }}"
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ request('status') === 'ditolak' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#E2E8F0]' }}">
                Ditolak ({{ $counts['ditolak'] }})
            </a>
        </div>
    </div>

    <!-- Daftar Sesi Konseling -->
    <div class="space-y-4">
        @forelse($counselings as $c)
            <div class="bg-white border border-[#E2E8F0] rounded-3xl p-5 md:p-6 shadow-xs hover:border-[#9FA1FF] transition-all space-y-4">
                
                <!-- Baris Profil Siswa, Asal Layanan, dan Status -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-[#E2E8F0]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#9FA1FF]/30 border border-[#8E90FF]/40 text-[#1E1B4B] font-extrabold flex items-center justify-center shrink-0">
                            {{ strtoupper(substr($c->student->nama ?? 'S', 0, 2)) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-extrabold text-[#1E1B4B] hover:underline">
                                    <a href="{{ route('guru.students.show', $c->student_id) }}">{{ $c->student->nama ?? 'Siswa Terhapus' }}</a>
                                </h4>
                                <span class="text-[11px] font-bold text-[#64748B]">({{ $c->student->nis ?? '-' }} • Kelas {{ $c->student->kelas ?? '-' }})</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                @if(($c->initiated_by ?? 'siswa') === 'guru')
                                    <span class="px-2 py-0.5 bg-[#EEF2FF] text-[#4338CA] border border-[#C7D2FE] text-[10px] font-extrabold rounded-md flex items-center gap-1">
                                        Inisiasi Guru BK
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 bg-[#F8FAFF] text-[#64748B] border border-[#E2E8F0] text-[10px] font-extrabold rounded-md flex items-center gap-1">
                                        Pengajuan Siswa
                                    </span>
                                @endif

                                <span class="px-2 py-0.5 bg-[#9FA1FF]/20 text-[#1E1B4B] border border-[#8E90FF]/30 text-[10px] font-extrabold rounded-md">
                                    {{ $c->category }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div>
                        @if($c->status === 'menunggu')
                            <span class="px-3 py-1 bg-amber-50 text-amber-800 border border-amber-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                Menunggu Konfirmasi
                            </span>
                        @elseif($c->status === 'disetujui')
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                Terjadwal / Disetujui
                            </span>
                        @elseif($c->status === 'dijadwalkan ulang')
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-800 border border-indigo-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                                Dijadwalkan Ulang
                            </span>
                        @elseif($c->status === 'selesai')
                            <span class="px-3 py-1 bg-slate-100 text-slate-800 border border-slate-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-slate-500"></span>
                                Selesai Dilayani
                            </span>
                        @elseif($c->status === 'ditolak')
                            <span class="px-3 py-1 bg-rose-50 text-rose-800 border border-rose-200 text-xs font-extrabold rounded-xl inline-flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                                Ditolak
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Detail Pelaksanaan (Tanggal, Waktu, Ruangan) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 bg-[#F8FAFF] p-3 rounded-2xl border border-[#E2E8F0] text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Tanggal Sesi</span>
                        <span class="font-extrabold text-[#1E1B4B] flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $c->preferred_date ? $c->preferred_date->format('d M Y') : '-' }}</span>
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Waktu / Jam</span>
                        <span class="font-extrabold text-[#1E1B4B] flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ $c->preferred_time ?? '-' }}</span>
                        </span>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-[#64748B] block uppercase tracking-wider">Ruang / Tempat</span>
                        <span class="font-extrabold text-[#1E1B4B] flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span>{{ $c->room_or_media ?? 'Ruang BK' }}</span>
                        </span>
                    </div>
                </div>

                <!-- Topik / Permasalahan -->
                <div>
                    <span class="text-xs font-bold text-[#64748B] block mb-1">Topik / Uraian Permasalahan:</span>
                    <p class="text-xs md:text-sm text-[#1E293B] font-medium leading-relaxed bg-white p-3 rounded-2xl border border-[#E2E8F0] whitespace-pre-line">
                        {{ $c->topic }}
                    </p>
                </div>

                <!-- Catatan Khusus (Reschedule / Penolakan / Penyelesaian) -->
                @if($c->status === 'dijadwalkan ulang' && $c->rescheduled_reason)
                    <div class="p-3 bg-indigo-50 border border-indigo-200 rounded-2xl text-xs text-indigo-900 space-y-0.5">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Catatan Jadwal Ulang:
                        </span>
                        <p class="text-indigo-800 font-medium">{{ $c->rescheduled_reason }}</p>
                    </div>
                @endif

                @if($c->status === 'ditolak' && $c->rejection_reason)
                    <div class="p-3 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 space-y-0.5">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            Alasan Penolakan:
                        </span>
                        <p class="text-rose-800 font-medium">{{ $c->rejection_reason }}</p>
                    </div>
                @endif

                @if($c->status === 'selesai' && $c->counselor_notes)
                    <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-2xl text-xs text-emerald-900 space-y-0.5">
                        <span class="font-bold flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Catatan Konselor / Hasil Layanan:
                        </span>
                        <p class="text-emerald-800 font-medium">{{ $c->counselor_notes }}</p>
                    </div>
                @endif

                <!-- Aksi Konseling -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-2 border-t border-[#E2E8F0]">
                    <div>
                        <a href="{{ route('guru.students.show', $c->student_id) }}" class="text-xs font-bold text-[#4338CA] hover:underline inline-flex items-center gap-1">
                            <span>Buka Rekam Kasus Siswa</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        @if($c->status === 'menunggu')
                            <button type="button" @click="openApprove({{ Js::from($c) }})" class="px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all active:scale-95 cursor-pointer">
                                Setujui Jadwal
                            </button>
                            <button type="button" @click="openReschedule({{ Js::from($c) }})" class="px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all active:scale-95 cursor-pointer">
                                Jadwalkan Ulang
                            </button>
                            <button type="button" @click="openReject({{ Js::from($c) }})" class="px-3.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs rounded-xl transition-all cursor-pointer">
                                Tolak
                            </button>
                        @elseif($c->status === 'disetujui' || $c->status === 'dijadwalkan ulang')
                            <button type="button" @click="openComplete({{ Js::from($c) }})" class="px-4 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all active:scale-95 cursor-pointer">
                                Selesaikan Sesi
                            </button>
                            <button type="button" @click="openReschedule({{ Js::from($c) }})" class="px-3.5 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold text-xs rounded-xl transition-all cursor-pointer">
                                Ubah Waktu
                            </button>
                            <button type="button" @click="openReject({{ Js::from($c) }})" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs rounded-xl transition-all cursor-pointer">
                                Batalkan
                            </button>
                        @endif

                        <form action="{{ route('guru.counseling.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data sesi konseling ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 rounded-lg hover:bg-rose-50 transition-all cursor-pointer" title="Hapus Riwayat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @empty
            <div class="py-12 px-6 text-center bg-white border border-dashed border-[#CBD5E1] rounded-3xl space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-[#EEF2FF] text-[#4338CA] mx-auto flex items-center justify-center text-xl">
                    <svg class="w-6 h-6 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h4 class="text-base font-extrabold text-[#1E1B4B]">Belum ada sesi konseling ditemukan</h4>
                <p class="text-xs text-[#64748B] max-w-md mx-auto">
                    Gunakan tombol inisiasi di atas untuk memulai konseling terencana kepada siswa, atau tunggu pengajuan dari akun siswa.
                </p>
                <div>
                    <button type="button" @click="openInitiateModal = true" class="px-4 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                        Inisiasi Konseling Baru
                    </button>
                </div>
            </div>
        @endforelse

        <div class="pt-4">
            {{ $counselings->links() }}
        </div>
    </div>

    <!-- MODAL 1: INISIASI KONSELING BARU OLEH GURU BK -->
    <div x-show="openInitiateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openInitiateModal = false" class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-5 shadow-2xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <div>
                    <span class="text-[10px] font-extrabold text-[#4338CA] bg-[#EEF2FF] px-2 py-0.5 rounded uppercase">Inisiasi Guru BK</span>
                    <h3 class="text-lg font-extrabold text-[#1E1B4B] mt-1">Buat Jadwal Konseling Baru</h3>
                </div>
                <button type="button" @click="openInitiateModal = false" class="text-[#64748B] hover:text-[#1E1B4B] text-xl font-bold">&times;</button>
            </div>

            <form action="{{ route('guru.counseling.store') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Pilih Siswa -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Pilih Siswa <span class="text-rose-500">*</span></label>
                    <select name="student_id" x-model="initiateStudentId" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                        <option value="">-- Pilih Siswa Yang Akan Diberikan Layanan --</option>
                        @foreach($students as $st)
                            <option value="{{ $st->id }}">{{ $st->nama }} (NIS: {{ $st->nis }} • Kelas {{ $st->kelas }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bidang Layanan -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Bidang Bimbingan <span class="text-rose-500">*</span></label>
                    <select name="category" x-model="initiateCategory" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                        <option value="Pribadi">Pribadi (Kedisiplinan, motivasi internal, emosi)</option>
                        <option value="Belajar">Belajar (Prestasi akademik, kendala belajar, tugas)</option>
                        <option value="Karir">Karir (Minat bakat, rencana studi lanjut, pilihan jurusan)</option>
                        <option value="Sosial">Sosial (Relasi pertemanan, adaptasi lingkungan, interaksi)</option>
                    </select>
                </div>

                <!-- Tanggal & Jam -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Tanggal Sesi <span class="text-rose-500">*</span></label>
                        <input type="date" name="preferred_date" x-model="initiateDate" @change="checkCounselingConflict(initiateDate, initiateTime)" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Jam / Waktu <span class="text-rose-500">*</span></label>
                        <select name="preferred_time" x-model="initiateTime" @change="checkCounselingConflict(initiateDate, initiateTime)" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required>
                            <option value="Istirahat 1 (09:45 - 10:15 WIB)">Istirahat 1 (09:45 - 10:15 WIB)</option>
                            <option value="Istirahat 2 (12:00 - 12:45 WIB)">Istirahat 2 (12:00 - 12:45 WIB)</option>
                            <option value="Jam Pelajaran BK">Jam Pelajaran BK</option>
                            <option value="Setelah Jam Pulang Sekolah (15:00 - 16:00 WIB)">Setelah Pulang Sekolah (15:00 - 16:00 WIB)</option>
                        </select>
                    </div>
                </div>

                <!-- Ruangan / Tempat -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Ruang / Tempat Konseling</label>
                    <input type="text" name="room_or_media" x-model="initiateRoom" placeholder="Ruang Konseling BK 1" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]">
                </div>

                <!-- Topik / Dasar Inisiasi -->
                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1.5">Topik / Dasar Kebutuhan Layanan <span class="text-rose-500">*</span></label>
                    <textarea name="topic" x-model="initiateTopic" rows="3" placeholder="Contoh: Tindak lanjut hasil asesmen IKMS terkait area karir / pemantauan catatan belajar..." class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-medium text-[#1E1B4B] outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF]" required></textarea>
                </div>

                <!-- Banner Peringatan Bentrok Real-Time -->
                <div x-show="conflictWarning" x-cloak class="p-4 bg-amber-50 border border-amber-300 rounded-2xl text-xs text-amber-900 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div class="space-y-1">
                        <span class="font-bold text-amber-950 block text-xs">Peringatan Jadwal Bentrok!</span>
                        <p class="font-medium text-amber-900" x-text="conflictWarning"></p>
                        <span class="text-[11px] text-amber-800 block">Jadwal pada jam tersebut sudah terisi. Anda disarankan memindahkan jam atau tanggal agar bimbingan tidak bertabrakan.</span>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openInitiateModal = false" class="px-4 py-2.5 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                        Simpan & Masukkan ke Kalender
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: PERSETUJUAN JADWAL (APPROVE) -->
    <div x-show="openApproveModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openApproveModal = false" class="bg-white rounded-3xl max-w-md w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <h3 class="text-base font-extrabold text-[#1E1B4B]">Konfirmasi Persetujuan Jadwal</h3>
                <button type="button" @click="openApproveModal = false" class="text-[#64748B] text-xl font-bold">&times;</button>
            </div>

            <p class="text-xs text-[#64748B]">Setujui jadwal konseling untuk <strong class="text-[#1E1B4B]" x-text="selectedStudentName"></strong>. Jadwal akan otomatis dicatat di Kalender Kegiatan BK.</p>

            <form :action="'/guru/counseling/' + selectedCounselingId + '/status'" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="approve">
                <input type="hidden" name="counseling_id" :value="selectedCounselingId">

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Tanggal Disetujui</label>
                    <input type="date" name="preferred_date" x-model="selectedDate" @change="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Waktu / Jam</label>
                    <input type="text" name="preferred_time" x-model="selectedTime" @input.debounce.300ms="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" @change="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Ruangan / Tempat</label>
                    <input type="text" name="room_or_media" x-model="selectedRoom" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]" required>
                </div>

                <!-- Banner Peringatan Bentrok Real-Time -->
                <div x-show="conflictWarning" x-cloak class="p-3 bg-amber-50 border border-amber-300 rounded-xl text-xs text-amber-900 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <span class="font-bold text-amber-950 block">Peringatan Jadwal Bentrok!</span>
                        <p class="font-medium text-amber-900 mt-0.5" x-text="conflictWarning"></p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openApproveModal = false" class="px-4 py-2 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs">Ya, Setujui Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: PENJADWALAN ULANG (RESCHEDULE) -->
    <div x-show="openRescheduleModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openRescheduleModal = false" class="bg-white rounded-3xl max-w-md w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <h3 class="text-base font-extrabold text-[#1E1B4B]">Jadwalkan Ulang Konseling</h3>
                <button type="button" @click="openRescheduleModal = false" class="text-[#64748B] text-xl font-bold">&times;</button>
            </div>

            <p class="text-xs text-[#64748B]">Ubah waktu konseling untuk <strong class="text-[#1E1B4B]" x-text="selectedStudentName"></strong>. Siswa akan menerima notifikasi jadwal baru beserta alasan penyesuaian.</p>

            <form :action="'/guru/counseling/' + selectedCounselingId + '/status'" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="reschedule">
                <input type="hidden" name="counseling_id" :value="selectedCounselingId">

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Tanggal Baru <span class="text-rose-500">*</span></label>
                    <input type="date" name="preferred_date" x-model="selectedDate" @change="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Jam Baru <span class="text-rose-500">*</span></label>
                    <input type="text" name="preferred_time" x-model="selectedTime" @input.debounce.300ms="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" @change="checkCounselingConflict(selectedDate, selectedTime, selectedCounselingId)" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]" required>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Ruangan / Tempat</label>
                    <input type="text" name="room_or_media" x-model="selectedRoom" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]">
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Alasan Penjadwalan Ulang <span class="text-rose-500">*</span></label>
                    <textarea name="rescheduled_reason" x-model="rescheduleReason" rows="3" placeholder="Contoh: Bersamaan dengan rapat dewan guru / dipindahkan ke ruang BK 2..." class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-medium text-[#1E1B4B]" required></textarea>
                </div>

                <!-- Banner Peringatan Bentrok Real-Time -->
                <div x-show="conflictWarning" x-cloak class="p-3 bg-amber-50 border border-amber-300 rounded-xl text-xs text-amber-900 flex items-start gap-2.5">
                    <svg class="w-4 h-4 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <div>
                        <span class="font-bold text-amber-950 block">Peringatan Jadwal Bentrok!</span>
                        <p class="font-medium text-amber-900 mt-0.5" x-text="conflictWarning"></p>
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openRescheduleModal = false" class="px-4 py-2 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs">Simpan Jadwal Baru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 4: PENOLAKAN PENGAJUAN (REJECT) -->
    <div x-show="openRejectModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openRejectModal = false" class="bg-white rounded-3xl max-w-md w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <h3 class="text-base font-extrabold text-[#1E1B4B]">Tolak / Batalkan Konseling</h3>
                <button type="button" @click="openRejectModal = false" class="text-[#64748B] text-xl font-bold">&times;</button>
            </div>

            <p class="text-xs text-[#64748B]">Berikan keterangan mengapa pengajuan konseling untuk <strong class="text-[#1E1B4B]" x-text="selectedStudentName"></strong> belum dapat dipenuhi.</p>

            <form :action="'/guru/counseling/' + selectedCounselingId + '/status'" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="reject">
                <input type="hidden" name="counseling_id" :value="selectedCounselingId">

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Alasan Penolakan / Pembatalan <span class="text-rose-500">*</span></label>
                    <textarea name="rejection_reason" x-model="rejectionReason" rows="3" placeholder="Contoh: Jadwal bentrok dengan kegiatan ujian / silakan ajukan di pekan depan..." class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-medium text-[#1E1B4B]" required></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openRejectModal = false" class="px-4 py-2 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-xs">Konfirmasi Penolakan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 5: SELESAIKAN KONSELING (COMPLETE -> AUTO REKAM KASUS) -->
    <div x-show="openCompleteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openCompleteModal = false" class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-2xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <div>
                    <span class="text-[10px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded uppercase">Hasil Layanan</span>
                    <h3 class="text-lg font-extrabold text-[#1E1B4B] mt-1">Selesaikan Sesi Konseling</h3>
                </div>
                <button type="button" @click="openCompleteModal = false" class="text-[#64748B] text-xl font-bold">&times;</button>
            </div>

            <p class="text-xs text-[#64748B]">Tandai sesi konseling bersama <strong class="text-[#1E1B4B]" x-text="selectedStudentName"></strong> sebagai selesai. Catatan hasil layanan akan otomatis disimpan ke Rekam Kasus Digital siswa.</p>

            <form :action="'/guru/counseling/' + selectedCounselingId + '/status'" method="POST" class="space-y-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="action" value="complete">
                <input type="hidden" name="counseling_id" :value="selectedCounselingId">

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Catatan Layanan / Hasil Pembahasan <span class="text-rose-500">*</span></label>
                    <textarea name="counselor_notes" x-model="counselorNotes" rows="4" placeholder="Uraikan hasil wawancara konseling, poin kesepakatan, atau solusi yang disepakati..." class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-medium text-[#1E1B4B]" required></textarea>
                </div>

                <div>
                    <label class="text-xs font-bold text-[#1E1B4B] block mb-1">Rencana Tindak Lanjut</label>
                    <input type="text" name="follow_up" x-model="followUpNotes" class="w-full px-3.5 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-semibold text-[#1E1B4B]">
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openCompleteModal = false" class="px-4 py-2 text-xs font-bold text-[#64748B] hover:bg-[#F8FAFF] rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-xs">Simpan & Selesaikan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection