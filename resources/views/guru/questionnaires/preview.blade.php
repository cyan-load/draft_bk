<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Kuisioner - SIM-BK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#9FA1FF',
                        'primary-hover': '#8E90FF',
                        'primary-dark': '#7B7EFF',
                        'primary-text': '#1E1B4B',
                        secondary: '#B5BAFF',
                        'secondary-hover': '#A5AAFF',
                        'secondary-text': '#1E1B4B',
                        'app-bg': '#FFFFFF',
                        surface: '#F8FAFF',
                        'surface-hover': '#F1F5F9',
                        'surface-border': '#E2E8F0',
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }</style>
</head>
<body class="bg-white text-[#1E293B] pb-16">

    <!-- Top Bar Preview Mode -->
    <header class="bg-white/90 backdrop-blur-md border-b border-[#E2E8F0] sticky top-0 z-30 px-6 py-4 shadow-xs">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="{{ route('guru.questionnaires.index') }}" class="px-3.5 py-1.5 bg-white hover:bg-[#F8FAFF] text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-xl transition-all shadow-2xs inline-flex items-center gap-1.5 cursor-pointer">
                    <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>Kembali</span>
                </a>
                <span class="px-3.5 py-1.5 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] rounded-xl text-xs font-bold uppercase tracking-wider">
                    Mode Preview (Tampilan Siswa)
                </span>
            </div>
            <span class="text-xs text-[#64748B] font-semibold">Hanya Pratinjau Guru</span>
        </div>
    </header>

    <!-- Container Utama Kuisioner -->
    <main class="max-w-4xl mx-auto px-6 mt-8 space-y-6">
        
        <!-- Header Kuisioner -->
        <div class="bg-white rounded-3xl border border-[#E2E8F0] p-8 border-t-[6px] border-t-[#9FA1FF] shadow-xs">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold text-[#1E1B4B] bg-[#B5BAFF]/30 border border-[#B5BAFF] px-3.5 py-1 rounded-full">
                    Target: {{ $questionnaire->target_kelas }}
                </span>
                <span class="text-xs text-[#64748B] font-bold">
                    {{ $questionnaire->questions->count() }} Pertanyaan
                </span>
            </div>
            <h1 class="text-2xl font-bold text-[#1E1B4B] mb-2">{{ $questionnaire->title ?? $questionnaire->judul }}</h1>
            <p class="text-sm text-[#475569] leading-relaxed">
                {{ $questionnaire->description ?? $questionnaire->deskripsi ?? 'Tidak ada deskripsi atau petunjuk khusus untuk kuisioner ini.' }}
            </p>
        </div>

        <!-- Daftar Soal -->
        @foreach($questionnaire->questions as $index => $q)
            <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs space-y-4">
                
                <!-- Pertanyaan & Aspek -->
                <div class="flex items-start justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-[#94A3B8]">Butir Soal {{ $index + 1 }}</span>
                        <h3 class="text-base font-bold text-[#1E1B4B] leading-snug">
                            {{ $q->question_text ?? $q->teks_pertanyaan }}
                            @if($q->is_required ?? $q->is_wajib)
                                <span class="text-rose-500 ml-1">*</span>
                            @endif
                        </h3>
                    </div>
                    @if($q->category ?? $q->aspek)
                        <span class="shrink-0 bg-[#AEE2FF]/40 border border-[#AEE2FF] text-[#0369A1] px-3 py-1 rounded-full text-[11px] font-bold">
                            Aspek: {{ $q->category ?? $q->aspek }}
                        </span>
                    @endif
                </div>

                <!-- Opsi Jawaban Berdasarkan Tipe -->
                <div class="pt-2">
                    @if(($q->question_type ?? $q->tipe_jawaban) === 'single_choice')
                        <div class="space-y-2.5">
                            @foreach($q->options as $opt)
                                <label class="flex items-center space-x-3 p-3 rounded-2xl border border-[#E2E8F0] hover:bg-[#F8FAFF] cursor-pointer transition-colors">
                                    <input type="radio" name="question_{{ $q->id }}" class="w-4 h-4 text-[#1E1B4B] border-[#E2E8F0] focus:ring-[#9FA1FF]">
                                    <span class="text-sm text-[#1E293B] font-medium">{{ $opt->option_text ?? $opt->teks_opsi }}</span>
                                </label>
                            @endforeach
                        </div>

                    @elseif(($q->question_type ?? $q->tipe_jawaban) === 'multichoice')
                        <div class="space-y-2.5">
                            @foreach($q->options as $opt)
                                <label class="flex items-center space-x-3 p-3 rounded-2xl border border-[#E2E8F0] hover:bg-[#F8FAFF] cursor-pointer transition-colors">
                                    <input type="checkbox" name="question_{{ $q->id }}[]" class="w-4 h-4 text-[#1E1B4B] border-[#E2E8F0] rounded focus:ring-[#9FA1FF]">
                                    <span class="text-sm text-[#1E293B] font-medium">{{ $opt->option_text ?? $opt->teks_opsi }}</span>
                                </label>
                            @endforeach
                        </div>

                    @elseif(($q->question_type ?? $q->tipe_jawaban) === 'text')
                        <div>
                            <textarea rows="3" placeholder="Tuliskan jawaban atau tanggapan Anda di sini..." class="w-full p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl text-sm outline-none transition-all text-[#1E293B]" disabled></textarea>
                            <span class="text-[11px] text-[#64748B] mt-1 block italic">*Kotak isian esai untuk jawaban panjang siswa.</span>
                        </div>
                    @endif
                </div>

            </div>
        @endforeach

        <!-- Tombol Kirim Simulasi -->
        <div class="flex justify-end pt-4">
            <button type="button" onclick="alert('Ini adalah mode preview. Tombol kirim belum aktif.')" class="px-6 py-3 bg-[#9FA1FF] text-[#1E1B4B] font-bold text-sm rounded-xl border border-[#8E90FF] shadow-xs opacity-80 cursor-not-allowed">
                Kirim Jawaban (Simulasi Siswa)
            </button>
        </div>

    </main>

</body>
</html>