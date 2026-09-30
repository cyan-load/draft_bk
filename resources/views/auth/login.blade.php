<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIM-BK</title>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }</style>
</head>
<body class="bg-white min-h-screen flex items-center justify-center p-4">

    <!-- CONTAINER UTAMA -->
    <div class="bg-white rounded-3xl shadow-xl w-full max-w-4xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-[#E2E8F0]">
        
        <!-- KOLOM KIRI: ILUSTRASI & BRANDING -->
        <div class="md:col-span-6 bg-gradient-to-br from-[#B5BAFF]/30 via-[#AEE2FF]/20 to-[#D9F9DF]/30 p-6 sm:p-8 md:p-12 flex flex-col justify-center items-center text-center relative overflow-hidden border-b md:border-b-0 md:border-r border-[#E2E8F0]">
            
            <div class="bg-white/95 backdrop-blur-md p-6 rounded-3xl shadow-sm border border-[#E2E8F0] mb-6 w-full max-w-xs flex flex-col items-center">
                <div class="w-16 h-16 bg-[#9FA1FF] text-[#1E1B4B] rounded-2xl flex items-center justify-center mb-4 shadow-xs border border-[#8E90FF]">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="h-3 w-28 bg-[#B5BAFF]/60 rounded-full mb-2"></div>
                <div class="h-2 w-16 bg-[#AEE2FF]/70 rounded-full"></div>
            </div>

            <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight mb-2">Ruang Aman Siswa</h2>
            <p class="text-xs md:text-sm text-[#475569] max-w-sm leading-relaxed">
                Layanan Bimbingan & Konseling terpadu untuk mendukung potensi, akademik, dan kesejahteraan siswa.
            </p>
            
            <div class="mt-6 flex items-center gap-2">
                <span class="px-3 py-1 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-full text-xs font-semibold">
                    Konseling & Angket
                </span>
                <span class="px-3 py-1 bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] rounded-full text-xs font-semibold">
                    Rahasia & Terpercaya
                </span>
            </div>
        </div>

        <!-- KOLOM KANAN: FORM LOGIN -->
        <div class="md:col-span-6 p-6 sm:p-8 md:p-12 flex flex-col justify-center bg-white">
            
            <div class="text-center mb-8">
                <div class="w-12 h-12 bg-[#9FA1FF] text-[#1E1B4B] font-extrabold text-sm rounded-2xl mx-auto flex items-center justify-center shadow-xs border border-[#8E90FF] mb-3">
                    BK
                </div>
                <h3 class="text-2xl font-bold text-[#1E1B4B]">Selamat Datang</h3>
                <p class="text-xs text-[#64748B] mt-1 font-medium">Masuk menggunakan Akun Email atau NIS Anda</p>
            </div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                
                <!-- Pesan Error Login -->
                @if($errors->any())
                    <div class="bg-rose-50 text-rose-700 text-xs p-3.5 rounded-2xl border border-rose-200">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Input Login Identity (Email atau NIS) -->
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Email atau NIS</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#94A3B8]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        </span>
                        <input type="text" name="login_identity" value="{{ old('login_identity') }}" placeholder="Contoh: andipratama@gmail.com atau NIS" class="w-full pl-10 pr-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569]">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-[#94A3B8]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <input type="password" name="password" placeholder="••••••••" class="w-full pl-10 pr-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] focus:border-[#9FA1FF] transition-all outline-none text-[#1E293B]" required>
                    </div>
                </div>

                <!-- Tombol Masuk -->
                <button type="submit" class="w-full py-3 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] font-bold text-sm rounded-xl shadow-xs border border-[#8E90FF] transition-all flex items-center justify-center space-x-2 mt-2 cursor-pointer">
                    <span>Masuk ke SIM-BK</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>

                <!-- Tautan Register -->
                <div class="text-center pt-4 text-xs text-[#64748B]">
                    Belum punya akun? <a href="/register" class="text-[#9FA1FF] font-bold hover:underline">Daftar Akun Siswa Baru</a>
                </div>

            </form>
        </div>
    </div>
</body>
</html>