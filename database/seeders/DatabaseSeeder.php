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

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Guru BK
        $guruUser = User::updateOrCreate(
            ['email' => 'guru@gmail.com'],
            [
                'username' => 'guru',
                'password' => Hash::make('gurubk123'),
                'role' => 'guru',
            ]
        );

        // 2. Akun Siswa 1 (Andi Pratama)
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
                'tanggal_lahir' => '2006-05-14',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Merdeka No. 45, Bandung',
                'nomor_telepon' => '081234567891',
                'nomor_telepon_orang_tua' => '081298765432',
                'nama_ayah' => 'Bambang Pratama',
                'nama_ibu' => 'Siti Aminah',
                'hobi' => 'Sepak Bola & Pemrograman',
                'cita_cita' => 'Software Engineer',
            ]
        );

        // 3. Akun Siswa 2 (Rina Putri)
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
                'tanggal_lahir' => '2006-08-20',
                'jenis_kelamin' => 'Perempuan',
                'agama' => 'Islam',
                'alamat' => 'Jl. Kenanga No. 12, Bandung',
                'nomor_telepon' => '081345678902',
                'nomor_telepon_orang_tua' => '081398765401',
                'nama_ayah' => 'Hendro Susilo',
                'nama_ibu' => 'Dewi Lestari',
                'hobi' => 'Menulis & Desain Grafis',
                'cita_cita' => 'Psikolog',
            ]
        );

        // 4. Akun Siswa 3 (Budi Santoso)
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
                'tanggal_lahir' => '2007-03-10',
                'jenis_kelamin' => 'Laki-laki',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pahlawan No. 88, Bandung',
                'nomor_telepon' => '081567890123',
                'nomor_telepon_orang_tua' => '081587654321',
                'nama_ayah' => 'Joko Santoso',
                'nama_ibu' => 'Sri Wahyuni',
                'hobi' => 'Bermain Musik & Robotik',
                'cita_cita' => 'Teknik Elektro',
            ]
        );

        // 5. Kuisioner Contoh 1: AKPD (Angket Kebutuhan Peserta Didik)
        $q1 = Questionnaire::updateOrCreate(
            ['judul' => 'Angket Kebutuhan Peserta Didik (AKPD)'],
            [
                'deskripsi' => 'Kuisioner ini bertujuan untuk mengidentifikasi kebutuhan bimbingan dan konseling siswa dalam aspek pribadi, sosial, belajar, dan karir.',
                'target_kelas' => 'Semua Kelas',
                'is_active' => true,
            ]
        );

        $questionsQ1 = [
            [
                'teks_pertanyaan' => 'Saya merasa bingung dalam menentukan arah karir atau jurusan kuliah setelah lulus SMA.',
                'tipe_jawaban' => 'single_choice',
                'is_wajib' => 1,
                'aspek' => 'Karier',
                'options' => [
                    ['teks_opsi' => 'Sangat Sering / Sangat Sesuai', 'bobot_nilai' => 4],
                    ['teks_opsi' => 'Sering / Sesuai', 'bobot_nilai' => 3],
                    ['teks_opsi' => 'Kadang-kadang', 'bobot_nilai' => 2],
                    ['teks_opsi' => 'Tidak Pernah / Sangat Tidak Sesuai', 'bobot_nilai' => 1],
                ]
            ],
            [
                'teks_pertanyaan' => 'Saya merasa kesulitan mengatur waktu belajar mandiri di rumah dan aktivitas lainnya.',
                'tipe_jawaban' => 'single_choice',
                'is_wajib' => 1,
                'aspek' => 'Belajar',
                'options' => [
                    ['teks_opsi' => 'Sangat Sering / Sangat Sesuai', 'bobot_nilai' => 4],
                    ['teks_opsi' => 'Sering / Sesuai', 'bobot_nilai' => 3],
                    ['teks_opsi' => 'Kadang-kadang', 'bobot_nilai' => 2],
                    ['teks_opsi' => 'Tidak Pernah / Sangat Tidak Sesuai', 'bobot_nilai' => 1],
                ]
            ],
            [
                'teks_pertanyaan' => 'Kegiatan ekstrakurikuler atau bidang pengembangan diri apa saja yang paling Anda minati?',
                'tipe_jawaban' => 'multichoice',
                'is_wajib' => 0,
                'aspek' => 'Pribadi',
                'options' => [
                    ['teks_opsi' => 'Sains & Teknologi / Komputer', 'bobot_nilai' => 1],
                    ['teks_opsi' => 'Seni, Musik & Desain', 'bobot_nilai' => 1],
                    ['teks_opsi' => 'Olahraga & Kesehatan', 'bobot_nilai' => 1],
                    ['teks_opsi' => 'Kepemimpinan & Organisasi (OSIS/Pramuka)', 'bobot_nilai' => 1],
                    ['teks_opsi' => 'Bahasa & Jurnalistik', 'bobot_nilai' => 1],
                ]
            ],
            [
                'teks_pertanyaan' => 'Ceritakan secara singkat harapan Anda terhadap layanan bimbingan konseling di sekolah.',
                'tipe_jawaban' => 'text',
                'is_wajib' => 0,
                'aspek' => 'Pribadi',
                'options' => []
            ],
        ];

        $q1->questions()->delete();
        foreach ($questionsQ1 as $qData) {
            $question = Question::create([
                'questionnaire_id' => $q1->id,
                'teks_pertanyaan' => $qData['teks_pertanyaan'],
                'tipe_jawaban' => $qData['tipe_jawaban'],
                'is_wajib' => $qData['is_wajib'],
                'aspek' => $qData['aspek'],
            ]);

            foreach ($qData['options'] as $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'teks_opsi' => $opt['teks_opsi'],
                    'bobot_nilai' => $opt['bobot_nilai'],
                ]);
            }
        }

        // 6. Kuisioner Contoh 2: Asesmen Gaya Belajar Siswa
        $q2 = Questionnaire::updateOrCreate(
            ['judul' => 'Asesmen Minat & Gaya Belajar Siswa'],
            [
                'deskripsi' => 'Membantu siswa mengenali modalitas belajar dominan (Visual, Auditori, atau Kinestetik) agar belajar lebih efektif.',
                'target_kelas' => 'Semua Kelas',
                'is_active' => true,
            ]
        );

        $questionsQ2 = [
            [
                'teks_pertanyaan' => 'Ketika mengingat informasi penting dari penjelasan guru, saya lebih mudah mengingat melalui:',
                'tipe_jawaban' => 'single_choice',
                'is_wajib' => 1,
                'aspek' => 'Belajar',
                'options' => [
                    ['teks_opsi' => 'Catatan visual, diagram, dan gambar warna-warni', 'bobot_nilai' => 3],
                    ['teks_opsi' => 'Mendengarkan penjelasan secara langsung dan diskusi', 'bobot_nilai' => 2],
                    ['teks_opsi' => 'Mempraktikkan langsung / bergerak sambil belajar', 'bobot_nilai' => 1],
                ]
            ],
            [
                'teks_pertanyaan' => 'Ketika merasa stres atau lelah belajar, cara yang paling membantu saya rileks adalah:',
                'tipe_jawaban' => 'single_choice',
                'is_wajib' => 1,
                'aspek' => 'Pribadi',
                'options' => [
                    ['teks_opsi' => 'Mendengarkan musik atau berbicara dengan teman', 'bobot_nilai' => 2],
                    ['teks_opsi' => 'Berolahraga, jalan santai, atau beraktivitas fisik', 'bobot_nilai' => 1],
                    ['teks_opsi' => 'Membaca buku, menonton film, atau menggambar', 'bobot_nilai' => 3],
                ]
            ],
        ];

        $q2->questions()->delete();
        foreach ($questionsQ2 as $qData) {
            $question = Question::create([
                'questionnaire_id' => $q2->id,
                'teks_pertanyaan' => $qData['teks_pertanyaan'],
                'tipe_jawaban' => $qData['tipe_jawaban'],
                'is_wajib' => $qData['is_wajib'],
                'aspek' => $qData['aspek'],
            ]);

            foreach ($qData['options'] as $opt) {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'teks_opsi' => $opt['teks_opsi'],
                    'bobot_nilai' => $opt['bobot_nilai'],
                ]);
            }
        }

        // 7. Simpan jawaban contoh untuk Andi Pratama pada Kuisioner 1
        StudentAnswer::where('student_id', $student1->id)->where('questionnaire_id', $q1->id)->delete();
        $q1Questions = $q1->questions()->get();
        if ($q1Questions->count() >= 4) {
            StudentAnswer::create([
                'student_id' => $student1->id,
                'questionnaire_id' => $q1->id,
                'question_id' => $q1Questions[0]->id,
                'jawaban_teks' => 'Sering / Sesuai',
            ]);
            StudentAnswer::create([
                'student_id' => $student1->id,
                'questionnaire_id' => $q1->id,
                'question_id' => $q1Questions[1]->id,
                'jawaban_teks' => 'Kadang-kadang',
            ]);
            StudentAnswer::create([
                'student_id' => $student1->id,
                'questionnaire_id' => $q1->id,
                'question_id' => $q1Questions[2]->id,
                'jawaban_teks' => 'Sains & Teknologi / Komputer, Seni, Musik & Desain',
            ]);
            StudentAnswer::create([
                'student_id' => $student1->id,
                'questionnaire_id' => $q1->id,
                'question_id' => $q1Questions[3]->id,
                'jawaban_teks' => 'Saya berharap ada sesi konsultasi one-on-one berkala untuk persiapan masuk perguruan tinggi dan pemilihan jurusan.',
            ]);
        }

        // 8. Seeder Sesi Konseling
        CounselingSession::truncate();
        CounselingSession::create([
            'student_id' => $student1->id,
            'guru_id' => $guruUser->id,
            'category' => 'Karir',
            'topic' => 'Konsultasi pemilihan jurusan Teknik Informatika vs Sistem Informasi di perguruan tinggi negeri.',
            'preferred_date' => date('Y-m-d', strtotime('+1 day')),
            'preferred_time' => '10:00 - 11:00 WIB',
            'room_or_media' => 'Ruang Konseling BK 1',
            'status' => 'disetujui',
            'counselor_notes' => null,
        ]);

        CounselingSession::create([
            'student_id' => $student2->id,
            'guru_id' => $guruUser->id,
            'category' => 'Belajar',
            'topic' => 'Mengalami kesulitan fokus belajar menjelang ujian akhir semester dan rasa cemas berlebih.',
            'preferred_date' => date('Y-m-d', strtotime('+2 days')),
            'preferred_time' => '13:00 - 14:00 WIB',
            'room_or_media' => 'Ruang Konseling BK 2',
            'status' => 'menunggu',
            'counselor_notes' => null,
        ]);

        CounselingSession::create([
            'student_id' => $student3->id,
            'guru_id' => $guruUser->id,
            'category' => 'Pribadi',
            'topic' => 'Bimbingan penyesuaian diri dan manajemen waktu antara organisasi robotik dan sekolah.',
            'preferred_date' => date('Y-m-d', strtotime('-3 days')),
            'preferred_time' => '09:00 - 10:00 WIB',
            'room_or_media' => 'Ruang Konseling BK 1',
            'status' => 'selesai',
            'counselor_notes' => 'Siswa telah menyusun matriks prioritas waktu (Eisenhower Matrix) dan sepakat mengurangi beban rapat di luar jam sekolah.',
            'completed_at' => now()->subDays(3),
        ]);

        // 9. Seeder Kalender & Agenda Kegiatan BK
        CalendarEvent::truncate();
        CalendarEvent::create([
            'user_id' => $guruUser->id,
            'title' => 'Bimbingan Klasikal: Perencanaan Karir Masa Depan',
            'event_date' => date('Y-m-d'),
            'start_time' => '08:00',
            'end_time' => '09:30',
            'location' => 'Kelas XII-1 & XII-2',
            'category' => 'Bimbingan Klasikal',
            'description' => 'Materi pengenalan dunia perkuliahan dan peluang karir di era digital.',
        ]);

        CalendarEvent::create([
            'user_id' => $guruUser->id,
            'title' => 'Sesi Konseling Individu (Andi Pratama)',
            'event_date' => date('Y-m-d', strtotime('+1 day')),
            'start_time' => '10:00',
            'end_time' => '11:00',
            'location' => 'Ruang Konseling BK 1',
            'category' => 'Konseling',
            'description' => 'Konsultasi lanjutan pemilihan jurusan dan universitas target.',
        ]);

        CalendarEvent::create([
            'user_id' => $guruUser->id,
            'title' => 'Kunjungan Rumah (Home Visit) Siswa',
            'event_date' => date('Y-m-d', strtotime('+3 days')),
            'start_time' => '14:00',
            'end_time' => '16:00',
            'location' => 'Domisili Siswa Terkait',
            'category' => 'Home Visit',
            'description' => 'Koordinasi perkembangan belajar dengan orang tua murid.',
        ]);

        // 11. Seeder Catatan Kasus & Rekam Bimbingan Siswa (Counseling Notes)
        CounselingNote::truncate();
        CounselingNote::create([
            'student_id' => $student1->id,
            'guru_id' => $guruUser->id,
            'tanggal' => date('Y-m-d', strtotime('-5 days')),
            'kategori' => 'Karir',
            'keluhan_masalah' => 'Siswa merasa bimbang memilih antara Program Studi Teknik Informatika (ITB) atau Ilmu Komputer (UI). Orang tua mengarahkan ke Kedokteran.',
            'layanan_diberikan' => 'Konseling individual mengenai pemetaan bakat minat, analisis data nilai rapor semester 1-4, dan simulasi passing grade SNBP.',
            'tindak_lanjut_evaluasi' => 'Menjadwalkan sesi konsultasi bersama orang tua siswa untuk menyelaraskan pilihan minat bakat dengan harapan keluarga.',
            'status' => 'Dalam Pemantauan',
        ]);

        CounselingNote::create([
            'student_id' => $student1->id,
            'guru_id' => $guruUser->id,
            'tanggal' => date('Y-m-d', strtotime('-2 weeks')),
            'kategori' => 'Belajar',
            'keluhan_masalah' => 'Konsentrasi belajar menurun saat menghadapi ujian tengah semester karena manajemen waktu kegiatan ekstrakurikuler.',
            'layanan_diberikan' => 'Bimbingan teknik manajemen waktu (Pomodoro & Time-blocking), pembuatan matriks prioritas harian.',
            'tindak_lanjut_evaluasi' => 'Siswa telah menyusun jadwal belajar mandiri dan nilai UTS terpantau stabil.',
            'status' => 'Selesai / Teratasi',
        ]);

        CounselingNote::create([
            'student_id' => $student2->id,
            'guru_id' => $guruUser->id,
            'tanggal' => date('Y-m-d', strtotime('-1 week')),
            'kategori' => 'Pribadi',
            'keluhan_masalah' => 'Kecemasan akademik menjelang asesmen sumatif sekolah.',
            'layanan_diberikan' => 'Teknik relaksasi pernapasan 4-7-8, reframing pola pikir positif, dan afirmasi diri.',
            'tindak_lanjut_evaluasi' => 'Siswa merasa lebih tenang dan percaya diri dalam menghadapi ujian.',
            'status' => 'Selesai / Teratasi',
        ]);

        // 13. Seeder Notifikasi Sistem
        AppNotification::truncate();
        AppNotification::create([
            'user_id' => $guruUser->id,
            'title' => 'Pesan Chat Konseling Baru',
            'message' => 'Rina Putri mengirim pesan chat bimbingan baru.',
            'url' => '/guru/counseling',
            'type' => 'chat',
            'is_read' => false,
            'created_at' => now()->subMinutes(45),
        ]);

        AppNotification::create([
            'user_id' => $guruUser->id,
            'title' => 'Permohonan Janji Konseling',
            'message' => 'Andi Pratama mengajukan janji temu bimbingan karir.',
            'url' => '/guru/counseling',
            'type' => 'counseling',
            'is_read' => false,
            'created_at' => now()->subHours(2),
        ]);

        AppNotification::create([
            'user_id' => $user1->id,
            'title' => 'Permohonan Konseling Disetujui',
            'message' => 'Jadwal konseling Anda telah disetujui Guru BK pada Ruang BK 1.',
            'url' => '/siswa/counseling',
            'type' => 'counseling',
            'is_read' => false,
            'created_at' => now()->subHours(1),
        ]);

        // 13. Seeder Pengaturan Dokumen Cetak / Template Laporan
        ReportSetting::truncate();
        ReportSetting::create([
            'school_name' => 'SMA NEGERI 1 KOTA BANDUNG',
            'school_address' => 'Jl. Ir. H. Juanda No. 93, Coblong, Kota Bandung, Jawa Barat 40132',
            'school_phone' => '(022) 2503582',
            'school_email' => 'smansabandung@gmail.com',
            'school_website' => 'www.sman1bandung.sch.id',
            'headmaster_name' => 'Dr. H. Ahmad Supardi, M.Pd.',
            'headmaster_nip' => '19720315 199802 1 003',
            'counselor_name' => 'Dra. Hj. Siti Rohmah, M.Psi.',
            'counselor_nip' => '19800512 200501 2 006',
            'city_date' => 'Bandung',
        ]);
    }
}
