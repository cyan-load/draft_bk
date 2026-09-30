-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: draft_bk
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `app_notifications`
--

DROP TABLE IF EXISTS `app_notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `app_notifications` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'general',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `app_notifications_user_id_foreign` (`user_id`),
  CONSTRAINT `app_notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_notifications`
--

LOCK TABLES `app_notifications` WRITE;
/*!40000 ALTER TABLE `app_notifications` DISABLE KEYS */;
INSERT INTO `app_notifications` VALUES (1,1,'Pesan Chat Konseling Baru','Rina Putri mengirim pesan chat bimbingan baru.','/guru/counseling','chat',1,'2026-09-01 16:50:27','2026-09-01 17:42:55'),(2,1,'Permohonan Janji Konseling','Andi Pratama mengajukan janji temu bimbingan karir.','/guru/counseling','counseling',1,'2026-09-01 15:35:27','2026-09-01 18:09:13'),(3,2,'Permohonan Konseling Disetujui','Jadwal konseling Anda telah disetujui Guru BK pada Ruang BK 1.','/siswa/counseling','counseling',1,'2026-09-01 16:35:27','2026-09-01 17:50:00'),(4,2,'Pengumuman Baru Diterbitkan','Sosialisasi SNBP & SNBT 2026 telah dipublikasikan.','/siswa/announcements','announcement',1,'2026-08-31 17:35:27','2026-09-01 17:35:27'),(5,3,'Pesan dari Guru BK','Bapak/Ibu Guru BK mengirimkan pesan: \"oke\"','/siswa/counseling','chat',0,'2026-09-01 17:41:40','2026-09-01 17:41:40'),(6,3,'Pesan dari Guru BK','Bapak/Ibu Guru BK mengirimkan pesan: \"logo\"','/siswa/counseling','chat',0,'2026-09-01 17:41:50','2026-09-01 17:41:50'),(7,1,'Pengajuan Konseling Baru','Andi Pratama (Kelas XII-1) mengajukan bimbingan bidang Pribadi pada 02 Sep 2026','/guru/counseling','counseling',1,'2026-09-01 17:48:25','2026-09-01 18:09:13'),(8,1,'Pengajuan Konseling Baru','Andi Pratama (Kelas XII-1) mengajukan bimbingan bidang Pribadi pada 02 Sep 2026','/guru/counseling','counseling',1,'2026-09-01 17:48:27','2026-09-01 18:09:13'),(9,1,'Pengajuan Konseling Baru','Andi Pratama (Kelas XII-1) mengajukan bimbingan bidang Pribadi pada 02 Sep 2026','/guru/counseling','counseling',1,'2026-09-01 17:48:28','2026-09-01 18:09:13'),(10,1,'Pesan Baru dari Andi Pratama','Andi Pratama (Kelas XII-1): \"Assalamualaikum\"','/guru/counseling','chat',1,'2026-09-01 17:53:37','2026-09-01 18:09:13'),(11,1,'Pesan Baru dari Andi Pratama','Andi Pratama (Kelas XII-1): \"Ibu saya mau tanya\"','/guru/counseling','chat',1,'2026-09-01 18:06:40','2026-09-01 18:09:13'),(12,1,'Pesan Baru dari Andi Pratama','Andi Pratama (Kelas XII-1): \"halo\"','/guru/counseling','chat',1,'2026-09-01 18:12:29','2026-09-02 02:54:37'),(13,1,'Pesan Baru dari Andi Pratama','Andi Pratama (Kelas XII-1): \"hao\"','/guru/counseling','chat',1,'2026-09-02 01:33:37','2026-09-02 02:54:37'),(14,2,'Permohonan Konseling Disetujui','Jadwal temu bimbingan Anda telah disetujui untuk 02 Sep 2026 di Ruang Konseling BK 1','/siswa/counseling','counseling',1,'2026-09-02 02:34:33','2026-09-02 03:05:37'),(15,2,'Catatan Bimbingan Diperbarui','Guru BK telah menambahkan catatan bimbingan pada rekam jejak konseling Anda.','/siswa/counseling','note',1,'2026-09-02 02:37:19','2026-09-02 03:05:37'),(16,4,'Jadwal Konseling Ditetapkan','Guru BK telah menjadwalkan konseling untuk Anda pada 02 Sep 2026','/siswa/counseling','counseling',0,'2026-09-02 02:40:58','2026-09-02 02:40:58'),(17,1,'📅 Pengingat Kegiatan BK Hari Ini','Agenda: Bimbingan Klasikal: Perencanaan Karir Masa Depan (08:00) di Kelas XII-1 & XII-2','/guru/calendar','calendar_reminder',1,'2026-09-02 02:52:41','2026-09-02 02:54:37'),(18,1,'📅 Pengingat Kegiatan BK Hari Ini','Agenda: Konseling Budi (08:00) di Ruang Konseling BK 1','/guru/calendar','calendar_reminder',1,'2026-09-02 02:52:41','2026-09-02 02:54:37'),(19,2,'Jadwal Konseling Ditetapkan','Guru BK telah menjadwalkan konseling untuk Anda pada 03 Sep 2026','/siswa/counseling','counseling',1,'2026-09-02 02:54:23','2026-09-02 03:05:37'),(20,1,'📅 Pengingat Kegiatan BK Hari Ini','Agenda: Sesi Konseling Individu (Andi Pratama) (10:00) di Ruang Konseling BK 1','/guru/calendar','calendar_reminder',1,'2026-09-02 23:54:27','2026-09-03 01:41:46'),(21,2,'🔔 Pengingat Jadwal Konseling Hari Ini','Anda memiliki temu bimbingan bersama Guru BK hari ini pukul 10:00 - 11:00 WIB di Ruang Konseling BK 1','/siswa/counseling','counseling_reminder',1,'2026-09-03 01:56:56','2026-09-03 03:19:47'),(22,1,'Pesan Baru dari Andi Pratama','Andi Pratama (Kelas XII-1): \"Halo bu\"','/guru/counseling','chat',1,'2026-09-03 01:57:24','2026-09-03 03:27:53'),(23,1,'Pengajuan Konseling Baru','Andi Pratama (Kelas XII-1) mengajukan bimbingan bidang Karir pada 03 Sep 2026','/guru/counseling','counseling',1,'2026-09-03 02:01:25','2026-09-03 02:01:46'),(24,2,'Permohonan Konseling Disetujui','Jadwal temu bimbingan Anda telah disetujui untuk 03 Sep 2026 di Ruang Konseling BK 1','/siswa/counseling','counseling',1,'2026-09-03 02:02:01','2026-09-03 03:19:47'),(25,1,'📅 Pengingat Kegiatan BK Hari Ini','Agenda: Konseling: Andi Pratama (Karir) (Istirahat Pertama (09:45 - 10:15 WIB)) di Ruang Konseling BK 1','/guru/calendar','calendar_reminder',1,'2026-09-03 02:02:01','2026-09-03 03:27:53'),(26,2,'Catatan Bimbingan Diperbarui','Guru BK telah menambahkan catatan bimbingan pada rekam jejak konseling Anda.','/siswa/counseling','note',1,'2026-09-03 02:06:12','2026-09-03 03:19:47'),(27,2,'Sesi Konseling Selesai','Catatan hasil bimbingan telah dicatat oleh Guru BK.','/siswa/counseling','counseling',1,'2026-09-03 02:27:22','2026-09-03 03:19:47'),(28,2,'Pesan dari Guru BK','Bapak/Ibu Guru BK mengirimkan pesan: \"halo\"','/siswa/counseling','chat',1,'2026-09-03 03:49:33','2026-09-30 21:48:22'),(29,1,'📅 Pengingat Kegiatan BK Hari Ini','Agenda: Kunjungan Rumah (Home Visit) Siswa (14:00) di Domisili Siswa Terkait','/guru/calendar','calendar_reminder',1,'2026-09-05 02:58:48','2026-09-30 21:39:06'),(30,4,'Sesi Konseling Selesai','Catatan hasil bimbingan telah dicatat oleh Guru BK.','/siswa/counseling','counseling',0,'2026-09-09 00:02:20','2026-09-09 00:02:20'),(31,2,'Catatan Bimbingan Diperbarui','Guru BK telah menambahkan catatan bimbingan pada rekam jejak konseling Anda.','/siswa/counseling','note',1,'2026-09-09 00:13:05','2026-09-30 21:48:22'),(32,2,'Sesi Konseling Selesai','Catatan hasil bimbingan telah dicatat oleh Guru BK.','/siswa/counseling','counseling',1,'2026-09-09 00:14:03','2026-09-30 21:48:22'),(33,3,'Permohonan Konseling Disetujui','Jadwal temu bimbingan Anda telah disetujui untuk 04 Sep 2026 di Ruang Konseling BK 1','/siswa/counseling','counseling',0,'2026-09-09 00:15:08','2026-09-09 00:15:08'),(34,2,'Permohonan Konseling Disetujui','Jadwal temu bimbingan Anda telah disetujui untuk 02 Sep 2026 di Ruang Konseling BK 1','/siswa/counseling','counseling',1,'2026-09-09 00:22:59','2026-09-30 21:48:22');
/*!40000 ALTER TABLE `app_notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar_events`
--

DROP TABLE IF EXISTS `calendar_events`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_events` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` varchar(255) DEFAULT NULL,
  `end_time` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Konseling',
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `calendar_events_user_id_foreign` (`user_id`),
  CONSTRAINT `calendar_events_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_events`
--

LOCK TABLES `calendar_events` WRITE;
/*!40000 ALTER TABLE `calendar_events` DISABLE KEYS */;
INSERT INTO `calendar_events` VALUES (1,1,'Bimbingan Klasikal: Perencanaan Karir Masa Depan','2026-09-02','08:00','09:30','Kelas XII-1 & XII-2','Konseling','Materi pengenalan dunia perkuliahan dan peluang karir di era digital.','2026-09-01 17:35:27','2026-09-02 02:26:40'),(2,1,'Sesi Konseling Individu (Andi Pratama)','2026-09-03','10:00','11:00','Ruang Konseling BK 1','Konseling','Konsultasi lanjutan pemilihan jurusan dan universitas target.','2026-09-01 17:35:27','2026-09-01 17:35:27'),(3,1,'Kunjungan Rumah (Home Visit) Siswa','2026-09-05','14:00','16:00','Domisili Siswa Terkait','Home Visit','Koordinasi perkembangan belajar dengan orang tua murid.','2026-09-01 17:35:27','2026-09-01 17:35:27'),(4,1,'Konseling Budi','2026-09-02','08:00','09:30','Ruang Konseling BK 1','Konseling','Konseling pribadi mengenai karir','2026-09-02 02:26:15','2026-09-02 02:26:15'),(5,1,'Konseling: Andi Pratama (Karir)','2026-09-03','Istirahat Pertama (09:45 - 10:15 WIB)',NULL,'Ruang Konseling BK 1','Konseling Individu','Topik: Bimbingan mengenai jurusan dan universitas\nSiswa: Andi Pratama (Kelas XII-1)','2026-09-03 02:02:01','2026-09-03 02:02:01'),(6,1,'Konseling: Rina Putri (Belajar)','2026-09-04','13:00 - 14:00 WIB',NULL,'Ruang Konseling BK 1','Konseling Individu','Topik: Mengalami kesulitan fokus belajar menjelang ujian akhir semester dan rasa cemas berlebih.\nSiswa: Rina Putri (Kelas XII-2)','2026-09-09 00:15:08','2026-09-09 00:15:08'),(7,1,'Konseling: Andi Pratama (Pribadi)','2026-09-02','Istirahat Pertama (09:45 - 10:15 WIB)',NULL,'Ruang Konseling BK 1','Konseling Individu','Topik: aenwd\nSiswa: Andi Pratama (Kelas XII-1)','2026-09-09 00:22:59','2026-09-09 00:22:59');
/*!40000 ALTER TABLE `calendar_events` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `chat_messages`
--

DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` bigint(20) unsigned NOT NULL,
  `receiver_id` bigint(20) unsigned NOT NULL,
  `student_id` bigint(20) unsigned NOT NULL,
  `message` text NOT NULL,
  `type` enum('text','appointment_request','appointment_card') NOT NULL DEFAULT 'text',
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_messages_sender_id_foreign` (`sender_id`),
  KEY `chat_messages_receiver_id_foreign` (`receiver_id`),
  KEY `chat_messages_student_id_foreign` (`student_id`),
  CONSTRAINT `chat_messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `chat_messages_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chat_messages`
