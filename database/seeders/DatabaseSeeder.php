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
use App\Models\AppNotification;
use App\Models\ReportSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with rich, professional BK dummy data.
     */
    public function run(): void
    {
        // =========================================================================
        // 1. BERSIHKAN DATA LAMA
        // =========================================================================
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        StudentAnswer::truncate();
        QuestionOption::truncate();
        Question::truncate();
        Questionnaire::truncate();
        CounselingSession::truncate();
        CounselingNote::truncate();
        CalendarEvent::truncate();
        AppNotification::truncate();
        ReportSetting::truncate();
        if (DB::getSchemaBuilder()->hasTable('chat_messages')) {
            DB::table('chat_messages')->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // =========================================================================
        // 2. AKUN GURU BK & SISWA (8 Siswa Lengkap Berbagai Jenjang X, XI, XII)
        // =========================================================================
        
        // Akun Guru BK
        $guruUser = User::updateOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'username' => 'guru',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru',
            ]
        );

        // Siswa 1: Andi Pratama (XII-1)
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

        // Siswa 2: Rina Putri (XII-2)
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

        // Siswa 3: Budi Santoso (XI-3)
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

        // Siswa 4: Fajar Nugraha (X-1)
        $user4 = User::updateOrCreate(
            ['email' => 'fajarnugraha@gmail.com'],
            [
                'username' => '10296',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student4 = Student::updateOrCreate(
            ['nis' => '10296'],
            [
                'user_id' => $user4->id,
                'email' => 'fajarnugraha@gmail.com',
                'nama' => 'Fajar Nugraha',
                'kelas' => 'X-1',
                'status' => 'aktif',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2009-01-18',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Ir. H. Juanda No. 102, Dago, Kota Bandung',
                'nomor_telepon' => '082123456781',
                'nomor_telepon_orang_tua' => '082198765431',
                'nama_ayah' => 'Suryanto Nugraha, S.T.',
                'nama_ibu' => 'Retno Wulandari, S.Pd.',
                'hobi' => 'Basket & Fotografi Lanskap',
                'cita_cita' => 'Arsitek Lanskap & Perencanaan Kota',
            ]
        );

        // Siswa 5: Dinda Kirana (X-4)
        $user5 = User::updateOrCreate(
            ['email' => 'dindakirana@gmail.com'],
            [
                'username' => '10297',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student5 = Student::updateOrCreate(
            ['nis' => '10297'],
            [
                'user_id' => $user5->id,
                'email' => 'dindakirana@gmail.com',
                'nama' => 'Dinda Kirana',
                'kelas' => 'X-4',
                'status' => 'aktif',
                'tempat_lahir' => 'Semarang',
                'tanggal_lahir' => '2009-06-25',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Dr. Setiabudhi No. 54, Sukasari, Kota Bandung',
                'nomor_telepon' => '082234567892',
                'nomor_telepon_orang_tua' => '082298765432',
                'nama_ayah' => 'Ir. Gunawan Wibisono',
                'nama_ibu' => 'Ratna Sari, S.Pd.',
                'hobi' => 'Olimpiade Biologi & Tari Tradisional',
                'cita_cita' => 'Dokter Spesialis Anak',
            ]
        );

        // Siswa 6: Rizky Pratama Putra (XI-2)
        $user6 = User::updateOrCreate(
            ['email' => 'rizkypratama@gmail.com'],
            [
                'username' => '10298',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student6 = Student::updateOrCreate(
            ['nis' => '10298'],
            [
                'user_id' => $user6->id,
                'email' => 'rizkypratama@gmail.com',
                'nama' => 'Rizky Pratama Putra',
                'kelas' => 'XI-2',
                'status' => 'aktif',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '2008-09-12',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. L.L.R.E. Martadinata (Riau) No. 77, Bandung',
                'nomor_telepon' => '082345678903',
                'nomor_telepon_orang_tua' => '082398765403',
                'nama_ayah' => 'Agus Haryanto, S.H.',
                'nama_ibu' => 'Nurul Hidayah, S.E.',
                'hobi' => 'Debat Bahasa Inggris & Permainan Catur',
                'cita_cita' => 'Diplomat / Hubungan Internasional',
            ]
        );

        // Siswa 7: Siti Nurhaliza (XI-5)
        $user7 = User::updateOrCreate(
            ['email' => 'sitinurhaliza@gmail.com'],
            [
                'username' => '10299',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student7 = Student::updateOrCreate(
            ['nis' => '10299'],
            [
                'user_id' => $user7->id,
                'email' => 'sitinurhaliza@gmail.com',
                'nama' => 'Siti Nurhaliza',
                'kelas' => 'XI-5',
                'status' => 'aktif',
                'tempat_lahir' => 'Cirebon',
                'tanggal_lahir' => '2008-11-04',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Buah Batu No. 120, Lengkong, Kota Bandung',
                'nomor_telepon' => '085234567894',
                'nomor_telepon_orang_tua' => '085298765434',
                'nama_ayah' => 'Ahmad Fauzi, M.Ag.',
                'nama_ibu' => 'Maryam Ulfah, S.Pd.I.',
                'hobi' => 'Matematika Terapan & Seni Kaligrafi',
                'cita_cita' => 'Aktuaris / Dosen Statistika',
            ]
        );

        // Siswa 8: Bayu Anggara (XII-3)
        $user8 = User::updateOrCreate(
            ['email' => 'bayuanggara@gmail.com'],
            [
                'username' => '10300',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
            ]
        );
        $student8 = Student::updateOrCreate(
            ['nis' => '10300'],
            [
                'user_id' => $user8->id,
                'email' => 'bayuanggara@gmail.com',
                'nama' => 'Bayu Anggara',
                'kelas' => 'XII-3',
                'status' => 'aktif',
                'tempat_lahir' => 'Bandung',
                'tanggal_lahir' => '2007-04-02',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Cihampelas No. 33, Coblong, Kota Bandung',
                'nomor_telepon' => '085345678905',
                'nomor_telepon_orang_tua' => '085398765405',
                'nama_ayah' => 'Tri Wahyudi, S.Sn.',
                'nama_ibu' => 'Indah Permatasari',
                'hobi' => 'Desain Antarmuka (UI/UX) & Animasi 3D',
                'cita_cita' => 'Desainer Produk Digital & Kreator Animasi',
            ]
        );

        // =========================================================================
        // 3. KUISIONER & ASESMEN DIAGNOSTIK BK
        // =========================================================================

        // INSTRUMEN 1: AKPD / IKMS Terpadu (Status: published)
        $q1 = Questionnaire::create([
            'judul'           => 'Angket Kebutuhan Peserta Didik (AKPD) / IKMS Terpadu',
            'jenis_instrumen' => 'IKMS',
            'deskripsi'       => 'Asesmen diagnostik komprehensif berbasis 4 bidang layanan bimbingan konseling (Pribadi, Sosial, Belajar, dan Karir) untuk memetakan program layanan tahun ajaran berjalan.',
            'target_kelas'    => 'Semua Kelas',
            'status'          => 'published',
            'is_active'       => 1,
            'published'       => 1,
            'created_at'      => now()->subDays(12),
            'updated_at'      => now()->subDays(12),
        ]);

        $q1Items = [
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
                'teks'   => 'Saya sering merasa kewalahan dalam membagi waktu antara jadwal tugas sekolah, les bimbingan belajar luar, dan waktu istirahat harian.',
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
                'teks'   => 'Saya kerap mengalami ketegangan emosional atau kecemasan yang menurunkan konsentrasi belajar saat menjelang pelaksanaan ujian sumatif sekolah.',
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

        $q1Pack = [];
        foreach ($q1Items as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q1->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => $item['tipe'] === 'text' ? 0 : 1,
                'aspek'            => $item['aspek'],
            ]);

            $opts = [];
            foreach ($item['options'] as $opt) {
                $opts[] = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
            }
            $q1Pack[] = ['q' => $createdQ, 'opts' => $opts];
        }

        // Jawaban untuk 6 Siswa di Kuisioner 1
        $q1Responses = [
            [
                'student' => $student1,
                'choices' => [0, 1, 2, 1, 0], // option index
                'essay'   => 'Saya ingin berkonsultasi mengenai strategi pemilihan jurusan Teknik Informatika di ITB atau UI melalui jalur SNBP berdasarkan persebaran nilai rapor saya.',
                'date'    => now()->subDays(7),
            ],
            [
                'student' => $student2,
                'choices' => [1, 1, 0, 0, 2],
                'essay'   => 'Terkadang saya merasakan kecemasan yang berlebihan menjelang ujian sehingga sulit beristirahat malam dengan tenang.',
                'date'    => now()->subDays(6),
            ],
            [
                'student' => $student3,
                'choices' => [1, 0, 2, 1, 0],
                'essay'   => 'Membutuhkan saran tentang cara menyeimbangkan latihan persiapan lomba robotik dengan pengerjaan tugas mandiri sekolah.',
                'date'    => now()->subDays(5),
            ],
            [
                'student' => $student4,
                'choices' => [2, 1, 1, 1, 4],
                'essay'   => 'Saya masih beradaptasi dengan ritme belajar jenjang SMA yang cukup padat dan ingin mendalami minat desain arsitektur.',
                'date'    => now()->subDays(4),
            ],
            [
                'student' => $student5,
                'choices' => [0, 0, 1, 0, 1],
                'essay'   => 'Ingin mengetahui persyaratan dan persiapan portofolio untuk masuk Fakultas Kedokteran jalur prestasi.',
                'date'    => now()->subDays(3),
            ],
            [
                'student' => $student6,
                'choices' => [1, 2, 2, 0, 2],
                'essay'   => 'Memerlukan wawasan mengenai karir di bidang Hubungan Internasional serta peluang beasiswa studi luar negeri.',
                'date'    => now()->subDays(2),
            ],
        ];

        foreach ($q1Responses as $resp) {
            for ($i = 0; $i < 5; $i++) {
                $selectedOpt = $q1Pack[$i]['opts'][$resp['choices'][$i]];
                StudentAnswer::create([
                    'student_id'         => $resp['student']->id,
                    'questionnaire_id'   => $q1->id,
                    'question_id'        => $q1Pack[$i]['q']->id,
                    'question_option_id' => $selectedOpt->id,
                    'jawaban_teks'       => $selectedOpt->teks_opsi,
                    'created_at'         => $resp['date'],
                ]);
            }
            // Essay
            StudentAnswer::create([
                'student_id'         => $resp['student']->id,
                'questionnaire_id'   => $q1->id,
                'question_id'        => $q1Pack[5]['q']->id,
                'question_option_id' => null,
                'jawaban_teks'       => $resp['essay'],
                'created_at'         => $resp['date'],
            ]);
        }

        // INSTRUMEN 2: Asesmen Modalitas Gaya Belajar Siswa (VAK) (Status: published)
        $q2 = Questionnaire::create([
            'judul'           => 'Inventori Modalitas & Gaya Belajar Siswa (VAK)',
            'jenis_instrumen' => 'AUM',
            'deskripsi'       => 'Pemetaan modalitas preferensi penyerapan informasi (Visual, Auditori, dan Kinestetik) untuk optimalisasi strategi belajar efektif mandiri.',
            'target_kelas'    => 'Tingkat XII',
            'status'          => 'published',
            'is_active'       => 1,
            'published'       => 1,
            'created_at'      => now()->subDays(8),
            'updated_at'      => now()->subDays(8),
        ]);

        $q2Items = [
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

        $q2Pack = [];
        foreach ($q2Items as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q2->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => 1,
                'aspek'            => $item['aspek'],
            ]);

            $opts = [];
            foreach ($item['options'] as $opt) {
                $opts[] = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
            }
            $q2Pack[] = ['q' => $createdQ, 'opts' => $opts];
        }

        // Jawaban untuk 5 Siswa di Kuisioner 2 (Andi, Rina, Budi, Rizky, Bayu)
        $q2Responses = [
            ['student' => $student1, 'choices' => [0, 0, 0], 'date' => now()->subDays(4)],
            ['student' => $student2, 'choices' => [1, 1, 0], 'date' => now()->subDays(3)],
            ['student' => $student3, 'choices' => [2, 2, 2], 'date' => now()->subDays(3)],
            ['student' => $student6, 'choices' => [1, 1, 1], 'date' => now()->subDays(2)],
            ['student' => $student8, 'choices' => [0, 0, 2], 'date' => now()->subDays(1)],
        ];

        foreach ($q2Responses as $resp) {
            for ($i = 0; $i < 3; $i++) {
                $opt = $q2Pack[$i]['opts'][$resp['choices'][$i]];
                StudentAnswer::create([
                    'student_id'         => $resp['student']->id,
                    'questionnaire_id'   => $q2->id,
                    'question_id'        => $q2Pack[$i]['q']->id,
                    'question_option_id' => $opt->id,
                    'jawaban_teks'       => $opt->teks_opsi,
                    'created_at'         => $resp['date'],
                ]);
            }
        }

        // INSTRUMEN 3: Skala Orientasi Minat Karir Holland (RIASEC) (Status: finished)
        $q3 = Questionnaire::create([
            'judul'           => 'Skala Orientasi Minat Karir Holland (RIASEC)',
            'jenis_instrumen' => 'IKMS',
            'deskripsi'       => 'Instrumen eksplorasi tipologi minat vokasional Holland (Realistic, Investigative, Artistic, Social, Enterprising, Conventional) untuk penelusuran karir lanjutan.',
            'target_kelas'    => 'Tingkat XII',
            'status'          => 'finished',
            'is_active'       => 0,
            'published'       => 1,
            'created_at'      => now()->subDays(28),
            'updated_at'      => now()->subDays(14),
        ]);

        $q3Items = [
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

        $q3Pack = [];
        foreach ($q3Items as $item) {
            $createdQ = Question::create([
                'questionnaire_id' => $q3->id,
                'teks_pertanyaan'  => $item['teks'],
                'tipe_jawaban'     => $item['tipe'],
                'is_wajib'         => 1,
                'aspek'            => $item['aspek'],
            ]);

            $opts = [];
            foreach ($item['options'] as $opt) {
                $opts[] = QuestionOption::create([
                    'question_id' => $createdQ->id,
                    'teks_opsi'   => $opt['teks'],
                    'bobot_nilai' => $opt['skor'],
                ]);
            }
            $q3Pack[] = ['q' => $createdQ, 'opts' => $opts];
        }

        // Jawaban untuk 4 Siswa di Kuisioner 3 (Andi, Rina, Rizky, Bayu)
        $q3Responses = [
            ['student' => $student1, 'choices' => [0, 2], 'date' => now()->subDays(20)],
            ['student' => $student2, 'choices' => [1, 0], 'date' => now()->subDays(20)],
            ['student' => $student6, 'choices' => [2, 0], 'date' => now()->subDays(18)],
            ['student' => $student8, 'choices' => [1, 1], 'date' => now()->subDays(17)],
        ];

        foreach ($q3Responses as $resp) {
            for ($i = 0; $i < 2; $i++) {
                $opt = $q3Pack[$i]['opts'][$resp['choices'][$i]];
                StudentAnswer::create([
                    'student_id'         => $resp['student']->id,
                    'questionnaire_id'   => $q3->id,
                    'question_id'        => $q3Pack[$i]['q']->id,
                    'question_option_id' => $opt->id,
                    'jawaban_teks'       => $opt->teks_opsi,
                    'created_at'         => $resp['date'],
                ]);
            }
        }

        // INSTRUMEN 4: Skala Regulasi Diri & Resiliensi Akademik Siswa (Status: draft)
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
        foreach ([
            ['teks' => 'Sangat Sesuai', 'skor' => 4],
            ['teks' => 'Sesuai', 'skor' => 3],
            ['teks' => 'Kurang Sesuai', 'skor' => 2],
            ['teks' => 'Tidak Sesuai', 'skor' => 1],
        ] as $opt) {
            QuestionOption::create([
                'question_id' => $createdQ4->id,
                'teks_opsi'   => $opt['teks'],
                'bobot_nilai' => $opt['skor'],
            ]);
        }

        // =========================================================================
        // 4. SESI KONSELING (15 Sesi Beragam Status: Selesai, Disetujui, Reschedule, Menunggu)
        // =========================================================================

        $counselingData = [
            // 1. Selesai - Andi Pratama
            [
                'student_id'         => $student1->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Karir',
                'topic'              => 'Konsultasi pemilihan jurusan prioritas antara Teknik Informatika ITB vs Ilmu Komputer UI, serta penyelarasan aspirasi minat pribadi dengan harapan orang tua.',
                'preferred_date'     => date('Y-m-d', strtotime('-5 days')),
                'preferred_time'     => '10:00 - 11:00 WIB',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'selesai',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => 'Telah dilakukan bedah nilai rapor semester 1-4 dan simulasi passing grade. Siswa memiliki profil penalaran logis-matematis yang sangat unggul di rumpun komputasi (rata-rata 92.5). Disepakati penyusunan lembar komparasi prospek karir untuk didiskusikan bersama orang tua secara kekeluargaan.',
                'rescheduled_reason' => null,
                'completed_at'       => now()->subDays(5)->setTime(11, 10),
                'created_at'         => now()->subDays(8),
            ],
            // 2. Disetujui (Hari Ini) - Rina Putri
            [
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
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subDays(2),
            ],
            // 3. Dijadwalkan Ulang - Budi Santoso
            [
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
                'rescheduled_reason' => 'Jadwal disesuaikan dari tanggal sebelumnya karena Guru BK menghadiri rapat koordinasi MGMP BK se-Kota Bandung. Bimbingan dialihkan ke sesi sore yang kondusif.',
                'completed_at'       => null,
                'created_at'         => now()->subDays(3),
            ],
            // 4. Menunggu Konfirmasi - Andi Pratama
            [
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
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subHours(5),
            ],
            // 5. Selesai - Rina Putri
            [
                'student_id'         => $student2->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Sosial',
                'topic'              => 'Pendampingan hubungan interpersonal teman sebaya dalam dinamika kerja kelompok organisasi mading sekolah.',
                'preferred_date'     => date('Y-m-d', strtotime('-12 days')),
                'preferred_time'     => '13:00 - 14:00 WIB',
                'room_or_media'      => 'Ruang Konseling BK 2',
                'status'             => 'selesai',
                'initiated_by'       => 'guru',
                'counselor_notes'    => 'Siswa diberikan pelatihan teknik komunikasi asertif dalam mengemukakan pendapat di forum kelompok tanpa merasa inferior. Siswa mampu mempraktikkan komunikasi asertif dengan baik.',
                'rescheduled_reason' => null,
                'completed_at'       => now()->subDays(12)->setTime(14, 15),
                'created_at'         => now()->subDays(15),
            ],
            // 6. Selesai - Fajar Nugraha (X-1)
            [
                'student_id'         => $student4->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Pribadi',
                'topic'              => 'Adaptasi transisi masa pengenalan lingkungan sekolah (MPLS) dan adaptasi budaya belajar mandiri jenjang SMA.',
                'preferred_date'     => date('Y-m-d', strtotime('-18 days')),
                'preferred_time'     => '10:00 - 11:00 WIB',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'selesai',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => 'Siswa difasilitasi pemahaman profil peminatan kurikulum dan diberikan teknik adaptasi sosial positif. Siswa merasa lebih percaya diri dan telah bergabung di ekskul fotografi.',
                'rescheduled_reason' => null,
                'completed_at'       => now()->subDays(18)->setTime(11, 0),
                'created_at'         => now()->subDays(20),
            ],
            // 7. Disetujui - Dinda Kirana (X-4)
            [
                'student_id'         => $student5->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Karir',
                'topic'              => 'Eksplorasi minat karir kedokteran dan penyusunan peta jalan (roadmap) portofolio prestasi sains sejak kelas X.',
                'preferred_date'     => date('Y-m-d', strtotime('+2 days')),
                'preferred_time'     => 'Jam Pelajaran BK',
                'room_or_media'      => 'Ruang Konseling BK 2',
                'status'             => 'disetujui',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => null,
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subDays(1),
            ],
            // 8. Dijadwalkan Ulang - Rizky Pratama Putra (XI-2)
            [
                'student_id'         => $student6->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Sosial',
                'topic'              => 'Konsultasi dinamika kepengurusan OSIS dan manajemen resolusi konflik antar seksi bidang kegiatan.',
                'preferred_date'     => date('Y-m-d', strtotime('+4 days')),
                'preferred_time'     => 'Setelah Jam Pulang Sekolah (15:00 - 16:00 WIB)',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'dijadwalkan ulang',
                'initiated_by'       => 'guru',
                'counselor_notes'    => null,
                'rescheduled_reason' => 'Dipindahkan menyesuaikan ketersediaan waktu luang siswa setelah gladi kotor apel bendera.',
                'completed_at'       => null,
                'created_at'         => now()->subDays(2),
            ],
            // 9. Selesai - Siti Nurhaliza (XI-5)
            [
                'student_id'         => $student7->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Belajar',
                'topic'              => 'Konseling pemecahan masalah kejenuhan belajar (academic burnout) akibat target olimpiade matematika.',
                'preferred_date'     => date('Y-m-d', strtotime('-8 days')),
                'preferred_time'     => '13:00 - 14:00 WIB',
                'room_or_media'      => 'Ruang Konseling BK 2',
                'status'             => 'selesai',
                'initiated_by'       => 'guru',
                'counselor_notes'    => 'Dilakukan teknik relaksasi mindfulness dan restrukturisasi target belajar terukur. Siswa sepakat meluangkan jeda hobi kaligrafi di akhir pekan.',
                'rescheduled_reason' => null,
                'completed_at'       => now()->subDays(8)->setTime(14, 5),
                'created_at'         => now()->subDays(11),
            ],
            // 10. Menunggu Konfirmasi - Bayu Anggara (XII-3)
            [
                'student_id'         => $student8->id,
                'guru_id'            => null,
                'category'           => 'Karir',
                'topic'              => 'Konsultasi penyusunan portofolio digital bidang Desain Komunikasi Visual untuk seleksi SNBP FSRD ITB.',
                'preferred_date'     => date('Y-m-d', strtotime('+6 days')),
                'preferred_time'     => 'Istirahat 1 (09:45 - 10:15 WIB)',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'menunggu',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => null,
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subHours(3),
            ],
            // 11. Selesai - Budi Santoso (XI-3)
            [
                'student_id'         => $student3->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Belajar',
                'topic'              => 'Optimalisasi strategi belajar mandiri menggunakan modalitas kinestetik berdasarkan hasil asesmen VAK.',
                'preferred_date'     => date('Y-m-d', strtotime('-15 days')),
                'preferred_time'     => '09:00 - 10:00 WIB',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'selesai',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => 'Siswa diberikan panduan belajar berbasis proyek aplikatif (project-based study) dan teknik flashcard peraga untuk konsep teoritis.',
                'rescheduled_reason' => null,
                'completed_at'       => now()->subDays(15)->setTime(10, 0),
                'created_at'         => now()->subDays(17),
            ],
            // 12. Disetujui - Andi Pratama (XII-1)
            [
                'student_id'         => $student1->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Karir',
                'topic'              => 'Finalisasi lembar persetujuan orang tua terhadap pilihan program studi SNBP 2027.',
                'preferred_date'     => date('Y-m-d', strtotime('+1 day')),
                'preferred_time'     => 'Istirahat 1 (09:45 - 10:15 WIB)',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'disetujui',
                'initiated_by'       => 'guru',
                'counselor_notes'    => null,
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subDays(1),
            ],
            // 13. Dijadwalkan Ulang - Dinda Kirana (X-4)
            [
                'student_id'         => $student5->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Belajar',
                'topic'              => 'Teknik mencatat efektif (Cornell Notes) untuk menunjang pemahaman mata pelajaran Biologi dan Kimia.',
                'preferred_date'     => date('Y-m-d', strtotime('+7 days')),
                'preferred_time'     => 'Istirahat 2 (12:00 - 12:45 WIB)',
                'room_or_media'      => 'Ruang Konseling BK 2',
                'status'             => 'dijadwalkan ulang',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => null,
                'rescheduled_reason' => 'Siswa mengajukan pergeseran jam karena bersamaan dengan praktikum laboratorium Biologi.',
                'completed_at'       => null,
                'created_at'         => now()->subDays(2),
            ],
            // 14. Menunggu Konfirmasi - Fajar Nugraha (X-1)
            [
                'student_id'         => $student4->id,
                'guru_id'            => null,
                'category'           => 'Sosial',
                'topic'              => 'Konsultasi pemilihan mitra kelompok kerja proyek kolaborasi lintas mata pelajaran.',
                'preferred_date'     => date('Y-m-d', strtotime('+8 days')),
                'preferred_time'     => 'Jam Pelajaran BK',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'menunggu',
                'initiated_by'       => 'siswa',
                'counselor_notes'    => null,
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subHours(2),
            ],
            // 15. Disetujui - Bayu Anggara (XII-3)
            [
                'student_id'         => $student8->id,
                'guru_id'            => $guruUser->id,
                'category'           => 'Pribadi',
                'topic'              => 'Konseling pemeliharaan motivasi belajar dan regulasi diri menjelang ujian kelulusan.',
                'preferred_date'     => date('Y-m-d', strtotime('+9 days')),
                'preferred_time'     => 'Setelah Jam Pulang Sekolah (15:00 - 16:00 WIB)',
                'room_or_media'      => 'Ruang Konseling BK 1',
                'status'             => 'disetujui',
                'initiated_by'       => 'guru',
                'counselor_notes'    => null,
                'rescheduled_reason' => null,
                'completed_at'       => null,
                'created_at'         => now()->subDays(1),
            ],
        ];

        foreach ($counselingData as $cd) {
            CounselingSession::create($cd);
        }

        // =========================================================================
        // 5. CATATAN KASUS & BIMBINGAN SISWA (14 Catatan Kasus Lengkap & Mendalam)
        // =========================================================================

        $counselingNotesData = [
            [
                'student_id'             => $student1->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-5 days')),
                'kategori'               => 'Karir',
                'keluhan_masalah'        => 'Kebimbangan menentukan pilihan program studi prioritas antara Teknik Informatika ITB dan Ilmu Komputer UI, serta belum selarasnya aspirasi siswa dengan arahan keluarga (Kedokteran).',
                'layanan_diberikan'      => 'Konseling individual dengan teknik restrukturisasi kognitif dan eksplorasi data prospek karir digital. Peninjauan rekam jejak nilai rapor matematika dan informatika (rata-rata 92.5).',
                'tindak_lanjut_evaluasi' => 'Siswa menyusun portofolio prestasi dan materi diskusi keluarga; dijadwalkan sesi pendampingan keluarga jika diperlukan.',
                'status'                 => 'Dalam Pemantauan',
            ],
            [
                'student_id'             => $student1->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-22 days')),
                'kategori'               => 'Belajar',
                'keluhan_masalah'        => 'Penurunan stamina dan konsentrasi belajar akibat kebiasaan belajar hingga larut malam (sistem kebut semalam) saat pekan asesmen sumatif.',
                'layanan_diberikan'      => 'Bimbingan teknik manajemen waktu (Pomodoro 25/5 menit) dan penyusunan jadwal istirahat teratur.',
                'tindak_lanjut_evaluasi' => 'Siswa melaporkan peningkatan keteraturan tidur dan performa kuis harian terpantau meningkat stabil.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student2->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-12 days')),
                'kategori'               => 'Sosial',
                'keluhan_masalah'        => 'Kesulitan bersikap asertif saat menghadapi perbedaan pandangan kerja tim mading sekolah sehingga memicu ketegangan pertemanan.',
                'layanan_diberikan'      => 'Latihan bermain peran (role-playing) teknik komunikasi asertif \'I-Message\' dan mediasi terbuka antar anggota tim.',
                'tindak_lanjut_evaluasi' => 'Siswa telah mampu menyampaikan pandangan dengan tenang dan relasi kerja tim kembali harmonis.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student2->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-26 days')),
                'kategori'               => 'Pribadi',
                'keluhan_masalah'        => 'Kecemasan akademik (academic anxiety) yang bermanifestasi pada ketegangan fisik saat presentasi individu di depan kelas.',
                'layanan_diberikan'      => 'Teknik relaksasi pernapasan diafragma 4-7-8, latihan desensitisasi sistematis, serta afirmasi diri positif.',
                'tindak_lanjut_evaluasi' => 'Siswa mempraktikkan latihan pernapasan sebelum berbicara di depan kelas; terpantau lebih percaya diri saat penilaian formatif.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student3->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-10 days')),
                'kategori'               => 'Pribadi',
                'keluhan_masalah'        => 'Kelelahan fisik dan mental karena padatnya jadwal persiapan kompetisi robotik tingkat provinsi yang menyita waktu belajar mandiri.',
                'layanan_diberikan'      => 'Konseling realitas mengenai penetapan batas energi harian (work-life balance tingkat pelajar) dan koordinasi dispensasi terukur dengan pembina ekstrakurikuler.',
                'tindak_lanjut_evaluasi' => 'Pembina ekskul menyepakati jadwal latihan terstruktur maksimal hingga pukul 17:00 WIB agar waktu belajar di rumah terlindungi.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student3->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-15 days')),
                'kategori'               => 'Belajar',
                'keluhan_masalah'        => 'Kesulitan menghafal konsep rumus Fisika dan Kimia ketika hanya mengandalkan membaca buku teks pasif.',
                'layanan_diberikan'      => 'Penyesuaian strategi belajar berbasis gaya kinestetik: peragaan laboratorium mandiri, membuat mind-map fisik di karton, dan belajar kolaboratif.',
                'tindak_lanjut_evaluasi' => 'Nilai tugas praktikum dan ulangan harian Fisika menunjukkan kenaikan signifikan menjadi 88.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student4->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-18 days')),
                'kategori'               => 'Pribadi',
                'keluhan_masalah'        => 'Gegar budaya belajar (academic shock) dari jenjang SMP ke SMA dengan volume materi pelajaran yang jauh lebih padat.',
                'layanan_diberikan'      => 'Layanan orientasi individual: pemetaan silabus kurikulum merdeka, pemahaman jam efektif belajar, serta teknik pencatatan intisari materi.',
                'tindak_lanjut_evaluasi' => 'Siswa merasa lebih tenang dan mampu mengikuti ritme pembelajaran di kelas X-1 dengan optimal.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student5->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-6 days')),
                'kategori'               => 'Karir',
                'keluhan_masalah'        => 'Kurangnya pemahaman mengenai linimasa dan kriteria seleksi mahasiswa baru jalur prestasi SNBP di Fakultas Kedokteran PTN.',
                'layanan_diberikan'      => 'Pemberian informasi karir komprehensif: pemaparan matriks bobot mata pelajaran pendukung prodi Kedokteran (Biologi dan Kimia) serta pentingnya stabilitas tren nilai rapor.',
                'tindak_lanjut_evaluasi' => 'Siswa menyusun target nilai minimal tiap semester dan bergabung dalam tim pembinaan olimpiade sains sekolah.',
                'status'                 => 'Dalam Pemantauan',
            ],
            [
                'student_id'             => $student6->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-14 days')),
                'kategori'               => 'Sosial',
                'keluhan_masalah'        => 'Tantangan memimpin rapat divisi OSIS ketika terjadi kebuntuan ide dan perbedaan karakter antar anggota.',
                'layanan_diberikan'      => 'Konseling kepemimpinan dan teknik fasilitasi diskusi kelompok: metode active listening, parafrase ide anggota, dan consensus building.',
                'tindak_lanjut_evaluasi' => 'Rapat kerja OSIS terlaksana lancar dengan program kerja peringatan bulan bahasa yang telah disepakati bersama.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student7->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-8 days')),
                'kategori'               => 'Belajar',
                'keluhan_masalah'        => 'Kejenuhan belajar (burnout) yang dipicu oleh ekspektasi pribadi yang terlalu perfeksionis pada mata pelajaran eksakta.',
                'layanan_diberikan'      => 'Konseling kognitif restrukturisasi standar keberhasilan: membedakan antara perfeksionisme neurotik dan striving for excellence, serta penjadwalan hobi seni kaligrafi.',
                'tindak_lanjut_evaluasi' => 'Siswa merasa beban mental berkurang dan dapat kembali menikmati proses belajar tanpa kecemasan berlebih.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student8->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-4 days')),
                'kategori'               => 'Karir',
                'keluhan_masalah'        => 'Kebimbangan menentukan arah portofolio gambar naratif atau ilustrasi digital untuk seleksi masuk FSRD ITB.',
                'layanan_diberikan'      => 'Konsultasi kurasi portofolio: mengundang guru seni budaya sekolah untuk bedah karya bersama dan mengkaji rubrik resmi penilaian FSRD.',
                'tindak_lanjut_evaluasi' => 'Siswa telah menentukan tema naratif karya portofolio dan menjadwalkan asistensi berkala ke guru seni.',
                'status'                 => 'Dalam Pemantauan',
            ],
            [
                'student_id'             => $student4->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-11 days')),
                'kategori'               => 'Sosial',
                'keluhan_masalah'        => 'Rasa canggung dalam memulai pertemanan di kelas baru karena berasal dari SMP luar kota.',
                'layanan_diberikan'      => 'Bimbingan keterampilan sosial: teknik ice-breaking komunikasi santai, bergabung dalam kelompok studi sepulang sekolah, dan partisipasi ekskul basket.',
                'tindak_lanjut_evaluasi' => 'Siswa telah memiliki lingkaran teman akrab di kelas X-1 dan aktif dalam tim basket sekolah.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student6->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-21 days')),
                'kategori'               => 'Karir',
                'keluhan_masalah'        => 'Mencari informasi mengenai universitas yang memiliki program studi Ilmu Hubungan Internasional terakreditasi Unggul di dalam dan luar negeri.',
                'layanan_diberikan'      => 'Layanan informasi karir: penelusuran database BAN-PT, data alumni di UI, UGM, dan Unpad, serta jalur beasiswa Kementerian Pendidikan.',
                'tindak_lanjut_evaluasi' => 'Siswa menyimpan arsip informasi dan fokus mempertahankan nilai mata pelajaran Bahasa Inggris dan Sosiologi.',
                'status'                 => 'Selesai / Teratasi',
            ],
            [
                'student_id'             => $student7->id,
                'guru_id'                => $guruUser->id,
                'tanggal'                => date('Y-m-d', strtotime('-17 days')),
                'kategori'               => 'Pribadi',
                'keluhan_masalah'        => 'Kekhawatiran terhadap adaptasi kurikulum dan beban tugas mata pelajaran pilihan di tingkat XI.',
                'layanan_diberikan'      => 'Reframing pola pikir positif dan bimbingan pembuatan matriks skala prioritas harian (Eisenhower Box).',
                'tindak_lanjut_evaluasi' => 'Siswa mampu mengorganisasi jadwal harian secara mandiri dan tidak lagi mengalami penumpukan tugas.',
                'status'                 => 'Selesai / Teratasi',
            ],
        ];

        foreach ($counselingNotesData as $cnd) {
            CounselingNote::create($cnd);
        }

        // =========================================================================
        // 6. AGENDA KALENDER KEGIATAN BK (14 Agenda Terpadu)
        // =========================================================================

        $calendarData = [
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Klasikal: Sosialisasi Mekanisme SNBP & Strategi Pemilihan Program Studi PTN',
                'event_date'  => date('Y-m-d', strtotime('-7 days')),
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Aula Pertemuan Utama SMAN 1 Bandung',
                'category'    => 'Bimbingan Klasikal',
                'description' => 'Pemaparan kebijakan seleksi nasional, pembacaan kuota sekolah, dan strategi rasionalisasi nilai rapor semester 1 sampai 5 untuk seluruh siswa kelas XII.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Layanan Bimbingan Kelompok: Manajemen Stres Akademik & Teknik Mindful Learning',
                'event_date'  => date('Y-m-d', strtotime('-4 days')),
                'start_time'  => '10:15',
                'end_time'    => '11:45',
                'location'    => 'Ruang Konseling BK 2',
                'category'    => 'Bimbingan Kelompok',
                'description' => 'Sesi bimbingan kelompok beranggotakan 8 siswa terpilih untuk melatih regulasi emosi, relaksasi otot progresif, dan teknik belajar mindful.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Layanan Orientasi & Konsultasi Karir Terbuka: Klinik Minat Bakat Siswa Kelas XII',
                'event_date'  => date('Y-m-d'), // Hari Ini
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Ruang Multimedia SMAN 1 Bandung',
                'category'    => 'Konsultasi',
                'description' => 'Klinik konsultasi karir interaktif bersama Guru BK bagi siswa yang ingin berkonsultasi mengenai penjurusan dan akreditasi prodi kampus mitra.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Klasikal Kelas X: Pengenalan Gaya Belajar VAK & Adaptasi Budaya Belajar SMA',
                'event_date'  => date('Y-m-d', strtotime('+2 days')),
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Kelas X-1 s.d. X-4',
                'category'    => 'Bimbingan Klasikal',
                'description' => 'Materi pengenalan modalitas belajar mandiri, pembentukan kelompok belajar efektif, dan pencegahan prokrastinasi tugas sekolah.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Kunjungan Rumah (Home Visit) Terjadwal: Koordinasi Prestasi & Absensi Siswa',
                'event_date'  => date('Y-m-d', strtotime('+5 days')),
                'start_time'  => '13:30',
                'end_time'    => '15:30',
                'location'    => 'Wilayah Domisili Siswa Binaan',
                'category'    => 'Home Visit',
                'description' => 'Kunjungan silaturahmi edukatif dan koordinasi berkala bersama orang tua siswa untuk membangun keselarasan pendampingan belajar di rumah.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Kelompok: Pengembangan Keterampilan Komunikasi Asertif & Resolusi Konflik',
                'event_date'  => date('Y-m-d', strtotime('+8 days')),
                'start_time'  => '10:00',
                'end_time'    => '11:30',
                'location'    => 'Ruang Konseling BK 2',
                'category'    => 'Bimbingan Kelompok',
                'description' => 'Simulasi bermain peran dan latihan komunikasi empati bagi pengurus organisasi ekstrakurikuler sekolah.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Klasikal Kelas XI: Eksplorasi Minat Karir & Persiapan Pemilihan Mata Pelajaran Lanjut',
                'event_date'  => date('Y-m-d', strtotime('+10 days')),
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Ruang Multimedia SMAN 1 Bandung',
                'category'    => 'Bimbingan Klasikal',
                'description' => 'Pemberian wawasan karir modern berbasis kecerdasan buatan, teknologi hijau, dan industri kreatif.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Konferensi Kasus Terpadu: Penanganan Kasus Khusus Bersama Wali Kelas & Guru Mata Pelajaran',
                'event_date'  => date('Y-m-d', strtotime('+12 days')),
                'start_time'  => '13:00',
                'end_time'    => '14:30',
                'location'    => 'Ruang Rapat Guru BK',
                'category'    => 'Konferensi Kasus',
                'description' => 'Rapat koordinasi internal guru BK, wali kelas, dan guru mapel guna merumuskan tindak lanjut penanganan komprehensif bagi siswa yang membutuhkan pendampingan khusus.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Parenting & Temu Konsultasi Wali Murid: Sinergi Sekolah dan Keluarga Menyiapkan Kelulusan',
                'event_date'  => date('Y-m-d', strtotime('+14 days')),
                'start_time'  => '08:30',
                'end_time'    => '11:30',
                'location'    => 'Aula Pertemuan Utama SMAN 1 Bandung',
                'category'    => 'Konferensi Kasus',
                'description' => 'Pertemuan interaktif Guru BK, Kepala Sekolah, dan Wali Murid kelas XII untuk menyelaraskan dukungan emosional dan finansial studi lanjut siswa.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Kunjungan Rumah (Home Visit): Pendampingan Kesehatan Mental & Lingkungan Belajar',
                'event_date'  => date('Y-m-d', strtotime('+18 days')),
                'start_time'  => '13:30',
                'end_time'    => '15:30',
                'location'    => 'Wilayah Domisili Siswa Binaan',
                'category'    => 'Home Visit',
                'description' => 'Home visit berkala untuk mempererat relasi kemitraan sekolah dan keluarga dalam mendukung capaian akademik siswa.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Klasikal: Soft Skills Abad 21 & Etika Komunikasi Profesional di Era Digital',
                'event_date'  => date('Y-m-d', strtotime('-14 days')),
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Kelas XII-1 & XII-2',
                'category'    => 'Bimbingan Klasikal',
                'description' => 'Materi pembekalan kompetensi abad 21: critical thinking, komunikasi interpersonal, personal branding, dan etika komunikasi profesional.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Kelompok: Strategi Manajemen Waktu Menjelang Penilaian Tengah Semester',
                'event_date'  => date('Y-m-d', strtotime('-19 days')),
                'start_time'  => '10:00',
                'end_time'    => '11:30',
                'location'    => 'Ruang Konseling BK 2',
                'category'    => 'Bimbingan Kelompok',
                'description' => 'Praktek penyusunan agenda belajar mingguan dan eliminasi distraksi penggunaan gawai berlebihan.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Layanan Konsultasi Peminatan: Pendampingan Siswa Peserta Seleksi Olimpiade Sains',
                'event_date'  => date('Y-m-d', strtotime('+22 days')),
                'start_time'  => '13:00',
                'end_time'    => '14:30',
                'location'    => 'Ruang Konseling BK 1',
                'category'    => 'Konsultasi',
                'description' => 'Sesi konsultasi penguatan motivasi dan kesiapan mental menghadapi kompetisi tingkat kota.',
            ],
            [
                'user_id'     => $guruUser->id,
                'title'       => 'Bimbingan Klasikal: Pencegahan Perundungan (Anti-Bullying) & Budaya Saling Menghargai',
                'event_date'  => date('Y-m-d', strtotime('-25 days')),
                'start_time'  => '08:00',
                'end_time'    => '09:30',
                'location'    => 'Aula Pertemuan Utama SMAN 1 Bandung',
                'category'    => 'Bimbingan Klasikal',
                'description' => 'Kampanye sekolah ramah anak dan sosialisasi saluran pengaduan perlindungan siswa di lingkungan sekolah.',
            ],
        ];

        foreach ($calendarData as $cEv) {
            CalendarEvent::create($cEv);
        }

        // =========================================================================
        // 7. NOTIFIKASI SISTEM (HANYA FITUR ASLI: KONSELING, ASESMEN, KALENDER, REKAM KASUS)
        // =========================================================================

        // Notifikasi untuk Guru BK
        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Permohonan Bimbingan Masuk',
            'message'    => 'Andi Pratama mengajukan permohonan temu bimbingan bidang Belajar.',
            'url'        => '/guru/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(5),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Permohonan Bimbingan Masuk',
            'message'    => 'Bayu Anggara mengajukan permohonan temu bimbingan bidang Karir.',
            'url'        => '/guru/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(3),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Respon Asesmen Diterima',
            'message'    => 'Rina Putri telah menyelesaikan pengisian Inventori Modalitas & Gaya Belajar Siswa (VAK).',
            'url'        => '/guru/questionnaires/' . $q2->id,
            'type'       => 'questionnaire',
            'is_read'    => true,
            'created_at' => now()->subDays(1),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Pengingat Kegiatan BK Hari Ini',
            'message'    => 'Agenda hari ini: Layanan Orientasi & Konsultasi Karir Terbuka: Klinik Minat Bakat Siswa Kelas XII (08:00 WIB) di Ruang Multimedia.',
            'url'        => '/guru/calendar',
            'type'       => 'calendar_reminder',
            'is_read'    => false,
            'created_at' => now()->subHours(1),
        ]);

        AppNotification::create([
            'user_id'    => $guruUser->id,
            'title'      => 'Respon Asesmen Diterima',
            'message'    => 'Fajar Nugraha telah menyelesaikan pengisian Angket Kebutuhan Peserta Didik (AKPD) / IKMS Terpadu.',
            'url'        => '/guru/questionnaires/' . $q1->id,
            'type'       => 'questionnaire',
            'is_read'    => true,
            'created_at' => now()->subDays(2),
        ]);

        // Notifikasi untuk Siswa 1 (Andi Pratama)
        AppNotification::create([
            'user_id'    => $user1->id,
            'title'      => 'Jadwal Konseling Disetujui',
            'message'    => 'Guru BK telah menyetujui jadwal konseling tindak lanjut SNBP pada besok pukul 09:45 WIB di Ruang Konseling BK 1.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(6),
        ]);

        AppNotification::create([
            'user_id'    => $user1->id,
            'title'      => 'Sesi Konseling Selesai',
            'message'    => 'Sesi bimbingan bidang Karir telah selesai dilaksanakan. Catatan hasil bimbingan telah diperbarui oleh Guru BK.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => true,
            'created_at' => now()->subDays(5),
        ]);

        // Notifikasi untuk Siswa 2 (Rina Putri)
        AppNotification::create([
            'user_id'    => $user2->id,
            'title'      => 'Pengingat Jadwal Konseling Hari Ini',
            'message'    => 'Anda memiliki sesi bimbingan bersama Guru BK hari ini pukul 09:45 WIB di Ruang Konseling BK 1.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(2),
        ]);

        // Notifikasi untuk Siswa 3 (Budi Santoso)
        AppNotification::create([
            'user_id'    => $user3->id,
            'title'      => 'Jadwal Konseling Dijadwalkan Ulang',
            'message'    => 'Jadwal konseling Anda disesuaikan menjadi tanggal ' . date('d M Y', strtotime('+3 days')) . ' pukul 15:00 WIB di Ruang BK 2. Alasan: Koordinasi MGMP BK Guru BK.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(8),
        ]);

        // Notifikasi untuk Siswa 5 (Dinda Kirana)
        AppNotification::create([
            'user_id'    => $user5->id,
            'title'      => 'Jadwal Konseling Disetujui',
            'message'    => 'Guru BK telah menyetujui sesi bimbingan roadmap karir kedokteran pada ' . date('d M Y', strtotime('+2 days')) . ' di Ruang Konseling BK 2.',
            'url'        => '/siswa/counseling',
            'type'       => 'counseling',
            'is_read'    => false,
            'created_at' => now()->subHours(12),
        ]);

        // =========================================================================
        // 8. PENGATURAN KOP SURAT LAPORAN RESMI (Report Settings)
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
