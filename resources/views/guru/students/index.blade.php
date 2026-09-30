@extends('layouts.app')

@section('title', 'Data Siswa - SIM-BK')

@section('content')
<div class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto bg-white">
    
    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-[#1E1B4B]">Data Siswa Bimbingan</h2>
            <p class="text-[#64748B] text-sm mt-1 font-medium">Kelola data profil, rekam jejak bimbingan, dan akun login siswa.</p>
        </div>
        <a href="/guru/students/create" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] text-sm font-bold rounded-xl border border-[#8E90FF] transition-all shadow-xs cursor-pointer">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Siswa Baru
        </a>
    </div>

    <!-- Alert Notifikasi -->
    @if (session('success'))
    <div class="mb-6 p-4 bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] rounded-2xl flex items-center gap-3 font-semibold">
        <svg class="w-5 h-5 text-[#14532D]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span class="text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-3xl border border-[#E2E8F0] shadow-xs mb-6">
        <form action="/guru/students" method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <svg class="w-5 h-5 text-[#94A3B8] absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa atau NIS..." class="w-full pl-11 pr-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
            </div>
            <div class="md:w-56">
                <select name="kelas" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B] font-medium">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $kelas)
                        <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>Kelas {{ $kelas }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F8FAFF] border-b border-[#E2E8F0] text-xs uppercase tracking-wider text-[#64748B] font-bold">
                        <th class="p-4 pl-6">NIS</th>
                        <th class="p-4">Nama Siswa</th>
                        <th class="p-4">Kelas</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">No. Telepon</th>
                        <th class="p-4 pr-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-[#1E293B] divide-y divide-[#E2E8F0]">
                    @forelse ($students as $student)
                    <tr class="hover:bg-[#F8FAFF] transition-colors">
                        <td class="p-4 pl-6 font-bold text-[#1E1B4B]">{{ $student->nis }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl bg-[#9FA1FF] text-[#1E1B4B] border border-[#8E90FF] flex items-center justify-center font-bold text-xs shrink-0 overflow-hidden shadow-2xs">
                                    @if(!empty($student->foto))
                                        <img src="{{ asset('storage/' . $student->foto) }}" alt="Foto" class="w-full h-full object-cover">
                                    @else
                                        <span>{{ strtoupper(substr($student->nama, 0, 2)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-[#1E1B4B] hover:text-[#9FA1FF]">
                                        <a href="/guru/students/{{ $student->id }}">{{ $student->nama }}</a>
                                    </div>
                                    <div class="text-xs text-[#64748B]">{{ $student->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] rounded-lg font-bold text-xs">
                                {{ $student->kelas }}
                            </span>
                        </td>
                        <td class="p-4">
                            @if($student->status == 'aktif')
                                <span class="px-2.5 py-1 bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] rounded-lg font-bold text-xs">Aktif</span>
                            @elseif($student->status == 'lulus')
                                <span class="px-2.5 py-1 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-lg font-bold text-xs">Lulus</span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 border border-amber-200 rounded-lg font-bold text-xs">Pindah</span>
                            @endif
                        </td>
                        <td class="p-4 font-medium text-[#64748B]">{{ $student->nomor_telepon ?? '-' }}</td>
                        <td class="p-4 pr-6">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Tombol Detail / Lihat Profil & Jawaban -->
                                <a href="/guru/students/{{ $student->id }}" class="p-2 bg-white text-[#1E1B4B] border border-[#E2E8F0] hover:bg-[#F8FAFF] active:scale-95 rounded-xl transition-all shadow-2xs cursor-pointer" title="Lihat Profil & Riwayat Jawaban">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                 </a>

                                 <!-- Tombol Edit -->
                                 <a href="/guru/students/{{ $student->id }}/edit" class="p-2 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] hover:bg-[#B5BAFF] active:scale-95 rounded-xl transition-all shadow-2xs cursor-pointer" title="Edit Data">
                                     <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                 </a>
                                 
                                 <!-- Tombol Hapus -->
                                 <form action="/guru/students/{{ $student->id }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini? Akun loginnya juga akan ikut terhapus.');">
                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="p-2 bg-rose-50 text-rose-600 border border-rose-200 hover:bg-rose-100 active:scale-95 rounded-xl transition-all shadow-2xs cursor-pointer" title="Hapus">
                                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                     </button>
                                 </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-[#64748B]">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-[#94A3B8] mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="font-bold text-[#1E1B4B]">Belum ada data siswa.</p>
                                <p class="text-xs mt-1">Silakan tambah data siswa baru menggunakan tombol di atas.</p>
                            </div>
                        </td>
                    </tr>
                    @endempty
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($students->hasPages())
        <div class="p-4 border-t border-[#E2E8F0]">
            {{ $students->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

</div>
@endsection