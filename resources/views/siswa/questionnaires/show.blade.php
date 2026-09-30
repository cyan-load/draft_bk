@extends('layouts.student')

@section('title', 'Isi Kuisioner - SIM-BK')

@section('content')

<div class="text-[#1E293B] pb-16 bg-white">

    <!-- Top Bar -->
    <header class="bg-white/90 backdrop-blur-md border border-[#E2E8F0] rounded-2xl sticky top-0 z-30 px-6 py-4 shadow-xs mb-8">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ route('siswa.questionnaires.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] text-xs font-bold rounded-xl border border-[#E2E8F0] transition-all shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
            <span class="text-xs font-bold text-[#64748B]">Mode Pengisian Angket</span>
        </div>
    </header>

    <!-- Container Utama Kuisioner -->
    <main class="max-w-4xl mx-auto space-y-6">
        
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
            <p class="text-sm text-[#475569] leading-relaxed font-medium">
                {{ $questionnaire->description ?? $questionnaire->deskripsi ?? 'Tidak ada petunjuk khusus untuk kuisioner ini.' }}
            </p>
        </div>

        <form action="{{ route('siswa.questionnaires.store', $questionnaire->id) }}" method="POST" class="space-y-6">
            @csrf

            <!-- Daftar Soal -->
            @foreach($questionnaire->questions as $index => $q)
                <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs space-y-4">
                    
                    <!-- Pertanyaan & Aspek -->
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-[#94A3B8]">Pertanyaan {{ $index + 1 }}</span>
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
                                    <label class="flex items-center space-x-3 p-3.5 rounded-2xl border border-[#E2E8F0] hover:bg-[#F8FAFF] cursor-pointer transition-colors">
                                        <input type="radio" name="question_{{ $q->id }}" value="{{ $opt->option_text ?? $opt->teks_opsi }}" class="w-4 h-4 text-[#1E1B4B] border-[#E2E8F0] focus:ring-[#9FA1FF]" {{ ($q->is_required ?? $q->is_wajib) ? 'required' : '' }}>
                                        <span class="text-sm text-[#1E293B] font-medium">{{ $opt->option_text ?? $opt->teks_opsi }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif(($q->question_type ?? $q->tipe_jawaban) === 'multichoice')
                            <div class="space-y-2.5">
                                @foreach($q->options as $opt)
                                    <label class="flex items-center space-x-3 p-3.5 rounded-2xl border border-[#E2E8F0] hover:bg-[#F8FAFF] cursor-pointer transition-colors">
                                        <input type="checkbox" name="question_{{ $q->id }}[]" value="{{ $opt->option_text ?? $opt->teks_opsi }}" class="w-4 h-4 text-[#1E1B4B] border-[#E2E8F0] rounded focus:ring-[#9FA1FF]">
                                        <span class="text-sm text-[#1E293B] font-medium">{{ $opt->option_text ?? $opt->teks_opsi }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif(($q->question_type ?? $q->tipe_jawaban) === 'text')
                            <div>
                                <textarea name="question_{{ $q->id }}" rows="3" placeholder="Tuliskan jawaban atau tanggapan Anda di sini..." class="w-full p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] outline-none transition-all text-[#1E293B]" {{ ($q->is_required ?? $q->is_wajib) ? 'required' : '' }}></textarea>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach

            <!-- Tombol Kirim Asli -->
            @if($questionnaire->questions->count() > 0)
                <div class="flex justify-end pt-4">
                    <button type="submit" class="px-8 py-3.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-sm rounded-2xl shadow-xs transition-all cursor-pointer">
                        Kirim Jawaban Kuisioner
                    </button>
                </div>
            @endif

        </form>

    </main>
</div>

@endsection