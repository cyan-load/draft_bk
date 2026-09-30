@extends('layouts.app')

@section('title', 'Hasil & Respon Kuisioner - ' . $questionnaire->judul)

@section('content')
<div x-data="{ expandedStudentId: null }" class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto space-y-6 md:space-y-8 bg-white">
    
    <!-- Top Bar Navigation & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('guru.questionnaires.index') }}" class="p-2.5 bg-white border border-[#E2E8F0] hover:bg-[#F8FAFF] active:scale-95 rounded-2xl text-[#1E1B4B] transition-all shadow-2xs cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-extrabold text-[#1E1B4B]">{{ $questionnaire->judul }}</h2>
                <p class="text-xs text-[#64748B] font-medium">Target: {{ $questionnaire->target_kelas }} • {{ count($questionnaire->questions) }} Butir Soal • {{ count($respondents) }} Siswa Mengisi</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3">
            <a href="{{ route('guru.questionnaires.preview', $questionnaire->id) }}" target="_blank" class="px-3.5 sm:px-4 py-2.5 bg-[#B5BAFF]/30 hover:bg-[#B5BAFF] active:scale-95 text-[#1E1B4B] border border-[#B5BAFF] rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-1.5 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                Preview Soal
            </a>
            <a href="{{ route('guru.questionnaires.export_excel', $questionnaire->id) }}" class="px-3.5 sm:px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <span>Ekspor CSV</span>
            </a>
            <a href="{{ route('guru.questionnaires.print_all', $questionnaire->id) }}" target="_blank" class="px-3.5 sm:px-4 py-2.5 bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Rekap</span>
            </a>
            <a href="{{ route('guru.questionnaires.edit', $questionnaire->id) }}" class="px-3.5 sm:px-4 py-2.5 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-[#1E1B4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                <span>Edit Soal</span>
            </a>
        </div>
    </div>

    <!-- Questionnaire Metadata Card -->
    <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
        <div class="space-y-2 flex-1">
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-1 rounded-lg text-xs font-bold {{ $questionnaire->is_active ? 'bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]' : 'bg-slate-100 text-slate-600 border border-slate-200' }}">
                    {{ $questionnaire->is_active ? 'Published / Aktif' : 'Draft' }}
                </span>
                <span class="px-2.5 py-1 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-lg text-xs font-bold">
                    Target: {{ $questionnaire->target_kelas }}
                </span>
            </div>
            <p class="text-xs text-[#475569] leading-relaxed">
                {{ $questionnaire->deskripsi ?? 'Tidak ada deskripsi tambahan untuk instrumen kuisioner ini.' }}
            </p>
        </div>

        <div class="flex items-center gap-4 border-t md:border-t-0 md:border-l border-[#E2E8F0] pt-4 md:pt-0 md:pl-6 shrink-0">
            <div class="text-center px-4">
                <span class="text-[11px] font-bold text-[#64748B] uppercase block">Total Soal</span>
                <span class="text-2xl font-black text-[#1E1B4B]">{{ count($questionnaire->questions) }}</span>
            </div>
            <div class="text-center px-4 border-l border-[#E2E8F0]">
                <span class="text-[11px] font-bold text-[#64748B] uppercase block">Siswa Mengisi</span>
                <span class="text-2xl font-black text-[#14532D]">{{ count($respondents) }}</span>
            </div>
        </div>
    </div>

    <!-- Table of Student Respondents -->
    <div class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden space-y-4 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-[#E2E8F0]">
            <div>
                <h3 class="font-extrabold text-[#1E1B4B] text-base">Daftar Responden Siswa</h3>
                <p class="text-xs text-[#64748B]">Siswa yang telah menyelesaikan pengisian instrumen angket ini.</p>
            </div>
            <span class="px-3 py-1 bg-[#D9F9DF] text-[#14532D] text-xs font-bold rounded-xl border border-[#BBF7D0]">
                {{ count($respondents) }} Siswa Terdata
            </span>
        </div>

        <div class="divide-y divide-[#E2E8F0]">
            @forelse($respondents as $resp)
                @php
                    $student = $resp['student'];
                @endphp
                <div class="py-4 space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <!-- Student Avatar -->
                            <div class="w-12 h-12 rounded-2xl bg-[#9FA1FF] text-[#1E1B4B] border border-[#8E90FF] flex items-center justify-center font-bold text-sm shadow-xs overflow-hidden shrink-0">
                                @if(!empty($student->foto))
                                    <img src="{{ asset('storage/' . $student->foto) }}" alt="{{ $student->nama }}" class="w-full h-full object-cover">
                                @else
                                    <span>{{ strtoupper(substr($student->nama ?? 'S', 0, 2)) }}</span>
                                @endif
                            </div>

                            <!-- Student Info -->
                            <div>
                                <h4 class="font-bold text-sm text-[#1E1B4B]">{{ $student->nama }}</h4>
                                <p class="text-xs text-[#64748B] font-semibold">NIS: {{ $student->nis }} • Kelas {{ $student->kelas }} • Diisi pada: {{ $resp['filled_at'] ? $resp['filled_at']->format('d M Y, H:i') : '-' }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center gap-2 self-end sm:self-center">
                            <span class="px-3 py-1 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] rounded-xl text-xs font-bold">
                                Skor: {{ $resp['total_score'] }} Poin
                            </span>
                            <button @click="expandedStudentId = (expandedStudentId === {{ $student->id }} ? null : {{ $student->id }})" class="px-3 py-2 bg-[#F8FAFF] hover:bg-[#B5BAFF]/30 active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all flex items-center gap-1.5 shadow-2xs cursor-pointer">
                                <span x-text="expandedStudentId === {{ $student->id }} ? 'Tutup Jawaban' : 'Rincian Jawaban'"></span>
                            </button>
                            <a href="{{ route('guru.questionnaires.print_student', ['id' => $questionnaire->id, 'studentId' => $student->id]) }}" target="_blank" class="px-3.5 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] rounded-xl text-xs font-bold transition-all shadow-xs flex items-center gap-1.5 cursor-pointer">
                                <span>Cetak PDF</span>
                            </a>
                        </div>
                    </div>

                    <!-- Expandable Answer Details for this Student -->
                    <div x-show="expandedStudentId === {{ $student->id }}" x-cloak class="mt-4 p-5 bg-[#F8FAFF] rounded-2xl border border-[#E2E8F0] space-y-3">
                        <div class="flex items-center justify-between border-b border-[#E2E8F0] pb-2 text-xs font-bold text-[#1E1B4B]">
                            <span>Jawaban Lengkap: {{ $student->nama }} ({{ $student->nis }})</span>
                            <span>{{ count($resp['answers']) }} / {{ count($questionnaire->questions) }} Soal Terjawab</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2">
                            @foreach($questionnaire->questions as $index => $q)
                                @php
                                    $qAnswers = $resp['answers']->get($q->id);
                                    $qScore = $qAnswers ? $qAnswers->sum(fn($a) => $a->option ? ($a->option->bobot_nilai ?? 0) : 0) : 0;
                                @endphp
                                <div class="bg-white p-3.5 rounded-xl border border-[#E2E8F0] text-xs space-y-1.5">
                                    <p class="font-bold text-[#1E1B4B]">{{ $index + 1 }}. {{ $q->teks_pertanyaan }}</p>
                                    <div class="flex items-center justify-between gap-2 pt-1 border-t border-[#E2E8F0]">
                                        <span class="text-[#64748B]">Jawaban:</span>
                                        <span class="font-bold text-[#1E1B4B] bg-[#F8FAFF] px-2.5 py-0.5 rounded-md border border-[#E2E8F0]">
                                            @if($qAnswers && $qAnswers->isNotEmpty())
                                                {{ $qAnswers->map(fn($a) => $a->option ? $a->option->teks_opsi : $a->jawaban_teks)->filter()->unique()->implode(', ') }}
                                                @if($qScore > 0)
                                                    <span class="text-[10px] text-[#9FA1FF]">({{ $qScore }} pt)</span>
                                                @endif
                                            @else
                                                <span class="text-rose-500">Belum dijawab</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-12 text-center text-[#64748B] space-y-2">
                    <svg class="w-12 h-12 text-[#94A3B8] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <p class="font-bold text-sm text-[#1E1B4B]">Belum ada siswa yang mengisi kuisioner ini.</p>
                    <p class="text-xs text-[#64748B]">Pastikan kuisioner berstatus Published agar siswa di kelas target dapat mengisinya.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
