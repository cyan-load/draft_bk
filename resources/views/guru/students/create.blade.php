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
        <p class="text-[#64748B] text-sm font-medium">Masukkan informasi lengkap siswa beserta data orang tua, minat, dan bakat.</p>
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
        <form action="/guru/students" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Bagian 1: Informasi Utama & Akun -->
            <div>
                <h3 class="text-sm font-bold text-[#1E1B4B] uppercase tracking-wider mb-4 pb-2 border-b border-[#E2E8F0] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Informasi Akun & Akademik</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">NIS <span class="text-rose-500">*</span></label>
                        <input type="text" name="nis" value="{{ old('nis') }}" required placeholder="Nomor Induk Siswa" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                        <span class="text-[11px] text-[#64748B] mt-1 block">NIS akan digunakan sebagai username default login siswa.</span>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Nama lengkap siswa" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Kelas <span class="text-rose-500">*</span></label>
                        <select name="kelas" required class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B] font-medium">
                            <option value="">Pilih Kelas</option>
                            @foreach(['X', 'XI', 'XII'] as $tingkat)
                                <optgroup label="Tingkat {{ $tingkat }}">
                                    @for($i = 1; $i <= 12; $i++)
                                        @php $kVal = $tingkat . '-' . $i; @endphp
                                        <option value="{{ $kVal }}" {{ old('kelas') == $kVal ? 'selected' : '' }}>Kelas {{ $kVal }}</option>
                                    @endfor
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Email Siswa (Opsional)</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="siswa@sekolah.sch.id" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Foto Profil Siswa (Opsional)</label>
                        <input type="file" name="foto" accept="image/*" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs text-[#64748B] file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#9FA1FF] file:text-[#1E1B4B] hover:file:bg-[#8E90FF]">
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Data Pribadi -->
            <div>
                <h3 class="text-sm font-bold text-[#1E1B4B] uppercase tracking-wider mb-4 pb-2 border-b border-[#E2E8F0] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                    <span>Data Pribadi</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Agama</label>
                        <select name="agama" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                            <option value="">-- Pilih Agama --</option>
                            @foreach(['Islam', 'Kristen Protestan', 'Kristen Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $agm)
                                <option value="{{ $agm }}" {{ old('agama') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}" placeholder="Kota kelahiran" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                </div>
            </div>

            <!-- Bagian 3: Informasi Orang Tua / Wali -->
            <div>
                <h3 class="text-sm font-bold text-[#1E1B4B] uppercase tracking-wider mb-4 pb-2 border-b border-[#E2E8F0] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Informasi Orang Tua / Wali</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nama Ayah</label>
                        <input type="text" name="nama_ayah" value="{{ old('nama_ayah') }}" placeholder="Nama lengkap ayah" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nama Ibu</label>
                        <input type="text" name="nama_ibu" value="{{ old('nama_ibu') }}" placeholder="Nama lengkap ibu" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nomor Telepon Orang Tua / Wali</label>
                        <input type="text" name="nomor_telepon_orang_tua" value="{{ old('nomor_telepon_orang_tua') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                </div>
            </div>

            <!-- Bagian 4: Minat, Bakat & Kontak -->
            <div>
                <h3 class="text-sm font-bold text-[#1E1B4B] uppercase tracking-wider mb-4 pb-2 border-b border-[#E2E8F0] flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#4338CA]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    <span>Minat, Bakat & Alamat</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Nomor Telepon / WhatsApp Siswa</label>
                        <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="08xxxxxxxxxx" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Hobi / Minat & Bakat</label>
                        <input type="text" name="hobi" value="{{ old('hobi') }}" placeholder="Contoh: Robotik, Musik, Olahraga, Menggambar" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Cita-Cita / Orientasi Masa Depan</label>
                        <input type="text" name="cita_cita" value="{{ old('cita_cita') }}" placeholder="Contoh: Teknik Informatika, Dokter, Desainer Grafis" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Alamat Lengkap</label>
                        <textarea name="alamat" rows="3" placeholder="Alamat domisili atau tempat tinggal siswa..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF] focus:bg-white text-[#1E293B]">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-5 border-t border-[#E2E8F0]">
                <a href="/guru/students" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] text-sm font-bold rounded-xl border border-[#E2E8F0] transition-all">Batal</a>
                <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-sm font-bold rounded-xl border border-[#8E90FF] shadow-xs transition-all cursor-pointer">Simpan Data Siswa</button>
            </div>
        </form>
    </div>

</div>
@endsection