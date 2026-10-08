@extends('layouts.app')

@section('title', 'Kalender & Timeline Kegiatan BK - SIM-BK')

@section('content')
<div x-data="{
        viewType: 'calendar', // 'calendar', 'timeline', 'list'
        currentYear: new Date().getFullYear(),
        currentMonth: new Date().getMonth(), // 0-indexed
        selectedDateStr: '{{ date('Y-m-d') }}',
        filterCategory: 'all',
        
        events: {{ Js::from($events->map(function($e) {
            return [
                'id' => $e->id,
                'source_id' => $e->source_id ?? $e->id,
                'source_type' => $e->source_type ?? 'event',
                'title' => $e->title,
                'date' => is_string($e->event_date) ? $e->event_date : ($e->event_date ? $e->event_date->format('Y-m-d') : $e->date),
                'start_time' => $e->start_time,
                'end_time' => $e->end_time,
                'location' => $e->location,
                'category' => $e->category,
                'description' => $e->description,
            ];
        })) }},

        // Modals
        openCreateModal: false,
        openEditModal: false,
        openDetailModal: false,
        selectedEvent: null,

        formDate: '{{ date('Y-m-d') }}',
        formTitle: '',
        formStartTime: '08:00',
        formEndTime: '09:30',
        formLocation: 'Ruang Konseling BK 1',
        formCategory: 'Konseling',
        formDescription: '',

        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

        formatLocalDate(d = new Date()) {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

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

        goToToday() {
            const now = new Date();
            this.currentYear = now.getFullYear();
            this.currentMonth = now.getMonth();
            this.selectedDateStr = this.formatLocalDate(now);
        },

        // Menghitung hari dalam bulan aktif
        get calendarDays() {
            const firstDayIndex = new Date(this.currentYear, this.currentMonth, 1).getDay();
            const startOffset = (firstDayIndex + 6) % 7;
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();
            const todayStr = this.formatLocalDate(new Date());

            const days = [];

            // Hari dari bulan sebelumnya
            for (let i = startOffset - 1; i >= 0; i--) {
                const dayNum = daysInPrevMonth - i;
                const prevMonth = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
                const prevYear = this.currentMonth === 0 ? this.currentYear - 1 : this.currentYear;
                const dateStr = `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                days.push({
                    dayNum: dayNum,
                    dateStr: dateStr,
                    isCurrentMonth: false,
                    isToday: dateStr === todayStr,
                    events: this.getEventsForDate(dateStr)
                });
            }

            // Hari dari bulan ini
            for (let i = 1; i <= daysInMonth; i++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    dayNum: i,
                    dateStr: dateStr,
                    isCurrentMonth: true,
                    isToday: dateStr === todayStr,
                    events: this.getEventsForDate(dateStr)
                });
            }

            // Hari penutup bulan berikutnya agar genap kelipatan 7
            const totalCells = Math.ceil(days.length / 7) * 7;
            const remaining = totalCells - days.length;
            for (let i = 1; i <= remaining; i++) {
                const nextMonth = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
                const nextYear = this.currentMonth === 11 ? this.currentYear + 1 : this.currentYear;
                const dateStr = `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    dayNum: i,
                    dateStr: dateStr,
                    isCurrentMonth: false,
                    isToday: dateStr === todayStr,
                    events: this.getEventsForDate(dateStr)
                });
            }

            return days;
        },

        getEventsForDate(dateStr) {
            return this.events.filter(e => {
                const matchesDate = e.date === dateStr;
                const matchesCat = this.filterCategory === 'all' || e.category === this.filterCategory;
                return matchesDate && matchesCat;
            });
        },

        get selectedDateEvents() {
            return this.getEventsForDate(this.selectedDateStr);
        },

        selectDate(dateStr) {
            this.selectedDateStr = dateStr;
        },

        openAddForDate(dateStr) {
            this.formDate = dateStr || this.selectedDateStr;
            this.formTitle = '';
            this.formStartTime = '08:00';
            this.formEndTime = '09:30';
            this.formLocation = 'Ruang Konseling BK 1';
            this.formCategory = 'Konseling';
            this.formDescription = '';
            this.openCreateModal = true;
        },

        showDetail(ev) {
            this.selectedEvent = ev;
            this.openDetailModal = true;
        },

        openEdit(ev) {
            this.selectedEvent = ev;
            this.formDate = ev.date;
            this.formTitle = ev.title;
            this.formStartTime = ev.start_time;
            this.formEndTime = ev.end_time;
            this.formLocation = ev.location;
            this.formCategory = ev.category;
            this.formDescription = ev.description;
            this.openDetailModal = false;
            this.openEditModal = true;
        },

        getCategoryBadgeClass(cat) {
            switch(cat) {
                case 'Konseling': return 'bg-[#9FA1FF] text-[#1E1B4B] border border-[#8E90FF]';
                case 'Bimbingan Klasikal': return 'bg-[#B5BAFF]/40 text-[#1E1B4B] border border-[#B5BAFF]';
                case 'Home Visit': return 'bg-amber-100 text-amber-900 border border-amber-200';
                case 'Asesmen': return 'bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF]';
                default: return 'bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]';
            }
        }
     }" 
     class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto space-y-6 md:space-y-8 bg-white">
    
    <!-- Title & Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 shrink-0">
        <div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Kalender & Timeline Kegiatan BK</h2>
            <p class="text-[#64748B] mt-1 text-xs sm:text-sm font-medium">Visualisasi interaktif jadwal konseling, kunjungan rumah, asesmen, dan bimbingan klasikal.</p>
        </div>
        <button @click="openAddForDate(selectedDateStr)" class="bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] text-xs font-bold px-5 py-3 rounded-2xl transition-all shadow-xs flex items-center justify-center gap-2 w-full sm:w-auto cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Agenda Baru
        </button>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
        </div>
    @endif

    <!-- CONTROLS & FILTER BAR -->
    <div class="bg-white rounded-3xl p-4 md:p-6 border border-[#E2E8F0] shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        
        <!-- View Toggle Buttons -->
        <div class="flex items-center gap-2 bg-[#F8FAFF] p-1 rounded-2xl border border-[#E2E8F0] w-full md:w-auto overflow-x-auto">
            <button @click="viewType = 'calendar'" :class="viewType === 'calendar' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B]'" class="px-4 py-2 rounded-xl text-xs font-bold active:scale-95 transition-all flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kalender Bulanan
            </button>
            <button @click="viewType = 'timeline'" :class="viewType === 'timeline' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B]'" class="px-4 py-2 rounded-xl text-xs font-bold active:scale-95 transition-all flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Timeline Jam Kerja
            </button>
            <button @click="viewType = 'list'" :class="viewType === 'list' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B]'" class="px-4 py-2 rounded-xl text-xs font-bold active:scale-95 transition-all flex items-center gap-1.5 whitespace-nowrap cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                Daftar Agenda
            </button>
        </div>

        <!-- Category Filters -->
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto">
            <button @click="filterCategory = 'all'" :class="filterCategory === 'all' ? 'bg-[#1E1B4B] text-white font-bold' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#B5BAFF]/20 font-semibold'" class="px-3.5 py-2 rounded-xl text-xs active:scale-95 transition-all whitespace-nowrap cursor-pointer">
                Semua
            </button>
            <button @click="filterCategory = 'Konseling'" :class="filterCategory === 'Konseling' ? 'bg-[#9FA1FF] text-[#1E1B4B] font-bold border border-[#8E90FF]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#B5BAFF]/20 font-semibold'" class="px-3.5 py-2 rounded-xl text-xs active:scale-95 transition-all whitespace-nowrap cursor-pointer">
                Konseling
            </button>
            <button @click="filterCategory = 'Bimbingan Klasikal'" :class="filterCategory === 'Bimbingan Klasikal' ? 'bg-[#B5BAFF] text-[#1E1B4B] font-bold border border-[#A5AAFF]' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#B5BAFF]/20 font-semibold'" class="px-3.5 py-2 rounded-xl text-xs active:scale-95 transition-all whitespace-nowrap cursor-pointer">
                Klasikal
            </button>
            <button @click="filterCategory = 'Home Visit'" :class="filterCategory === 'Home Visit' ? 'bg-amber-200 text-amber-900 font-bold border border-amber-300' : 'bg-[#F8FAFF] text-[#64748B] hover:bg-[#B5BAFF]/20 font-semibold'" class="px-3.5 py-2 rounded-xl text-xs active:scale-95 transition-all whitespace-nowrap cursor-pointer">
                Home Visit
            </button>
        </div>

    </div>

    <!-- ================= VIEW 1: KALENDER BULANAN INTERAKTIF ================= -->
    <div x-show="viewType === 'calendar'" class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- GRID KALENDER (KIRI - 8 COLS) -->
        <div class="lg:col-span-8 bg-white rounded-3xl p-3 sm:p-5 md:p-6 border border-[#E2E8F0] shadow-xs flex flex-col space-y-4">
            
            <!-- Calendar Navigation Header -->
            <div class="flex items-center justify-between gap-2 pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-1.5 sm:gap-3 min-w-0">
                    <button @click="prevMonth()" class="p-1.5 sm:p-2 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl transition-all cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    </button>
                    <h3 class="text-sm sm:text-lg md:text-xl font-extrabold text-[#1E1B4B] text-center truncate" x-text="monthTitle"></h3>
                    <button @click="nextMonth()" class="p-1.5 sm:p-2 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl transition-all cursor-pointer shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <button @click="goToToday()" class="px-3 sm:px-3.5 py-1.5 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all shadow-2xs cursor-pointer shrink-0">
                    Hari Ini
                </button>
            </div>

            <!-- Days of Week Header -->
            <div class="grid grid-cols-7 bg-[#F8FAFF] rounded-2xl text-center text-[10px] sm:text-xs font-extrabold text-[#64748B] py-2 sm:py-3 border border-[#E2E8F0]">
                <div>Sen</div>
                <div>Sel</div>
                <div>Rab</div>
                <div>Kam</div>
                <div>Jum</div>
                <div class="text-[#9FA1FF]">Sab</div>
                <div class="text-rose-600">Min</div>
            </div>

            <!-- Date Cells Grid -->
            <div class="grid grid-cols-7 gap-1 sm:gap-1.5 md:gap-2 bg-white p-1 sm:p-2 rounded-2xl border border-[#E2E8F0]">
                <template x-for="day in calendarDays" :key="day.dateStr">
                    <div @click="selectDate(day.dateStr)" 
                         :class="{
                            'bg-white text-[#1E1B4B] shadow-2xs': day.isCurrentMonth,
                            'bg-[#F8FAFF]/60 text-[#94A3B8]/60': !day.isCurrentMonth,
                            'ring-2 ring-[#9FA1FF] bg-[#B5BAFF]/20 font-bold': selectedDateStr === day.dateStr,
                            'border-t-2 border-t-[#9FA1FF]': day.isToday && selectedDateStr !== day.dateStr
                         }"
                         class="h-14 sm:h-16 md:min-h-24 p-1 sm:p-1.5 md:p-2 rounded-xl sm:rounded-2xl border border-[#E2E8F0] cursor-pointer transition-all hover:border-[#9FA1FF] active:scale-95 flex flex-col justify-between overflow-hidden">
                        
                        <!-- Top Row: Date Number & Badge -->
                        <div class="flex items-center justify-between w-full">
                            <span :class="day.isToday ? 'bg-[#1E1B4B] text-white w-5 h-5 sm:w-6 sm:h-6 rounded-full flex items-center justify-center text-[10px] sm:text-xs shadow-xs' : 'text-[11px] sm:text-xs font-bold'" 
                                  x-text="day.dayNum"></span>
                            <template x-if="day.events.length > 0">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#9FA1FF] hidden md:block"></span>
                            </template>
                        </div>

                        <!-- Mobile Event Indicator (Dots) -->
                        <div class="md:hidden flex items-center justify-center gap-0.5 mt-auto">
                            <template x-if="day.events.length > 0">
                                <div class="flex items-center gap-0.5">
                                    <template x-for="(ev, idx) in day.events.slice(0, 3)" :key="ev.id">
                                        <span class="w-1.5 h-1.5 rounded-full shrink-0" 
                                              :class="ev.category === 'Konseling' ? 'bg-[#9FA1FF]' : (ev.category === 'Home Visit' ? 'bg-amber-400' : (ev.category === 'Bimbingan Klasikal' ? 'bg-[#B5BAFF]' : 'bg-[#AEE2FF]'))">
                                        </span>
                                    </template>
                                    <template x-if="day.events.length > 3">
                                        <span class="text-[8px] font-bold text-[#64748B] leading-none">+</span>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <!-- Desktop Event Chips List (hidden on mobile, shown on md and up) -->
                        <div class="hidden md:block space-y-1 mt-1 overflow-hidden w-full">
                            <template x-for="ev in day.events.slice(0, 2)" :key="ev.id">
                                <div @click.stop="showDetail(ev)" 
                                     :class="getCategoryBadgeClass(ev.category)"
                                     class="px-1.5 py-0.5 rounded-md text-[9px] font-bold truncate leading-tight transition-transform hover:scale-105 shadow-2xs">
                                    <span x-text="ev.start_time ? ev.start_time + ' ' : ''"></span>
                                    <span x-text="ev.title"></span>
                                </div>
                            </template>
                            <template x-if="day.events.length > 2">
                                <span class="text-[8px] font-bold text-[#64748B] block text-right" x-text="'+' + (day.events.length - 2) + ' lagi'"></span>
                            </template>
                        </div>

                    </div>
                </template>
            </div>

        </div>

        <!-- DETAIL TANGGAL TERPILIH (KANAN - 4 COLS) -->
        <div class="lg:col-span-4 bg-white rounded-3xl p-4 sm:p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between space-y-6">
            <div class="space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                    <div>
                        <h4 class="font-extrabold text-[#1E1B4B] text-base">Agenda Tanggal</h4>
                        <span class="text-xs font-bold text-[#9FA1FF]" x-text="selectedDateStr"></span>
                    </div>
                    <button @click="openAddForDate(selectedDateStr)" class="px-3 py-1.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] text-xs font-bold rounded-xl shadow-2xs transition-all cursor-pointer flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Tambah Agenda</span>
                    </button>
                </div>

                <!-- Event Cards on Selected Date -->
                <div class="space-y-3 max-h-[420px] overflow-y-auto pr-1">
                    <template x-for="ev in selectedDateEvents" :key="ev.id">
                        <div class="p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl space-y-2 hover:bg-white transition-colors">
                            <div class="flex items-center justify-between">
                                <span :class="getCategoryBadgeClass(ev.category)" class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase" x-text="ev.category"></span>
                                <div class="flex items-center gap-1">
                                    <template x-if="ev.source_type === 'event'">
                                        <div class="flex items-center gap-1">
                                            <button @click="openEdit(ev)" class="p-1.5 text-[#64748B] hover:text-[#1E1B4B] hover:bg-slate-200/60 rounded-lg cursor-pointer transition-colors" title="Edit Agenda">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                            <form :action="'/guru/calendar/' + ev.source_id" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg cursor-pointer transition-colors" title="Hapus Agenda">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </template>
                                    <template x-if="ev.source_type === 'counseling'">
                                        <a href="{{ route('guru.counseling.index') }}" class="px-2 py-1 bg-[#EEF2FF] hover:bg-[#E0E7FF] text-[#4338CA] text-[10px] font-bold rounded-lg transition-colors inline-flex items-center gap-1" title="Kelola di Menu Konseling">
                                            <span>Kelola Sesi</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </template>
                                </div>
                            </div>

                            <h5 class="font-bold text-xs text-[#1E1B4B]" x-text="ev.title"></h5>

                            <div class="text-[11px] text-[#64748B] space-y-1">
                                <p class="flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span x-text="(ev.start_time || '-') + ' s/d ' + (ev.end_time || '-') + ' WIB'"></span>
                                </p>
                                <template x-if="ev.location">
                                    <p class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        <span x-text="ev.location"></span>
                                    </p>
                                </template>
                            </div>

                            <template x-if="ev.description">
                                <p class="text-[11px] text-[#475569] bg-white p-2.5 rounded-xl border border-[#E2E8F0]" x-text="ev.description"></p>
                            </template>
                        </div>
                    </template>
                    <template x-if="selectedDateEvents.length === 0">
                        <div class="py-12 text-center text-[#64748B] bg-[#F8FAFF] rounded-2xl border border-dashed border-[#E2E8F0]">
                            <svg class="w-10 h-10 text-[#94A3B8] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="text-xs font-bold text-[#1E1B4B]">Tidak ada agenda pada tanggal ini</p>
                            <p class="text-[10px] text-[#64748B] mt-0.5">Klik "+ Tambah" untuk menjadwalkan kegiatan.</p>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Legend Info -->
            <div class="border-t border-[#E2E8F0] pt-4 space-y-2 text-xs font-semibold text-[#64748B]">
                <span class="text-[10px] uppercase font-bold text-[#64748B] block">Kategori Warna:</span>
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#9FA1FF] border border-[#8E90FF]"></span> Konseling</div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#B5BAFF] border border-[#A5AAFF]"></span> Klasikal</div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-300"></span> Home Visit</div>
                    <div class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#AEE2FF]"></span> Asesmen</div>
                </div>
            </div>
        </div>

    </div>

    <!-- ================= VIEW 2: TIMELINE JAM KERJA ================= -->
    <div x-show="viewType === 'timeline'" class="bg-white rounded-3xl p-6 md:p-8 border border-[#E2E8F0] shadow-xs space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-[#E2E8F0]">
            <div>
                <h3 class="font-bold text-lg text-[#1E1B4B]">Timeline Jam Kerja & Agenda Harian BK</h3>
                <p class="text-xs text-[#64748B]">Distribusi kegiatan bimbingan konseling per blok waktu (07:00 - 17:00 WIB).</p>
            </div>
            <div class="flex items-center gap-2">
                <input type="date" x-model="selectedDateStr" class="px-3 py-1.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-bold text-[#1E1B4B] outline-none">
            </div>
        </div>

        <!-- Vertical Timeline Stream -->
        <div class="relative pl-8 space-y-8 before:absolute before:left-3.5 before:top-3 before:bottom-3 before:w-0.5 before:bg-[#E2E8F0]">
            
            <template x-for="ev in selectedDateEvents" :key="ev.id">
                <div class="relative group">
                    <!-- Dot Indicator -->
                    <div class="absolute -left-[37px] top-1.5 w-5 h-5 rounded-full border-4 border-white bg-[#1E1B4B] shadow-xs"></div>

                    <!-- Event Card -->
                    <div class="p-5 bg-white border-2 border-[#E2E8F0] rounded-3xl shadow-xs space-y-2 hover:shadow-md transition-all">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#E2E8F0] pb-2">
                            <div class="flex items-center gap-2">
                                <span :class="getCategoryBadgeClass(ev.category)" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase" x-text="ev.category"></span>
                                <h4 class="font-extrabold text-sm text-[#1E1B4B]" x-text="ev.title"></h4>
                            </div>
                            <span class="text-xs font-bold text-[#1E1B4B] bg-[#F8FAFF] px-2.5 py-1 rounded-lg border border-[#E2E8F0]" x-text="(ev.start_time || '08:00') + ' - ' + (ev.end_time || '09:00') + ' WIB'"></span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs text-[#64748B] pt-1">
                            <p class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg> <span>Lokasi:</span> <strong class="text-[#1E1B4B]" x-text="ev.location || 'Ruang BK'"></strong></p>
                            <p class="flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg> <span>Tanggal:</span> <strong class="text-[#1E1B4B]" x-text="ev.date"></strong></p>
                        </div>

                        <template x-if="ev.description">
                            <p class="text-xs text-[#475569] bg-[#F8FAFF] p-3 rounded-xl border border-[#E2E8F0]" x-text="ev.description"></p>
                        </template>

                        <div class="flex justify-end gap-2 pt-2 border-t border-[#E2E8F0]">
                            <button @click="openEdit(ev)" class="px-3 py-1 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-lg transition-all cursor-pointer">
                                Edit
                            </button>
                        </div>
                    </div>
                </div>
            </template>

            <template x-if="selectedDateEvents.length === 0">
                <div class="py-12 text-center text-[#64748B]">
                    <p class="text-xs font-bold">Tidak ada agenda pada timeline tanggal terpilih.</p>
                </div>
            </template>

        </div>

    </div>

    <!-- ================= VIEW 3: DAFTAR AGENDA LENGKAP ================= -->
    <div x-show="viewType === 'list'" class="bg-white rounded-3xl p-6 md:p-8 border border-[#E2E8F0] shadow-xs space-y-4">
        <h3 class="font-bold text-lg text-[#1E1B4B] pb-3 border-b border-[#E2E8F0]">Semua Daftar Kegiatan BK</h3>
        
        <div class="space-y-3">
            @forelse($events as $ev)
                <div class="p-4 bg-[#F8FAFF] hover:bg-white border border-[#E2E8F0] rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors">
                    <div class="space-y-1 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                :class="getCategoryBadgeClass('{{ $ev->category }}')">
                                {{ $ev->category }}
                            </span>
                            <span class="text-xs font-semibold text-[#64748B] flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ is_string($ev->event_date) ? date('d F Y', strtotime($ev->event_date)) : ($ev->event_date ? $ev->event_date->format('d F Y') : '-') }} ({{ $ev->start_time ?? '-' }}{{ $ev->end_time ? ' - ' . $ev->end_time : '' }} WIB)</span>
                            </span>
                        </div>
                        <h4 class="font-bold text-sm text-[#1E1B4B]">{{ $ev->title }}</h4>
                        <div class="text-xs text-[#64748B] flex items-center gap-1.5 flex-wrap">
                            <span class="flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                <span>{{ $ev->location ?? 'Ruang BK' }}</span>
                            </span>
                            @if($ev->description)
                                <span>•</span>
                                <span>{{ $ev->description }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        @if(($ev->source_type ?? 'event') === 'event')
                            <button @click="openEdit({ id: '{{ $ev->id }}', source_id: '{{ $ev->source_id ?? $ev->id }}', title: `{{ addslashes($ev->title) }}`, date: '{{ is_string($ev->event_date) ? $ev->event_date : ($ev->event_date ? $ev->event_date->format('Y-m-d') : '') }}', start_time: '{{ $ev->start_time }}', end_time: '{{ $ev->end_time }}', location: `{{ addslashes($ev->location ?? '') }}`, category: '{{ $ev->category }}', description: `{{ addslashes($ev->description ?? '') }}` })" class="px-3 py-1.5 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-xl transition-all cursor-pointer">
                                Edit
                            </button>
                            <form action="{{ route('guru.calendar.destroy', $ev->source_id ?? $ev->id) }}" method="POST" onsubmit="return confirm('Hapus kegiatan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition-all cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        @else
                            <a href="{{ route('guru.counseling.index') }}" class="px-3 py-1.5 bg-[#EEF2FF] hover:bg-[#E0E7FF] text-[#4338CA] text-xs font-bold rounded-xl transition-all inline-flex items-center gap-1">
                                <span>Kelola di Menu Konseling</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-xs text-[#64748B] font-bold">
                    Belum ada agenda kegiatan yang terdaftar.
                </div>
            @endforelse
        </div>
    </div>

    <!-- MODAL CREATE AGENDA -->
    <div x-show="openCreateModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openCreateModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-6 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-lg font-bold text-[#1E1B4B]">Tambah Agenda Kegiatan BK</h3>
                <button type="button" @click="openCreateModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form action="{{ route('guru.calendar.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Kegiatan / Agenda</label>
                    <input type="text" name="title" x-model="formTitle" placeholder="Contoh: Bimbingan Karir Kelas XII" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tanggal Pelaksanaan</label>
                        <input type="date" name="event_date" x-model="formDate" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Kategori Kegiatan</label>
                        <select name="category" x-model="formCategory" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                            <option value="Konseling">Konseling</option>
                            <option value="Bimbingan Klasikal">Bimbingan Klasikal</option>
                            <option value="Home Visit">Home Visit</option>
                            <option value="Asesmen">Asesmen</option>
                            <option value="Rapat">Rapat / Evaluasi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Jam Mulai</label>
                        <input type="text" name="start_time" x-model="formStartTime" placeholder="08:00" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Jam Selesai</label>
                        <input type="text" name="end_time" x-model="formEndTime" placeholder="09:30" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Lokasi / Ruangan</label>
                    <input type="text" name="location" x-model="formLocation" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Keterangan / Uraian Agenda</label>
                    <textarea name="description" x-model="formDescription" rows="3" placeholder="Uraian sasaran kegiatan..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openCreateModal = false" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs cursor-pointer">
                        Simpan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT AGENDA -->
    <div x-show="openEditModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openEditModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-6 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-lg font-bold text-[#1E1B4B]">Edit Agenda Kegiatan</h3>
                <button type="button" @click="openEditModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form :action="'/guru/calendar/' + (selectedEvent ? selectedEvent.id : '')" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Kegiatan / Agenda</label>
                    <input type="text" name="title" x-model="formTitle" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tanggal Pelaksanaan</label>
                        <input type="date" name="event_date" x-model="formDate" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Kategori Kegiatan</label>
                        <select name="category" x-model="formCategory" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                            <option value="Konseling">Konseling</option>
                            <option value="Bimbingan Klasikal">Bimbingan Klasikal</option>
                            <option value="Home Visit">Home Visit</option>
                            <option value="Asesmen">Asesmen</option>
                            <option value="Rapat">Rapat / Evaluasi</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Jam Mulai</label>
                        <input type="text" name="start_time" x-model="formStartTime" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Jam Selesai</label>
                        <input type="text" name="end_time" x-model="formEndTime" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Lokasi / Ruangan</label>
                    <input type="text" name="location" x-model="formLocation" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Keterangan / Uraian Agenda</label>
                    <textarea name="description" x-model="formDescription" rows="3" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-[#E2E8F0]">
                    <button type="button" @click="openEditModal = false" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL DETAIL AGENDA / KONSELING -->
    <div x-show="openDetailModal" x-cloak class="fixed inset-0 z-[9999] overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openDetailModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-5 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-2">
                    <span :class="getCategoryBadgeClass(selectedEvent?.category)" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase" x-text="selectedEvent?.category"></span>
                    <span class="text-xs font-bold text-[#64748B]" x-text="selectedEvent?.date"></span>
                </div>
                <button type="button" @click="openDetailModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <div class="space-y-4">
                <h3 class="text-lg font-extrabold text-[#1E1B4B]" x-text="selectedEvent?.title"></h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs bg-[#F8FAFF] p-3.5 rounded-2xl border border-[#E2E8F0]">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block">Waktu / Jam</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="(selectedEvent?.start_time || '-') + (selectedEvent?.end_time ? ' - ' + selectedEvent?.end_time : '') + ' WIB'"></span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block">Lokasi / Tempat</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="selectedEvent?.location || 'Ruang BK'"></span>
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold text-[#64748B] block mb-1">Keterangan / Rincian:</span>
                    <p class="text-xs text-[#1E293B] leading-relaxed bg-white p-3 rounded-2xl border border-[#E2E8F0] whitespace-pre-line" x-text="selectedEvent?.description || 'Tidak ada uraian tambahan.'"></p>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 pt-3 border-t border-[#E2E8F0]">
                <template x-if="selectedEvent?.source_type === 'counseling'">
                    <a href="{{ route('guru.counseling.index') }}" class="px-4 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-xs font-bold rounded-xl shadow-xs transition-all flex items-center gap-1.5">
                        <span>Buka di Menu Konseling</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </template>
                <template x-if="selectedEvent?.source_type === 'event'">
                    <button type="button" @click="openEdit(selectedEvent)" class="px-4 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-xs font-bold rounded-xl shadow-xs transition-all">
                        Edit Agenda
                    </button>
                </template>
                <button type="button" @click="openDetailModal = false" class="px-4 py-2 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#64748B] text-xs font-bold rounded-xl transition-all">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection