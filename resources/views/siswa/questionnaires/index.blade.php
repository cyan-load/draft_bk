@extends('layouts.student')

@section('title', 'Kuisioner & Angket Siswa - SIM-BK')

@section('content')

<div class="max-w-6xl mx-auto space-y-6 pb-12 bg-white">
    <div>
        <h2 class="text-2xl md:text-3xl font-extrabold text-[#1E1B4B] tracking-tight">Kuisioner & Angket BK</h2>
        <p class="text-[#64748B] text-sm mt-0.5 font-medium">Silakan isi instrumen bimbingan konseling dan asesmen aktif yang ditugaskan oleh Guru BK.</p>
    </div>

    @if(session('success'))
        <div class="bg-[#D9F9DF] border border-[#BBF7D0] text-[#14532D] text-xs p-4 rounded-2xl shadow-2xs font-semibold">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 text-xs p-4 rounded-2xl shadow-2xs font-semibold">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($questionnaires as $q)
            @php 
                $isAnswered = in_array($q->id, $answeredIds); 
                $isFinished = ($q->status === 'finished');
            @endphp
            <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs flex flex-col justify-between space-y-5 hover:shadow-md transition-all">
                <div>
                    <div class="flex items-center justify-between mb-3">
                        @if($isAnswered)
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase bg-[#D9F9DF] text-[#14532D] border border-[#BBF7D0]">
                                ✓ Sudah Diisi
                            </span>
                        @elseif($isFinished)
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase bg-indigo-50 text-indigo-700 border border-indigo-200 inline-flex items-center gap-1">
                                <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                <span>Selesai / Ditutup</span>
                            </span>
                        @else
                            <span class="text-[10px] font-bold px-3 py-1 rounded-full uppercase bg-[#AEE2FF]/40 text-[#0369A1] border border-[#AEE2FF]">
                                ● Belum Diisi
                            </span>
                        @endif
                        <span class="text-xs text-[#64748B] font-semibold">{{ $q->created_at->format('d M Y') }}</span>
                    </div>
                    
                    <h3 class="text-lg font-bold text-[#1E1B4B]">{{ $q->title ?? $q->judul ?? 'Tanpa Judul' }}</h3>
                    <p class="text-xs text-[#475569] mt-1.5 line-clamp-2 leading-relaxed">{{ $q->description ?? $q->deskripsi ?? 'Tidak ada petunjuk tambahan.' }}</p>
                    
                    <div class="mt-4 flex items-center gap-2">
                        <span class="px-2.5 py-1 bg-[#F8FAFF] text-[#1E1B4B] rounded-lg text-[11px] font-bold border border-[#E2E8F0]">
                            Target: {{ $q->target_kelas }}
                        </span>
                        <span class="px-2.5 py-1 bg-[#F8FAFF] text-[#64748B] rounded-lg text-[11px] font-semibold border border-[#E2E8F0]">
                            {{ $q->questions->count() }} Pertanyaan
                        </span>
                        @if($isFinished)
                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-700 rounded-lg text-[11px] font-bold border border-indigo-200">
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>

                <div class="pt-2">
                    @if($isAnswered)
                        <div class="flex items-center gap-2">
                            <a href="{{ route('siswa.questionnaires.result', $q->id) }}" class="block text-center flex-1 py-2.5 bg-[#B5BAFF]/30 hover:bg-[#B5BAFF] active:scale-95 text-[#1E1B4B] border border-[#B5BAFF] font-bold text-xs rounded-xl transition-all shadow-2xs cursor-pointer">
                                Lihat Rangkuman Jawaban
                            </a>
                        </div>
                    @elseif($isFinished)
                        <button disabled class="flex items-center justify-center gap-1.5 w-full py-2.5 bg-slate-100 text-slate-400 border border-slate-200 font-bold text-xs rounded-xl cursor-not-allowed">
                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            <span>Kuisioner Telah Ditutup</span>
                        </button>
                    @else
                        <a href="{{ route('siswa.questionnaires.show', $q->id) }}" class="block text-center w-full py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] active:scale-95 text-[#1E1B4B] border border-[#8E90FF] font-bold text-xs rounded-xl transition-all shadow-xs cursor-pointer">
                            Mulai Mengisi Angket
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12 bg-white rounded-3xl border border-[#E2E8F0]">
                <p class="text-xs text-[#64748B] font-bold">Belum ada kuisioner aktif saat ini.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection