<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuisioner Siswa - {{ $student->nama }} - {{ $questionnaire->judul }}</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        [x-cloak] { display: none !important; }
        body { font-family: 'Times New Roman', Times, serif; background-color: #525659; }
        
        .print-page {
            width: 210mm;
            min-height: 297mm;
            padding: 15mm 20mm 20mm 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            box-sizing: border-box;
            position: relative;
        }

        @media print {
            @page {
                size: A4 portrait;
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

    <!-- DOCUMENT PAGE -->
    <div class="print-page text-black text-sm">
        
        <!-- KOP SURAT RESMI -->
        <div class="border-b-[3px] border-black pb-2 mb-4 text-center relative">
            <h3 class="text-sm font-bold uppercase tracking-wider">PEMERINTAH PROVINSI DINAS PENDIDIKAN</h3>
            <h2 class="text-lg font-black uppercase tracking-normal" x-text="schoolName || '[ .................................. (NAMA SATUAN PENDIDIKAN / SEKOLAH) .................................. ]'"></h2>
            <h4 class="text-xs font-bold uppercase tracking-widest text-slate-800">LAYANAN BIMBINGAN DAN KONSELING (BK)</h4>
            <p class="text-[11px] leading-tight text-slate-700 mt-1" x-text="(schoolAddress || '[ Alamat Sekolah ]') + ' | Telp: ' + (schoolPhone || '[ No. Telepon ]') + ' | Email: ' + (schoolEmail || '[ Email Sekolah ]')"></p>
            <div class="border-b border-black mt-1"></div>
        </div>

        <!-- JUDUL DOKUMEN -->
        <div class="text-center my-4">
            <h1 class="text-base font-bold uppercase tracking-wider underline">LEMBAR HASIL ASESMEN & KUISIONER SISWA</h1>
            <p class="text-xs italic mt-0.5" x-text="'Instrumen: ' + '{{ addslashes($questionnaire->judul) }}'"></p>
        </div>

        <!-- IDENTITAS SISWA & ANGKET -->
        <div class="bg-slate-50 border border-slate-300 p-3 rounded-lg mb-5 text-xs">
            <table class="w-full text-left">
                <tr>
                    <td class="w-32 font-bold py-0.5">Nama Siswa</td>
                    <td class="w-3">:</td>
                    <td class="font-bold uppercase text-slate-900">{{ $student->nama }}</td>
                    <td class="w-28 font-bold py-0.5">Target Kelas</td>
                    <td class="w-3">:</td>
                    <td>{{ $questionnaire->target_kelas }}</td>
                </tr>
                <tr>
                    <td class="font-bold py-0.5">NIS / Akun</td>
                    <td>:</td>
                    <td>{{ $student->nis }} / {{ $student->email ?? '-' }}</td>
                    <td class="font-bold py-0.5">Total Soal</td>
                    <td>:</td>
                    <td>{{ count($questionnaire->questions) }} Butir Pertanyaan</td>
                </tr>
                <tr>
                    <td class="font-bold py-0.5">Kelas / Jurusan</td>
                    <td>:</td>
                    <td>Kelas {{ $student->kelas }}</td>
                    <td class="font-bold py-0.5">Total Skor</td>
                    <td>:</td>
                    <td class="font-bold text-slate-900">{{ $totalScore }} Poin</td>
                </tr>
            </table>
        </div>

        <!-- TABEL RINCIAN PERTANYAAN & JAWABAN SISWA -->
        <div class="mb-6">
            <h3 class="font-bold text-xs uppercase mb-2">A. Rekapitulasi Jawaban Responden:</h3>
            <table class="w-full border-collapse border border-black text-xs">
                <thead>
                    <tr class="bg-slate-200">
                        <th class="border border-black px-2 py-1.5 text-center w-8">No</th>
                        <th class="border border-black px-3 py-1.5 text-left">Butir Pertanyaan / Aspek Asesmen</th>
                        <th class="border border-black px-3 py-1.5 text-left w-56">Jawaban Siswa</th>
                        <th class="border border-black px-2 py-1.5 text-center w-16">Bobot/Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($questionnaire->questions as $index => $q)
                        @php
                            $qAnswers = $answers->get($q->id);
                        @endphp
                        <tr>
                            <td class="border border-black px-2 py-2 text-center align-top">{{ $index + 1 }}</td>
                            <td class="border border-black px-3 py-2 align-top">
                                <p class="font-semibold text-slate-900">{{ $q->teks_pertanyaan }}</p>
                                @if($q->aspek)
                                    <span class="text-[10px] text-slate-600 italic">Aspek: {{ $q->aspek }}</span>
                                @endif
                            </td>
                            <td class="border border-black px-3 py-2 align-top">
                                @if($qAnswers && $qAnswers->isNotEmpty())
                                    <span class="font-bold text-slate-900">
                                        {{ $qAnswers->map(fn($a) => $a->option ? $a->option->teks_opsi : $a->jawaban_teks)->filter()->unique()->implode(', ') }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic">Tidak dijawab</span>
                                @endif
                            </td>
                            <td class="border border-black px-2 py-2 text-center align-top font-semibold">
                                @if($qAnswers && $qAnswers->isNotEmpty())
                                    {{ $qAnswers->sum(fn($a) => $a->option ? ($a->option->bobot_nilai ?? 0) : 0) }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border border-black p-4 text-center italic">Tidak ada pertanyaan.</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-slate-100 font-bold">
                        <td colspan="3" class="border border-black px-3 py-1.5 text-right uppercase">Akumulasi Total Skor Jawaban:</td>
                        <td class="border border-black px-2 py-1.5 text-center text-slate-900">{{ $totalScore }} Poin</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- CATATAN & INTERPRETASI GURU BK -->
        <div class="mb-8 border border-black p-3.5 rounded-sm">
            <h3 class="font-bold text-xs uppercase mb-1">B. Catatan Interpretasi & Rekomendasi Konselor BK:</h3>
            <p class="text-xs text-slate-800 leading-relaxed italic">
                Berdasarkan hasil pengisian instrumen kuisioner di atas, siswa bersangkutan telah menyelesaikan asesmen dengan total skor <strong>{{ $totalScore }} poin</strong>. Data ini dijadikan acuan dalam penyusunan program layanan bimbingan pribadi, sosial, belajar, maupun karir.
            </p>
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

    <!-- MODAL EDIT PENGATURAN TEMPLATE LAPORAN RESMI -->
    <div x-show="openSettingsModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 font-sans">
        <div @click.away="openSettingsModal = false" class="bg-white rounded-3xl border border-gray-200 max-w-2xl w-full p-8 shadow-2xl space-y-6 relative max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">⚙️ Pengaturan Kop & Template Cetak Dokumen</h3>
                <button type="button" @click="openSettingsModal = false" class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 text-gray-700 flex items-center justify-center font-bold text-lg cursor-pointer transition-all">&times;</button>
            </div>

            <form action="{{ route('guru.report_settings.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Satuan Pendidikan / Sekolah</label>
                    <input type="text" name="school_name" x-model="schoolName" placeholder="Contoh: SMA Negeri 1 ..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Alamat Lengkap Sekolah</label>
                    <input type="text" name="school_address" x-model="schoolAddress" placeholder="Contoh: Jl. Pendidikan No. 10 ..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nomor Telepon Sekolah</label>
                        <input type="text" name="school_phone" x-model="schoolPhone" placeholder="Contoh: (021) 123456" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Email Resmi Sekolah</label>
                        <input type="text" name="school_email" x-model="schoolEmail" placeholder="Contoh: sekolah@sch.id" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 border-t border-gray-200 pt-3">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="headmaster_name" x-model="headmasterName" placeholder="Nama & Gelar Kepala Sekolah" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="headmaster_nip" x-model="headmasterNip" placeholder="NIP Kepala Sekolah" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Nama Guru Pembimbing BK</label>
                        <input type="text" name="counselor_name" x-model="counselorName" placeholder="Nama & Gelar Guru BK" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-600 uppercase mb-1">NIP Guru BK</label>
                        <input type="text" name="counselor_nip" x-model="counselorNip" placeholder="NIP Guru BK" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Kota Tempat Pengesahan Surat</label>
                    <input type="text" name="city_date" x-model="cityDate" placeholder="Contoh: Jakarta / Bandung / Surabaya" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-300 rounded-xl text-xs outline-none focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] text-gray-900">
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button" @click="openSettingsModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl cursor-pointer">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-xs font-bold rounded-xl shadow-xs cursor-pointer">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
