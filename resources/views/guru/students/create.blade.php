@extends('layouts.app')

@section('title', 'Tambah Siswa - SIM-BK')

@section('content')
<div class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-4xl mx-auto bg-white">
    
    <div class="mb-6">
        <a href="/guru/students" class="px-4 py-2 bg-white hover:bg-[#F8FAFF] text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-xl transition-all shadow-2xs inline-flex items-center gap-2 mb-3">
            <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Data Siswa</span>
        </a>
        <h2 class="text-2xl font-bold text-[#1E1B4B]">Tambah Siswa Baru</h2>
        <p class="text-[#64748B] text-sm font-medium">Masukkan informasi lengkap siswa beserta akun aksesnya.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl">
            <p class="font-bold text-xs mb-1">Gagal Menyimpan Data Siswa:</p>
            <ul class="list-disc list-inside text-xs space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs p-6 md:p-8">
        <form action="/guru/students" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">NIS</label>
                    <input type="text" name="nis" value="{{ old('nis') }}" required class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Email Siswa (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Opsional (misal: nama@gmail.com)" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    <span class="text-[10px] text-[#64748B] mt-1 block">*Jika dikosongkan, siswa tetap bisa login menggunakan NIS.</span>
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Kelas</label>
                    <select name="kelas" required class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B] font-medium">
                        <option value="">Pilih Kelas</option>
                        @foreach(['X', 'XI', 'XII'] as $tingkat)
                            <optgroup label="Tingkat {{ $tingkat }}">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $tingkat }}-{{ $i }}">Kelas {{ $tingkat }}-{{ $i }}</option>
                                @endfor
                            </optgroup>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nomor Telepon / WhatsApp (Opsional)</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="081234567890" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nomor Telepon Orang Tua (Opsional)</label>
                    <input type="text" name="nomor_telepon_orang_tua" value="{{ old('nomor_telepon_orang_tua') }}" placeholder="081234567890" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Alamat Lengkap (Opsional)</label>
                <textarea name="alamat" rows="3" placeholder="Alamat domisili atau tempat tinggal siswa..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">{{ old('alamat') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#E2E8F0]">
                <a href="/guru/students" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] text-sm font-bold rounded-xl border border-[#E2E8F0] transition-all">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-sm font-bold rounded-xl border border-[#8E90FF] shadow-xs transition-all cursor-pointer">Simpan Data Siswa</button>
            </div>
        </form>
    </div>

</div>
@endsection