--

LOCK TABLES `chat_messages` WRITE;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES (1,2,1,1,'Selamat pagi Ibu Guru BK, saya Andi dari kelas XII-1. Apakah ada waktu luang untuk konsultasi jurusan kuliah?','text',NULL,1,'2026-09-01 13:35:27','2026-09-01 17:35:27'),(2,1,2,1,'Halo Andi! Tentu saja ada. Kamu bisa ajukan jadwal temu bimbingan di tombol pengajuan konseling atau langsung bicarakan di sini.','text',NULL,1,'2026-09-01 14:35:27','2026-09-01 17:35:27'),(3,2,1,1,'Saya mengajukan permohonan konseling mengenai pemetaan nilai rapor untuk SNBP Teknik Informatika.','appointment_card','{\"category\":\"Karir\",\"preferred_date\":\"2026-09-03\",\"preferred_time\":\"10:00 - 11:00 WIB\",\"topic\":\"Konsultasi pemetaan nilai rapor semester 1-5 untuk SNBP Teknik Informatika\"}',1,'2026-09-01 15:35:27','2026-09-01 17:35:27'),(4,3,1,2,'Ibu guru, terima kasih atas saran bimbingan belajar kemarin. Nilai tryout matematika saya sudah meningkat.','text',NULL,1,'2026-09-01 16:50:27','2026-09-01 17:41:13'),(5,1,3,2,'oke','text',NULL,0,'2026-09-01 17:41:40','2026-09-01 17:41:40'),(6,1,3,2,'logo','text',NULL,0,'2026-09-01 17:41:50','2026-09-01 17:41:50'),(7,2,1,1,'Permohonan Janji Konseling Baru: Bidang Pribadi pada tanggal 02 Sep 2026 (Istirahat Pertama (09:45 - 10:15 WIB))','appointment_card','{\"category\":\"Pribadi\",\"preferred_date\":\"2026-09-02\",\"preferred_time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"topic\":\"aenwd\",\"status\":\"menunggu\"}',1,'2026-09-01 17:48:25','2026-09-01 18:13:41'),(8,2,1,1,'Permohonan Janji Konseling Baru: Bidang Pribadi pada tanggal 02 Sep 2026 (Istirahat Pertama (09:45 - 10:15 WIB))','appointment_card','{\"category\":\"Pribadi\",\"preferred_date\":\"2026-09-02\",\"preferred_time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"topic\":\"aenwd\",\"status\":\"menunggu\"}',1,'2026-09-01 17:48:27','2026-09-01 18:13:41'),(9,2,1,1,'Permohonan Janji Konseling Baru: Bidang Pribadi pada tanggal 02 Sep 2026 (Istirahat Pertama (09:45 - 10:15 WIB))','appointment_card','{\"category\":\"Pribadi\",\"preferred_date\":\"2026-09-02\",\"preferred_time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"topic\":\"aenwd\",\"status\":\"menunggu\"}',1,'2026-09-01 17:48:28','2026-09-01 18:13:41'),(10,2,1,1,'Assalamualaikum','text',NULL,1,'2026-09-01 17:53:37','2026-09-01 18:13:41'),(11,2,1,1,'Ibu saya mau tanya','text',NULL,1,'2026-09-01 18:06:40','2026-09-01 18:13:41'),(12,2,1,1,'halo','text',NULL,1,'2026-09-01 18:12:29','2026-09-01 18:13:41'),(13,2,1,1,'hao','text',NULL,1,'2026-09-02 01:33:37','2026-09-02 01:36:13'),(14,1,2,1,'Permohonan konseling Anda tentang \"aenwd\" telah DISETUJUI oleh Guru BK.','appointment_card','{\"session_id\":6,\"status\":\"disetujui\",\"topic\":\"aenwd\",\"category\":\"Pribadi\",\"date\":\"02 Sep 2026\",\"time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"room\":\"Ruang Konseling BK 1\"}',1,'2026-09-02 02:34:33','2026-09-02 03:04:35'),(15,1,4,3,'Sesi konseling telah dijadwalkan oleh Guru BK pada 02 Sep 2026 (09:00 - 10:00 WIB) di Ruang Konseling BK 1','appointment_card','{\"category\":\"Pribadi\",\"preferred_date\":\"2026-09-02\",\"preferred_time\":\"09:00 - 10:00 WIB\",\"room_or_media\":\"Ruang Konseling BK 1\",\"topic\":\"nb\"}',0,'2026-09-02 02:40:58','2026-09-02 02:40:58'),(16,1,2,1,'Sesi konseling telah dijadwalkan oleh Guru BK pada 03 Sep 2026 (09:00 - 10:00 WIB) di Ruang Konseling BK 1','appointment_card','{\"category\":\"Pribadi\",\"preferred_date\":\"2026-09-03\",\"preferred_time\":\"09:00 - 10:00 WIB\",\"room_or_media\":\"Ruang Konseling BK 1\",\"topic\":\"Mengenai karir\"}',1,'2026-09-02 02:54:23','2026-09-02 03:04:35'),(17,2,1,1,'Halo bu','text',NULL,1,'2026-09-03 01:57:23','2026-09-03 02:01:47'),(18,2,1,1,'Permohonan Janji Konseling Baru: Bidang Karir pada tanggal 03 Sep 2026 (Istirahat Pertama (09:45 - 10:15 WIB))','appointment_card','{\"category\":\"Karir\",\"preferred_date\":\"2026-09-03\",\"preferred_time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"topic\":\"Bimbingan mengenai jurusan dan universitas\",\"status\":\"menunggu\"}',1,'2026-09-03 02:01:25','2026-09-03 02:01:47'),(19,1,2,1,'Permohonan konseling Anda tentang \"Bimbingan mengenai jurusan dan universitas\" telah DISETUJUI oleh Guru BK.','appointment_card','{\"session_id\":9,\"status\":\"disetujui\",\"topic\":\"Bimbingan mengenai jurusan dan universitas\",\"category\":\"Karir\",\"date\":\"03 Sep 2026\",\"time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"room\":\"Ruang Konseling BK 1\"}',1,'2026-09-03 02:02:01','2026-09-03 03:48:46'),(20,1,2,1,'halo','text',NULL,0,'2026-09-03 03:49:33','2026-09-03 03:49:33'),(21,1,3,2,'Permohonan konseling Anda tentang \"Mengalami kesulitan fokus belajar menjelang ujian akhir semester dan rasa cemas berlebih.\" telah DISETUJUI oleh Guru BK.','appointment_card','{\"session_id\":2,\"status\":\"disetujui\",\"topic\":\"Mengalami kesulitan fokus belajar menjelang ujian akhir semester dan rasa cemas berlebih.\",\"category\":\"Belajar\",\"date\":\"04 Sep 2026\",\"time\":\"13:00 - 14:00 WIB\",\"room\":\"Ruang Konseling BK 1\"}',0,'2026-09-09 00:15:08','2026-09-09 00:15:08'),(22,1,2,1,'Permohonan konseling Anda tentang \"aenwd\" telah DISETUJUI oleh Guru BK.','appointment_card','{\"session_id\":4,\"status\":\"disetujui\",\"topic\":\"aenwd\",\"category\":\"Pribadi\",\"date\":\"02 Sep 2026\",\"time\":\"Istirahat Pertama (09:45 - 10:15 WIB)\",\"room\":\"Ruang Konseling BK 1\"}',0,'2026-09-09 00:22:59','2026-09-09 00:22:59');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counseling_notes`
--

DROP TABLE IF EXISTS `counseling_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counseling_notes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `guru_id` bigint(20) unsigned DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `kategori` varchar(255) NOT NULL DEFAULT 'Pribadi',
  `keluhan_masalah` text NOT NULL,
  `layanan_diberikan` text NOT NULL,
  `tindak_lanjut_evaluasi` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'Dalam Pemantauan',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `counseling_notes_student_id_foreign` (`student_id`),
  KEY `counseling_notes_guru_id_foreign` (`guru_id`),
  CONSTRAINT `counseling_notes_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `counseling_notes_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counseling_notes`
--

LOCK TABLES `counseling_notes` WRITE;
/*!40000 ALTER TABLE `counseling_notes` DISABLE KEYS */;
INSERT INTO `counseling_notes` VALUES (1,1,1,'2026-08-28','Karir','Siswa merasa bimbang memilih antara Program Studi Teknik Informatika (ITB) atau Ilmu Komputer (UI). Orang tua mengarahkan ke Kedokteran.','Konseling individual mengenai pemetaan bakat minat, analisis data nilai rapor semester 1-4, dan simulasi passing grade SNBP.','Menjadwalkan sesi konsultasi bersama orang tua siswa untuk menyelaraskan pilihan minat bakat dengan harapan keluarga.','Dalam Pemantauan','2026-09-01 17:35:27','2026-09-01 17:35:27'),(2,1,1,'2026-08-19','Belajar','Konsentrasi belajar menurun saat menghadapi ujian tengah semester karena manajemen waktu kegiatan ekstrakurikuler.','Bimbingan teknik manajemen waktu (Pomodoro & Time-blocking), pembuatan matriks prioritas harian.','Siswa telah menyusun jadwal belajar mandiri dan nilai UTS terpantau stabil.','Selesai / Teratasi','2026-09-01 17:35:27','2026-09-01 17:35:27'),(3,2,1,'2026-08-26','Pribadi','Kecemasan akademik menjelang asesmen sumatif sekolah.','Teknik relaksasi pernapasan 4-7-8, reframing pola pikir positif, dan afirmasi diri.','Siswa merasa lebih tenang dan percaya diri dalam menghadapi ujian.','Selesai / Teratasi','2026-09-01 17:35:27','2026-09-01 17:35:27'),(4,1,1,'2026-09-02','Pribadi','Tidak','harus',NULL,'Dalam Pemantauan','2026-09-02 02:37:19','2026-09-02 02:37:19'),(5,1,1,'2026-09-03','Pribadi','Mengalami kemunduran dalam pembelajaran','gatau',NULL,'Dalam Pemantauan','2026-09-03 02:06:12','2026-09-03 02:06:12'),(6,1,1,'2026-09-03','Pribadi','Mengenai karir','jnnubs','Pemantauan berkala dan bimbingan tindak lanjut.','Selesai / Teratasi','2026-09-03 02:27:22','2026-09-03 02:27:22'),(8,1,1,'2026-09-09','Pribadi','Beserta','Disertai',NULL,'Dalam Pemantauan','2026-09-09 00:13:05','2026-09-09 00:13:05'),(9,1,1,'2026-09-09','Karir','Konsultasi pemilihan jurusan Teknik Informatika vs Sistem Informasi di perguruan tinggi negeri.','Lebih memilih studi sastra','Pemantauan berkala dan bimbingan tindak lanjut.','Selesai / Teratasi','2026-09-09 00:14:03','2026-09-09 00:14:03');
/*!40000 ALTER TABLE `counseling_notes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `counseling_sessions`
--

