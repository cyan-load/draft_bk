@extends('layouts.student')

@section('title', 'Profil Saya - SIM-BK')

@section('content')

<div class="max-w-6xl mx-auto space-y-8 pb-12 bg-white">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Profil Siswa</h2>
            <p class="text-[#64748B] mt-0.5 text-sm font-medium">Kelola informasi pribadi, data akademik, dan informasi orang tua/wali Anda.</p>
        </div>
        <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <button type="button" @click="$dispatch('open-password-modal')" class="flex-1 sm:flex-initial justify-center px-4 sm:px-5 py-2.5 bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl shadow-2xs flex items-center gap-2 transition-all cursor-pointer">
                <svg class="w-4 h-4 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                <span>Ubah Kata Sandi</span>
            </button>
            <a href="{{ route('siswa.profile.edit') }}" class="flex-1 sm:flex-initial justify-center px-4 sm:px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs flex items-center gap-2 transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Profil</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="flex items-center gap-5">
            <div class="w-24 h-24 rounded-2xl bg-[#9FA1FF] border-2 border-white shadow-md overflow-hidden shrink-0 flex items-center justify-center text-[#1E1B4B]">
                @if(!empty($student->foto))
                    <img src="{{ asset('storage/' . $student->foto) }}" alt="Foto Siswa" class="w-full h-full object-cover">
                @else
                    <span class="text-2xl font-black">{{ strtoupper(substr($student->nama ?? 'S', 0, 2)) }}</span>
                @endif
            </div>

            <div>
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-xl font-bold text-[#1E1B4B]">{{ $student->nama }}</h3>
                    <span class="bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">Siswa Aktif</span>
                </div>
                <p class="text-xs text-[#64748B] font-semibold mb-3">NIS: {{ $student->nis ?? '-' }}</p>
                
                <div class="flex flex-wrap items-center gap-2">
                    <div class="bg-[#F8FAFF] border border-[#E2E8F0] px-3 py-1 rounded-xl text-xs font-bold text-[#1E1B4B] flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Kelas {{ $student->kelas }}
                    </div>
                    <div class="bg-[#B5BAFF]/30 border border-[#B5BAFF] px-3 py-1 rounded-xl text-xs font-bold text-[#1E1B4B] flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Tahun Masuk: {{ $student->created_at ? $student->created_at->format('Y') : date('Y') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <div class="lg:col-span-8 bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-[#E2E8F0]">
                    <h4 class="font-bold text-[#1E1B4B] text-base flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-[#9FA1FF]/20 flex items-center justify-center text-[#1E1B4B]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        Data Pribadi
                    </h4>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">Tempat, Tanggal Lahir</span>
                        <div class="text-sm font-semibold text-[#1E1B4B] py-1.5">
                            {{ $student->tempat_lahir ?? '-' }}, {{ $student->tanggal_lahir ? date('d F Y', strtotime($student->tanggal_lahir)) : '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">Jenis Kelamin</span>
                        <div class="text-sm font-semibold text-[#1E1B4B] py-1.5">
                            {{ $student->jenis_kelamin ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">Agama</span>
                        <div class="text-sm font-semibold text-[#1E1B4B] py-1.5">
                            {{ $student->agama ?? '-' }}
                        </div>
                    </div>

                    <div>
                        <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">No. Telepon / HP</span>
                        <div class="text-sm font-semibold text-[#1E1B4B] py-1.5">
                            {{ $student->nomor_telepon ?? '-' }}
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">Email Siswa</span>
                        <div class="text-sm font-semibold text-[#1E1B4B] py-1.5">
                            {{ $student->email ?? Auth::user()->email ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4 bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-[#E2E8F0]">
                    <h4 class="font-bold text-[#1E1B4B] text-base flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-[#AEE2FF]/40 flex items-center justify-center text-[#0369A1]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        Alamat Domisili
                    </h4>
                </div>

                <span class="block text-[11px] font-bold text-[#64748B] uppercase tracking-wider mb-1">Alamat Lengkap</span>
                <div class="text-sm font-medium text-[#475569] leading-relaxed py-1.5">
                    {{ $student->alamat ?? 'Belum diisi.' }}
                </div>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-[#E2E8F0]">
            <h4 class="font-bold text-[#1E1B4B] text-base flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-[#9FA1FF]/20 flex items-center justify-center text-[#1E1B4B]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                Minat & Bakat
            </h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl p-5 space-y-2">
                <span class="text-xs font-bold text-[#1E1B4B] uppercase tracking-wider block">Hobi / Kegemaran</span>
                <div class="text-sm font-bold text-[#1E1B4B]">{{ $student->hobi ?? '-' }}</div>
            </div>

            <div class="bg-[#B5BAFF]/20 border border-[#B5BAFF] rounded-2xl p-5 space-y-2">
                <span class="text-xs font-bold text-[#1E1B4B] uppercase tracking-wider block">Cita-Cita / Karir Impian</span>
                <div class="text-sm font-bold text-[#1E1B4B]">{{ $student->cita_cita ?? '-' }}</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs">
        <div class="flex items-center justify-between mb-6 pb-3 border-b border-[#E2E8F0]">
            <h4 class="font-bold text-[#1E1B4B] text-base flex items-center gap-2">
                <div class="w-7 h-7 rounded-lg bg-[#AEE2FF]/40 flex items-center justify-center text-[#0369A1]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                Data Orang Tua / Wali
            </h4>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl p-5 space-y-2">
                <span class="text-xs font-bold text-[#1E1B4B] uppercase tracking-wider block">Data Ayah</span>
                <div>
                    <span class="text-[10px] font-bold text-[#64748B] uppercase">Nama Lengkap</span>
                    <div class="text-sm font-bold text-[#1E1B4B]">{{ $student->nama_ayah ?? '-' }}</div>
                </div>
            </div>

            <div class="bg-[#B5BAFF]/20 border border-[#B5BAFF] rounded-2xl p-5 space-y-2">
                <span class="text-xs font-bold text-[#1E1B4B] uppercase tracking-wider block">Data Ibu</span>
                <div>
                    <span class="text-[10px] font-bold text-[#64748B] uppercase">Nama Lengkap</span>
                    <div class="text-sm font-bold text-[#1E1B4B]">{{ $student->nama_ibu ?? '-' }}</div>
                </div>
            </div>

            <div class="md:col-span-2">
                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block mb-1">Nomor Kontak Orang Tua / Wali</span>
                <div class="text-sm font-semibold text-[#1E1B4B] py-1">{{ $student->nomor_telepon_orang_tua ?? '-' }}</div>
            </div>
        </div>
    </div>

</div>

@endsection