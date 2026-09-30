<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kuisioner - SIM-BK</title>
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #FFFFFF; }
        [x-cloak] { display: none !important; }
        select.badge-select {
            -webkit-appearance: none; appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%231E1B4B' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat; background-position: right 0.5rem center; background-size: 1em;
            padding-right: 2rem;
        }
    </style>
</head>
<body class="bg-white text-[#1E293B]" x-data="kuisionerEditForm()">

    <header class="bg-white/90 backdrop-blur-md border-b border-[#E2E8F0] sticky top-0 z-30 px-6 py-4 mb-8 shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('guru.questionnaires.index') }}" class="text-sm font-bold text-[#64748B] hover:text-[#1E1B4B] flex items-center space-x-2 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali ke Kuisioner</span>
                </a>
                <span class="text-[#E2E8F0]">|</span>
                <h1 class="text-xl font-bold text-[#1E1B4B] tracking-tight">Edit Kuisioner</h1>
            </div>
            
            <div class="flex items-center space-x-2">
                <a href="{{ route('guru.questionnaires.preview', $questionnaire->id) }}" target="_blank" class="px-3.5 py-2 bg-[#B5BAFF]/30 text-[#1E1B4B] border border-[#B5BAFF] hover:bg-[#B5BAFF] text-xs font-bold rounded-xl transition-all flex items-center space-x-1.5 shadow-2xs cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span>Preview</span>
                </a>
                <button type="button" @click="submitForm('draft')" class="px-4 py-2 bg-[#F8FAFF] text-[#1E1B4B] hover:bg-[#E2E8F0] text-xs font-bold rounded-xl border border-[#E2E8F0] transition-all cursor-pointer">
                    Simpan Draft
                </button>
                <button type="button" @click="submitForm('finished')" class="px-4 py-2 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 text-xs font-bold rounded-xl border border-indigo-200 transition-all cursor-pointer">
                    Tutup (Finished)
                </button>
                <button type="button" @click="submitForm('published')" class="px-4 py-2 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] text-xs font-bold rounded-xl border border-[#8E90FF] shadow-xs transition-all cursor-pointer">
                    Perbarui & Publikasikan
                </button>
            </div>
        </div>
    </header>

    <div id="initData" class="hidden"
         data-judul="{{ $questionnaire->title ?? $questionnaire->judul }}" 
         data-deskripsi="{{ $questionnaire->description ?? $questionnaire->deskripsi }}" 
         data-target="{{ $questionnaire->target_kelas }}" 
         data-status="{{ $questionnaire->status ?? ($questionnaire->is_active ? 'published' : 'draft') }}"
         data-questions="{{ json_encode($questionnaire->questions->map(function($q) {
             return [
                 'id' => $q->id,
                 'teks_pertanyaan' => $q->question_text ?? $q->teks_pertanyaan,
                 'tipe_jawaban' => $q->question_type ?? $q->tipe_jawaban,
                 'is_wajib' => ($q->is_required ?? $q->is_wajib) == 1,
                 'aspek' => $q->category ?? $q->aspek,
                 'options' => $q->options->map(fn($o) => ['teks' => $o->option_text ?? $o->teks_opsi, 'bobot' => $o->score ?? $o->bobot_nilai ?? 0])
             ];
         })) }}">
    </div>

    <form action="{{ route('guru.questionnaires.update', $questionnaire->id) }}" method="POST" id="mainForm" class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-8 pb-16">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" id="status_input" value="{{ $questionnaire->status ?? ($questionnaire->is_active ? 'published' : 'draft') }}">
        <input type="hidden" name="is_active" id="is_active" value="{{ $questionnaire->is_active }}">
        <input type="hidden" name="questions_json" id="questions_json" value="">

        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white rounded-3xl border border-[#E2E8F0] p-8 border-t-[6px] border-t-[#9FA1FF] shadow-xs">
                <h2 class="text-xl font-bold text-[#1E1B4B] mb-6">Informasi Kuisioner</h2>
                <div class="space-y-5">
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Judul Kuisioner</label>
                        <input type="text" name="judul" x-model="title" class="w-full px-4 py-3 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] outline-none text-[#1E293B]" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Deskripsi</label>
                        <textarea name="deskripsi" x-model="description" rows="2" class="w-full px-4 py-3 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] outline-none text-[#1E293B]"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#475569] uppercase mb-2">Target Kelas</label>
                        <select name="target_kelas" x-model="targetKelas" class="w-full px-4 py-3 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-[#9FA1FF] outline-none text-[#1E293B] font-medium">
                            <option value="Semua Kelas">Semua Kelas</option>
                            <option value="Kelas 10">Kelas 10</option>
                            <option value="Kelas 11">Kelas 11</option>
                            <option value="Kelas 12">Kelas 12</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 pb-2">
                <h2 class="text-2xl font-bold text-[#1E1B4B]">Daftar Butir Pertanyaan</h2>
                <button type="button" @click="addQuestion()" class="px-5 py-2.5 bg-[#9FA1FF] hover:bg-[#8E90FF] text-[#1E1B4B] border border-[#8E90FF] text-xs font-bold rounded-xl flex items-center gap-1.5 shadow-xs transition-all cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Tambah Butir Soal
                </button>
            </div>

            <template x-if="questions.length === 0">
                <div class="bg-white rounded-3xl border border-dashed border-[#E2E8F0] p-10 text-center">
                    <p class="text-[#64748B] text-sm mb-3">Belum ada pertanyaan pada kuisioner ini.</p>
                    <button type="button" @click="addQuestion()" class="px-4 py-2 bg-[#9FA1FF] text-[#1E1B4B] font-bold text-xs rounded-xl hover:bg-[#8E90FF] border border-[#8E90FF] cursor-pointer">Tambah Soal</button>
                </div>
            </template>

            <template x-for="(q, qIndex) in questions" :key="q.id">
                <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs mb-4 relative">
                    <div class="flex flex-col md:flex-row gap-4 mb-6">
                        <div class="flex-1">
                            <label class="block text-[11px] font-bold text-[#475569] uppercase mb-1.5" x-text="'Butir Soal #' + (qIndex + 1)"></label>
                            <input type="text" :name="`questions[${qIndex}][teks_pertanyaan]`" x-model="q.teks_pertanyaan" class="w-full px-4 py-3 bg-[#F8FAFF] border border-[#E2E8F0] rounded-xl text-sm font-medium outline-none focus:ring-2 focus:ring-[#9FA1FF] text-[#1E293B]" required>
                        </div>
                        <div class="w-full md:w-56 shrink-0">
                            <label class="block text-[11px] font-bold text-[#475569] uppercase mb-1.5">Tipe Jawaban</label>
                            <select :name="`questions[${qIndex}][tipe_jawaban]`" x-model="q.tipe_jawaban" class="w-full px-4 py-3 bg-white border border-[#E2E8F0] rounded-xl text-sm outline-none text-[#1E293B] font-medium">
                                <option value="single_choice">Pilihan Ganda (Satu)</option>
                                <option value="multichoice">Pilihan Ganda (Banyak)</option>
                                <option value="text">Isian / Paragraf</option>
                            </select>
                        </div>
                    </div>

                    <template x-if="q.tipe_jawaban !== 'text'">
                        <div class="space-y-3 mb-4">
                            <label class="block text-[11px] font-bold text-[#475569] uppercase">Pilihan Opsi & Skor Bobot:</label>
                            <template x-for="(opt, oIndex) in q.options" :key="oIndex">
                                <div class="flex items-center gap-3">
                                    <div class="w-5 h-5 border-[1.5px] border-[#B5BAFF] shrink-0" :class="q.tipe_jawaban === 'multichoice' ? 'rounded-md' : 'rounded-full'"></div>
                                    <input type="text" :name="`questions[${qIndex}][opsi][${oIndex}][teks]`" x-model="opt.teks" class="flex-1 text-sm bg-transparent border-b border-[#E2E8F0] hover:border-[#B5BAFF] focus:border-[#1E1B4B] py-1 outline-none text-[#1E293B]" required>
                                    <input type="number" :name="`questions[${qIndex}][opsi][${oIndex}][bobot]`" x-model="opt.bobot" class="w-16 px-2 py-1 bg-[#F8FAFF] border border-[#E2E8F0] rounded-lg text-xs text-center outline-none">
                                    <button type="button" @click="removeOption(qIndex, oIndex)" class="text-[#94A3B8] hover:text-rose-600 p-1 cursor-pointer"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                </div>
                            </template>
                            <button type="button" @click="addOption(qIndex)" class="text-xs font-bold text-[#9FA1FF] hover:underline mt-2 cursor-pointer">Tambah Opsi Pilihan</button>
                        </div>
                    </template>

                    <template x-if="q.tipe_jawaban === 'text'">
                        <div class="mb-6"><div class="w-full border-b border-dashed border-[#E2E8F0] pb-2 pt-2 text-sm text-[#64748B] italic">Siswa akan mengisi dalam bentuk teks bebas...</div></div>
                    </template>

                    <div class="flex items-center justify-between pt-4 border-t border-[#E2E8F0]">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-[#64748B] font-bold">Aspek BK:</span>
                            <select :name="`questions[${qIndex}][aspek]`" x-model="q.aspek" class="badge-select bg-[#B5BAFF]/30 border border-[#B5BAFF] text-[#1E1B4B] rounded-xl px-3 py-1 text-xs font-bold outline-none cursor-pointer">
                                <option value="">Pilih Aspek</option>
                                <option value="Karier">Karier</option>
                                <option value="Pribadi">Pribadi</option>
                                <option value="Sosial">Sosial</option>
                                <option value="Belajar">Belajar</option>
                            </select>
                        </div>
                        <div class="flex items-center gap-4">
                            <label class="flex items-center cursor-pointer gap-2">
                                <div class="relative">
                                    <input type="checkbox" :name="`questions[${qIndex}][is_wajib]`" value="1" x-model="q.is_wajib" class="sr-only peer">
                                    <div class="w-9 h-5 bg-[#E2E8F0] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1E1B4B]"></div>
                                </div>
                                <span class="text-xs font-bold text-[#475569]">Wajib</span>
                            </label>
                            <div class="w-px h-5 bg-[#E2E8F0]"></div>
                            <button type="button" @click="duplicateQuestion(qIndex)" class="text-[#94A3B8] hover:text-[#1E1B4B] cursor-pointer"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></button>
                            <button type="button" @click="removeQuestion(qIndex)" class="text-[#94A3B8] hover:text-rose-600 cursor-pointer"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <div class="lg:col-span-4">
            <div class="bg-white rounded-3xl border border-[#E2E8F0] p-6 shadow-xs sticky top-24">
                <h2 class="text-xl font-bold text-[#1E1B4B] mb-6">Ringkasan Kuisioner</h2>
                <div class="flex gap-4 mb-6">
                    <div class="w-24 h-24 bg-[#B5BAFF]/30 rounded-2xl flex flex-col items-center justify-center shrink-0 border border-[#B5BAFF]">
                        <span class="text-4xl font-extrabold text-[#1E1B4B]" x-text="questions.length"></span>
                        <span class="text-[9px] font-bold text-[#64748B] uppercase mt-1">Total Soal</span>
                    </div>
                    <div class="flex-1 flex flex-col justify-center space-y-2">
                        <div class="bg-[#F8FAFF] border border-[#E2E8F0] px-3 py-2 rounded-xl flex justify-between items-center text-xs">
                            <span class="text-[#64748B] font-medium">Wajib Dijawab</span>
                            <span class="font-bold text-[#1E1B4B]" x-text="requiredCount"></span>
                        </div>
                        <div class="bg-[#F8FAFF] border border-[#E2E8F0] px-3 py-2 rounded-xl flex justify-between items-center text-xs">
                            <span class="text-[#64748B] font-medium">Memiliki Skor</span>
                            <span class="font-bold text-[#1E1B4B]" x-text="scoredCount"></span>
                        </div>
                    </div>
                </div>
                <div class="space-y-4 text-sm border-t border-[#E2E8F0] pt-5">
                    <div class="flex justify-between items-center border-b border-[#E2E8F0] pb-3">
                        <span class="text-[#64748B] font-medium">Status</span>
                        <span class="px-3 py-1 bg-[#B5BAFF]/30 border border-[#B5BAFF] text-[#1E1B4B] font-bold rounded-full text-xs" x-text="statusText"></span>
                    </div>
                    <div class="flex justify-between items-center border-b border-[#E2E8F0] pb-3">
                        <span class="text-[#64748B] font-medium">Target Siswa</span>
                        <span class="font-bold text-[#1E1B4B]" x-text="targetKelas"></span>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kuisionerEditForm', () => {
                const dataContainer = document.getElementById('initData');
                let rawQ = [];
                try { rawQ = JSON.parse(dataContainer.dataset.questions || '[]'); } catch(e) {}

                return {
                    title: dataContainer.dataset.judul,
                    description: dataContainer.dataset.deskripsi,
                    targetKelas: dataContainer.dataset.target,
                    statusText: dataContainer.dataset.status == "1" ? 'Published' : (dataContainer.dataset.status === 'finished' ? 'Finished' : 'Draft'),
                    questions: rawQ,

                    get requiredCount() { return this.questions.filter(q => q.is_wajib).length; },
                    get scoredCount() { return this.questions.filter(q => q.tipe_jawaban !== 'text' && q.options.some(o => o.bobot > 0)).length; },

                    addQuestion() {
                        this.questions.push({ id: Date.now(), teks_pertanyaan: '', tipe_jawaban: 'single_choice', aspek: 'Pribadi', is_wajib: true, options: [{ teks: 'Sangat Sesuai', bobot: 4 }, { teks: 'Sesuai', bobot: 3 }] });
                    },
                    removeQuestion(index) { if(confirm('Hapus pertanyaan ini?')) this.questions.splice(index, 1); },
                    duplicateQuestion(index) {
                        const clone = JSON.parse(JSON.stringify(this.questions[index]));
                        clone.id = Date.now();
                        this.questions.splice(index + 1, 0, clone);
                    },
                    addOption(qIndex) { this.questions[qIndex].options.push({ teks: '', bobot: 0 }); },
                    removeOption(qIndex, oIndex) { this.questions[qIndex].options.splice(oIndex, 1); },
                    submitForm(statusVal) {
                        if (!this.title.trim()) {
                            alert('Mohon masukkan Judul Kuisioner terlebih dahulu.');
                            return;
                        }
                        const isPub = statusVal === 'published';
                        this.statusText = statusVal === 'published' ? 'Published' : (statusVal === 'finished' ? 'Finished' : 'Draft');
                        if(document.getElementById('status_input')) {
                            document.getElementById('status_input').value = statusVal;
                        }
                        document.getElementById('is_active').value = isPub ? 1 : 0;
                        document.getElementById('questions_json').value = JSON.stringify(this.questions);
                        document.getElementById('mainForm').submit();
                    }
                }
            });
        });
    </script>
</body>
</html>