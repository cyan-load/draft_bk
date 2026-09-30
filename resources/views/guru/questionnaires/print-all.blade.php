<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Hasil Kuisioner - {{ $questionnaire->judul }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }
        [x-cloak] { display: none !important; }
        body { font-family: 'Times New Roman', Times, serif; background-color: #525659; }
        
        .print-page {
            width: 297mm; /* Landscape for wide table */
            min-height: 210mm;
            padding: 15mm 20mm 20mm 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            box-sizing: border-box;
            position: relative;
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 0;
            }
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }
            .no-print {
                display: none !important;
            }
            .print-page {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                min-height: auto !important;
                padding: 15mm 20mm 20mm 20mm !important;
                page-break-after: always;
            }
        }
    </style>
</head>
<body class="antialiased" x-data="{
    openSettingsModal: false,
    schoolName: '{{ addslashes($setting->school_name ?? '') }}',
    schoolAddress: '{{ addslashes($setting->school_address ?? '') }}',
    schoolPhone: '{{ addslashes($setting->school_phone ?? '') }}',
    schoolEmail: '{{ addslashes($setting->school_email ?? '') }}',
    headmasterName: '{{ addslashes($setting->headmaster_name ?? '') }}',
    headmasterNip: '{{ addslashes($setting->headmaster_nip ?? '') }}',
    counselorName: '{{ addslashes($setting->counselor_name ?? '') }}',
    counselorNip: '{{ addslashes($setting->counselor_nip ?? '') }}',
    cityDate: '{{ addslashes($setting->city_date ?? '') }}'
}">

    <!-- FLOATING ACTION BAR (SCREEN ONLY) -->
    <div class="no-print fixed top-5 left-1/2 -translate-x-1/2 z-50 bg-[#1E1B4B] text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-4 border border-white/20">
        <button type="button" onclick="if (window.opener || window.history.length <= 1) { window.close(); } else { window.history.back(); }" class="text-xs font-semibold text-white/90 hover:text-white flex items-center gap-1.5 transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </button>
        <div class="h-4 w-px bg-white/30"></div>
        <button @click="openSettingsModal = true" class="text-xs font-bold px-3.5 py-1.5 bg-[#B5BAFF] text-[#1E1B4B] hover:bg-white rounded-xl transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Sesuaikan Template Dokumen</span>
        </button>
        <button onclick="window.print()" class="text-xs font-bold px-4 py-1.5 bg-[#9FA1FF] text-[#1E1B4B] hover:bg-[#8E90FF] rounded-xl transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak / Unduh PDF</span>
        </button>
    </div>

    <!-- DOCUMENT PAGE (LANDSCAPE A4) -->
    <div class="print-page text-black text-xs">
        
        <!-- KOP SURAT RESMI -->
        <div class="border-b-[3px] border-black pb-2 mb-4 text-center relative">
            <h3 class="text-xs font-bold uppercase tracking-wider">PEMERINTAH PROVINSI DINAS PENDIDIKAN</h3>
            <h2 class="text-base font-black uppercase" x-text="schoolName || '[ .................................. (NAMA SATUAN PENDIDIKAN / SEKOLAH) .................................. ]'"></h2>
            <h4 class="text-[11px] font-bold uppercase tracking-widest text-slate-800">LAYANAN BIMBINGAN DAN KONSELING (BK)</h4>
            <p class="text-[10px] leading-tight text-slate-700 mt-0.5" x-text="(schoolAddress || '[ Alamat Sekolah ]') + ' | Telp: ' + (schoolPhone || '[ No. Telepon ]') + ' | Email: ' + (schoolEmail || '[ Email Sekolah ]')"></p>
            <div class="border-b border-black mt-1"></div>
        </div>

        <!-- JUDUL DOKUMEN -->
        <div class="text-center my-3">
            <h1 class="text-sm font-bold uppercase tracking-wider underline">REKAPITULASI HASIL PENGISIAN ANGKET / KUISIONER</h1>
            <p class="text-xs italic mt-0.5" x-text="'Instrumen: ' + '{{ addslashes($questionnaire->judul) }}' + ' (Target: ' + '{{ $questionnaire->target_kelas }}' + ')'"></p>
        </div>

        <!-- METADATA RINGKASAN -->
        <div class="bg-slate-50 border border-slate-300 p-2.5 rounded-lg mb-4 text-xs flex justify-between">
            <div>Total Butir Pertanyaan: <strong>{{ count($questionnaire->questions) }} Soal</strong></div>
            <div>Total Siswa Responden: <strong>{{ count($answersByStudent) }} Siswa</strong></div>
            <div>Tanggal Cetak Rekap: <strong>{{ date('d F Y') }}</strong></div>
        </div>

        <!-- TABEL REKAPITULASI RESPONDEN -->
        <div class="mb-6">
            <table class="w-full border-collapse border border-black text-[11px]">
                <thead>
                    <tr class="bg-slate-200">
                        <th class="border border-black px-1.5 py-1 text-center w-8">No</th>
                        <th class="border border-black px-2 py-1 text-center w-24">NIS</th>
                        <th class="border border-black px-2 py-1 text-left">Nama Lengkap Siswa</th>
                        <th class="border border-black px-2 py-1 text-center w-16">Kelas</th>
                        <th class="border border-black px-2 py-1 text-center w-28">Waktu Isi</th>
                        @foreach($questionnaire->questions as $idx => $q)
                            <th class="border border-black px-1.5 py-1 text-center w-12" title="{{ $q->teks_pertanyaan }}">
                                P{{ $idx + 1 }}
                            </th>
                        @endforeach
                        <th class="border border-black px-2 py-1 text-center w-16">Total Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @php $no = 1; @endphp
                    @forelse($answersByStudent as $studentId => $answers)
                        @php
                            $firstAns = $answers->first();
                            $student = $firstAns->student ?? \App\Models\Student::find($studentId);
                            $answersGrouped = $answers->groupBy('question_id');
                            $totalScore = $answers->sum(function($a) {
                                return $a->option ? ($a->option->bobot_nilai ?? 0) : 0;
                            });
                        @endphp
                        @if($student)
                            <tr>
                                <td class="border border-black px-1.5 py-1 text-center">{{ $no++ }}</td>
                                <td class="border border-black px-2 py-1 text-center font-mono">{{ $student->nis }}</td>
                                <td class="border border-black px-2 py-1 font-semibold">{{ $student->nama }}</td>
                                <td class="border border-black px-2 py-1 text-center">{{ $student->kelas }}</td>
                                <td class="border border-black px-2 py-1 text-center">{{ $firstAns->created_at ? $firstAns->created_at->format('d/m/y H:i') : '-' }}</td>
                                @foreach($questionnaire->questions as $q)
                                    @php
                                        $qAnswers = $answersGrouped->get($q->id);
                                        $hasScore = $qAnswers && $qAnswers->some(fn($a) => $a->option && ($a->option->bobot_nilai ?? 0) > 0);
                                    @endphp
                                    <td class="border border-black px-1 py-1 text-center">
                                        @if($qAnswers && $qAnswers->isNotEmpty())
                                            @if($hasScore)
                                                <span class="font-bold">{{ $qAnswers->sum(fn($a) => $a->option ? ($a->option->bobot_nilai ?? 0) : 0) }}</span>
                                            @else
                                                <span class="text-emerald-700 font-bold">✓</span>
                                            @endif
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="border border-black px-2 py-1 text-center font-bold bg-slate-50">{{ $totalScore }}</td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="{{ 6 + count($questionnaire->questions) }}" class="border border-black p-4 text-center italic">Belum ada responden.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- LEMBAR TANDA TANGAN PENGESAHAN -->
        <div class="mt-8 flex justify-between text-xs break-inside-avoid">
            <div class="w-64 text-center">
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala Sekolah</p>
                <div class="h-16"></div>
                <p class="font-bold underline" x-text="headmasterName ? headmasterName : '( .................................................. )'"></p>
                <p x-text="headmasterNip ? ('NIP. ' + headmasterNip) : 'NIP. ...............................................'"></p>
            </div>

            <div class="w-64 text-center">
                <p x-text="(cityDate || '.........................') + ', ' + '{{ date('d F Y') }}'"></p>
                <p class="font-bold">Guru Pembimbing / Konselor BK</p>
                <div class="h-16"></div>
                <p class="font-bold underline" x-text="counselorName ? counselorName : '( .................................................. )'"></p>
                <p x-text="counselorNip ? ('NIP. ' + counselorNip) : 'NIP. ...............................................'"></p>
            </div>
        </div>

    </div>

    <!-- MODAL PENGATURAN TEMPLATE DOKUMEN -->
    <div x-show="openSettingsModal" x-cloak class="no-print fixed inset-0 z-[9999] overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openSettingsModal = false" class="bg-white rounded-3xl border border-gray-200 max-w-xl w-full p-8 shadow-2xl space-y-6 relative text-gray-900 font-sans">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">⚙️ Pengaturan Kop & Template Dokumen Cetak</h3>
                <button type="button" @click="openSettingsModal = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form action="{{ route('guru.report_settings.update') }}" method="POST" class="space-y-4 text-xs">
                @csrf
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="block font-bold uppercase text-gray-600 mb-1">Nama Satuan Pendidikan / Sekolah</label>
                        <input type="text" name="school_name" x-model="schoolName" placeholder="Contoh: SMA Negeri 1 ..." class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div class="col-span-2">
                        <label class="block font-bold uppercase text-gray-600 mb-1">Alamat Lengkap Sekolah</label>
                        <input type="text" name="school_address" x-model="schoolAddress" placeholder="Contoh: Jl. Pendidikan No. 10 ..." class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">No. Telepon Sekolah</label>
                        <input type="text" name="school_phone" x-model="schoolPhone" placeholder="Contoh: (021) 123456" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">Email Resmi Sekolah</label>
                        <input type="text" name="school_email" x-model="schoolEmail" placeholder="Contoh: sekolah@sch.id" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="headmaster_name" x-model="headmasterName" placeholder="Nama & Gelar Kepala Sekolah" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="headmaster_nip" x-model="headmasterNip" placeholder="NIP Kepala Sekolah" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">Nama Guru Pembimbing BK</label>
                        <input type="text" name="counselor_name" x-model="counselorName" placeholder="Nama & Gelar Guru BK" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-gray-600 mb-1">NIP Guru Pembimbing BK</label>
                        <input type="text" name="counselor_nip" x-model="counselorNip" placeholder="NIP Guru BK" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div class="col-span-2">
                        <label class="block font-bold uppercase text-gray-600 mb-1">Kota & Tanggal Dokumen</label>
                        <input type="text" name="city_date" x-model="cityDate" placeholder="Contoh: Jakarta / Bandung / Surabaya" class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-xl outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button" @click="openSettingsModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] font-bold rounded-xl shadow-xs cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
