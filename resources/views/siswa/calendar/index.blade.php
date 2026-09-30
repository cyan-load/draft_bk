@extends('layouts.student')

@section('title', 'Kalender & Agenda BK Siswa - SIM-BK')

@section('content')
<div x-data="{
        currentYear: new Date().getFullYear(),
        currentMonth: new Date().getMonth(),
        selectedDateStr: '{{ date('Y-m-d') }}',
        filterType: 'all', // 'all', 'counseling', 'event'

        items: {{ Js::from($calendarItems) }},
        selectedItem: null,
        openDetailModal: false,

        monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],

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
            this.selectedDateStr = now.toISOString().split('T')[0];
        },

        get calendarDays() {
            const firstDayIndex = new Date(this.currentYear, this.currentMonth, 1).getDay();
            const startOffset = (firstDayIndex + 6) % 7;
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(this.currentYear, this.currentMonth, 0).getDate();

            const days = [];

            for (let i = startOffset - 1; i >= 0; i--) {
                const dayNum = daysInPrevMonth - i;
                const prevMonth = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
                const prevYear = this.currentMonth === 0 ? this.currentYear - 1 : this.currentYear;
                const dateStr = `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(dayNum).padStart(2, '0')}`;
                days.push({
                    dayNum: dayNum,
                    dateStr: dateStr,
                    isCurrentMonth: false,
                    isToday: dateStr === new Date().toISOString().split('T')[0],
                    items: this.getItemsForDate(dateStr)
                });
            }

            for (let i = 1; i <= daysInMonth; i++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    dayNum: i,
                    dateStr: dateStr,
                    isCurrentMonth: true,
                    isToday: dateStr === new Date().toISOString().split('T')[0],
                    items: this.getItemsForDate(dateStr)
                });
            }

            const totalSlots = Math.ceil(days.length / 7) * 7;
            const nextDaysCount = totalSlots - days.length;
            for (let i = 1; i <= nextDaysCount; i++) {
                const nextMonth = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
                const nextYear = this.currentMonth === 11 ? this.currentYear + 1 : this.currentYear;
                const dateStr = `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                days.push({
                    dayNum: i,
                    dateStr: dateStr,
                    isCurrentMonth: false,
                    isToday: false,
                    items: this.getItemsForDate(dateStr)
                });
            }

            return days;
        },

        getItemsForDate(dateStr) {
            return this.items.filter(it => {
                const matchDate = it.date === dateStr;
                if (!matchDate) return false;
                if (this.filterType === 'all') return true;
                return it.type === this.filterType;
            });
        },

        get selectedDateItems() {
            return this.getItemsForDate(this.selectedDateStr);
        },

        formatDateIndo(dateStr) {
            if (!dateStr) return '-';
            const parts = dateStr.split('-');
            if (parts.length < 3) return dateStr;
            const day = parseInt(parts[2]);
            const mIndex = parseInt(parts[1]) - 1;
            const year = parts[0];
            return `${day} ${this.monthNames[mIndex]} ${year}`;
        },

        showDetail(item) {
            this.selectedItem = item;
            this.openDetailModal = true;
        }
    }" class="space-y-6 pb-12">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Kalender Kegiatan & Konseling</h2>
            <p class="text-xs md:text-sm text-[#64748B] mt-1 font-medium">Jadwal sesi temu konseling dan agenda bimbingan yang teragendakan untuk Anda.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('siswa.counseling.index') }}" class="w-full sm:w-auto justify-center px-4 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Ajukan Konseling</span>
            </a>
        </div>
    </div>

    <!-- Main Grid: Kalender & Detail Panel -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Kalender Box (Col 8) -->
        <div class="lg:col-span-8 bg-white border border-[#E2E8F0] rounded-3xl p-5 md:p-6 shadow-xs space-y-4">
            
            <!-- Controls Navigasi Bulan -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-[#E2E8F0]">
                <div class="flex items-center gap-3">
                    <h3 class="text-lg md:text-xl font-extrabold text-[#1E1B4B]" x-text="monthTitle"></h3>
                    <button @click="goToToday()" class="px-2.5 py-1 text-[11px] font-bold text-[#4338CA] bg-[#EEF2FF] hover:bg-[#E0E7FF] rounded-lg transition-all active:scale-95">
                        Hari Ini
                    </button>
                </div>
                
                <div class="flex items-center gap-2">
                    <!-- Filter Tipe -->
                    <select x-model="filterType" class="text-xs bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl px-3 py-1.5 font-semibold text-[#1E1B4B] outline-none">
                        <option value="all">Semua Agenda</option>
                        <option value="counseling">Jadwal Konseling Saya</option>
                        <option value="event">Agenda Umum BK</option>
                    </select>

                    <div class="flex items-center gap-1 bg-[#F8FAFF] p-1 rounded-xl border border-[#E2E8F0]">
                        <button @click="prevMonth()" class="p-1.5 hover:bg-white rounded-lg text-[#64748B] hover:text-[#1E1B4B] transition-all" title="Bulan Sebelumnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                        </button>
                        <button @click="nextMonth()" class="p-1.5 hover:bg-white rounded-lg text-[#64748B] hover:text-[#1E1B4B] transition-all" title="Bulan Berikutnya">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Header Hari -->
            <div class="grid grid-cols-7 gap-1 text-center">
                <template x-for="day in ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min']" :key="day">
                    <div class="py-2 text-[11px] font-bold text-[#64748B] uppercase tracking-wider" x-text="day"></div>
                </template>
            </div>

            <!-- Grid Hari dalam Bulan -->
            <div class="grid grid-cols-7 gap-1 md:gap-1.5">
                <template x-for="(day, idx) in calendarDays" :key="idx">
                    <div @click="selectedDateStr = day.dateStr"
                         :class="{
                             'bg-white border-[#E2E8F0] text-[#1E293B] hover:border-[#9FA1FF]': day.isCurrentMonth,
                             'bg-[#F8FAFF]/50 border-transparent text-[#94A3B8]': !day.isCurrentMonth,
                             'ring-2 ring-[#4338CA] ring-offset-1 font-extrabold': selectedDateStr === day.dateStr,
                             'bg-[#EEF2FF] border-[#C7D2FE]': day.isToday
                         }"
                         class="min-h-[64px] md:min-h-[85px] p-1.5 rounded-2xl border transition-all cursor-pointer flex flex-col justify-between">
                        
                        <div class="flex items-center justify-between">
                            <span :class="day.isToday ? 'w-5 h-5 rounded-full bg-[#4338CA] text-white flex items-center justify-center text-[10px] font-extrabold' : 'text-xs font-bold'" x-text="day.dayNum"></span>
                            <template x-if="day.items.length > 0">
                                <span class="text-[9px] px-1 py-0.2 bg-[#9FA1FF] text-[#1E1B4B] font-extrabold rounded-md md:hidden" x-text="day.items.length"></span>
                            </template>
                        </div>

                        <!-- Item Badges di Desktop -->
                        <div class="space-y-1 mt-1 hidden md:block overflow-hidden">
                            <template x-for="item in day.items.slice(0, 2)" :key="item.id">
                                <div @click.stop="showDetail(item)"
                                     :class="item.type === 'counseling' ? 'bg-[#9FA1FF]/25 text-[#1E1B4B] border-l-2 border-[#8E90FF]' : 'bg-[#E0E7FF] text-[#312E81] border-l-2 border-[#4338CA]'"
                                     class="text-[9px] px-1.5 py-0.5 rounded truncate font-bold leading-tight hover:opacity-80 transition-opacity">
                                    <span x-text="item.type === 'counseling' ? '🤝 ' + item.time : '📅 ' + item.title"></span>
                                </div>
                            </template>
                            <template x-if="day.items.length > 2">
                                <div class="text-[9px] text-[#64748B] font-bold pl-1" x-text="'+' + (day.items.length - 2) + ' lagi'"></div>
                            </template>
                        </div>

                        <!-- Dot Indicator di Mobile -->
                        <div class="flex items-center gap-1 md:hidden mt-auto justify-center">
                            <template x-for="item in day.items.slice(0, 3)" :key="item.id">
                                <div :class="item.type === 'counseling' ? 'bg-[#8E90FF]' : 'bg-[#4338CA]'" class="w-1.5 h-1.5 rounded-full"></div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Legenda -->
            <div class="flex flex-wrap items-center gap-4 pt-3 border-t border-[#E2E8F0] text-xs font-semibold text-[#64748B]">
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#8E90FF]"></span>
                    <span>Jadwal Konseling Saya</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#4338CA]"></span>
                    <span>Agenda Umum Kegiatan BK</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-[#C7D2FE]"></span>
                    <span>Hari Ini</span>
                </div>
            </div>
        </div>

        <!-- Detail Panel untuk Tanggal yang Dipilih (Col 4) -->
        <div class="lg:col-span-4 bg-white border border-[#E2E8F0] rounded-3xl p-5 md:p-6 shadow-xs space-y-4">
            <div class="border-b border-[#E2E8F0] pb-3">
                <span class="text-[11px] font-bold text-[#9FA1FF] uppercase tracking-wider block">Agenda Tanggal</span>
                <h4 class="text-base font-extrabold text-[#1E1B4B]" x-text="formatDateIndo(selectedDateStr)"></h4>
            </div>

            <div class="space-y-3 max-h-[500px] overflow-y-auto pr-1">
                <template x-if="selectedDateItems.length === 0">
                    <div class="text-center py-10 px-4 bg-[#F8FAFF] rounded-2xl border border-dashed border-[#CBD5E1]">
                        <svg class="w-8 h-8 text-[#94A3B8] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <p class="text-xs font-bold text-[#64748B]">Tidak ada agenda atau jadwal konseling pada tanggal ini.</p>
                        <p class="text-[11px] text-[#94A3B8] mt-1">Pilih tanggal lain atau ajukan konseling baru.</p>
                    </div>
                </template>

                <template x-for="item in selectedDateItems" :key="item.id">
                    <div @click="showDetail(item)"
                         :class="item.type === 'counseling' ? 'border-[#8E90FF]/40 bg-[#F8FAFF]' : 'border-[#C7D2FE] bg-white'"
                         class="p-4 rounded-2xl border hover:shadow-sm transition-all cursor-pointer space-y-2">
                        
                        <div class="flex items-center justify-between gap-2">
                            <span :class="item.type === 'counseling' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#E0E7FF] text-[#312E81]'"
                                  class="text-[10px] font-extrabold px-2 py-0.5 rounded-lg"
                                  x-text="item.type === 'counseling' ? '🤝 Konseling ' + (item.status === 'dijadwalkan ulang' ? '(Jadwal Ulang)' : '') : '📅 Agenda Sekolah'"></span>
                            
                            <span class="text-xs font-bold text-[#4338CA]" x-text="item.time"></span>
                        </div>

                        <h5 class="text-sm font-extrabold text-[#1E1B4B] line-clamp-1" x-text="item.title"></h5>

                        <div class="flex items-center gap-2 text-xs text-[#64748B] font-medium">
                            <svg class="w-3.5 h-3.5 shrink-0 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                            <span class="truncate" x-text="item.location"></span>
                        </div>

                        <template x-if="item.description">
                            <p class="text-xs text-[#64748B] line-clamp-2 bg-white/70 p-2 rounded-xl border border-[#E2E8F0]" x-text="item.description"></p>
                        </template>

                        <template x-if="item.note">
                            <div class="text-[11px] text-amber-800 bg-amber-50 p-2 rounded-xl border border-amber-200">
                                <span class="font-bold">Catatan Guru BK:</span>
                                <span x-text="item.note"></span>
                            </div>
                        </template>
                    </div>
                </template>
            </div>
        </div>

    </div>

    <!-- Modal Detail Agenda / Konseling -->
    <div x-show="openDetailModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-[#1E1B4B]/40 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openDetailModal = false" class="bg-white rounded-3xl max-w-lg w-full max-h-[90vh] overflow-y-auto p-5 sm:p-6 space-y-4 shadow-xl border border-[#E2E8F0]">
            <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-3">
                <span :class="selectedItem?.type === 'counseling' ? 'bg-[#9FA1FF] text-[#1E1B4B]' : 'bg-[#E0E7FF] text-[#312E81]'"
                      class="text-xs font-extrabold px-3 py-1 rounded-xl"
                      x-text="selectedItem?.type === 'counseling' ? '🤝 Konseling Siswa' : '📅 Agenda Sekolah'"></span>
                <button type="button" @click="openDetailModal = false" class="text-[#64748B] hover:text-[#1E1B4B] text-xl font-bold">&times;</button>
            </div>

            <div class="space-y-3">
                <h3 class="text-lg font-extrabold text-[#1E1B4B]" x-text="selectedItem?.title"></h3>
                
                <div class="grid grid-cols-2 gap-3 text-xs bg-[#F8FAFF] p-3 rounded-2xl border border-[#E2E8F0]">
                    <div>
                        <span class="text-[#64748B] font-semibold block text-[10px]">TANGGAL</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="formatDateIndo(selectedItem?.date)"></span>
                    </div>
                    <div>
                        <span class="text-[#64748B] font-semibold block text-[10px]">WAKTU</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="selectedItem?.time"></span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-[#64748B] font-semibold block text-[10px]">LOKASI / RUANG</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="selectedItem?.location"></span>
                    </div>
                </div>

                <div>
                    <span class="text-xs font-bold text-[#1E1B4B] block mb-1">Topik / Uraian:</span>
                    <p class="text-xs text-[#475569] bg-[#F8FAFF] p-3 rounded-2xl border border-[#E2E8F0] whitespace-pre-line" x-text="selectedItem?.description || '-'"></p>
                </div>

                <template x-if="selectedItem?.note">
                    <div class="p-3 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900">
                        <span class="font-bold block mb-1">Catatan Khusus dari Guru BK:</span>
                        <span x-text="selectedItem?.note"></span>
                    </div>
                </template>
            </div>

            <div class="flex justify-end pt-3 border-t border-[#E2E8F0]">
                <button type="button" @click="openDetailModal = false" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] font-bold text-xs rounded-xl transition-all cursor-pointer">
                    Tutup
                </button>
            </div>
        </div>
    </div>

</div>
@endsection
