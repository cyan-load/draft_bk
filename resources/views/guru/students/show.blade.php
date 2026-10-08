@extends('layouts.app')

@section('title', 'Detail Siswa & Rekam Bimbingan - ' . $student->nama)

@section('content')
<div x-data="{ 
        detailTab: 'notes',
        openAddNoteModal: false, 
        openEditNoteModal: false,
        selectedNoteId: null,
        editTanggal: '',
        editKategori: 'Pribadi',
        editKeluhan: '',
        editLayanan: '',
        editTindakLanjut: '',
        editStatus: 'Dalam Pemantauan'
     }" 
     class="px-4 sm:px-6 md:px-10 py-6 md:py-8 max-w-7xl mx-auto space-y-6 md:space-y-8 pb-20 bg-white">
    
    <!-- Top Bar Navigation & Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="/guru/students" class="p-2.5 bg-white border border-[#E2E8F0] hover:bg-[#F8FAFF] active:scale-95 rounded-2xl text-[#1E1B4B] transition-all shadow-2xs cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl font-extrabold text-[#1E1B4B]">{{ $student->nama }}</h2>
                <p class="text-xs text-[#64748B] font-medium">NIS: {{ $student->nis }} • Kelas {{ $student->kelas }}</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto">
            <a href="{{ route('guru.students.notes.print', $student->id) }}" target="_blank" class="flex-1 sm:flex-initial justify-center px-4 py-2.5 bg-white hover:bg-[#F8FAFF] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] rounded-xl text-xs font-bold transition-all shadow-2xs flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4 text-[#9FA1FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak Rekam Jejak</span>
            </a>
            <a href="/guru/counseling?student_id={{ $student->id }}&open_initiate=1" class="flex-1 sm:flex-initial justify-center px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] rounded-xl text-xs font-bold transition-all shadow-xs flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Jadwalkan Konseling</span>
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <span>{{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-[#14532D] font-bold">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-4 rounded-2xl flex items-center justify-between shadow-2xs font-semibold">
            <span>{{ session('error') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-rose-600 font-bold">&times;</button>
        </div>
    @endif

    <!-- Student Profile Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Profile Card -->
        <div class="lg:col-span-1 bg-white rounded-3xl p-6 border border-[#E2E8F0] shadow-xs flex flex-col items-center text-center self-start">
            <div class="w-24 h-24 rounded-3xl bg-[#9FA1FF] text-[#1E1B4B] border-2 border-[#8E90FF] flex items-center justify-center font-extrabold text-3xl shadow-xs mb-4 overflow-hidden">
                @if(!empty($student->foto))
                    <img src="{{ asset('storage/' . $student->foto) }}" alt="{{ $student->nama }}" class="w-full h-full object-cover">
                @else
                    <span>{{ strtoupper(substr($student->nama, 0, 2)) }}</span>
                @endif
            </div>
            
            <h3 class="text-xl font-extrabold text-[#1E1B4B]">{{ $student->nama }}</h3>
            <p class="text-xs text-[#64748B] mt-0.5 font-semibold">{{ $student->email ?? 'Tanpa Email' }}</p>

            <div class="flex items-center gap-2 mt-4">
                <span class="px-3 py-1 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] rounded-full text-xs font-bold">
                    Kelas {{ $student->kelas }}
                </span>
                <span class="px-3 py-1 bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0] rounded-full text-xs font-bold uppercase">
                    {{ $student->status }}
                </span>
            </div>

            <div class="w-full border-t border-[#E2E8F0] mt-6 pt-6 text-left space-y-4">
                <div class="p-3 bg-[#F8FAFF] rounded-2xl border border-[#E2E8F0] space-y-2.5">
                    <span class="text-[10px] font-extrabold text-[#4338CA] uppercase tracking-wider block">Informasi Orang Tua / Wali</span>
                    <div>
                        <span class="text-[11px] font-bold text-[#64748B] block">Nama Ayah</span>
                        <span class="text-xs font-extrabold text-[#1E1B4B]">{{ $student->nama_ayah ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-[#64748B] block">Nama Ibu</span>
                        <span class="text-xs font-extrabold text-[#1E1B4B]">{{ $student->nama_ibu ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-[#64748B] block">No. Telp Orang Tua</span>
                        <span class="text-xs font-extrabold text-[#1E1B4B]">{{ $student->nomor_telepon_orang_tua ?? '-' }}</span>
                    </div>
                </div>

                <div class="p-3 bg-[#EEF2FF] rounded-2xl border border-[#C7D2FE] space-y-2.5">
                    <span class="text-[10px] font-extrabold text-[#312E81] uppercase tracking-wider block">Minat, Bakat & Cita-Cita</span>
                    <div>
                        <span class="text-[11px] font-bold text-[#64748B] block">Minat & Bakat (Hobi)</span>
                        <span class="text-xs font-extrabold text-[#1E1B4B]">{{ $student->hobi ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold text-[#64748B] block">Cita-Cita / Orientasi Masa Depan</span>
                        <span class="text-xs font-extrabold text-[#1E1B4B]">{{ $student->cita_cita ?? '-' }}</span>
                    </div>
                </div>

                <div>
                    <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">Tempat & Tanggal Lahir</span>
                    <span class="text-xs font-semibold text-[#1E1B4B]">{{ ($student->tempat_lahir ?? '-') . ', ' . ($student->tanggal_lahir ? \Carbon\Carbon::parse($student->tanggal_lahir)->translatedFormat('d F Y') : '-') }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">Jenis Kelamin & Agama</span>
                    <span class="text-xs font-semibold text-[#1E1B4B]">{{ ($student->jenis_kelamin ?? '-') . ' • ' . ($student->agama ?? '-') }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">No. Telepon / WhatsApp Siswa</span>
                    <span class="text-xs font-semibold text-[#1E1B4B]">{{ $student->nomor_telepon ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">Alamat Lengkap</span>
                    <span class="text-xs font-semibold text-[#1E1B4B] leading-relaxed">{{ $student->alamat ?? '-' }}</span>
                </div>
                <div>
                    <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block">Akun Login Siswa</span>
                    <span class="text-xs font-mono bg-[#F8FAFF] text-[#1E1B4B] px-2.5 py-1 rounded-lg border border-[#E2E8F0] inline-block mt-1">
                        Username: {{ $student->user->username ?? $student->nis }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Right: Tabbed Details (Catatan Kasus & Kuisioner) -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Navigation Tabs Bar -->
            <div class="flex items-center gap-2 bg-white p-2 rounded-2xl border border-[#E2E8F0] shadow-xs overflow-x-auto">
                <button type="button" @click="detailTab = 'notes'" 
                        :class="detailTab === 'notes' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-[#F8FAFF]'" 
                        class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 flex items-center gap-2 shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <span>Catatan Kasus & Bimbingan ({{ $student->counselingNotes->count() }})</span>
                </button>
                <button type="button" @click="detailTab = 'questionnaires'" 
                        :class="detailTab === 'questionnaires' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-[#F8FAFF]'" 
                        class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 flex items-center gap-2 shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    <span>Hasil & Respon Kuisioner ({{ count($answeredQuestionnaires) }})</span>
                </button>
                <button type="button" @click="detailTab = 'counseling'" 
                        :class="detailTab === 'counseling' ? 'bg-[#9FA1FF] text-[#1E1B4B] shadow-xs' : 'text-[#64748B] hover:text-[#1E1B4B] hover:bg-[#F8FAFF]'" 
                        class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all active:scale-95 flex items-center gap-2 shrink-0 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>Sesi Konseling ({{ $student->counselingSessions->count() }})</span>
                </button>
            </div>

            <!-- ================= TAB 1: CATATAN KASUS ================= -->
            <div x-show="detailTab === 'notes'" class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden">
                <div class="p-6 border-b border-[#E2E8F0] bg-[#F8FAFF] flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="font-bold text-[#1E1B4B] text-base">Rekam Jejak & Catatan Bimbingan Kasus</h3>
                        <p class="text-xs text-[#64748B] font-medium">Histori masalah, tindakan layanan konseling, dan tindak lanjut evaluasi.</p>
                    </div>
                    <button @click="openAddNoteModal = true" class="px-4 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] text-xs font-bold rounded-xl shadow-xs flex items-center gap-1.5 transition-all self-start sm:self-auto cursor-pointer">
                        Tambah Catatan Kasus
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($student->counselingNotes as $note)
                        <div class="border border-[#E2E8F0] rounded-2xl p-5 bg-[#F8FAFF] space-y-3 relative hover:shadow-xs transition-all">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#E2E8F0] pb-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        @if($note->status === 'Dalam Pemantauan') bg-amber-50 text-amber-700 border border-amber-200
                                        @elseif($note->status === 'Selesai / Teratasi') bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]
                                        @else bg-rose-50 text-rose-700 border border-rose-200 @endif">
                                        {{ $note->status }}
                                    </span>
                                    <span class="px-2.5 py-0.5 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-full text-[10px] font-bold uppercase">
                                        Bidang: {{ $note->kategori }}
                                    </span>
                                </div>
                                <span class="text-xs text-[#64748B] font-medium flex items-center gap-1.5"><svg class="w-3.5 h-3.5 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> {{ $note->tanggal ? $note->tanggal->format('d F Y') : '-' }}</span>
                            </div>

                            <div>
                                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block mb-0.5">Keluhan / Deskripsi Masalah:</span>
                                <p class="text-xs font-semibold text-[#1E1B4B] leading-relaxed">{{ $note->keluhan_masalah }}</p>
                            </div>

                            <div>
                                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block mb-0.5">Layanan & Tindakan BK yang Diberikan:</span>
                                <p class="text-xs font-medium text-[#475569] leading-relaxed">{{ $note->layanan_diberikan }}</p>
                            </div>

                            @if($note->tindak_lanjut_evaluasi)
                                <div class="bg-white p-3 rounded-xl border border-[#E2E8F0]">
                                    <span class="text-[10px] font-bold text-[#1E1B4B] uppercase tracking-wider block mb-0.5">Rencana Tindak Lanjut & Evaluasi:</span>
                                    <p class="text-xs text-[#475569]">{{ $note->tindak_lanjut_evaluasi }}</p>
                                </div>
                            @endif

                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-3 border-t border-[#E2E8F0] text-xs">
                                <span class="text-[#64748B]">Konselor: <strong class="text-[#1E1B4B]">{{ $note->counselor->name ?? 'Guru BK' }}</strong></span>
                                <div class="flex items-center flex-wrap gap-2">
                                     <a href="{{ route('guru.students.notes.print', ['id' => $student->id, 'note_id' => $note->id]) }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#9FA1FF]/20 hover:bg-[#9FA1FF]/40 active:scale-95 text-[#1E1B4B] border border-[#9FA1FF]/60 text-xs font-bold rounded-xl transition-all shadow-2xs whitespace-nowrap cursor-pointer" title="Cetak lembar rekam konseling khusus sesi ini saja">
                                         <svg class="w-3.5 h-3.5 text-[#1E1B4B] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                                         <span>Cetak PDF</span>
                                     </a>
                                     <button @click="selectedNoteId = {{ $note->id }}; editTanggal = '{{ $note->tanggal ? $note->tanggal->format('Y-m-d') : date('Y-m-d') }}'; editKategori = '{{ $note->kategori }}'; editKeluhan = `{{ addslashes($note->keluhan_masalah) }}`; editLayanan = `{{ addslashes($note->layanan_diberikan) }}`; editTindakLanjut = `{{ addslashes($note->tindak_lanjut_evaluasi) }}`; editStatus = '{{ $note->status }}'; openEditNoteModal = true" class="inline-flex items-center justify-center px-3 py-1.5 bg-[#B5BAFF]/30 hover:bg-[#B5BAFF] active:scale-95 text-[#1E1B4B] border border-[#B5BAFF] text-xs font-bold rounded-xl transition-all cursor-pointer whitespace-nowrap">
                                         Edit
                                     </button>
                                     <form action="{{ route('guru.students.notes.destroy', ['id' => $student->id, 'noteId' => $note->id]) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus catatan bimbingan ini?')" class="inline-block">
                                         @csrf
                                         @method('DELETE')
                                         <button type="submit" class="inline-flex items-center justify-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 active:scale-95 text-rose-700 border border-rose-200 text-xs font-bold rounded-xl transition-all cursor-pointer whitespace-nowrap">
                                             Hapus
                                         </button>
                                     </form>
                                 </div>
                             </div>
                        </div>
                    @empty
                        <div class="py-12 text-center text-[#64748B]">
                            <svg class="w-12 h-12 text-[#94A3B8] mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <p class="font-bold text-xs text-[#1E1B4B]">Belum ada catatan kasus bimbingan untuk siswa ini.</p>
                            <p class="text-[11px] text-[#64748B] mt-0.5">Klik tombol "+ Tambah Catatan Kasus" untuk mulai mendokumentasikan bimbingan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ================= TAB 2: HASIL KUISIONER ================= -->
            <div x-show="detailTab === 'questionnaires'" class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden">
                <div class="p-6 border-b border-[#E2E8F0] bg-[#F8FAFF] flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-[#1E1B4B] text-base">Hasil & Respon Kuisioner Siswa</h3>
                        <p class="text-xs text-[#64748B] font-medium">Rekapitulasi instrumen angket asesmen yang telah diisi siswa.</p>
                    </div>
                    <span class="px-3 py-1 bg-[#D9F9DF] text-[#14532D] text-xs font-bold rounded-xl border border-[#BBF7D0]">
                        {{ count($answeredQuestionnaires) }} Angket Diselesaikan
                    </span>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($answeredQuestionnaires as $questionnaireId => $answers)
                        @php
                            $firstAnswer = $answers->first();
                            $questionnaire = $firstAnswer->questionnaire ?? null;
                        @endphp
                        @if($questionnaire)
                            <div class="border border-[#E2E8F0] rounded-2xl p-5 bg-[#F8FAFF] space-y-3">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#E2E8F0] pb-2.5">
                                    <div>
                                        <h4 class="font-bold text-[#1E1B4B] text-sm">{{ $questionnaire->title ?? $questionnaire->judul }}</h4>
                                        <p class="text-xs text-[#64748B]">{{ $questionnaire->description ?? $questionnaire->deskripsi }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('guru.questionnaires.print_student', ['id' => $questionnaire->id, 'studentId' => $student->id]) }}" target="_blank" class="px-3 py-1 bg-white hover:bg-[#F8FAFF] text-[#1E1B4B] border border-[#E2E8F0] text-xs font-bold rounded-lg transition-all shadow-2xs">
                                            Cetak Hasil
                                        </a>
                                        <span class="px-2.5 py-1 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-lg text-xs font-bold">
                                            {{ count($answers) }} Jawaban
                                        </span>
                                    </div>
                                </div>

                                <div class="space-y-2.5">
                                    @php
                                        $groupedAnswers = $answers->groupBy('question_id');
                                    @endphp
                                    @foreach($groupedAnswers as $qId => $qAnsList)
                                        @php
                                            $firstQAns = $qAnsList->first();
                                            $questionObj = $firstQAns->question ?? null;
                                            $answerText = $qAnsList->map(fn($a) => $a->option ? $a->option->teks_opsi : $a->jawaban_teks)->filter()->unique()->implode(', ');
                                            $scoreSum = $qAnsList->sum(fn($a) => $a->option ? ($a->option->bobot_nilai ?? 0) : 0);
                                        @endphp
                                        <div class="bg-white p-3 rounded-xl border border-[#E2E8F0] text-xs">
                                            <p class="font-bold text-[#1E1B4B] mb-1">{{ $loop->iteration }}. {{ $questionObj ? ($questionObj->teks_pertanyaan ?? $questionObj->question_text) : 'Pertanyaan' }}</p>
                                            <div class="flex items-center justify-between gap-2 pt-1 border-t border-[#E2E8F0]">
                                                <span class="text-[#64748B]">Jawaban:</span>
                                                <span class="font-bold text-[#1E1B4B] bg-[#F8FAFF] px-2.5 py-0.5 rounded-md border border-[#E2E8F0]">
                                                    {{ !empty($answerText) ? $answerText : 'Terisi' }}
                                                    @if($scoreSum > 0)
                                                        <span class="text-[10px] text-[#9FA1FF]">({{ $scoreSum }} pt)</span>
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="p-8 text-center text-[#64748B]">
                            <svg class="w-12 h-12 text-[#94A3B8] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <p class="font-bold text-[#1E1B4B]">Belum ada angket yang diselesaikan oleh siswa ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- ================= TAB 3: SESI KONSELING ================= -->
            <div x-show="detailTab === 'counseling'" class="bg-white rounded-3xl border border-[#E2E8F0] shadow-xs overflow-hidden">
                <div class="p-6 border-b border-[#E2E8F0] bg-[#F8FAFF] flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-[#1E1B4B] text-base">Riwayat Permohonan & Sesi Konseling</h3>
                        <p class="text-xs text-[#64748B] font-medium">Histori pengajuan bimbingan konseling tatap muka oleh siswa.</p>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                    @forelse($student->counselingSessions as $session)
                        <div class="border border-[#E2E8F0] rounded-2xl p-5 bg-[#F8FAFF] space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#E2E8F0] pb-2.5">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase
                                        @if($session->status === 'disetujui') bg-indigo-50 text-indigo-700 border border-indigo-200
                                        @elseif($session->status === 'selesai') bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]
                                        @elseif($session->status === 'ditolak') bg-rose-50 text-rose-700 border border-rose-200
                                        @else bg-amber-50 text-amber-700 border border-amber-200 @endif">
                                        {{ $session->status }}
                                    </span>
                                    <span class="px-2.5 py-0.5 bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF] rounded-full text-[10px] font-bold uppercase">
                                        {{ $session->category }}
                                    </span>
                                </div>
                                <span class="text-xs text-[#64748B] font-medium flex items-center gap-2">
                                    <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg> {{ $session->preferred_date ? $session->preferred_date->format('d M Y') : '-' }}</span>
                                    <span>•</span>
                                    <span class="inline-flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#94A3B8]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> {{ $session->preferred_time ?? '-' }}</span>
                                </span>
                            </div>

                            <div>
                                <span class="text-[11px] font-bold text-[#64748B] uppercase tracking-wider block mb-0.5">Topik Konseling:</span>
                                <p class="text-xs font-semibold text-[#1E1B4B] leading-relaxed">{{ $session->topic }}</p>
                            </div>

                            @if($session->counselor_notes)
                                <div class="bg-white p-3 rounded-xl border border-[#E2E8F0]">
                                    <span class="text-[10px] font-bold text-[#1E1B4B] uppercase tracking-wider block mb-0.5">Catatan Hasil Sesi:</span>
                                    <p class="text-xs text-[#475569]">{{ $session->counselor_notes }}</p>
                                </div>
                            @endif

                            @if($session->rejection_reason)
                                <div class="bg-rose-50/80 p-3 rounded-xl border border-rose-200">
                                    <span class="text-[10px] font-bold text-rose-800 uppercase tracking-wider block mb-0.5">Alasan Penolakan:</span>
                                    <p class="text-xs text-rose-700">{{ $session->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="p-8 text-center text-[#64748B]">
                            <svg class="w-12 h-12 text-[#94A3B8] mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <p class="font-bold text-[#1E1B4B]">Belum ada riwayat sesi konseling untuk siswa ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

    </div>

    <!-- MODAL TAMBAH CATATAN KASUS -->
    <div x-show="openAddNoteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openAddNoteModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-xl w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-6 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-lg font-bold text-[#1E1B4B]">Tambah Catatan Bimbingan Kasus</h3>
                <button type="button" @click="openAddNoteModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form action="{{ route('guru.students.notes.store', $student->id) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tanggal Bimbingan</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Bidang Bimbingan</label>
                        <select name="kategori" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                            <option value="Pribadi">Pribadi</option>
                            <option value="Belajar">Belajar</option>
                            <option value="Karir">Karir & Lanjutan Studi</option>
                            <option value="Sosial">Sosial / Pergaulan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Keluhan / Gambaran Masalah</label>
                    <textarea name="keluhan_masalah" rows="3" placeholder="Uraikan keluhan atau masalah siswa..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Layanan / Tindakan BK Diberikan</label>
                    <textarea name="layanan_diberikan" rows="3" placeholder="Langkah penanganan, arahan, atau konseling yang dilakukan..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tindak Lanjut & Rencana Evaluasi (Opsional)</label>
                    <input type="text" name="tindak_lanjut_evaluasi" placeholder="Pemantauan berkala, pemanggilan orang tua, dsb..." class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Status Penanganan</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                        <option value="Dalam Pemantauan">Dalam Pemantauan</option>
                        <option value="Selesai / Teratasi">Selesai / Teratasi</option>
                        <option value="Rujukan / Alih Tangan">Rujukan / Alih Tangan Kasus</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                    <button type="button" @click="openAddNoteModal = false" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl cursor-pointer transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs cursor-pointer transition-all">
                        Simpan Catatan Kasus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT CATATAN KASUS -->
    <div x-show="openEditNoteModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openEditNoteModal = false" class="bg-white rounded-3xl border border-[#E2E8F0] max-w-xl w-full max-h-[90vh] overflow-y-auto p-5 sm:p-8 shadow-2xl space-y-6 relative">
            <div class="flex items-center justify-between pb-3 border-b border-[#E2E8F0]">
                <h3 class="text-lg font-bold text-[#1E1B4B]">Perbarui Catatan Kasus</h3>
                <button type="button" @click="openEditNoteModal = false" class="w-8 h-8 rounded-full bg-[#F8FAFF] hover:bg-[#E2E8F0] text-[#1E1B4B] flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form :action="'/guru/students/{{ $student->id }}/notes/' + selectedNoteId" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tanggal Bimbingan</label>
                        <input type="date" name="tanggal" x-model="editTanggal" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Bidang Bimbingan</label>
                        <select name="kategori" x-model="editKategori" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                            <option value="Pribadi">Pribadi</option>
                            <option value="Belajar">Belajar</option>
                            <option value="Karir">Karir & Lanjutan Studi</option>
                            <option value="Sosial">Sosial / Pergaulan</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Keluhan / Gambaran Masalah</label>
                    <textarea name="keluhan_masalah" x-model="editKeluhan" rows="3" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Layanan / Tindakan BK Diberikan</label>
                    <textarea name="layanan_diberikan" x-model="editLayanan" rows="3" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Tindak Lanjut & Rencana Evaluasi</label>
                    <input type="text" name="tindak_lanjut_evaluasi" x-model="editTindakLanjut" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-[#475569] mb-1.5">Status Penanganan</label>
                    <select name="status" x-model="editStatus" class="w-full px-4 py-2.5 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                        <option value="Dalam Pemantauan">Dalam Pemantauan</option>
                        <option value="Selesai / Teratasi">Selesai / Teratasi</option>
                        <option value="Rujukan / Alih Tangan">Rujukan / Alih Tangan Kasus</option>
                    </select>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-[#E2E8F0]">
                    <button type="button" @click="openEditNoteModal = false" class="px-5 py-2.5 bg-[#F8FAFF] hover:bg-[#E2E8F0] active:scale-95 text-[#1E1B4B] border border-[#E2E8F0] font-bold text-xs rounded-xl cursor-pointer transition-all">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl shadow-xs cursor-pointer transition-all">
                        Perbarui Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
