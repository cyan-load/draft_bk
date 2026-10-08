## **Draft Source Code Praktik Lapang / Tugas Akhir**  


## Ringkasan Proyek

**SIM-BK** adalah aplikasi berbasis web yang dikembangkan untuk mendigitalkan dan meningkatkan efisiensi tata kelola layanan Bimbingan dan Konseling (BK) di institusi sekolah. Sistem ini dirancang untuk mempermudah Guru BK dalam mengelola agenda bimbingan, memonitor perkembangan peserta didik, melakukan asesmen pemetaan minat, bakat, dan kebutuhan peserta didik, serta menghasilkan rekam jejak bimbingan resmi yang terstandardisasi. Di sisi lain, siswa memperoleh ruang aman dan terstruktur untuk mengajukan konsultasi serta memantau perkembangan asesmen mereka.

---

## Fitur dan Spesifikasi Sistem

Sistem ini dibangun dengan pemisahan hak akses berbasis peran (*Role-Based Access Control*):

### 1. Autentikasi & Keamanan
- **Autentikasi Multi-Peran**: Pemisahan otorisasi ketat antara **Guru BK** dan **Siswa**.
- **Enkripsi Kredensial**: Penyimpanan kata sandi menggunakan algoritma hashing *Bcrypt*.
- **Proteksi Akses**: Dilengkapi proteksi CSRF (*Cross-Site Request Forgery*), sanitasi input, dan middleware proteksi rute.
- **Manajemen Profil**: Pembaruan biodata diri dan penggantian kata sandi berkala.

### 2. Modul Guru BK
- **Dashboard Ringkasan Eksekutif**: Metrik jumlah siswa asuh, agenda konseling aktif, dan progres asesmen berjalan.
- **Pengelolaan Data Siswa**:
  - Direktori data siswa dengan filter pencarian dan kelas.
  - Profil mendalam siswa: riwayat bimbingan, rekam kasus (*anecdotal notes*), dan hasil kuisioner yang telah diselesaikan.
  - Fitur cetak resmi dokumen **Rekam Jejak Konseling Siswa** berstandar dinas pendidikan (dilengkapi kop surat dan tanda tangan yang dapat disesuaikan).
- **Layanan Konseling Terstruktur**:
  - Konfirmasi, penjadwalan ulang (*reschedule*), dan penutupan sesi bimbingan siswa.
  - **Deteksi Otomatis Jadwal Bentrok**: Peringatan otomatis interaktif (*real-time warning*) saat inisiasi, persetujuan, atau penjadwalan ulang jika waktu konseling bertabrakan dengan agenda lain.
  - Form pencatatan hasil bimbingan: permasalahan, pendekatan/teknik BK yang digunakan, kesimpulan, dan rekomendasi tindak lanjut.
- **Asesmen & Kuisioner Dinamis**:
  - Pembuatan butir instrumen mandiri (Pilihan Tunggal, Pilihan Ganda dengan bobot skor, dan Isian/Uraian).
  - Klasifikasi 4 bidang bimbingan: **Pribadi, Sosial, Belajar, dan Karier**.
  - Monitoring partisipasi siswa dan rekapitulasi data jawaban.
  - Ekspor data mentah responden ke format Excel/CSV.
  - Cetak Rekapitulasi Hasil Asesmen Kelas dan Lembar Jawaban Individual berformat PDF resmi.
- **Kalender & Agenda Kerja BK**:
  - Kalender interaktif bulanan untuk mencatat kegiatan bimbingan klasikal, konferensi kasus, kunjungan rumah (*home visit*), dan janji temu siswa.
  - **Pencegahan Bentrok Jadwal Kalender**: Validasi otomatis dan peringatan interaktif saat penambahan maupun pembaruan kegiatan di kalender bila waktu pelaksanaan bentrok dengan sesi konseling atau kegiatan lain.

### 3. Modul Siswa
- **Dashboard Siswa**: Informasi agenda bimbingan yang akan datang dan status instrumen asesmen yang wajib diisi.
- **Pengajuan Konseling Mandiri**:
  - Siswa dapat mengajukan sesi konsultasi dengan memilih topik masalah, tanggal/waktu yang diinginkan, serta jenis bidang bimbingan.
  - **Peringatan Otomatis Jadwal Bentrok**: Peringatan dini di formulir pengajuan apabila slot waktu yang dipilih sudah terisi agenda Guru BK.
  - Mengetahui status konfirmasi dari Guru BK secara transparan.
- **Pengisian Asesmen & Kuisioner**:
  - Antarmuka pengisian angket responsif dengan indikator butir wajib.
  - Visualisasi grafik diagram distribusi skor asesmen berdasarkan 4 Aspek BK (Karier, Belajar, Sosial, Pribadi).
- **Notifikasi Internal**: Pemberitahuan otomatis ketika pengajuan konseling disetujui atau dijadwalkan ulang oleh Guru BK.

---

## Tech Stack & Arsitektur

