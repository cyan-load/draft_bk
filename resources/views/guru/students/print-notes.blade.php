<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekam Jejak Konseling - {{ $student->nama }} (NIS: {{ $student->nis }})</title>
    <!-- Tailwind CSS for screen preview -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Times+New+Roman&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        @page {
            size: A4 portrait;
            margin: 0; /* Menghilangkan URL dan header/footer bawaan browser secara otomatis */
        }
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #111;
            background-color: #f8fafc;
        }
        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm 20mm 20mm 20mm;
            margin: 20px auto;
            background: white;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            box-sizing: border-box;
        }
        @media print {
            @page {
                size: A4 portrait;
                margin: 0; /* Menghapus otomatis URL, tanggal, dan header/footer browser */
            }
            html, body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .page {
                width: 100% !important;
                min-height: auto !important;
                margin: 0 !important;
                padding: 15mm 20mm 20mm 20mm !important;
                box-shadow: none !important;
                border: none !important;
            }
            .no-print {
                display: none !important;
            }
        }
        .kop-border {
            border-bottom: 3px double #000;
        }
    </style>
</head>
<body x-data="{ 
    openSettingsModal: false,
    schoolName: '{{ addslashes($customSchoolName) }}',
    schoolAddress: '{{ addslashes($customAddress) }}',
    schoolPhone: '{{ addslashes($customPhone) }}',
    schoolEmail: '{{ addslashes($customEmail) }}',
    headmasterName: '{{ addslashes($customHeadmaster) }}',
    headmasterNip: '{{ addslashes($customHeadmasterNip) }}',
    counselorName: '{{ addslashes($customCounselor) }}',
    counselorNip: '{{ addslashes($customCounselorNip) }}',
    cityDate: '{{ addslashes($customCityDate) }}'
}">

    <!-- FLOATING ACTION BAR (SCREEN ONLY) -->
    <div class="no-print fixed top-5 left-1/2 -translate-x-1/2 z-50 bg-[#1E1B4B] text-white px-5 py-2.5 rounded-2xl shadow-2xl flex items-center gap-3 border border-white/20">
        <button type="button" onclick="if (window.opener || window.history.length <= 1) { window.close(); } else { window.history.back(); }" class="text-xs font-semibold text-white/90 hover:text-white flex items-center gap-1.5 transition-colors cursor-pointer">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali</span>
        </button>
        <div class="h-4 w-px bg-white/30"></div>

        <!-- Pilihan Mode Cetak: Satu Per Satu atau Semua -->
        <div class="flex items-center gap-2">
            <span class="text-xs text-white/80 font-medium">Pilih Catatan:</span>
            <select onchange="window.location.href = this.value" class="bg-white/10 hover:bg-white/20 text-white border border-white/30 rounded-xl px-2.5 py-1 text-xs outline-none cursor-pointer">
                <option value="{{ route('guru.students.notes.print', $student->id) }}" class="text-[#1E1B4B]" {{ empty(request('note_id')) ? 'selected' : '' }}>
                    Cetak Semua Catatan ({{ $student->counselingNotes->count() }} Sesi)
                </option>
                @foreach($student->counselingNotes as $idx => $n)
                    <option value="{{ route('guru.students.notes.print', ['id' => $student->id, 'note_id' => $n->id]) }}" class="text-[#1E1B4B]" {{ request('note_id') == $n->id ? 'selected' : '' }}>
                        Sesi #{{ $idx + 1 }}: {{ $n->tanggal ? $n->tanggal->format('d/m/Y') : '-' }} ({{ $n->kategori }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="h-4 w-px bg-white/30"></div>
        <button @click="openSettingsModal = true" class="text-xs font-bold px-3 py-1.5 bg-[#B5BAFF] text-[#1E1B4B] hover:bg-white rounded-xl transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span>Sesuaikan Kop/Ttd</span>
        </button>
        <button onclick="window.print()" class="text-xs font-bold px-4 py-1.5 bg-[#9FA1FF] text-[#1E1B4B] hover:bg-[#8E90FF] rounded-xl transition-all shadow-sm flex items-center gap-1.5 cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4H7v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            <span>Cetak / Unduh PDF</span>
        </button>
    </div>

    <!-- DOCUMENT PAGE -->
    <div class="page text-[13px] leading-relaxed">
        
        <!-- KOP SURAT RESMI -->
        <div class="text-center pb-4 mb-5 kop-border">
            <h3 class="text-base font-bold uppercase tracking-wider">PEMERINTAH DAERAH PROVINSI</h3>
            <h2 class="text-xl font-bold uppercase tracking-wide mt-0.5" x-text="schoolName || '[ .................................. (NAMA SATUAN PENDIDIKAN / SEKOLAH) .................................. ]'"></h2>
            <h4 class="text-sm font-bold uppercase tracking-wide">UNIT BIMBINGAN DAN KONSELING (BK)</h4>
            <p class="text-xs mt-1" x-text="(schoolAddress || '[ Alamat Sekolah ]') + ' | Telp: ' + (schoolPhone || '[ No. Telepon ]') + ' | Email: ' + (schoolEmail || '[ Email Sekolah ]')"></p>
        </div>

        <!-- JUDUL LAPORAN -->
        <div class="text-center my-6">
            @if(request('note_id'))
                <h2 class="text-base font-bold uppercase underline tracking-wider">LEMBAR REKAM CATATAN KONSELING INDIVIDUAL SISWA</h2>
                <p class="text-xs font-semibold mt-1">Dokumen Layanan Bimbingan & Konseling Sekolah</p>
            @else
                <h2 class="text-base font-bold uppercase underline tracking-wider">REKAM JEJAK & CATATAN LAYANAN KONSELING SISWA</h2>
                <p class="text-xs font-semibold mt-1">Tahun Pelajaran {{ date('Y') }}/{{ date('Y', strtotime('+1 year')) }}</p>
            @endif
        </div>

        <!-- IDENTITAS SISWA -->
        <div class="mb-6 border border-black p-3.5 rounded-sm">
            <table class="w-full text-xs">
                <tr>
                    <td class="font-bold py-1 w-36">Nama Siswa</td>
                    <td class="w-4">:</td>
                    <td class="font-bold uppercase">{{ $student->nama }}</td>
                    <td class="font-bold py-1 w-32">Kelas / Tingkat</td>
                    <td class="w-4">:</td>
                    <td>{{ $student->kelas }}</td>
                </tr>
                <tr>
                    <td class="font-bold py-1">NIS / NISN</td>
                    <td>:</td>
                    <td>{{ $student->nis }}</td>
                    <td class="font-bold py-1">Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $student->jenis_kelamin ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-bold py-1">No. Kontak Siswa</td>
                    <td>:</td>
                    <td>{{ $student->nomor_telepon ?? '-' }}</td>
                    <td class="font-bold py-1">No. Kontak Orang Tua</td>
                    <td>:</td>
                    <td>{{ $student->nomor_telepon_orang_tua ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="font-bold py-1">Alamat Domisili</td>
                    <td>:</td>
                    <td colspan="4">{{ $student->alamat ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <!-- TABEL CATATAN BIMBINGAN KASUS -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-2">
                <h4 class="font-bold text-xs uppercase">A. Rekam Catatan & Layanan Bimbingan</h4>
                @if(request('note_id'))
                    <span class="text-[11px] font-semibold text-slate-500 italic">* Sesi Tunggal Terpilih</span>
                @else
                    <span class="text-[11px] font-semibold text-slate-500 italic">* Seluruh Riwayat ({{ $notes->count() }} Sesi)</span>
                @endif
            </div>
            <table class="w-full border-collapse border border-black text-xs">
                <thead>
                    <tr class="bg-gray-100 text-center font-bold">
                        <th class="border border-black p-2 w-8">No</th>
                        <th class="border border-black p-2 w-24">Tanggal</th>
                        <th class="border border-black p-2 w-24">Bidang</th>
                        <th class="border border-black p-2">Masalah / Keluhan Siswa</th>
                        <th class="border border-black p-2">Layanan & Tindakan BK</th>
                        <th class="border border-black p-2">Rencana Tindak Lanjut</th>
                        <th class="border border-black p-2 w-24">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notes as $index => $note)
                        <tr>
                            <td class="border border-black p-2 text-center align-top">{{ $index + 1 }}</td>
                            <td class="border border-black p-2 text-center align-top">{{ $note->tanggal ? $note->tanggal->format('d/m/Y') : '-' }}</td>
                            <td class="border border-black p-2 text-center align-top font-bold">{{ $note->kategori }}</td>
                            <td class="border border-black p-2 align-top">{{ $note->keluhan_masalah }}</td>
                            <td class="border border-black p-2 align-top">{{ $note->layanan_diberikan }}</td>
                            <td class="border border-black p-2 align-top">{{ $note->tindak_lanjut_evaluasi ?? '-' }}</td>
                            <td class="border border-black p-2 text-center align-top uppercase font-semibold">{{ $note->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="border border-black p-4 text-center italic text-gray-500">Belum ada catatan layanan konseling untuk siswa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- LEMBAR PENGESAHAN / TANDA TANGAN -->
        <div class="mt-12 break-inside-avoid">
            <div class="flex justify-between text-xs">
                
                <div class="w-64 text-center">
                    <p>Mengetahui,</p>
                    <p class="font-bold">Kepala Sekolah</p>
                    <div class="h-16"></div>
                    <p class="font-bold underline" x-text="headmasterName ? headmasterName : '( .................................................. )'"></p>
                    <p x-text="headmasterNip ? ('NIP. ' + headmasterNip) : 'NIP. ...............................................'"></p>
                </div>

                <div class="w-64 text-center">
                    <p x-text="(cityDate || '.........................') + ', ' + '{{ date('d F Y') }}'"></p>
                    <p class="font-bold">Guru Bimbingan Konseling</p>
                    <div class="h-16"></div>
                    <p class="font-bold underline" x-text="counselorName ? counselorName : '( .................................................. )'"></p>
                    <p x-text="counselorNip ? ('NIP. ' + counselorNip) : 'NIP. ...............................................'"></p>
                </div>

            </div>
        </div>

    </div>

    <!-- MODAL PENGATURAN TEMPLATE CETAK (SCREEN ONLY) -->
    <div x-show="openSettingsModal" x-cloak class="no-print fixed inset-0 z-50 overflow-y-auto bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div @click.away="openSettingsModal = false" class="bg-white rounded-3xl border border-gray-200 max-w-xl w-full p-8 shadow-2xl space-y-6 relative font-sans">
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h3 class="text-lg font-bold text-gray-900">Pengaturan Manual Template Cetak Dokumen</h3>
                <button @click="openSettingsModal = false" class="text-gray-400 hover:text-gray-900 font-black text-xl cursor-pointer">&times;</button>
            </div>

            <form action="{{ route('guru.report_settings.update') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Nama Satuan Pendidikan (Sekolah)</label>
                    <input type="text" name="school_name" x-model="schoolName" placeholder="Contoh: SMA Negeri 1 ..." class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Alamat Lengkap Sekolah</label>
                    <input type="text" name="school_address" x-model="schoolAddress" placeholder="Contoh: Jl. Pendidikan No. 10 ..." class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">No. Telepon Sekolah</label>
                        <input type="text" name="school_phone" x-model="schoolPhone" placeholder="Contoh: (021) 123456" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Email Sekolah</label>
                        <input type="text" name="school_email" x-model="schoolEmail" placeholder="Contoh: sekolah@sch.id" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Nama Kepala Sekolah</label>
                        <input type="text" name="headmaster_name" x-model="headmasterName" placeholder="Nama & Gelar Kepala Sekolah" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">NIP Kepala Sekolah</label>
                        <input type="text" name="headmaster_nip" x-model="headmasterNip" placeholder="NIP Kepala Sekolah" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Nama Guru Pembimbing BK</label>
                        <input type="text" name="counselor_name" x-model="counselorName" placeholder="Nama & Gelar Guru BK" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">NIP Guru BK</label>
                        <input type="text" name="counselor_nip" x-model="counselorNip" placeholder="NIP Guru BK" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-600 mb-1">Kota Tempat Cetak Surat</label>
                    <input type="text" name="city_date" x-model="cityDate" placeholder="Contoh: Jakarta / Bandung / Surabaya" class="w-full px-4 py-2 border border-gray-300 rounded-xl text-sm outline-none focus:ring-2 focus:ring-[#9FA1FF]">
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-200">
                    <button type="button" @click="openSettingsModal = false" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs rounded-xl transition-all cursor-pointer">
                        Batal
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
