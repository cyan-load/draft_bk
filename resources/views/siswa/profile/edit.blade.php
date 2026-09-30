@extends('layouts.student')

@section('title', 'Edit Profil - SIM-BK')

@section('content')

<div class="max-w-4xl mx-auto space-y-6 pb-16 bg-white">
    
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-[#1E1B4B]">Edit Profil Siswa</h2>
            <p class="text-[#64748B] text-xs mt-0.5">Perbarui informasi data diri dan keluarga Anda di bawah ini.</p>
        </div>
        <a href="{{ route('siswa.profile.index') }}" class="px-4 py-2 bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-xl transition-all shadow-2xs inline-flex items-center gap-2 cursor-pointer">
            <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 text-rose-700 text-xs rounded-2xl border border-rose-200">
            <ul class="list-disc pl-4 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('siswa.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs space-y-6">
            <h3 class="font-bold text-[#1E1B4B] text-base pb-3 border-b border-[#E2E8F0]">Informasi Utama Siswa</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $student->nama) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Foto Profil</label>
                    <input type="file" name="foto" class="w-full px-3 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-xs text-[#64748B] file:mr-4 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#9FA1FF] file:text-[#1E1B4B] hover:file:bg-[#8E90FF]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $student->tempat_lahir) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $student->tanggal_lahir) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B] cursor-pointer">
                        <option value="Laki-laki" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Agama</label>
                    <input type="text" name="agama" value="{{ old('agama', $student->agama) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nomor Telepon / HP</label>
                    <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon', $student->nomor_telepon) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Alamat Lengkap Domisili</label>
                    <textarea name="alamat" rows="3" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">{{ old('alamat', $student->alamat) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs space-y-6">
            <h3 class="font-bold text-[#1E1B4B] text-base pb-3 border-b border-[#E2E8F0]">Minat & Bakat</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Hobi / Kegemaran</label>
                    <input type="text" name="hobi" value="{{ old('hobi', $student->hobi) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Cita-Cita / Profesi Impian</label>
                    <input type="text" name="cita_cita" value="{{ old('cita_cita', $student->cita_cita) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-[#E2E8F0] p-5 sm:p-8 shadow-xs space-y-6">
            <h3 class="font-bold text-[#1E1B4B] text-base pb-3 border-b border-[#E2E8F0]">Data Orang Tua / Wali</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Ayah</label>
                    <input type="text" name="nama_ayah" value="{{ old('nama_ayah', $student->nama_ayah) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Ibu</label>
                    <input type="text" name="nama_ibu" value="{{ old('nama_ibu', $student->nama_ibu) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">No. Kontak Orang Tua / Wali</label>
                    <input type="text" name="nomor_telepon_orang_tua" value="{{ old('nomor_telepon_orang_tua', $student->nomor_telepon_orang_tua) }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-3 pt-2">
            <a href="{{ route('siswa.profile.index') }}" class="w-full sm:w-auto text-center px-6 py-3 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl transition-all cursor-pointer">
                Batal
            </a>
            <button type="submit" class="w-full sm:w-auto text-center px-8 py-3 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                Simpan Perubahan Data
            </button>
        </div>

    </form>

</div>

@endsection