@extends('layouts.app')

@section('title', 'Manajemen Kuisioner - SIM-BK')

@section('content')
<div class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto bg-white">
    
    <!-- Title & Create Button -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-[#1E1B4B] tracking-tight">Kuisioner & Asesmen</h2>
            <p class="text-[#64748B] mt-0.5 text-sm font-medium">Kelola instrumen angket, asesmen kebutuhan (AKPD), dan tes minat belajar siswa.</p>
        </div>
        <a href="{{ route('guru.questionnaires.create') }}" class="bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] text-sm font-bold px-5 py-2.5 rounded-xl border border-[#8E90FF] transition-all shadow-xs flex items-center justify-center gap-2 w-fit cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Buat Kuisioner Baru
        </a>
    </div>

    <!-- Filter Bar & Search Form -->
    <form method="GET" action="{{ route('guru.questionnaires.index') }}" class="bg-white rounded-3xl p-4 border border-[#E2E8F0] shadow-xs mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <!-- Filter Kelas -->
            <select name="kelas" onchange="this.form.submit()" class="px-3.5 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-bold text-[#1E1B4B] outline-none cursor-pointer">
                <option value="">Semua Kelas</option>
                <option value="Kelas 10" {{ request('kelas') == 'Kelas 10' ? 'selected' : '' }}>Kelas 10</option>
                <option value="Kelas 11" {{ request('kelas') == 'Kelas 11' ? 'selected' : '' }}>Kelas 11</option>
                <option value="Kelas 12" {{ request('kelas') == 'Kelas 12' ? 'selected' : '' }}>Kelas 12</option>
            </select>

            <!-- Filter Status -->
            <select name="status" onchange="this.form.submit()" class="px-3.5 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs font-bold text-[#1E1B4B] outline-none cursor-pointer">
                <option value="">Semua Status</option>
                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published (Aktif)</option>
                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="finished" {{ request('status') === 'finished' ? 'selected' : '' }}>Finished (Ditutup)</option>
            </select>

            @if(request()->anyFilled(['search', 'status', 'kelas']))
                <a href="{{ route('guru.questionnaires.index') }}" class="text-xs font-bold text-rose-600 hover:underline px-2">Reset Filter</a>
            @endif
        </div>
        
        <!-- Search Bar -->
        <div class="relative w-full md:w-72">
            <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#94A3B8]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </span>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul kuisioner..." class="w-full pl-9 pr-4 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] outline-none text-[#1E293B]">
        </div>
    </form>

    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl mb-6 flex items-center justify-between font-semibold">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
        </div>
    @endif

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($questionnaires as $q)
            <div class="bg-white rounded-3xl p-6 border border-[#E2E8F0] shadow-xs flex flex-col justify-between relative hover:shadow-md transition-shadow" x-data="{ openMenu: false }">
                <div>
                    <!-- Header Card: Status & Three Dots Menu -->
                    <div class="flex items-center justify-between mb-3">
                        @if($q->status === 'published' || ($q->status === null && $q->is_active))
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Published
                            </span>
                        @elseif($q->status === 'finished')
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Finished (Ditutup)</span>
                            </span>
                        @else
                            <span class="px-2.5 py-1 rounded-lg text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                <span>Draft</span>
                            </span>
                        @endif

                        <!-- Three Dots Dropdown -->
                        <div class="relative">
                            <button @click="openMenu = !openMenu" type="button" class="text-[#64748B] hover:text-[#1E1B4B] p-1.5 rounded-xl hover:bg-[#F8FAFF] transition-colors cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                            </button>

                            <!-- Dropdown Menu Content -->
                            <div x-show="openMenu" @click.away="openMenu = false" x-cloak class="absolute right-0 mt-2 w-52 bg-white border border-[#E2E8F0] rounded-2xl shadow-xl py-1.5 z-20 text-xs">
                                <a href="{{ route('guru.questionnaires.show', $q->id) }}" class="block px-4 py-2 font-bold text-[#1E1B4B] hover:bg-[#F8FAFF]">Lihat Hasil & Respon</a>
                                <a href="{{ route('guru.questionnaires.export_excel', $q->id) }}" class="block px-4 py-2 font-semibold text-emerald-700 hover:bg-emerald-50">Ekspor Excel (.csv)</a>
                                <a href="{{ route('guru.questionnaires.print_all', $q->id) }}" target="_blank" class="block px-4 py-2 font-semibold text-[#1E1B4B] hover:bg-[#F8FAFF]">Cetak Rekap (PDF)</a>
                                
                                <div class="border-t border-[#E2E8F0] my-1"></div>
                                <div class="px-4 py-1 text-[10px] font-bold uppercase text-[#64748B]">Ubah Status:</div>
                                @if($q->status !== 'published')
                                    <form action="{{ route('guru.questionnaires.update_status', $q->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="published">
                                        <button type="submit" class="w-full text-left px-4 py-1.5 font-semibold text-emerald-700 hover:bg-emerald-50 cursor-pointer">Publikasikan (Published)</button>
                                    </form>
                                @endif
                                @if($q->status !== 'finished')
                                    <form action="{{ route('guru.questionnaires.update_status', $q->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="finished">
                                        <button type="submit" class="w-full text-left px-4 py-1.5 font-semibold text-indigo-700 hover:bg-indigo-50 cursor-pointer">Tutup Kuisioner (Finished)</button>
                                    </form>
                                @endif
                                @if($q->status !== 'draft')
                                    <form action="{{ route('guru.questionnaires.update_status', $q->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="status" value="draft">
                                        <button type="submit" class="w-full text-left px-4 py-1.5 font-semibold text-slate-600 hover:bg-slate-50 cursor-pointer">Jadikan Draft</button>
                                    </form>
                                @endif

                                <div class="border-t border-[#E2E8F0] my-1"></div>
                                <a href="{{ route('guru.questionnaires.preview', $q->id) }}" target="_blank" class="block px-4 py-2 font-semibold text-[#1E1B4B] hover:bg-[#F8FAFF]">Preview Soal</a>
                                <a href="{{ route('guru.questionnaires.edit', $q->id) }}" class="block px-4 py-2 font-semibold text-[#1E1B4B] hover:bg-[#F8FAFF]">Edit Kuisioner</a>
                                <form action="{{ route('guru.questionnaires.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kuisioner ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-full text-left px-4 py-2 font-semibold text-rose-600 hover:bg-rose-50 cursor-pointer">Hapus Kuisioner</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Title & Description -->
                    <h3 class="font-bold text-[#1E1B4B] text-base mb-1">{{ $q->title ?? $q->judul }}</h3>
                    <p class="text-[#64748B] text-xs leading-relaxed mb-6 line-clamp-2">
                        {{ $q->description ?? $q->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                <!-- Card Footer / Details -->
                <div>
                    <div class="bg-[#F8FAFF] rounded-2xl p-3.5 mb-4 space-y-1.5 border border-[#E2E8F0]">
                        <div class="flex justify-between text-xs">
                            <span class="text-[#64748B] font-medium">Target:</span>
                            <span class="font-bold text-[#1E1B4B]">{{ $q->target_kelas }}</span>
                        </div>
                        <div class="flex justify-between text-xs">
                            <span class="text-[#64748B] font-medium">Pertanyaan:</span>
                            <span class="font-bold text-[#1E1B4B]">{{ $q->questions_count ?? count($q->questions) }} Soal</span>
                        </div>
                        <div class="flex justify-between text-xs pt-1 border-t border-[#E2E8F0]">
                            <span class="text-[#64748B] font-medium">Siswa Mengisi:</span>
                            <span class="font-bold text-[#14532D]">{{ $q->respondents_count ?? 0 }} Siswa</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('guru.questionnaires.preview', $q->id) }}" target="_blank" class="py-2.5 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center justify-center gap-1.5 cursor-pointer">
                            <svg class="w-3.5 h-3.5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Preview
                        </a>
                        <a href="{{ route('guru.questionnaires.show', $q->id) }}" class="py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] rounded-xl text-xs font-bold transition-all shadow-xs flex items-center justify-center gap-1.5 cursor-pointer">
                            Hasil & Respon
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-[#E2E8F0] shadow-xs my-4">
                <div class="w-16 h-16 bg-[#9FA1FF]/20 text-[#1E1B4B] border border-[#9FA1FF]/40 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-[#1E1B4B] mb-1">Tidak Ada Kuisioner Ditemukan</h3>
                <p class="text-xs text-[#64748B] max-w-sm mx-auto mb-6 leading-relaxed">
                    {{ request()->anyFilled(['search', 'status', 'kelas']) ? 'Tidak ada data yang cocok dengan kriteria pencarian/filter Anda.' : 'Anda belum membuat kuisioner apa pun.' }}
                </p>
                <a href="{{ route('guru.questionnaires.create') }}" class="inline-flex items-center gap-2 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] text-xs font-bold px-5 py-2.5 rounded-xl border border-[#8E90FF] shadow-xs transition-all cursor-pointer">
                    Buat Kuisioner Baru
                </a>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $questionnaires->links() }}
    </div>
</div>
@endsection