DROP TABLE IF EXISTS `counseling_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `counseling_sessions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `guru_id` bigint(20) unsigned DEFAULT NULL,
  `initiated_by` varchar(20) NOT NULL DEFAULT 'siswa',
  `category` varchar(255) NOT NULL DEFAULT 'Pribadi',
  `topic` text NOT NULL,
  `preferred_date` date DEFAULT NULL,
  `preferred_time` varchar(255) DEFAULT NULL,
  `room_or_media` varchar(255) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'menunggu',
  `counselor_notes` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `rescheduled_reason` text DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `counseling_sessions_student_id_foreign` (`student_id`),
  KEY `counseling_sessions_guru_id_foreign` (`guru_id`),
  CONSTRAINT `counseling_sessions_guru_id_foreign` FOREIGN KEY (`guru_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `counseling_sessions_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `counseling_sessions`
--

LOCK TABLES `counseling_sessions` WRITE;
/*!40000 ALTER TABLE `counseling_sessions` DISABLE KEYS */;
INSERT INTO `counseling_sessions` VALUES (1,1,1,'siswa','Karir','Konsultasi pemilihan jurusan Teknik Informatika vs Sistem Informasi di perguruan tinggi negeri.','2026-09-03','10:00 - 11:00 WIB','Ruang Konseling BK 1','selesai','Lebih memilih studi sastra',NULL,NULL,'2026-09-09 00:14:03','2026-09-01 17:35:27','2026-09-09 00:14:03'),(2,2,1,'siswa','Belajar','Mengalami kesulitan fokus belajar menjelang ujian akhir semester dan rasa cemas berlebih.','2026-09-04','13:00 - 14:00 WIB','Ruang Konseling BK 1','disetujui',NULL,NULL,NULL,NULL,'2026-09-01 17:35:27','2026-09-09 00:15:08'),(3,3,1,'siswa','Pribadi','Bimbingan penyesuaian diri dan manajemen waktu antara organisasi robotik dan sekolah.','2026-08-30','09:00 - 10:00 WIB','Ruang Konseling BK 1','selesai','Siswa telah menyusun matriks prioritas waktu (Eisenhower Matrix) dan sepakat mengurangi beban rapat di luar jam sekolah.',NULL,NULL,'2026-08-29 17:35:27','2026-09-01 17:35:27','2026-09-01 17:35:27'),(4,1,1,'siswa','Pribadi','aenwd','2026-09-02','Istirahat Pertama (09:45 - 10:15 WIB)','Ruang Konseling BK 1','disetujui',NULL,NULL,NULL,NULL,'2026-09-01 17:48:25','2026-09-09 00:22:59'),(6,1,1,'siswa','Pribadi','aenwd','2026-09-02','Istirahat Pertama (09:45 - 10:15 WIB)','Ruang Konseling BK 1','selesai','ginilha',NULL,NULL,'2026-09-02 02:35:13','2026-09-01 17:48:28','2026-09-02 02:35:13'),(8,1,1,'siswa','Pribadi','Mengenai karir','2026-09-03','09:00 - 10:00 WIB','Ruang Konseling BK 1','selesai','jnnubs',NULL,NULL,'2026-09-03 02:27:22','2026-09-02 02:54:22','2026-09-03 02:27:22'),(9,1,1,'siswa','Karir','Bimbingan mengenai jurusan dan universitas','2026-09-03','Istirahat Pertama (09:45 - 10:15 WIB)','Ruang Konseling BK 1','selesai','Nununana',NULL,NULL,'2026-09-03 02:03:12','2026-09-03 02:01:25','2026-09-03 02:03:12');
/*!40000 ALTER TABLE `counseling_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_08_12_011913_create_students_table',1),(5,'2026_08_13_040001_create_questionnaires_table',1),(6,'2026_08_13_040002_create_questions_table',1),(7,'2026_08_13_040003_create_question_options_table',1),(8,'2026_08_13_040004_create_student_answers_table',1),(9,'2026_08_26_015942_add_published_to_questionnaires_table',1),(10,'2026_09_02_000001_create_counseling_sessions_table',1),(11,'2026_09_02_000002_create_announcements_table',1),(12,'2026_09_02_000003_create_calendar_events_table',1),(13,'2026_09_02_000004_create_chat_messages_table',2),(14,'2026_09_02_000005_create_counseling_notes_table',2),(15,'2026_09_02_000006_create_app_notifications_table',2),(16,'2026_09_02_000007_create_report_settings_table',2),(17,'2026_09_02_000001_add_status_to_questionnaires_table',3),(18,'2026_09_02_000002_make_email_nullable_in_students_table',4),(19,'2026_09_03_000001_make_status_string_in_counseling_notes_table',5),(20,'2026_10_01_000001_align_simbk_specifications',6),(21,'2026_10_01_000002_drop_announcements_table',7);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question_options`
--

DROP TABLE IF EXISTS `question_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` bigint(20) unsigned NOT NULL,
  `teks_opsi` varchar(255) NOT NULL,
  `bobot_nilai` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `question_options_question_id_foreign` (`question_id`),
  CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question_options`
--

LOCK TABLES `question_options` WRITE;
/*!40000 ALTER TABLE `question_options` DISABLE KEYS */;
INSERT INTO `question_options` VALUES (20,7,'Sangat Sering / Sangat Sesuai',4,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(21,7,'Sering / Sesuai',3,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(22,7,'Kadang-kadang',2,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(23,7,'Tidak Pernah / Sangat Tidak Sesuai',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(24,8,'Sangat Sering / Sangat Sesuai',4,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(25,8,'Sering / Sesuai',3,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(26,8,'Kadang-kadang',2,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(27,8,'Tidak Pernah / Sangat Tidak Sesuai',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(28,9,'Sains & Teknologi / Komputer',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(29,9,'Seni, Musik & Desain',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(30,9,'Olahraga & Kesehatan',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(31,9,'Kepemimpinan & Organisasi (OSIS/Pramuka)',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(32,9,'Bahasa & Jurnalistik',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(33,11,'Catatan visual, diagram, dan gambar warna-warni',3,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(34,11,'Mendengarkan penjelasan secara langsung dan diskusi',2,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(35,11,'Mempraktikkan langsung / bergerak sambil belajar',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(36,12,'Mendengarkan musik atau berbicara dengan teman',2,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(37,12,'Berolahraga, jalan santai, atau beraktivitas fisik',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(38,12,'Membaca buku, menonton film, atau menggambar',3,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(39,13,'Sangat Sesuai',4,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(40,13,'Sesuai',3,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(41,13,'Tidak Sesuai',2,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(42,13,'Sangat Tidak Sesuai',1,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(43,14,'Matematika',4,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(44,14,'Fisika',3,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(45,14,'Teknik Informatika',2,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(46,14,'Sosiologi',1,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(63,20,'Sangat Sesuai',4,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(64,20,'Sesuai',3,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(65,20,'Tidak Sesuai',2,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(66,20,'Sangat Tidak Sesuai',1,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(67,21,'Matematika',4,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(68,21,'Fisika',3,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(69,21,'Teknik Informatika',2,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(70,21,'Sosiologi',1,'2026-09-02 02:20:00','2026-09-02 02:20:00');
/*!40000 ALTER TABLE `question_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questionnaires`
--

DROP TABLE IF EXISTS `questionnaires`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questionnaires` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `jenis_instrumen` varchar(50) NOT NULL DEFAULT 'IKMS',
  `deskripsi` text DEFAULT NULL,
  `target_kelas` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'draft',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `published` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questionnaires`
--

LOCK TABLES `questionnaires` WRITE;
/*!40000 ALTER TABLE `questionnaires` DISABLE KEYS */;
INSERT INTO `questionnaires` VALUES (1,'Angket Kebutuhan Peserta Didik (AKPD)','IKMS','Kuisioner ini bertujuan untuk mengidentifikasi kebutuhan bimbingan dan konseling siswa dalam aspek pribadi, sosial, belajar, dan karir.','Semua Kelas','published',1,'2026-09-01 17:20:46','2026-09-01 17:35:27',0),(2,'Asesmen Minat & Gaya Belajar Siswa','IKMS','Membantu siswa mengenali modalitas belajar dominan (Visual, Auditori, atau Kinestetik) agar belajar lebih efektif.','Semua Kelas','published',1,'2026-09-01 17:20:46','2026-09-01 17:35:27',0),(3,'Kesesuaian Tingkat belajar Siswa Kelas X','IKMS','dan seterusnya','Semua Kelas','published',1,'2026-09-01 18:16:37','2026-09-01 18:16:37',0),(4,'Kesesuaian Tingkat belajar Siswa Kelas X','IKMS','Dan begitulah','Semua Kelas','published',1,'2026-09-02 01:40:23','2026-09-02 01:40:23',0),(5,'Kesesuaian Tingkat belajar Siswa Kelas X','IKMS','Dan begitulah','Semua Kelas','draft',0,'2026-09-02 01:40:27','2026-09-02 02:20:00',0);
/*!40000 ALTER TABLE `questionnaires` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `questions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` bigint(20) unsigned NOT NULL,
  `teks_pertanyaan` text NOT NULL,
  `tipe_jawaban` varchar(255) NOT NULL,
  `aspek` varchar(255) DEFAULT NULL,
  `is_wajib` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `questions_questionnaire_id_foreign` (`questionnaire_id`),
  CONSTRAINT `questions_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `questions`
--

LOCK TABLES `questions` WRITE;
/*!40000 ALTER TABLE `questions` DISABLE KEYS */;
INSERT INTO `questions` VALUES (7,1,'Saya merasa bingung dalam menentukan arah karir atau jurusan kuliah setelah lulus SMA.','single_choice','Karier',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(8,1,'Saya merasa kesulitan mengatur waktu belajar mandiri di rumah dan aktivitas lainnya.','single_choice','Belajar',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(9,1,'Kegiatan ekstrakurikuler atau bidang pengembangan diri apa saja yang paling Anda minati?','multichoice','Pribadi',0,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(10,1,'Ceritakan secara singkat harapan Anda terhadap layanan bimbingan konseling di sekolah.','text','Pribadi',0,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(11,2,'Ketika mengingat informasi penting dari penjelasan guru, saya lebih mudah mengingat melalui:','single_choice','Belajar',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(12,2,'Ketika merasa stres atau lelah belajar, cara yang paling membantu saya rileks adalah:','single_choice','Pribadi',1,'2026-09-01 17:35:27','2026-09-01 17:35:27'),(13,4,'Saya sudah...','single_choice','Belajar',1,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(14,4,'Mata kuliah yang kamu kuasai','multichoice','Belajar',1,'2026-09-02 01:40:24','2026-09-02 01:40:24'),(20,5,'Saya sudah...','single_choice','Belajar',1,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(21,5,'Mata kuliah yang kamu kuasai','multichoice','Belajar',1,'2026-09-02 02:20:00','2026-09-02 02:20:00'),(22,5,'Apakah kamu mendapatkan','text','Pribadi',1,'2026-09-02 02:20:00','2026-09-02 02:20:00');
/*!40000 ALTER TABLE `questions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_settings`
--

DROP TABLE IF EXISTS `report_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `school_name` varchar(255) NOT NULL DEFAULT 'SMA NEGERI 1 KOTA BANDUNG',
  `school_address` varchar(255) NOT NULL DEFAULT 'Jl. Ir. H. Juanda No. 93, Coblong, Kota Bandung, Jawa Barat 40132',
  `school_phone` varchar(255) NOT NULL DEFAULT '(022) 2503582',
  `school_email` varchar(255) NOT NULL DEFAULT 'smansabandung@gmail.com',
  `school_website` varchar(255) NOT NULL DEFAULT 'www.sman1bandung.sch.id',
  `headmaster_name` varchar(255) NOT NULL DEFAULT 'Dr. H. Ahmad Supardi, M.Pd.',
  `headmaster_nip` varchar(255) NOT NULL DEFAULT '19720315 199802 1 003',
  `counselor_name` varchar(255) NOT NULL DEFAULT 'Dra. Hj. Siti Rohmah, M.Psi.',
  `counselor_nip` varchar(255) NOT NULL DEFAULT '19800512 200501 2 006',
  `city_date` varchar(255) NOT NULL DEFAULT 'Bandung',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_settings`
--

LOCK TABLES `report_settings` WRITE;
/*!40000 ALTER TABLE `report_settings` DISABLE KEYS */;
INSERT INTO `report_settings` VALUES (1,'SMA NEGERI 1 LEUWILIANG','Jalan Raya Leuwiliang No. 47, Kampung Sawah Kulon RT.04/02, Desa Leuwiliang, Kecamatan Leuwiliang, Kabupaten Bogor, Jawa Barat 16640','contoh','contoh','','contoh','contoh','contoh','contoh','contoh','2026-09-02 02:13:56','2026-09-02 02:17:04');
/*!40000 ALTER TABLE `report_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_answers`
--

DROP TABLE IF EXISTS `student_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_answers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` bigint(20) unsigned NOT NULL,
  `questionnaire_id` bigint(20) unsigned NOT NULL,
  `question_id` bigint(20) unsigned NOT NULL,
  `question_option_id` bigint(20) unsigned DEFAULT NULL,
  `jawaban_teks` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `student_answers_student_id_foreign` (`student_id`),
  KEY `student_answers_questionnaire_id_foreign` (`questionnaire_id`),
  KEY `student_answers_question_id_foreign` (`question_id`),
  KEY `student_answers_question_option_id_foreign` (`question_option_id`),
  CONSTRAINT `student_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_answers_question_option_id_foreign` FOREIGN KEY (`question_option_id`) REFERENCES `question_options` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_answers_questionnaire_id_foreign` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaires` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_answers_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_answers`
--

LOCK TABLES `student_answers` WRITE;
/*!40000 ALTER TABLE `student_answers` DISABLE KEYS */;
INSERT INTO `student_answers` VALUES (5,1,1,7,NULL,'Sering / Sesuai','2026-09-01 17:35:27','2026-09-01 17:35:27'),(6,1,1,8,NULL,'Kadang-kadang','2026-09-01 17:35:27','2026-09-01 17:35:27'),(7,1,1,9,NULL,'Sains & Teknologi / Komputer, Seni, Musik & Desain','2026-09-01 17:35:27','2026-09-01 17:35:27'),(8,1,1,10,NULL,'Saya berharap ada sesi konsultasi one-on-one berkala untuk persiapan masuk perguruan tinggi dan pemilihan jurusan.','2026-09-01 17:35:27','2026-09-01 17:35:27'),(9,2,1,7,NULL,'Sangat Sering / Sangat Sesuai','2026-09-01 18:09:42','2026-09-01 18:09:42'),(10,2,1,8,NULL,'Sering','2026-09-01 18:09:42','2026-09-01 18:09:42'),(11,2,1,9,NULL,'Kesehatan & Kedokteran, Psikologi / Hubungan Sosial','2026-09-01 18:09:42','2026-09-01 18:09:42'),(12,2,1,10,NULL,'Saya ingin bimbingan mengenai beasiswa kedokteran.','2026-09-01 18:09:42','2026-09-01 18:09:42'),(13,1,2,11,33,'Catatan visual, diagram, dan gambar warna-warni','2026-09-01 18:09:42','2026-09-01 18:09:42'),(14,1,2,12,38,'Membaca buku, menonton film, atau menggambar','2026-09-01 18:09:42','2026-09-01 18:09:42'),(15,2,2,11,34,'Mendengarkan penjelasan secara langsung dan diskusi','2026-09-01 18:09:42','2026-09-01 18:09:42'),(16,2,2,12,36,'Mendengarkan musik atau berbicara dengan teman','2026-09-01 18:09:42','2026-09-01 18:09:42'),(17,1,4,13,39,'Sangat Sesuai','2026-09-02 01:41:51','2026-09-02 01:41:51'),(18,1,4,14,43,'Matematika, Fisika','2026-09-02 01:41:52','2026-09-02 01:41:52');
/*!40000 ALTER TABLE `student_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `students` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `nis` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `nama` varchar(255) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `alamat` text DEFAULT NULL,
  `nomor_telepon` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `tempat_lahir` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `agama` varchar(255) DEFAULT NULL,
  `nama_ayah` varchar(255) DEFAULT NULL,
  `nama_ibu` varchar(255) DEFAULT NULL,
  `nomor_telepon_orang_tua` varchar(255) DEFAULT NULL,
  `hobi` varchar(255) DEFAULT NULL,
  `cita_cita` varchar(255) DEFAULT NULL,
  `status` enum('aktif','lulus','pindah') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `students_nis_unique` (`nis`),
  KEY `students_user_id_foreign` (`user_id`),
  CONSTRAINT `students_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `students`
--

LOCK TABLES `students` WRITE;
/*!40000 ALTER TABLE `students` DISABLE KEYS */;
INSERT INTO `students` VALUES (1,2,'10293','andipratama@gmail.com','Andi Pratama','XII-1','Jl. Merdeka No. 45, Bandung','081234567891','student-photos/qmzRLg2CVDEe5Gt3aEaduyoxYtGseBMXrcE3VXLk.jpg','Bandung','2006-05-14','Laki-laki','Islam','Bambang Pratama','Siti Aminah','081298765432','Sepak Bola','Atlit','aktif','2026-09-01 17:20:45','2026-09-03 03:58:08'),(2,3,'10294','rinaputri@gmail.com','Rina Putri','XII-2','Jl. Kenanga No. 12, Bandung','081345678902',NULL,'Jakarta','2006-08-20','Perempuan','Islam','Hendro Susilo','Dewi Lestari','081398765401','Menulis & Desain Grafis','Psikolog','aktif','2026-09-01 17:20:45','2026-09-01 17:20:45'),(3,4,'10295','budisantoso@gmail.com','Budi Santoso','XI-3','Jl. Pahlawan No. 88, Bandung','081567890123',NULL,'Surabaya','2007-03-10','Laki-laki','Islam','Joko Santoso','Sri Wahyuni','081587654321','Bermain Musik & Robotik','Teknik Elektro','aktif','2026-09-01 17:20:45','2026-09-01 17:20:45'),(4,6,'12345678','cahyarahmatunnisa@gmail.com','Cahya Rahmatunnisa','XII-1','Jalan-jalan','088213151080','student-photos/QfqjTp7GgIAB9WLu4LAMJ0tkB6fK7ELCI4sKPAIH.png','Bogor','2005-05-06','Laki-laki','Islam',NULL,NULL,NULL,'Informatika','Penulis Fiksi','aktif','2026-09-03 04:00:05','2026-09-03 04:22:17');
/*!40000 ALTER TABLE `students` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('siswa','guru') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'guru','guru@gmail.com','$2y$12$q0gKA7.SoF7r.4DrDsSdhOrLoDX6W6Ox8/VvYH.IkczhdXQppaO3a','guru','2026-09-01 17:20:44','2026-09-02 02:24:04'),(2,'10293','andipratama@gmail.com','$2y$12$NK21DVpPj4YimxfhBs8PmuiFgybSH8Cg.6XscA3vnjHzHRI15aBgi','siswa','2026-09-01 17:20:45','2026-09-01 17:35:26'),(3,'10294','rinaputri@gmail.com','$2y$12$J/JW9fIXuTj1c5LTezUW1eI5XlsxB1y2ApXPyRhgEQie/lMXqi2xi','siswa','2026-09-01 17:20:45','2026-09-01 17:35:26'),(4,'10295','budisantoso@gmail.com','$2y$12$reizcz70ChhoCx2qeWB/ieUOAa1HSBpZxMY3M35v9Wnq3rsMf8Ljm','siswa','2026-09-01 17:20:45','2026-09-01 17:35:27'),(5,'14445556','14445556@siswa.simbk.id','$2y$12$Ta7EhEEcABCdhlxBQzpT8.TaFh8Eyx45T2Vye2rI5FNkctunGfR4K','siswa','2026-09-02 02:31:35','2026-09-02 02:31:35'),(6,'12345678','cahyarahmatunnisa@gmail.com','$2y$12$LNUmArLroUf/OMkhELXwBeEHc4JCplkACr2PGgWwoZaS99Uu.VQc2','siswa','2026-09-03 04:00:05','2026-09-03 04:00:05');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-01  5:26:49
