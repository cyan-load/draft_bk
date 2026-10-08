<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Questionnaire;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\StudentAnswer;
use App\Models\CounselingSession;
use App\Models\CalendarEvent;
use App\Models\CounselingNote;
use App\Models\ChatMessage;
use App\Models\AppNotification;
use App\Models\ReportSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic, professional BK data.
     */
    public function run(): void
    {
        // =========================================================================
        // 1. AKUN GURU BK & SISWA (Data Akun & Profil Siswa Dipertahankan & Disempurnakan)
        // =========================================================================
        
        $guruUser = User::updateOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'username' => 'guru',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru',
            ]
        );

        // Siswa 1: Andi Pratama
        $user1 = User::updateOrCreate(
            ['email' => 'andipratama@gmail.com'],
            [
                'username' => '10293',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student1 = Student::updateOrCreate(
            ['nis' => '10293'],
            [
                'user_id' => $user1->id,
                'email' => 'andipratama@gmail.com',
                'nama' => 'Andi Pratama',
                'kelas' => 'XII-1',
                'status' => 'aktif',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2007-05-14',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 45, Coblong, Kota Bandung',
                'nomor_telepon' => '081234567891',
                'nomor_telepon_orang_tua' => '081298765432',
                'nama_ayah' => 'Bambang Pratama, S.T.',
                'nama_ibu' => 'Siti Aminah, S.Pd.',
                'hobi' => 'Pengembangan Perangkat Lunak & Robotik',
                'cita_cita' => 'Ahli Rekayasa Perangkat Lunak (Software Engineer)',
            ]
        );

        // Siswa 2: Rina Putri
        $user2 = User::updateOrCreate(
            ['email' => 'rinaputri@gmail.com'],
            [
                'username' => '10294',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student2 = Student::updateOrCreate(
            ['nis' => '10294'],
            [
                'user_id' => $user2->id,
                'email' => 'rinaputri@gmail.com',
                'nama' => 'Rina Putri',
                'kelas' => 'XII-2',
                'status' => 'aktif',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2007-08-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kenanga No. 12, Sukasari, Kota Bandung',
                'nomor_telepon' => '081345678902',
                'nomor_telepon_orang_tua' => '081398765401',
                'nama_ayah' => 'Hendro Susilo, M.Si.',
                'nama_ibu' => 'Dewi Lestari, S.Farm.',
                'hobi' => 'Jurnalistik, Menulis Esai & Desain Komunikasi Visual',
                'cita_cita' => 'Psikolog Klinis / Konselor Pendidikan',
            ]
        );

        // Siswa 3: Budi Santoso
        $user3 = User::updateOrCreate(
            ['email' => 'budisantoso@gmail.com'],
            [
                'username' => '10295',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student3 = Student::updateOrCreate(
            ['nis' => '10295'],
            [
                'user_id' => $user3->id,
                'email' => 'budisantoso@gmail.com',
                'nama' => 'Budi Santoso',
                'kelas' => 'XI-3',
                'status' => 'aktif',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '2008-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pahlawan No. 88, Cibeunying, Kota Bandung',
                'nomor_telepon' => '081567890123',
                'nomor_telepon_orang_tua' => '081587654321',
                'nama_ayah' => 'Joko Santoso, S.Kom.',
                'nama_ibu' => 'Sri Wahyuni, S.E.',
                'hobi' => 'Mekanika Instrumentasi & Musik Akustik',
                'cita_cita' => 'Teknik Elektro & Otomasi Industri',
            ]
        );

        // =========================================================================
        // 2. BERSIHKAN DATA LAMA SELAIN DATA SISWA
        // =========================================================================
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudentAnswer::truncate();
        QuestionOption::truncate();
        Question::truncate();
        Questionnaire::truncate();
        CounselingSession::truncate();
        CounselingNote::truncate();
        CalendarEvent::truncate();
        ChatMessage::truncate();
        AppNotification::truncate();
        ReportSetting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =========================================================================
        // 3. KUISIONER & ASESMEN DIAGNOSTIK BK
        // =========================================================================

        // INSTRUMEN 1: AKPD / IKMS Terpadu (Status: published)
        $q1 = Questionnaire::create([
            'judul'           => 'Angket Kebutuhan Peserta Didik (AKPD) / IKMS Terpadu',
            'jenis_instrumen' => 'IKMS',
            'deskripsi'       => 'Asesmen kebutuhan diagnostik komprehensif berbasis 4 bidang layanan BK (Pribadi, Sosial, Belajar, dan Karir) guna memetakan prioritas bimbingan tahun ajaran berjalan.',
            'target_kelas'    => 'Semua Kelas',
            'status'          => 'published',
            'is_active'       => 1,
            'published'       => 1,
            'created_at'      => now()->subDays(10),
            'updated_at'      => now()->subDays(10),
        ]);

        $q1Questions = [
            [
                'teks'   => 'Saya membutuhkan informasi terstruktur dan pendampingan mendalam mengenai pemilihan program studi di perguruan tinggi negeri serta peluang karir masa depan.',
                'tipe'   => 'single_choice',
                'aspek'  => 'Karir',
                'options' => [
                    ['teks' => 'Sangat Butuh', 'skor' => 4],
                    ['teks' => 'Butuh', 'skor' => 3],
                    ['teks' => 'Cukup Butuh', 'skor' => 2],
                    ['teks' => 'Tidak Butuh', 'skor' => 1],
                ]
            ],
            [
                'teks'   => 'Saya sering merasa kewalahan dalam membagi waktu antara jadwal tugas sekolah, bimbingan belajar persiapan masuk PTN, dan waktu istirahat harian.',
                'tipe'   => 'single_choice',
                'aspek'  => 'Belajar',
                'options' => [
                    ['teks' => 'Sangat Sering', 'skor' => 4],
                    ['teks' => 'Sering', 'skor' => 3],
                    ['teks' => 'Kadang-kadang', 'skor' => 2],
                    ['teks' => 'Tidak Pernah', 'skor' => 1],
                ]
            ],
            [
                'teks'   => 'Saya kerap mengalami ketegangan emosional atau kecemasan yang menurunkan konsentrasi saat menjelang pelaksanaan ujian sumatif sekolah.',
                'tipe'   => 'single_choice',
                'aspek'  => 'Pribadi',
                'options' => [
                    ['teks' => 'Sangat Sering', 'skor' => 4],
                    ['teks' => 'Sering', 'skor' => 3],
                    ['teks' => 'Kadang-kadang', 'skor' => 2],
                    ['teks' => 'Tidak Pernah', 'skor' => 1],
                ]
            ],
            [
                'teks'   => 'Saya merasa percaya diri saat harus mengemukakan pendapat di depan umum dan dapat berkolaborasi secara produktif dalam dinamika kelompok kerja.',
                'tipe'   => 'single_choice',
                'aspek'  => 'Sosial',
                'options' => [
                    ['teks' => 'Sangat Setuju', 'skor' => 4],
                    ['teks' => 'Setuju', 'skor' => 3],
                    ['teks' => 'Kurang Setuju', 'skor' => 2],
                    ['teks' => 'Tidak Setuju', 'skor' => 1],
                ]
            ],
            [
                'teks'   => 'Rumpun keilmuan atau bidang profesi yang paling menarik minat eksplorasi masa depan Anda (dapat memilih lebih dari satu):',
                'tipe'   => 'multichoice',
                'aspek'  => 'Karir',
                'options' => [
                    ['teks' => 'Sains, Teknologi, Rekayasa & Informatika (STEM)', 'skor' => 1],
                    ['teks' => 'Kedokteran, Keperawatan & Ilmu Kesehatan', 'skor' => 1],
                    ['teks' => 'Ilmu Sosial, Hukum, Komunikasi & Psikologi', 'skor' => 1],
                    ['teks' => 'Ekonomi, Bisnis, Akuntansi & Manajemen', 'skor' => 1],
                    ['teks' => 'Seni, Desain Grafis & Industri Kreatif', 'skor' => 1],
                ]
            ],
            [
                'teks'   => 'Tuliskan aspirasi atau tantangan terbesar yang sedang Anda hadapi saat ini dan ingin dikonsultasikan bersama Guru BK:',
                'tipe'   => 'text',
                'aspek'  => 'Pribadi',
                'options' => []
            ],
        ];

        $q1QuestionModels = [];
        foreach ($q1Questions as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q1->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => $item['tipe'] === 'text' ? 0 : 1,
                'aspek'            => $item['aspek'],
            ]);

            $createdQOptions = [];
            foreach ($item['options'] as $opt) {
                $createdOpt = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
                $createdQOptions[] = $createdOpt;
            }
            $q1QuestionModels[] = [
                'question' => $createdQ,
                'options'  => $createdQOptions,
            ];
        }

        // Simpan jawaban siswa untuk Kuisioner 1
        // Responden 1: Andi Pratama (XII-1)
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[0]['question']->id,
            'question_option_id' => $q1QuestionModels[0]['options'][0]->id, // Sangat Butuh (4)
            'jawaban_teks'       => 'Sangat Butuh',
            'created_at'         => now()->subDays(6),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[1]['question']->id,
            'question_option_id' => $q1QuestionModels[1]['options'][1]->id, // Sering (3)
            'jawaban_teks'       => 'Sering',
            'created_at'         => now()->subDays(6),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[2]['question']->id,
            'question_option_id' => $q1QuestionModels[2]['options'][2]->id, // Kadang-kadang (2)
            'jawaban_teks'       => 'Kadang-kadang',
            'created_at'         => now()->subDays(6),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[3]['question']->id,
            'question_option_id' => $q1QuestionModels[3]['options'][1]->id, // Setuju (3)
            'jawaban_teks'       => 'Setuju',
            'created_at'         => now()->subDays(6),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[4]['question']->id,
            'question_option_id' => $q1QuestionModels[4]['options'][0]->id, // STEM (1)
            'jawaban_teks'       => 'Sains, Teknologi, Rekayasa & Informatika (STEM)',
            'created_at'         => now()->subDays(6),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[5]['question']->id,
            'question_option_id' => null,
            'jawaban_teks'       => 'Saya ingin berkonsultasi mengenai strategi pemilihan jurusan Teknik Informatika di ITB atau UI melalui jalur SNBP berdasarkan persebaran nilai rapor saya.',
            'created_at'         => now()->subDays(6),
        ]);

        // Responden 2: Rina Putri (XII-2)
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[0]['question']->id,
            'question_option_id' => $q1QuestionModels[0]['options'][1]->id, // Butuh (3)
            'jawaban_teks'       => 'Butuh',
            'created_at'         => now()->subDays(5),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[1]['question']->id,
            'question_option_id' => $q1QuestionModels[1]['options'][1]->id, // Sering (3)
            'jawaban_teks'       => 'Sering',
            'created_at'         => now()->subDays(5),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[2]['question']->id,
            'question_option_id' => $q1QuestionModels[2]['options'][0]->id, // Sangat Sering (4)
            'jawaban_teks'       => 'Sangat Sering',
            'created_at'         => now()->subDays(5),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[3]['question']->id,
            'question_option_id' => $q1QuestionModels[3]['options'][0]->id, // Sangat Setuju (4)
            'jawaban_teks'       => 'Sangat Setuju',
            'created_at'         => now()->subDays(5),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[4]['question']->id,
            'question_option_id' => $q1QuestionModels[4]['options'][2]->id, // Sosial & Psikologi (1)
            'jawaban_teks'       => 'Ilmu Sosial, Hukum, Komunikasi & Psikologi',
            'created_at'         => now()->subDays(5),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[5]['question']->id,
            'question_option_id' => null,
            'jawaban_teks'       => 'Terkadang saya merasakan kecemasan yang berlebihan menjelang ujian sehingga sulit beristirahat malam dengan tenang.',
            'created_at'         => now()->subDays(5),
        ]);

        // Responden 3: Budi Santoso (XI-3)
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[0]['question']->id,
            'question_option_id' => $q1QuestionModels[0]['options'][1]->id, // Butuh (3)
            'jawaban_teks'       => 'Butuh',
            'created_at'         => now()->subDays(4),
        ]);
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[1]['question']->id,
            'question_option_id' => $q1QuestionModels[1]['options'][0]->id, // Sangat Sering (4)
            'jawaban_teks'       => 'Sangat Sering',
            'created_at'         => now()->subDays(4),
        ]);
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[2]['question']->id,
            'question_option_id' => $q1QuestionModels[2]['options'][2]->id, // Kadang-kadang (2)
            'jawaban_teks'       => 'Kadang-kadang',
            'created_at'         => now()->subDays(4),
        ]);
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[3]['question']->id,
            'question_option_id' => $q1QuestionModels[3]['options'][1]->id, // Setuju (3)
            'jawaban_teks'       => 'Setuju',
            'created_at'         => now()->subDays(4),
        ]);
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[4]['question']->id,
            'question_option_id' => $q1QuestionModels[4]['options'][0]->id, // STEM (1)
            'jawaban_teks'       => 'Sains, Teknologi, Rekayasa & Informatika (STEM)',
            'created_at'         => now()->subDays(4),
        ]);
        StudentAnswer::create([
            'student_id'         => $student3->id,
            'questionnaire_id'   => $q1->id,
            'question_id'        => $q1QuestionModels[5]['question']->id,
            'question_option_id' => null,
            'jawaban_teks'       => 'Membutuhkan saran tentang cara menyeimbangkan latihan persiapan lomba robotik dengan pengerjaan tugas mandiri sekolah.',
            'created_at'         => now()->subDays(4),
        ]);

        // INSTRUMEN 2: Asesmen Modalitas Gaya Belajar Siswa (VAK) (Status: published)
        $q2 = Questionnaire::create([
            'judul'           => 'Inventori Modalitas & Gaya Belajar Siswa (VAK)',
            'jenis_instrumen' => 'AUM',
            'deskripsi'       => 'Pemetaan modalitas preferensi penyerapan informasi (Visual, Auditori, dan Kinestetik) untuk optimalisasi strategi belajar efektif mandiri.',
            'target_kelas'    => 'Tingkat XII',
            'status'          => 'published',
            'is_active'       => 1,
            'published'       => 1,
            'created_at'      => now()->subDays(7),
            'updated_at'      => now()->subDays(7),
        ]);

        $q2Questions = [
            [
                'teks'   => 'Saat mempelajari materi pelajaran yang baru dan rumit, metode yang paling membantu Anda memahaminya adalah:',
                'tipe'   => 'single_choice',
                'aspek'  => 'Belajar',
                'options' => [
                    ['teks' => 'Melihat bagan ringkasan, diagram alir, dan peta konsep berkode warna (Visual)', 'skor' => 3],
                    ['teks' => 'Mendengarkan penjelasan guru secara lisan dan berdiskusi interaktif (Auditori)', 'skor' => 3],
                    ['teks' => 'Melakukan simulasi praktikum langsung atau mencatat sambil bergerak (Kinestetik)', 'skor' => 3],
                ]
            ],
            [
                'teks'   => 'Ketika sedang berkonsentrasi belajar mandiri di ruangan, gangguan yang paling cepat memecah fokus Anda adalah:',
                'tipe'   => 'single_choice',
                'aspek'  => 'Belajar',
                'options' => [
                    ['teks' => 'Ruangan yang berantakan, pencahayaan minim, atau visual yang kacau (Visual)', 'skor' => 2],
                    ['teks' => 'Suara bising, obrolan orang di sekitar, atau dengung peralatan (Auditori)', 'skor' => 2],
                    ['teks' => 'Keharusan duduk diam terlalu lama tanpa boleh berpindah posisi (Kinestetik)', 'skor' => 2],
                ]
            ],
            [
                'teks'   => 'Saat guru memberikan instruksi tugas proyek kelas, Anda lebih menyukai jika instruksi tersebut:',
                'tipe'   => 'single_choice',
                'aspek'  => 'Belajar',
                'options' => [
                    ['teks' => 'Dituliskan secara rinci di lembar panduan atau tayangan slide visual (Visual)', 'skor' => 2],
                    ['teks' => 'Diterangkan langsung langkah demi langkah secara lisan di kelas (Auditori)', 'skor' => 2],
                    ['teks' => 'Diberi contoh peragaan langsung cara mempraktikkan langkah kerjanya (Kinestetik)', 'skor' => 2],
                ]
            ],
        ];

        $q2QuestionModels = [];
        foreach ($q2Questions as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q2->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => 1,
                'aspek'            => $item['aspek'],
            ]);

            $createdQOptions = [];
            foreach ($item['options'] as $opt) {
                $createdOpt = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
                $createdQOptions[] = $createdOpt;
            }
            $q2QuestionModels[] = [
                'question' => $createdQ,
                'options'  => $createdQOptions,
            ];
        }

        // Jawaban untuk Kuisioner 2 (Andi & Rina sudah isi, Budi belum isi sehingga status pending)
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[0]['question']->id,
            'question_option_id' => $q2QuestionModels[0]['options'][0]->id, // Visual
            'jawaban_teks'       => $q2QuestionModels[0]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(3),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[1]['question']->id,
            'question_option_id' => $q2QuestionModels[1]['options'][0]->id, // Visual
            'jawaban_teks'       => $q2QuestionModels[1]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(3),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[2]['question']->id,
            'question_option_id' => $q2QuestionModels[2]['options'][0]->id, // Visual
            'jawaban_teks'       => $q2QuestionModels[2]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(3),
        ]);

        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[0]['question']->id,
            'question_option_id' => $q2QuestionModels[0]['options'][1]->id, // Auditori
            'jawaban_teks'       => $q2QuestionModels[0]['options'][1]->teks_opsi,
            'created_at'         => now()->subDays(2),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[1]['question']->id,
            'question_option_id' => $q2QuestionModels[1]['options'][1]->id, // Auditori
            'jawaban_teks'       => $q2QuestionModels[1]['options'][1]->teks_opsi,
            'created_at'         => now()->subDays(2),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q2->id,
            'question_id'        => $q2QuestionModels[2]['question']->id,
            'question_option_id' => $q2QuestionModels[2]['options'][0]->id, // Visual
            'jawaban_teks'       => $q2QuestionModels[2]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(2),
        ]);

        // INSTRUMEN 3: Skala Orientasi Minat Karir Holland (RIASEC) (Status: finished)
        $q3 = Questionnaire::create([
            'judul'           => 'Skala Orientasi Minat Karir Holland (RIASEC)',
            'jenis_instrumen' => 'IKMS',
            'deskripsi'       => 'Instrumen eksplorasi tipologi minat vokasional Holland (Realistic, Investigative, Artistic, Social, Enterprising, Conventional) untuk penelusuran karir lanjutan.',
            'target_kelas'    => 'Tingkat XII',
            'status'          => 'finished',
            'is_active'       => 0,
            'published'       => 1,
            'created_at'      => now()->subDays(25),
            'updated_at'      => now()->subDays(15),
        ]);

        $q3Questions = [
            [
                'teks'   => 'Aktivitas yang paling membuat Anda bersemangat dan antusias dalam keseharian adalah:',
                'tipe'   => 'single_choice',
                'aspek'  => 'Karir',
                'options' => [
                    ['teks' => 'Meneliti fenomena sains, memecahkan teka-teki logika, dan menganalisis data (Investigative)', 'skor' => 4],
                    ['teks' => 'Merancang karya visual, menulis cerita orisinal, atau mendesain konten estetika (Artistic)', 'skor' => 4],
                    ['teks' => 'Mendengarkan keluhan teman, membantu orang lain, dan berinteraksi sosial (Social)', 'skor' => 4],
                    ['teks' => 'Mengoperasikan mesin, merakit komponen teknik, atau aktivitas fisik teknis (Realistic)', 'skor' => 4],
                ]
            ],
            [
                'teks'   => 'Ketika dihadapkan pada tugas kelompok besar di sekolah, peran yang paling spontan Anda ambil adalah:',
                'tipe'   => 'single_choice',
                'aspek'  => 'Karir',
                'options' => [
                    ['teks' => 'Memimpin tim, mempresentasikan hasil karya, dan meyakinkan audiens (Enterprising)', 'skor' => 4],
                    ['teks' => 'Mengatur arsip dokumen, mengelola jadwal, dan memeriksa ketelitian laporan (Conventional)', 'skor' => 4],
                    ['teks' => 'Melakukan riset referensi pustaka dan mengecek validitas data teoritis (Investigative)', 'skor' => 4],
                ]
            ],
        ];

        $q3QuestionModels = [];
        foreach ($q3Questions as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q3->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => 1,
                'aspek'            => $item['aspek'],
            ]);

            $createdQOptions = [];
            foreach ($item['options'] as $opt) {
                $createdOpt = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
                $createdQOptions[] = $createdOpt;
            }
            $q3QuestionModels[] = [
                'question' => $createdQ,
                'options'  => $createdQOptions,
            ];
        }

        // Jawaban untuk Kuisioner 3 (sudah selesai dan terarsip)
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q3->id,
            'question_id'        => $q3QuestionModels[0]['question']->id,
            'question_option_id' => $q3QuestionModels[0]['options'][0]->id, // Investigative
            'jawaban_teks'       => $q3QuestionModels[0]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(20),
        ]);
        StudentAnswer::create([
            'student_id'         => $student1->id,
            'questionnaire_id'   => $q3->id,
            'question_id'        => $q3QuestionModels[1]['question']->id,
            'question_option_id' => $q3QuestionModels[1]['options'][2]->id, // Investigative
            'jawaban_teks'       => $q3QuestionModels[1]['options'][2]->teks_opsi,
            'created_at'         => now()->subDays(20),
        ]);

        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q3->id,
            'question_id'        => $q3QuestionModels[0]['question']->id,
            'question_option_id' => $q3QuestionModels[0]['options'][1]->id, // Artistic
            'jawaban_teks'       => $q3QuestionModels[0]['options'][1]->teks_opsi,
            'created_at'         => now()->subDays(19),
        ]);
        StudentAnswer::create([
            'student_id'         => $student2->id,
            'questionnaire_id'   => $q3->id,
            'question_id'        => $q3QuestionModels[1]['question']->id,
            'question_option_id' => $q3QuestionModels[1]['options'][0]->id, // Enterprising
            'jawaban_teks'       => $q3QuestionModels[1]['options'][0]->teks_opsi,
            'created_at'         => now()->subDays(19),
        ]);

        // INSTRUMEN 4: Skala Regulasi Emosi & Resiliensi Akademik (Status: draft)
        $q4 = Questionnaire::create([
            'judul'           => 'Skala Regulasi Diri & Resiliensi Akademik Siswa',
            'jenis_instrumen' => 'IKMS',
            'deskripsi'       => 'Draf instrumen telaah kapasitas ketahanan psikologis, manajemen stres, dan kegigihan akademik siswa menjelang Asesmen Sumatif Akhir Jenjang.',
            'target_kelas'    => 'Tingkat XI',
            'status'          => 'draft',
            'is_active'       => 0,
            'published'       => 0,
            'created_at'      => now()->subDays(2),
            'updated_at'      => now()->subDays(2),
        ]);

        $createdQ4 = Question::create([
            'questionnaire_id' => $q4->id,
            'teks_pertanyaan'  => 'Saat menghadapi hasil evaluasi belajar yang belum memuaskan, saya mampu menganalisis kekurangan saya secara tenang dan menyusun rencana belajar perbaikan.',
            'tipe_jawaban'     => 'single_choice',
            'is_wajib'         => 1,
            'aspek'            => 'Pribadi',
        ]);
        QuestionOption::create([
            'question_id' => $createdQ4->id,
            'teks_opsi'   => 'Sangat Sesuai',
            'bobot_nilai' => 4,
        ]);
        QuestionOption::create([
            'question_id' => $createdQ4->id,
            'teks_opsi'   => 'Sesuai',
            'bobot_nilai' => 3,
        ]);
        QuestionOption::create([
            'question_id' => $createdQ4->id,
            'teks_opsi'   => 'Kurang Sesuai',
            'bobot_nilai' => 2,
        ]);
        QuestionOption::create([
            'question_id' => $createdQ4->id,
            'teks_opsi'   => 'Tidak Sesuai',
            'bobot_nilai' => 1,
        ]);

        // =========================================================================
        // 4. SESI KONSELING (Variasi Lengkap: Selesai, Disetujui, Jadwal Ulang, Menunggu)
        // =========================================================================

        // Sesi 1: Selesai (Andi Pratama - Karir)
        CounselingSession::create([
            'student_id'         => $student1->id,
            'guru_id'            => $guruUser->id,
            'category'           => 'Karir',
            'topic'              => 'Konsultasi pemilihan jurusan prioritas antara Teknik Informatika ITB vs Ilmu Komputer UI, serta penyelarasan aspirasi minat pribadi dengan harapan orang tua.',
            'preferred_date'     => date('Y-m-d', strtotime('-3 days')),
            'preferred_time'     => '10:00 - 11:00 WIB',
            'room_or_media'      => 'Ruang Konseling BK 1',
            'status'             => 'selesai',
            'initiated_by'       => 'siswa',
            'counselor_notes'    => 'Telah dilakukan bedah nilai rapor semester 1-4 dan simulasi passing grade. Siswa memiliki profil penalaran logis-matematis yang sangat unggul di rumpun komputasi (rata-rata 92.5). Disepakati penyusunan lembar komparasi prospek karir untuk didiskusikan bersama orang tua secara kekeluargaan.',
            'rejection_reason'   => null,
            'rescheduled_reason' => null,
            'completed_at'       => now()->subDays(3)->setTime(11, 5),
            'created_at'         => now()->subDays(5),
            'updated_at'         => now()->subDays(3)->setTime(11, 5),
        ]);

        // Sesi 2: Disetujui / Terjadwal (Rina Putri - Belajar, Hari Ini)
        CounselingSession::create([
            'student_id'         => $student2->id,
            'guru_id'            => $guruUser->id,
            'category'           => 'Belajar',
            'topic'              => 'Tindak lanjut hasil asesmen IKMS mengenai penurunan konsentrasi belajar dan rasa cemas berlebih saat menghadapi evaluasi sumatif harian.',
            'preferred_date'     => date('Y-m-d'), // Hari Ini
            'preferred_time'     => 'Istirahat 1 (09:45 - 10:15 WIB)',
            'room_or_media'      => 'Ruang Konseling BK 1',
            'status'             => 'disetujui',
            'initiated_by'       => 'guru',
            'counselor_notes'    => null,
            'rejection_reason'   => null,
            'rescheduled_reason' => null,
            'completed_at'       => null,
            'created_at'         => now()->subDays(1),
            'updated_at'         => now()->subHours(12),
        ]);

        // Sesi 3: Dijadwalkan Ulang (Budi Santoso - Pribadi, Mendatang)
        CounselingSession::create([
            'student_id'         => $student3->id,
            'guru_id'            => $guruUser->id,
            'category'           => 'Pribadi',
            'topic'              => 'Bimbingan penyesuaian diri dan manajemen waktu akibat benturan jadwal latihan persiapan kompetisi robotik dengan tugas harian sekolah.',
            'preferred_date'     => date('Y-m-d', strtotime('+3 days')),
            'preferred_time'     => 'Setelah Jam Pulang Sekolah (15:00 - 16:00 WIB)',
            'room_or_media'      => 'Ruang Konseling BK 2',
            'status'             => 'dijadwalkan ulang',
            'initiated_by'       => 'siswa',
            'counselor_notes'    => null,
            'rejection_reason'   => null,
            'rescheduled_reason' => 'Jadwal disesuaikan dari tanggal sebelumnya karena Guru BK menghadiri rapat koordinasi MGMP BK se-Kota Bandung. Bimbingan dialihkan ke sesi sore yang kondusif.',
            'completed_at'       => null,
            'created_at'         => now()->subDays(2),
            'updated_at'         => now()->subHours(6),
        ]);

        // Sesi 4: Menunggu Konfirmasi (Andi Pratama - Belajar, Pengajuan Baru)
        CounselingSession::create([
            'student_id'         => $student1->id,
            'guru_id'            => null,
            'category'           => 'Belajar',
            'topic'              => 'Permohonan strategi belajar efektif menghadapi Tryout UTBK-SNBT pertama sekolah dan pembagian waktu les intensif malam hari.',
            'preferred_date'     => date('Y-m-d', strtotime('+5 days')),
            'preferred_time'     => 'Istirahat 2 (12:00 - 12:45 WIB)',
            'room_or_media'      => 'Ruang Konseling BK 1',
            'status'             => 'menunggu',
            'initiated_by'       => 'siswa',
            'counselor_notes'    => null,
            'rejection_reason'   => null,
            'rescheduled_reason' => null,
            'completed_at'       => null,
            'created_at'         => now()->subHours(4),
            'updated_at'         => now()->subHours(4),
        ]);

        // Sesi 5: Selesai (Rina Putri - Sosial, Masa Lalu)
        CounselingSession::create([
            'student_id'         => $student2->id,
            'guru_id'            => $guruUser->id,
            'category'           => 'Sosial',
            'topic'              => 'Pendampingan hubungan interpersonal teman sebaya dalam dinamika kerja kelompok organisasi mading sekolah.',
            'preferred_date'     => date('Y-m-d', strtotime('-11 days')),
            'preferred_time'     => '13:00 - 14:00 WIB',
            'room_or_media'      => 'Ruang Konseling BK 2',
            'status'             => 'selesai',
            'initiated_by'       => 'guru',
            'counselor_notes'    => 'Siswa diberikan pelatihan teknik komunikasi asertif dalam mengemukakan pendapat di forum kelompok tanpa merasa inferior. Siswa mampu mempraktikkan komunikasi asertif dengan baik.',
            'rejection_reason'   => null,
            'rescheduled_reason' => null,
            'completed_at'       => now()->subDays(11)->setTime(14, 15),
            'created_at'         => now()->subDays(14),
            'updated_at'         => now()->subDays(11)->setTime(14, 15),
        ]);

        // =========================================================================
        // 5. CATATAN KASUS & BIMBINGAN SISWA (Counseling Notes)
        // =========================================================================

        // Catatan 1: Andi Pratama (Karir)
        CounselingNote::create([
            'student_id'             => $student1->id,
            'guru_id'                => $guruUser->id,
            'tanggal'                => date('Y-m-d', strtotime('-3 days')),
            'kategori'               => 'Karir',
            'keluhan_masalah'        => 'Kebimbangan menentukan pilihan program studi antara Teknik Informatika ITB dan Ilmu Komputer UI, serta belum selarasnya aspirasi siswa dengan arahan keluarga (Kedokteran).',
            'layanan_diberikan'      => 'Konseling individual dengan teknik restrukturisasi kognitif dan eksplorasi data prospek karir digital. Peninjauan rekam jejak nilai rapor matematika dan informatika (rata-rata 92.5).',
            'tindak_lanjut_evaluasi' => 'Siswa menyusun portofolio prestasi dan materi diskusi keluarga; dijadwalkan sesi pendampingan keluarga jika diperlukan.',
            'status'                 => 'Dalam Pemantauan',
            'created_at'             => now()->subDays(3),
            'updated_at'             => now()->subDays(3),
        ]);

        // Catatan 2: Andi Pratama (Belajar)
        CounselingNote::create([
            'student_id'             => $student1->id,
            'guru_id'                => $guruUser->id,
            'tanggal'                => date('Y-m-d', strtotime('-20 days')),
            'kategori'               => 'Belajar',
            'keluhan_masalah'        => 'Penurunan stamina dan konsentrasi belajar akibat kebiasaan belajar hingga larut malam (sistem kebut semalam).',
            'layanan_diberikan'      => 'Bimbingan teknik manajemen waktu (Pomodoro 25/5 menit) dan penyusunan jadwal istirahat teratur.',
            'tindak_lanjut_evaluasi' => 'Siswa melaporkan peningkatan keteraturan tidur dan performa kuis harian terpantau meningkat stabil.',
            'status'                 => 'Selesai / Teratasi',
            'created_at'             => now()->subDays(20),
            'updated_at'             => now()->subDays(14),
        ]);

        // Catatan 3: Rina Putri (Sosial)
        CounselingNote::create([
            'student_id'             => $student2->id,
            'guru_id'                => $guruUser->id,
            'tanggal'                => date('Y-m-d', strtotime('-11 days')),
            'kategori'               => 'Sosial',
            'keluhan_masalah'        => 'Kesulitan bersikap asertif saat menghadapi perbedaan pandangan kerja tim mading sekolah sehingga memicu ketegangan pertemanan.',
            'layanan_diberikan'      => 'Latihan bermain peran (role-playing) teknik komunikasi asertif \'I-Message\' dan mediasi terbuka antar anggota tim.',
            'tindak_lanjut_evaluasi' => 'Siswa telah mampu menyampaikan pandangan dengan tenang dan relasi kerja tim kembali harmonis.',
            'status'                 => 'Selesai / Teratasi',
            'created_at'             => now()->subDays(11),
            'updated_at'             => now()->subDays(11),
        ]);

        // Catatan 4: Rina Putri (Pribadi)
        CounselingNote::create([
            'student_id'             => $student2->id,
            'guru_id'                => $guruUser->id,
            'tanggal'                => date('Y-m-d', strtotime('-24 days')),
            'kategori'               => 'Pribadi',
            'keluhan_masalah'        => 'Kecemasan akademik (academic anxiety) yang bermanifestasi pada ketegangan fisik saat presentasi individu di depan kelas.',
            'layanan_diberikan'      => 'Teknik relaksasi pernapasan diafragma 4-7-8, latihan desensitisasi sistematis, serta afirmasi diri positif.',
            'tindak_lanjut_evaluasi' => 'Siswa mempraktikkan latihan pernapasan sebelum berbicara di depan kelas; terpantau lebih percaya diri saat penilaian formatif.',
            'status'                 => 'Selesai / Teratasi',
            'created_at'             => now()->subDays(24),
            'updated_at'             => now()->subDays(18),
        ]);

        // Catatan 5: Budi Santoso (Pribadi)
        CounselingNote::create([
            'student_id'             => $student3->id,
            'guru_id'                => $guruUser->id,
            'tanggal'                => date('Y-m-d', strtotime('-8 days')),
            'kategori'               => 'Pribadi',
            'keluhan_masalah'        => 'Kelelahan fisik dan mental karena padatnya jadwal persiapan kompetisi robotik tingkat provinsi yang menyita waktu belajar mandiri.',
            'layanan_diberikan'      => 'Konseling realitas mengenai penetapan batas energi harian (work-life balance tingkat pelajar) dan koordinasi dispensasi terukur dengan pembina ekstrakurikuler.',
            'tindak_lanjut_evaluasi' => 'Pembina ekskul menyepakati jadwal latihan terstruktur maksimal hingga pukul 17:00 WIB agar waktu belajar di rumah terlindungi.',
            'status'                 => 'Selesai / Teratasi',
            'created_at'             => now()->subDays(8),
            'updated_at'             => now()->subDays(8),
        ]);

        // =========================================================================
        // 6. AGENDA KALENDER KEGIATAN BK (Calendar Events)
        // =========================================================================

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Bimbingan Klasikal: Sosialisasi Mekanisme SNBP & Strategi Pemilihan Program Studi PTN',
            'event_date'  => date('Y-m-d', strtotime('-7 days')),
            'start_time'  => '08:00',
            'end_time'    => '09:30',
            'location'    => 'Aula Pertemuan Utama SMAN 1 Bandung',
            'category'    => 'Bimbingan Klasikal',
            'description' => 'Pemaparan kebijakan seleksi nasional, pembacaan kuota sekolah, dan strategi rasionalisasi nilai rapor semester 1 sampai 5 untuk seluruh siswa kelas XII.',
            'created_at'  => now()->subDays(14),
        ]);

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Layanan Bimbingan Kelompok: Manajemen Stres Akademik & Teknik Mindful Learning',
            'event_date'  => date('Y-m-d', strtotime('-4 days')),
            'start_time'  => '10:15',
            'end_time'    => '11:45',
            'location'    => 'Ruang Konseling BK 2',
            'category'    => 'Bimbingan Kelompok',
            'description' => 'Sesi bimbingan kelompok beranggotakan 8 siswa terpilih untuk melatih regulasi emosi, relaksasi otot progresif, dan teknik belajar mindful.',
            'created_at'  => now()->subDays(10),
        ]);

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Layanan Orientasi & Konsultasi Karir Terbuka: Klinik Minat Bakat Siswa Kelas XII',
            'event_date'  => date('Y-m-d'), // Hari Ini
            'start_time'  => '08:00',
            'end_time'    => '09:30',
            'location'    => 'Ruang Multimedia SMAN 1 Bandung',
            'category'    => 'Konsultasi',
            'description' => 'Klinik konsultasi karir interaktif bersama Guru BK bagi siswa yang ingin berkonsultasi mengenai penjurusan dan akreditasi prodi kampus mitra.',
            'created_at'  => now()->subDays(3),
        ]);

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Kunjungan Rumah (Home Visit) Terjadwal: Koordinasi Prestasi & Absensi Siswa',
            'event_date'  => date('Y-m-d', strtotime('+5 days')),
            'start_time'  => '13:30',
            'end_time'    => '15:30',
            'location'    => 'Wilayah Domisili Siswa Binaan',
            'category'    => 'Home Visit',
            'description' => 'Kunjungan silaturahmi edukatif dan koordinasi berkala bersama orang tua siswa untuk membangun keselarasan pendampingan belajar di rumah.',
            'created_at'  => now()->subDays(1),
        ]);

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Bimbingan Klasikal: Pengenalan Dunia Kerja, Soft Skills, dan Etika Profesional di Era Digital',
            'event_date'  => date('Y-m-d', strtotime('+10 days')),
            'start_time'  => '08:00',
            'end_time'    => '09:30',
            'location'    => 'Kelas XII-1 & XII-2',
            'category'    => 'Bimbingan Klasikal',
            'description' => 'Materi pembekalan kompetensi abad 21: critical thinking, komunikasi interpersonal, personal branding, dan etika komunikasi profesional.',
            'created_at'  => now()->subDays(2),
        ]);

        CalendarEvent::create([
            'user_id'     => $guruUser->id,
            'title'       => 'Parenting & Temu Konsultasi Wali Murid: Sinergi Sekolah dan Keluarga dalam Menyiapkan Kelulusan Siswa',
            'event_date'  => date('Y-m-d', strtotime('+14 days')),
            'start_time'  => '08:30',
            'end_time'    => '11:30',
            'location'    => 'Aula Pertemuan Utama SMAN 1 Bandung',
            'category'    => 'Konferensi Kasus',
            'description' => 'Pertemuan interaktif Guru BK, Kepala Sekolah, dan Wali Murid kelas XII untuk menyelaraskan dukungan emosional dan finansial studi lanjut siswa.',
            'created_at'  => now()->subDays(2),
        ]);

        // =========================================================================
        // 7. PESAN CHAT KONSULTASI (Chat Messages)
        // =========================================================================

        ChatMessage::create([
            'sender_id'   => $user1->id,
            'receiver_id' => $guruUser->id,
            'student_id'  => $student1->id,
            'message'     => 'Selamat pagi Ibu Siti, izin bertanya apakah hari ini ada waktu luang di Ruang BK untuk berdiskusi seputar peluang alumni di jurusan Informatika ITB?',
            'type'        => 'text',
            'is_read'     => true,
            'created_at'  => now()->subHours(24),
        ]);

        ChatMessage::create([
            'sender_id'   => $guruUser->id,
            'receiver_id' => $user1->id,
            'student_id'  => $student1->id,
            'message'     => 'Selamat pagi Andi. Tentu ada, Ibu sudah siapkan data rekam jejak alumni tahun lalu. Silakan mampir ke Ruang BK 1 saat jam istirahat pertama ya.',
            'type'        => 'text',
            'is_read'     => true,
            'created_at'  => now()->subHours(23),
        ]);

        ChatMessage::create([
            'sender_id'   => $user1->id,
            'receiver_id' => $guruUser->id,
            'student_id'  => $student1->id,
            'message'     => 'Baik Ibu, terima kasih banyak atas kesediaannya. Nanti setelah jam istirahat berbunyi saya segera ke Ruang BK.',
            'type'        => 'text',
            'is_read'     => true,
            'created_at'  => now()->subHours(22),
        ]);

        ChatMessage::create([
            'sender_id'   => $user2->id,
            'receiver_id' => $guruUser->id,
            'student_id'  => $student2->id,
            'message'     => 'Assalamu\'alaikum Ibu Siti, saya sudah mengisi lembar asesmen gaya belajar. Mohon arahannya untuk jadwal temu konseling hari ini ya Bu.',
            'type'        => 'text',
            'is_read'     => true,
            'created_at'  => now()->subHours(2),
        ]);

        ChatMessage::create([
            'sender_id'   => $guruUser->id,
            'receiver_id' => $user2->id,
            'student_id'  => $student2->id,
            'message'     => 'Wa\'alaikumsalam Rina. Jawabanmu sudah Ibu terima dan pelajari. Jadwal sesi kita sudah disetujui pukul 09.45 WIB di Ruang BK 1. Sampai bertemu nanti ya.',
            'type'        => 'text',
            'is_read'     => false,
            'created_at'  => now()->subHours(1),
        ]);

        // =========================================================================
        // 8. NOTIFIKASI SISTEM (App Notifications - Bebas Emoji Mentah)
        // =========================================================================

        // Notifikasi untuk Guru BK
        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Permohonan Bimbingan Masuk',
            'message'    => 'Andi Pratama mengajukan permohonan temu bimbingan bidang Belajar.',
            'url'        => '/guru/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(4),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Respon Asesmen Diterima',
            'message'    => 'Rina Putri telah menyelesaikan pengisian Inventori Modalitas & Gaya Belajar Siswa (VAK).',
            'url'        => '/guru/questionnaires/' . $q2->id,
            'type'       => 'questionnaire',
            'is_read'    => true,
            'created_at' => now()->subHours(2),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Pesan Chat Konseling Baru',
            'message'    => 'Rina Putri mengirim pesan konsultasi baru terkait janji temu bimbingan.',
            'url'        => '/guru/counseling',
            'type'       => 'chat',
            'is_read'    => false,
            'created_at' => now()->subHours(2),
        ]);

        // Notifikasi untuk Siswa 1 (Andi Pratama)
        AppNotification::create([
            'user_id'    => $user1->id,
            'title'      => 'Sesi Konseling Selesai',
            'message'    => 'Sesi konseling bidang Karir telah selesai dilaksanakan. Catatan hasil bimbingan dapat ditinjau di akun Anda.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => true,
            'created_at' => now()->subDays(3),
        ]);

        // Notifikasi untuk Siswa 2 (Rina Putri)
        AppNotification::create([
            'user_id'    => $user2->id,
            'title'      => 'Jadwal Konseling Ditetapkan oleh Guru BK',
            'message'    => 'Guru BK telah menyetujui sesi bimbingan untuk Anda hari ini pukul 09:45 WIB di Ruang Konseling BK 1.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(12),
        ]);

        // Notifikasi untuk Siswa 3 (Budi Santoso)
        AppNotification::create([
            'user_id'    => $user3->id,
            'title'      => 'Penyesuaian Jadwal Konseling',
            'message'    => 'Jadwal bimbingan Anda disesuaikan menjadi tanggal ' . date('d M Y', strtotime('+3 days')) . ' pukul 15:00 WIB di Ruang BK 2.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(6),
        ]);

        // =========================================================================
        // 9. PENGATURAN KOP SURAT LAPORAN RESMI (Report Settings)
        // =========================================================================

        ReportSetting::create([
            'school_name'     => 'SMA NEGERI 1 KOTA BANDUNG',
            'school_address'  => 'Jl. Ir. H. Juanda No. 93, Lebak Siliwangi, Kecamatan Coblong, Kota Bandung, Jawa Barat 40132',
            'school_phone'    => '(022) 2503582',
            'school_email'    => 'info@sman1bandung.sch.id',
            'school_website'  => 'www.sman1bandung.sch.id',
            'headmaster_name' => 'Dr. H. Ahmad Supardi, M.Pd.',
            'headmaster_nip'  => '19720315 199802 1 003',
            'counselor_name'  => 'Dra. Hj. Siti Rohmah, M.Psi.',
            'counselor_nip'   => '19800512 200501 2 006',
            'city_date'       => 'Bandung',
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);
    }
}
