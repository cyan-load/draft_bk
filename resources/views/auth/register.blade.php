<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Siswa - SIM-BK</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#9FA1FF',
                        'primary-hover': '#8E90FF',
                        'primary-dark': '#7D80F5',
                        'primary-text': '#1E1B4B',
                        secondary: '#B5BAFF',
                        'secondary-hover': '#A4AAFF',
                        'secondary-text': '#1E1B4B',
                        accent: '#AEE2FF',
                        mint: '#D9F9DF',
                        'app-bg': '#FFFFFF',
                        surface: '#F8FAFF',
                        'surface-border': '#E2E8F0',
                    }
                }
            }
        }
    </script>
    <!-- Alpine.js untuk Animasi & State Stepper -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }</style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">

    <!-- CONTAINER UTAMA -->
    <div x-data="{ step: 1 }" class="bg-white rounded-3xl shadow-xl w-full max-w-4xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-[#E2E8F0] transition-all duration-300">
        
        <!-- KOLOM KIRI: PANEL STEPPER & INFORMASI -->
        <div class="md:col-span-5 bg-gradient-to-b from-[#B5BAFF]/30 via-[#AEE2FF]/20 to-[#D9F9DF]/30 text-[#1E1B4B] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden border-b md:border-b-0 md:border-r border-[#E2E8F0]">
            
            <!-- Efek Lingkaran Dekoratif -->
            <div class="absolute -right-12 -top-12 w-48 h-48 bg-[#9FA1FF]/20 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Header Sidebar -->
            <div>
                <div class="font-extrabold text-xl tracking-tight mb-6 text-[#1E1B4B] flex items-center gap-2">
                    <span class="w-8 h-8 bg-[#9FA1FF] border border-[#8E90FF] rounded-xl flex items-center justify-center text-xs shadow-xs text-[#1E1B4B]">BK</span>
                    SIM-BK
                </div>
                <h2 class="text-2xl font-bold tracking-tight mb-2 text-[#1E1B4B]">Pendaftaran Siswa</h2>
                <p class="text-[#475569] text-xs leading-relaxed font-medium">
                    Mulai perjalanan bimbingan dan konseling Anda bersama kami. Silakan lengkapi data diri Anda.
                </p>
            </div>

            <!-- Stepper List (4 Tahap) -->
            <div class="space-y-5 my-8 relative">
                <!-- Garis Penghubung Vertikal -->
                <div class="absolute left-4 top-3 bottom-3 w-0.5 bg-[#CBD5E1] -z-0"></div>

                <!-- Step 1 -->
                <div class="flex items-center space-x-4 relative z-10">
                    <div :class="step === 1 ? 'bg-[#9FA1FF] text-[#1E1B4B] font-bold shadow-md ring-4 ring-[#9FA1FF]/30 border border-[#8E90FF]' : (step > 1 ? 'bg-[#AEE2FF] text-[#0369A1] font-bold border border-[#7DD3FC]' : 'bg-white text-[#64748B] border border-[#E2E8F0]')" 
                         class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300">
                        <span x-show="step > 1">&check;</span>
                        <span x-show="step <= 1">1</span>
                    </div>
                    <div>
                        <span :class="step === 1 ? 'text-[#1E1B4B] font-bold' : 'text-[#64748B] font-medium'" class="text-sm transition-colors">Data Akun</span>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="flex items-center space-x-4 relative z-10">
                    <div :class="step === 2 ? 'bg-[#9FA1FF] text-[#1E1B4B] font-bold shadow-md ring-4 ring-[#9FA1FF]/30 border border-[#8E90FF]' : (step > 2 ? 'bg-[#AEE2FF] text-[#0369A1] font-bold border border-[#7DD3FC]' : 'bg-white text-[#64748B] border border-[#E2E8F0]')" 
                         class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300">
                        <span x-show="step > 2">&check;</span>
                        <span x-show="step <= 2">2</span>
                    </div>
                    <div>
                        <span :class="step === 2 ? 'text-[#1E1B4B] font-bold' : 'text-[#64748B] font-medium'" class="text-sm transition-colors">Data Diri</span>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="flex items-center space-x-4 relative z-10">
                    <div :class="step === 3 ? 'bg-[#9FA1FF] text-[#1E1B4B] font-bold shadow-md ring-4 ring-[#9FA1FF]/30 border border-[#8E90FF]' : (step > 3 ? 'bg-[#AEE2FF] text-[#0369A1] font-bold border border-[#7DD3FC]' : 'bg-white text-[#64748B] border border-[#E2E8F0]')" 
                         class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300">
                        <span x-show="step > 3">&check;</span>
                        <span x-show="step <= 3">3</span>
                    </div>
                    <div>
                        <span :class="step === 3 ? 'text-[#1E1B4B] font-bold' : 'text-[#64748B] font-medium'" class="text-sm transition-colors">Data Sekolah</span>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="flex items-center space-x-4 relative z-10">
                    <div :class="step === 4 ? 'bg-[#9FA1FF] text-[#1E1B4B] font-bold shadow-md ring-4 ring-[#9FA1FF]/30 border border-[#8E90FF]' : 'bg-white text-[#64748B] border border-[#E2E8F0]'" 
                         class="w-8 h-8 rounded-full flex items-center justify-center text-xs transition-all duration-300">
                        <span>4</span>
                    </div>
                    <div>
                        <span :class="step === 4 ? 'text-[#1E1B4B] font-bold' : 'text-[#64748B] font-medium'" class="text-sm transition-colors">Alamat & Kontak</span>
                    </div>
                </div>
            </div>

            <!-- Footer Keamanan Info -->
            <div class="bg-white/80 border border-[#E2E8F0] p-3.5 rounded-2xl flex items-start space-x-3 backdrop-blur-sm shadow-xs">
                <svg class="w-5 h-5 text-[#9FA1FF] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <p class="text-[11px] text-[#475569] leading-relaxed">
                    Data alamat dan kontak wali Anda terenkripsi aman dan hanya dapat diakses oleh Guru BK yang berwenang.
                </p>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM DINAMIS (DENGAN ANIMASI) -->
        <div class="md:col-span-7 p-6 sm:p-8 md:p-12 flex flex-col justify-between bg-white">
            
            <form action="{{ url('/register') }}" method="POST" class="space-y-6 flex-1 flex flex-col justify-between">
                @csrf

                <!-- KONTEN FORM BERDASARKAN STEP -->
                <div>
                    <!-- STEP 1: DATA AKUN -->
                    <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5">
                        <div>
                            <h3 class="text-xl font-bold text-[#1E1B4B]">Data Akun</h3>
                            <p class="text-xs text-[#64748B] mt-0.5">Gunakan Email dan NIS Anda untuk login.</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Email (Untuk Login)</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="contoh@gmail.com" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">NIS (Nomor Induk Siswa)</label>
                                <input type="text" name="nis" value="{{ old('nis') }}" placeholder="Contoh: 10293" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Kata Sandi</label>
                                <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 2: DATA DIRI -->
                    <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5" style="display: none;">
                        <div>
                            <h3 class="text-xl font-bold text-[#1E1B4B]">Data Diri Siswa</h3>
                            <p class="text-xs text-[#64748B] mt-0.5">Lengkapi identitas lengkap sesuai rapor sekolah.</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap siswa" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: DATA SEKOLAH -->
                    <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5" style="display: none;">
                        <div>
                            <h3 class="text-xl font-bold text-[#1E1B4B]">Data Kelas Sekolah</h3>
                            <p class="text-xs text-[#64748B] mt-0.5">Pilih tingkat dan rombongan belajar Anda.</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Kelas</label>
                                <select name="kelas" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
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
                    </div>

                    <!-- STEP 4: ALAMAT & KONTAK -->
                    <div x-show="step === 4" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="space-y-5" style="display: none;">
                        <div>
                            <h3 class="text-xl font-bold text-[#1E1B4B]">Alamat & Kontak</h3>
                            <p class="text-xs text-[#64748B] mt-0.5">Informasi tempat tinggal dan nomor kontak yang dapat dihubungi.</p>
                        </div>

                        <div class="space-y-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" placeholder="Nama jalan, RT/RW, Kelurahan, Kecamatan" class="w-full px-4 py-2 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>{{ old('alamat') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Nomor Telepon Siswa (WhatsApp)</label>
                                <input type="text" name="nomor_telepon" value="{{ old('nomor_telepon') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                            </div>
                        </div>

                        <!-- Menampilkan Pesan Error Validasi dari Laravel -->
                        @if ($errors->any())
                            <div class="p-3.5 bg-rose-50 text-rose-700 text-xs rounded-xl border border-rose-200">
                                <ul class="list-disc pl-4 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TOMBOL NAVIGASI STEPPER & LINK LOGIN -->
                <div>
                    <div class="flex items-center justify-between pt-6 border-t border-[#E2E8F0] mt-6">
                        <button type="button" 
                                @click="if(step > 1) step--" 
                                x-show="step > 1"
                                class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] border border-[#E2E8F0] text-sm font-bold rounded-xl transition-all inline-flex items-center gap-2 cursor-pointer">
                            <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            <span>Kembali</span>
                        </button>
                        <div x-show="step === 1"></div>

                        <!-- Tombol Lanjut (Step 1-3) atau Submit (Step 4) -->
                        <template x-if="step < 4">
                            <button type="button" 
                                    @click="step++" 
                                    class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-sm font-bold rounded-xl shadow-xs border border-[#8E90FF] transition-all flex items-center space-x-2 ml-auto cursor-pointer">
                                <span>Lanjut</span>
                                <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </button>
                        </template>

                        <template x-if="step === 4">
                            <button type="submit" 
                                    class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-sm font-bold rounded-xl shadow-xs border border-[#8E90FF] transition-all flex items-center space-x-2 ml-auto cursor-pointer">
                                <span>Selesaikan Pendaftaran</span>
                            </button>
                        </template>
                    </div>

                    <!-- Tautan Masuk / Login -->
                    <div class="text-center pt-4 text-xs text-[#64748B]">
                        Sudah punya akun? <a href="{{ url('/login') }}" class="text-[#9FA1FF] font-bold hover:underline">Masuk ke SIM-BK</a>
                    </div>
                </div>

            </form>
        </div>

    </div>

</body>
</html>