- **Backend Framework**: [Laravel 12](https://laravel.com) (PHP 8.2+)
- **Database Engine**: MySQL 5.7+ / MariaDB 10.4+
- **Frontend Architecture**: Laravel Blade Component, [Tailwind CSS v3](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Data Visualization**: [Chart.js](https://www.chartjs.org) (Radar & Bar Chart Asesmen)
- **Dokumentasi Cetak**: Print CSS Landscape & Portrait Berstandar Kop Surat Kedinasan

---

## Struktur Direktori Utama

```text
draft_bk/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php             # Login, Register, Logout, Profil
│   │   │   ├── Guru/                          # Modul Fungsional Guru BK
│   │   │   │   ├── DashboardController.php
│   │   │   │   ├── StudentController.php      # Data Siswa & Cetak Rekam Jejak
│   │   │   │   ├── CounselingController.php   # Sesi & Catatan Konseling
│   │   │   │   ├── QuestionnaireController.php# Pembuat Asesmen, Scoring, CSV, Cetak
│   │   │   │   └── CalendarController.php     # Agenda Kegiatan Guru BK
│   │   │   └── Siswa/                         # Modul Fungsional Siswa
│   │   │       ├── DashboardController.php
│   │   │       ├── CounselingController.php   # Pengajuan Jadwal Konseling
│   │   │       └── QuestionnaireController.php# Pengerjaan & Analisis Skor
│   │   └── Middleware/                        # RoleMiddleware (guru / siswa)
│   └── Models/                                # User, CounselingSession, Questionnaire, dll.
├── database/
│   ├── migrations/                            # Skema struktur tabel database
│   ├── seeders/                               # Data awal (seeder demo)
│   └── draft_bk.sql                           # File dump SQL lengkap (siap import)
├── resources/
│   └── views/
│       ├── auth/                              # Halaman Login & Registrasi
│       ├── guru/                              # View antarmuka Guru BK
│       ├── siswa/                             # View antarmuka Siswa
│       └── layouts/                           # Layout master responsif
└── routes/
    └── web.php                                # Pengalamatan rute dan grup middleware
```

---

## Panduan Instalasi & Pengujian

Bagi Dosen Pembimbing atau Penguji yang ingin menjalankan aplikasi ini di lingkungan lokal, berikut langkah-langkahnya:

### 1. Prasyarat Sistem
- **PHP** versi 8.2 atau lebih tinggi (disarankan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `bcmath` aktif)
- **Composer** (Package Manager PHP)
- **MySQL / MariaDB** (melalui XAMPP, Laragon, atau MySQL Server mandiri)

### 2. Langkah Instalasi

1. **Clone Repositori**:
   ```bash
   git clone <URL_REPOSITORI_GITHUB_ANDA>
   cd draft_bk
   ```

2. **Instal Dependensi PHP**:
   ```bash
   composer install
   ```

3. **Konfigurasi Environment**:
   Salin file konfigurasi contoh:
   ```bash
   # Di Windows (Command Prompt / PowerShell)
   copy .env.example .env

   # Atau di Linux / MacOS / Git Bash
   cp .env.example .env
   ```

4. **Generate Application Key**:
   ```bash
   php artisan key:generate
   ```

5. **Setup Database**:
   - Buat database baru bernama `draft_bk` di MySQL / phpMyAdmin.
   - **Metode A (Rekomendasi Cepat)**:
     Import langsung file `database/draft_bk.sql` ke dalam database `draft_bk` melalui menu **Import** di phpMyAdmin.
   - **Metode B (Via Artisan Migration & Seeder)**:
     ```bash
     php artisan migrate:fresh --seed
     ```

6. **Jalankan Web Server**:
   ```bash
   php artisan serve
   ```
   Aplikasi siap diakses melalui peramban web pada URL:  
   **`http://localhost:8000`** atau **`http://127.0.0.1:8000`**

---

## Kredensial Akun Pengujian (Demo)

Sistem login mendukung autentikasi menggunakan **Email** maupun **Username / NIS**. Untuk keperluan pengujian fungsi sistem oleh Dosen Pembimbing / Penguji, telah disediakan akun bawaan (*seeded data*):

| Peran (Role) | Identitas Login (Email / NIS) | Password | Profil / Keterangan |
| :--- | :--- | :--- | :--- |
| **Guru BK** | `guru@gmail.com` *(atau username: `guru`)* | `gurubk123` | Koordinator BK (Akses penuh dashboard guru, data siswa, kuisioner asesmen, dan agenda kegiatan) |
| **Siswa 1** | `andipratama@gmail.com` *(atau NIS: `10293`)* | `password123` | Andi Pratama (Kelas XII-1, riwayat konseling karir & respon asesmen lengkap) |
| **Siswa 2** | `rinaputri@gmail.com` *(atau NIS: `10294`)* | `password123` | Rina Putri (Kelas XII-2, sesi konseling belajar & asesmen VAK) |
| **Siswa 3** | `budisantoso@gmail.com` *(atau NIS: `10295`)* | `password123` | Budi Santoso (Kelas XI-1, sesi konseling sosial & asesmen AKPD) |
| **Siswa 4** | `fajarnugraha@gmail.com` *(atau NIS: `10296`)* | `password123` | Fajar Nugraha (Kelas XII-1, penjadwalan ulang & konseling karir) |
| **Siswa 5** | `dindapermata@gmail.com` *(atau NIS: `10297`)* | `password123` | Dinda Permata (Kelas XI-2, bimbingan resiliensi & belajar) |
| **Siswa 6** | `rizkyramadhan@gmail.com` *(atau NIS: `10298`)* | `password123` | Rizky Ramadhan (Kelas X-1, adaptasi lingkungan & bimbingan pribadi) |
| **Siswa 7** | `sitinurhaliza@gmail.com` *(atau NIS: `10299`)* | `password123` | Siti Nurhaliza (Kelas XII-3, eksplorasi karir kesehatan) |
| **Siswa 8** | `bayupratama@gmail.com` *(atau NIS: `10300`)* | `password123` | Bayu Pratama (Kelas X-2, bimbingan manajemen waktu dan ekstrakurikuler) |

> *Catatan: Form login dapat menerima Email ataupun NIS/Username secara langsung. Pengujian pendaftaran akun siswa baru juga dapat dilakukan melalui tombol **Daftar Akun Siswa Baru** (`/register`).*

