@extends('layouts.student')

@section('title', 'Hasil Kuisioner - SIM-BK')

@section('content')

<div class="text-[#1E293B] pb-16 bg-white">

    <!-- Top Bar -->
    <header class="bg-white/90 backdrop-blur-md border border-[#E2E8F0] rounded-2xl sticky top-0 z-30 px-6 py-4 shadow-xs mb-8">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
            <a href="{{ route('siswa.questionnaires.index') }}" class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-[#F8FAFF] text-[#1E1B4B] text-xs font-bold rounded-xl border border-[#E2E8F0] transition-all shadow-2xs cursor-pointer">
                <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
            <span class="px-3.5 py-1 bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] rounded-full text-xs font-bold uppercase tracking-wider">
                ✓ Selesai Dikerjakan
            </span>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 space-y-6">
        
        <div class="bg-white rounded-3xl border border-[#E2E8F0] p-8 border-t-[6px] border-t-[#9FA1FF] shadow-xs">
            <h1 class="text-2xl font-bold text-[#1E1B4B] mb-2">{{ $questionnaire->title ?? $questionnaire->judul }}</h1>
            <p class="text-sm text-[#475569] leading-relaxed font-medium">
                Berikut adalah rangkuman jawaban yang telah tersimpan dalam database bimbingan konseling.
            </p>
        </div>

        <div class="space-y-6">
            @foreach($questionnaire->questions as $index => $q)
                @php
                    $qAnswers = $answers->get($q->id);
                    $studentAnswer = ($qAnswers && $qAnswers->isNotEmpty())
                        ? $qAnswers->map(fn($a) => $a->option ? ($a->option->option_text ?? $a->option->teks_opsi) : $a->jawaban_teks)->filter()->unique()->implode(', ')
                        : 'Tidak dijawab / Dikosongkan';
                @endphp
                
                <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-[#94A3B8]">Pertanyaan {{ $index + 1 }}</span>
                            <h3 class="text-base font-bold text-[#1E1B4B] leading-snug">
                                {{ $q->question_text ?? $q->teks_pertanyaan }}
                            </h3>
                        </div>
                        @if($q->category ?? $q->aspek)
                            <span class="shrink-0 bg-[#AEE2FF]/40 border border-[#AEE2FF] text-[#0369A1] px-3 py-1 rounded-full text-[11px] font-bold">
                                Aspek: {{ $q->category ?? $q->aspek }}
                            </span>
                        @endif
                    </div>

                    <div class="p-4 bg-[#F8FAFF] border border-[#E2E8F0] rounded-2xl flex items-start gap-4 mt-2">
                        <div class="w-6 h-6 bg-[#1E1B4B] text-white rounded-full flex items-center justify-center shrink-0 mt-0.5 shadow-2xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-[#64748B] uppercase tracking-wider block mb-0.5">Jawaban Anda:</span>
                            <span class="text-sm font-bold text-[#1E1B4B]">{{ $studentAnswer }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </main>
</div>

@endsection