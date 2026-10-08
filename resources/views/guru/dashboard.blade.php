@extends('layouts.app')

@section('title', 'Dashboard Guru BK - SIM-BK')

@section('content')
<div x-data="{
        currentYear: new Date().getFullYear(),
        currentMonth: new Date().getMonth(),
        selectedDateStr: '{{ date('Y-m-d') }}',
        allEvents: {{ Js::from($allEvents->map(function($e) {
            return [
                'id' => $e->id,
                'title' => $e->title,
                'date' => $e->event_date->format('Y-m-d'),
                'start_time' => $e->start_time,
                'end_time' => $e->end_time,
                'location' => $e->location,
                'category' => $e->category,
            ];
        })) }},

        monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],

        get monthTitle() {
            return this.monthNames[this.currentMonth] + ' ' + this.currentYear;
        },

        prevMonth() {
            if (this.currentMonth === 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else {
                this.currentMonth--;
            }
        },

        nextMonth() {
            if (this.currentMonth === 11) {
                this.currentMonth = 0;
                this.currentYear++;
            } else {
                this.currentMonth++;
            }
        },

        get calendarDays() {
            const firstDayIndex = new Date(this.currentYear, this.currentMonth, 1).getDay();
            const startOffset = (firstDayIndex + 6) % 7;
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const days = [];

            for (let i = startOffset - 1; i >= 0; i--) {
                days.push({ dayNum: '', dateStr: '', isCurrentMonth: false, hasEvents: false });
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                const hasEvents = this.allEvents.some(e => e.date === dateStr);
                days.push({
                    dayNum: i,
                    dateStr: dateStr,
                    isCurrentMonth: true,
                    isToday: dateStr === new Date().toISOString().split('T')[0],
                    hasEvents: hasEvents
                });
            }
            return days;
        },

        get selectedDateEvents() {
            return this.allEvents.filter(e => e.date === this.selectedDateStr);
        }
     }" 
     class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto space-y-6 md:space-y-8 bg-white">
    
    <!-- Page Title -->
    <div>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Ruang Kerja Guru BK</h2>
        <p class="text-[#64748B] mt-1 text-xs sm:text-sm font-medium">Pusat pemantauan data bimbingan, verifikasi konseling siswa, dan kalender kegiatan sekolah.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-6">
        <!-- Card 1: Total Siswa -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#9FA1FF]/20 text-[#1E1B4B] border border-[#9FA1FF]/40 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 bg-[#D9F9DF] text-[#14532D] text-[10px] sm:text-[11px] font-bold rounded-full border border-[#BBF7D0]">Aktif</span>
            </div>
            <div>
                <p class="text-[#64748B] text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1">Total Siswa</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B4B]">{{ $totalStudents }}</h3>
            </div>
        </div>
        
        <!-- Card 2: Kuisioner Aktif -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#AEE2FF]/30 text-[#0369A1] border border-[#AEE2FF] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#0369A1]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 bg-[#AEE2FF]/40 text-[#0369A1] text-[10px] sm:text-[11px] font-bold rounded-full border border-[#AEE2FF]">Published</span>
            </div>
            <div>
                <p class="text-[#64748B] text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1">Kuisioner Aktif</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B4B]">{{ $activeQuestionnaires }}</h3>
            </div>
        </div>

        <!-- Card 3: Konseling Menunggu -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-amber-50 text-amber-700 border border-amber-200 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 bg-amber-50 text-amber-700 text-[10px] sm:text-[11px] font-bold rounded-full border border-amber-200">Konfirmasi</span>
            </div>
            <div>
                <p class="text-[#64748B] text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1">Permintaan Sesi</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-amber-700">{{ $pendingCounseling }}</h3>
            </div>
        </div>

        <!-- Card 4: Konseling Selesai -->
        <div class="bg-white rounded-3xl p-4 sm:p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-[#14532D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="px-2 sm:px-2.5 py-0.5 sm:py-1 bg-[#D9F9DF] text-[#14532D] text-[10px] sm:text-[11px] font-bold rounded-full border border-[#BBF7D0]">Selesai</span>
            </div>
            <div>
                <p class="text-[#64748B] text-[10px] sm:text-xs font-bold uppercase tracking-wider mb-1">Konseling Selesai</p>
                <h3 class="text-2xl sm:text-3xl font-extrabold text-[#14532D]">{{ $completedCounseling }}</h3>
            </div>
        </div>
    </div>

    <!-- Content Grid Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Kolom Kiri: Sesi Konseling Terbaru (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            <div class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-[#E2E8F0] flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-[#F8FAFF]">
                    <div>
                        <h3 class="font-bold text-[#1E1B4B] text-base">Permohonan & Sesi Konseling Terbaru</h3>
                        <p class="text-xs text-[#64748B]">Pengajuan bimbingan konseling dari siswa yang tercatat di sistem.</p>
                    </div>
                    <a href="{{ route('guru.counseling.index') }}" class="text-xs font-bold text-[#1E1B4B] hover:bg-[#F8FAFF] active:scale-95 px-3.5 py-2 bg-white border border-[#E2E8F0] rounded-xl shadow-2xs inline-flex items-center justify-center gap-1.5 transition-all cursor-pointer">
                        <span>Buka Ruang Konseling</span>
                        <svg class="w-3.5 h-3.5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
                <div class="p-4 sm:p-6 space-y-3.5">
                    @forelse($recentCounselings as $c)
                        <div class="bg-[#F8FAFF] rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 border border-[#E2E8F0] hover:bg-white transition-colors">
                            <div class="flex items-center gap-4">
                                <div class="w-11 h-11 rounded-2xl bg-[#9FA1FF] text-[#1E1B4B] border border-[#8E90FF] flex items-center justify-center font-bold text-sm shadow-xs overflow-hidden shrink-0">
                                    @if($c->student && !empty($c->student->foto))
                                        <img src="{{ asset('storage/' . $c->student->foto) }}" alt="Avatar" class="w-full h-full object-cover">
                                    @else
                                        <span>{{ strtoupper(substr($c->student->nama ?? 'S', 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <h4 class="font-bold text-[#1E1B4B] text-sm">{{ $c->student->nama ?? 'Siswa' }}</h4>
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                            @if($c->status === 'menunggu') bg-amber-50 text-amber-700 border border-amber-200
                                             @elseif($c->status === 'disetujui') bg-indigo-50 text-indigo-700 border border-indigo-200
                                             @elseif($c->status === 'selesai') bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]
                                             @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                            {{ ucfirst($c->status) }}
                                        </span>
                                    </div>
                                    <p class="text-[#64748B] text-xs mt-0.5 font-medium truncate">Kelas {{ $c->student->kelas ?? '-' }} • {{ $c->category }}: {{ Str::limit($c->topic, 45) }}</p>
                                </div>
                            </div>
                            <a href="{{ route('guru.counseling.index') }}" class="w-full sm:w-auto px-4 py-2 text-xs font-bold text-[#1E1B4B] bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 border border-[#8E90FF] rounded-xl transition-all shadow-xs text-center shrink-0 cursor-pointer">
                                Tanggapi
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8 text-xs text-[#64748B] font-semibold">
                            Belum ada permohonan konseling masuk.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: WIDGET KALENDER INTERAKTIF & AGENDA (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden p-4 sm:p-6 space-y-5">
                
                <!-- Mini Calendar Header -->
                <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-[#1E1B4B] text-base" x-text="monthTitle"></h3>
                    </div>
                    <div class="flex items-center gap-1.5">
                        <button @click="prevMonth()" class="p-1.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 transition-all rounded-lg text-xs cursor-pointer">◀</button>
                        <button @click="nextMonth()" class="p-1.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 transition-all rounded-lg text-xs cursor-pointer">▶</button>
                        <a href="{{ route('guru.calendar.index') }}" class="text-[11px] font-bold text-[#9FA1FF] hover:underline active:scale-95 transition-all ml-2 inline-flex items-center gap-1 cursor-pointer">
                            <span>Buka Kalender</span>
                            <svg class="w-3 h-3 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>

                <!-- Mini Grid -->
                <div>
                    <div class="grid grid-cols-7 text-center text-[10px] font-bold text-[#64748B] uppercase mb-1.5">
                        <div>Sn</div><div>Sl</div><div>Rb</div><div>Km</div><div>Jm</div><div>Sb</div><div>Mg</div>
                    </div>
                    <div class="grid grid-cols-7 gap-1 text-xs">
                        <template x-for="day in calendarDays">
                            <div @click="if(day.dateStr) selectedDateStr = day.dateStr" 
                                 :class="{
                                    'cursor-pointer hover:bg-[#B5BAFF]/20 active:scale-95': day.isCurrentMonth,
                                    'bg-[#9FA1FF] font-bold text-[#1E1B4B] shadow-xs': selectedDateStr === day.dateStr,
                                    'border border-[#9FA1FF] font-bold': day.isToday && selectedDateStr !== day.dateStr,
                                    'text-[#1E1B4B]': day.isCurrentMonth && selectedDateStr !== day.dateStr,
                                    'text-transparent pointer-events-none': !day.isCurrentMonth
                                 }"
                                 class="h-8 rounded-lg flex flex-col items-center justify-center relative transition-all">
                                <span class="text-[11px]" x-text="day.dayNum"></span>
                                <template x-if="day.hasEvents">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#9FA1FF] absolute bottom-1"></span>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Timeline for Selected Date -->
                <div class="border-t border-[#E2E8F0] pt-4 space-y-3">
                    <div class="flex items-center justify-between text-xs font-bold text-[#1E1B4B]">
                        <span>Agenda: <strong class="text-[#9FA1FF]" x-text="selectedDateStr"></strong></span>
                    </div>

                    <div class="space-y-2 max-h-48 overflow-y-auto pr-1">
                        <template x-for="ev in selectedDateEvents" :key="ev.id">
                            <div class="p-3 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl text-xs space-y-1">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold text-[10px] px-2 py-0.5 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-md" x-text="ev.category"></span>
                                    <span class="text-[10px] text-[#64748B] font-semibold" x-text="(ev.start_time || '08:00') + ' WIB'"></span>
                                </div>
                                <h5 class="font-bold text-[#1E1B4B]" x-text="ev.title"></h5>
                                <template x-if="ev.location">
                                    <p class="text-[10px] text-[#64748B] flex items-center gap-1">
                                        <svg class="w-3 h-3 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                        <span x-text="ev.location"></span>
                                    </p>
                                </template>
                            </div>
                        </template>

                        <template x-if="selectedDateEvents.length === 0">
                            <div class="p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl text-center text-xs text-[#64748B]">
                                Tidak ada kegiatan pada tanggal ini.
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>
@endsection