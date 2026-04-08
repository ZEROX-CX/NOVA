-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 08, 2026 at 01:31 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sekolah`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen_pertemuan`
--

CREATE TABLE `absen_pertemuan` (
  `id_absen` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `id_siswa` int NOT NULL,
  `status` enum('hadir','izin','sakit','alpa') NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `waktu_absen` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_sesi` int DEFAULT NULL,
  `judul_absen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `absen_pertemuan`
--

INSERT INTO `absen_pertemuan` (`id_absen`, `id_pertemuan`, `id_siswa`, `status`, `keterangan`, `waktu_absen`, `id_sesi`, `judul_absen`) VALUES
(1, 19, 2, 'hadir', NULL, '2025-11-12 00:00:00', NULL, 'kw'),
(115, 133, 8, 'hadir', '', '2026-01-02 13:42:57', 75, 'per'),
(118, 114, 8, 'hadir', '', '2026-01-09 13:28:38', 56, 'leb'),
(120, 138, 8, 'hadir', '', '2026-01-14 09:55:19', 80, 'ron'),
(121, 140, 8, 'hadir', '', '2026-01-21 18:05:57', 82, NULL),
(122, 136, 8, 'hadir', '', '2026-01-21 18:30:47', 78, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `achievements`
--

CREATE TABLE `achievements` (
  `id_achievement` int NOT NULL,
  `nama_achievement` varchar(100) NOT NULL,
  `deskripsi` text,
  `icon` varchar(255) DEFAULT NULL,
  `kondisi_pencapaian` text COMMENT 'Deskripsi kondisi untuk mendapatkan achievement'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `achievements`
--

INSERT INTO `achievements` (`id_achievement`, `nama_achievement`, `deskripsi`, `icon`, `kondisi_pencapaian`) VALUES
(1, 'siswa_teladan', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `drag_drop_area`
--

CREATE TABLE `drag_drop_area` (
  `id_area` int NOT NULL,
  `id_game` int NOT NULL,
  `nama_area` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drag_drop_area`
--

INSERT INTO `drag_drop_area` (`id_area`, `id_game`, `nama_area`) VALUES
(1, 1, 'Mahkluk Hidup'),
(3, 1, 'Benda Mati'),
(4, 3, 'Mahkluk'),
(5, 3, 'Benda Mati'),
(6, 4, 'Mahkluk Hidup'),
(7, 4, 'Benda Mati');

-- --------------------------------------------------------

--
-- Table structure for table `drag_drop_game`
--

CREATE TABLE `drag_drop_game` (
  `id_game` int NOT NULL,
  `id_guru` int NOT NULL,
  `judul` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drag_drop_game`
--

INSERT INTO `drag_drop_game` (`id_game`, `id_guru`, `judul`, `created_at`) VALUES
(1, 1, 'Drag and Drop', '2025-11-04 10:38:38'),
(2, 5, 'la li lu le lo', '2025-11-21 21:29:30'),
(3, 5, 'game 1', '2025-11-26 14:17:04'),
(4, 5, 'mgs', '2025-12-02 10:31:22');

-- --------------------------------------------------------

--
-- Table structure for table `drag_drop_item`
--

CREATE TABLE `drag_drop_item` (
  `id_item` int NOT NULL,
  `id_game` int NOT NULL,
  `nama_item` varchar(100) NOT NULL,
  `correct_area_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drag_drop_item`
--

INSERT INTO `drag_drop_item` (`id_item`, `id_game`, `nama_item`, `correct_area_id`) VALUES
(1, 1, 'Kucing', 1),
(2, 1, 'Pohon', 1),
(3, 1, 'Batu', NULL),
(4, 1, 'Kardus', NULL),
(5, 1, 'ayam', 1),
(6, 1, 'bebek', 1),
(7, 1, 'Laptop', 3),
(8, 3, 'Kucing', 5),
(9, 3, 'Laptop', 5),
(10, 3, 'Kardus', 5),
(11, 4, 'Pohon', 6),
(12, 4, 'Laptop', 7);

-- --------------------------------------------------------

--
-- Table structure for table `drag_drop_result`
--

CREATE TABLE `drag_drop_result` (
  `id_result` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_game` int NOT NULL,
  `skor` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `drag_drop_result`
--

INSERT INTO `drag_drop_result` (`id_result`, `id_siswa`, `id_game`, `skor`, `tanggal`) VALUES
(2, 8, 1, 100, '2025-11-21 20:19:30'),
(3, 8, 1, 25, '2025-11-21 21:28:21'),
(4, 8, 1, 60, '2025-11-22 08:58:01'),
(5, 8, 1, 80, '2025-11-22 09:02:08'),
(6, 8, 1, 67, '2025-11-22 09:22:53'),
(7, 8, 1, 67, '2025-11-22 09:23:04'),
(8, 8, 3, 100, '2025-11-26 14:19:15'),
(9, 8, 3, 67, '2025-11-26 14:19:23'),
(10, 8, 3, 33, '2025-11-26 20:37:12'),
(11, 8, 3, 33, '2025-11-26 20:37:12');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id_guru` int NOT NULL,
  `nama_guru` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'alpa',
  `jenis_kelamin` varchar(50) DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `angkatan` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status_akun` enum('aktif','nonaktif','suspended') DEFAULT 'aktif',
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id_guru`, `nama_guru`, `password`, `status`, `jenis_kelamin`, `foto_profil`, `nomor_hp`, `angkatan`, `email`, `status_akun`, `tanggal_daftar`, `alamat`) VALUES
(1, 'kasim', '12345678', 'Sakit', NULL, NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 21:58:21', NULL),
(4, 'kasim', 'hash_pass', 'Hadir', NULL, NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 21:58:21', NULL),
(5, 'sola', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', NULL, '1764631599_download (2).webp', NULL, NULL, NULL, 'aktif', '2025-12-01 21:58:21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_refleksi`
--

CREATE TABLE `jawaban_refleksi` (
  `id_jawaban` int NOT NULL,
  `id_refleksi` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `id_siswa` int NOT NULL,
  `jawaban` text NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `jawaban_refleksi`
--

INSERT INTO `jawaban_refleksi` (`id_jawaban`, `id_refleksi`, `id_pertemuan`, `id_siswa`, `jawaban`, `tanggal`) VALUES
(1, 2, 108, 8, 'fASDFD', '2025-12-01 11:43:22'),
(2, 3, 114, 8, 'bv', '2026-01-24 06:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `id_mapel` int NOT NULL,
  `id_guru` int NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `deskripsi` text,
  `id_pertemuan` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`id_mapel`, `id_guru`, `nama_mapel`, `deskripsi`, `id_pertemuan`) VALUES
(1, 1, 'Mapel Lama (ID 3)', 'Dibuat otomatis karena referensi pertemuan', NULL),
(2, 1, 'Mapel Lama (ID 5)', 'Dibuat otomatis karena referensi pertemuan', NULL),
(3, 5, 'Mapel Lama (ID 7)', 'Dibuat otomatis karena referensi pertemuan', NULL),
(4, 5, 'Bahasa Inggris', 'Dibuat otomatis karena referensi pertemuan', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `materi_dilihat`
--

CREATE TABLE `materi_dilihat` (
  `id` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_materi` int NOT NULL,
  `lihat` enum('belum dilihat','lihat') DEFAULT 'belum dilihat',
  `tanggal_dilihat` datetime DEFAULT NULL,
  `total_dilihat` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materi_dilihat`
--

INSERT INTO `materi_dilihat` (`id`, `id_siswa`, `id_materi`, `lihat`, `tanggal_dilihat`, `total_dilihat`) VALUES
(16, 1, 29, 'lihat', '2025-10-29 11:16:46', 0);

-- --------------------------------------------------------

--
-- Table structure for table `materi_pertemuan`
--

CREATE TABLE `materi_pertemuan` (
  `id` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `isi_materi` text,
  `file_materi` varchar(255) DEFAULT NULL,
  `link_youtube` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `materi_pertemuan`
--

INSERT INTO `materi_pertemuan` (`id`, `id_pertemuan`, `isi_materi`, `file_materi`, `link_youtube`) VALUES
(1, 5, 'Materi pembuka Bahasa Indonesia', NULL, NULL),
(4, 18, 'what is this diddy blud doing', NULL, NULL),
(5, 32, 'isi materi', NULL, NULL),
(30, 114, 'materi', '1764642361_Jadwal Asesmen Sumatif PPLG 2025.pdf', ''),
(31, 142, 'ew', '1769076846_LKPD_PHP_Percabangan_dan_Perulangan.docx', 'https://youtu.be/gbKRJDBPgWY?si=XIvzx71e-cZbVH3b');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_posttest`
--

CREATE TABLE `nilai_posttest` (
  `id_nilai` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `nilai` float NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nilai_posttest`
--

INSERT INTO `nilai_posttest` (`id_nilai`, `id_siswa`, `id_pertemuan`, `nilai`, `tanggal`) VALUES
(58, 8, 114, 0, '2026-01-24 06:11:54'),
(59, 8, 114, 0, '2026-01-26 03:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `nilai_pretest`
--

CREATE TABLE `nilai_pretest` (
  `id_nilai` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `nilai` decimal(5,2) NOT NULL,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `nilai_pretest`
--

INSERT INTO `nilai_pretest` (`id_nilai`, `id_siswa`, `id_pertemuan`, `nilai`, `tanggal`) VALUES
(35, 8, 114, '0.00', '2026-01-24 06:11:44');

-- --------------------------------------------------------

--
-- Table structure for table `pembelajaran`
--

CREATE TABLE `pembelajaran` (
  `id_materi` int NOT NULL,
  `materi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `mapel` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `judul` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pembelajaran`
--

INSERT INTO `pembelajaran` (`id_materi`, `materi`, `mapel`, `judul`) VALUES
(29, '', 'Bahasa Indonesia', 'letfgf'),
(67, NULL, 'Agama', 'koc');

-- --------------------------------------------------------

--
-- Table structure for table `pengumpulan_tugas`
--

CREATE TABLE `pengumpulan_tugas` (
  `id_pengumpulan` int NOT NULL,
  `id_tugas` int NOT NULL,
  `id_siswa` int NOT NULL,
  `file_jawaban` varchar(255) DEFAULT NULL,
  `tanggal_kumpul` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_late` tinyint(1) DEFAULT '0',
  `nilai` int DEFAULT NULL,
  `feedback` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengumpulan_tugas`
--

INSERT INTO `pengumpulan_tugas` (`id_pengumpulan`, `id_tugas`, `id_siswa`, `file_jawaban`, `tanggal_kumpul`, `is_late`, `nilai`, `feedback`) VALUES
(4, 6, 8, 'tugas_69182304e5f362.31435434.docx', '2025-11-15 14:51:48', 0, NULL, NULL),
(5, 6, 8, 'tugas_69182313425ed3.76401881.docx', '2025-11-15 14:52:03', 0, NULL, NULL),
(6, 6, 8, 'tugas_69182327076cb2.56542224.docx', '2025-11-15 14:52:23', 0, NULL, NULL),
(7, 6, 8, 'tugas_69182719f1ebf9.49834383.docx', '2025-11-15 15:09:13', 1, NULL, NULL),
(8, 6, 8, 'tugas_691827627c28f1.01798521.docx', '2025-11-15 15:10:26', 1, NULL, NULL),
(9, 6, 8, 'tugas_69182c612fe420.04370839.docx', '2025-11-15 15:31:45', 1, NULL, NULL),
(10, 6, 8, 'tugas_69185909753029.03975641.docx', '2025-11-15 18:42:17', 1, NULL, NULL),
(22, 31, 8, 'tugas_696888ceddd9e7.61434382.docx', '2026-01-15 14:27:26', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pertemuan`
--

CREATE TABLE `pertemuan` (
  `id_pertemuan` int NOT NULL,
  `id_mapel` int NOT NULL,
  `judul_pertemuan` varchar(100) NOT NULL,
  `deskripsi` text,
  `tanggal` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pertemuan`
--

INSERT INTO `pertemuan` (`id_pertemuan`, `id_mapel`, `judul_pertemuan`, `deskripsi`, `tanggal`) VALUES
(5, 1, 'Pertemuan 1 - Pengantar', 'Pengenalan awal topik pelajaran.', '2025-10-31'),
(8, 1, 'this', NULL, '2025-11-03'),
(17, 1, 'tes absen', NULL, '2025-11-26'),
(18, 1, 'tes materi', NULL, '2025-11-04'),
(19, 1, 'sesi', NULL, '2025-06-17'),
(20, 1, 'aktif', NULL, '2025-11-10'),
(21, 1, 'ngawur', NULL, '2025-11-24'),
(22, 1, 'tak da biji kau nak jadi presiden', NULL, '2025-11-08'),
(23, 1, 'tes sesi absen v2.0 dan pretest', NULL, '2025-11-28'),
(27, 1, 'test pre-test multi pertanyaan', NULL, '2025-11-09'),
(30, 2, 'fhdh', NULL, '2025-11-06'),
(31, 2, 'tugas', NULL, '2025-11-12'),
(32, 2, 'test materi', NULL, '2025-11-13'),
(34, 2, 'apalah', NULL, '2025-11-13'),
(38, 3, '-1', NULL, '2025-11-15'),
(114, 4, 'pertemuan 1', NULL, '2025-12-03'),
(115, 3, 'aneh', NULL, '2025-12-31'),
(116, 3, 'huh', NULL, '2025-12-14'),
(121, 3, 'gf', NULL, '2025-12-14'),
(122, 3, 'ai', NULL, '2025-12-14'),
(133, 4, '4', NULL, '2026-01-02'),
(136, 4, 'EFN', NULL, '2026-01-11'),
(138, 4, 'tse tugas', NULL, '2026-01-14'),
(139, 3, 'not', NULL, '2026-01-23'),
(140, 4, 'aneh bet jir', NULL, '2026-01-22'),
(141, 4, 'bat', NULL, '2026-01-22'),
(142, 4, 'bug test', NULL, '2026-01-29');

-- --------------------------------------------------------

--
-- Table structure for table `posttest_pertemuan`
--

CREATE TABLE `posttest_pertemuan` (
  `id_posttest` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `jawaban_benar` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `posttest_pertemuan`
--

INSERT INTO `posttest_pertemuan` (`id_posttest`, `id_pertemuan`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`) VALUES
(22, 114, 'tes', '1', '2', '3', '4', 'C'),
(23, 142, '1', '2', '3', '4', '5', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `pretest_pertemuan`
--

CREATE TABLE `pretest_pertemuan` (
  `id_pretest` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) DEFAULT NULL,
  `opsi_b` varchar(255) DEFAULT NULL,
  `opsi_c` varchar(255) DEFAULT NULL,
  `opsi_d` varchar(255) DEFAULT NULL,
  `jawaban_benar` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pretest_pertemuan`
--

INSERT INTO `pretest_pertemuan` (`id_pretest`, `id_pertemuan`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`) VALUES
(1, 5, 'Apa itu kalimat?', 'Kumpulan kata', 'Angka', 'Simbol', 'Warna', 'A'),
(3, 23, 'type shit', 's', 'sh', 'shi', 'shit', 'D'),
(4, 27, 'holy shit it gaster theme', ':hand: :hand:', 'darkan than dark', 'sans undertale', 'eoeo', 'B'),
(5, 27, 'real', 'rill', 'fa ke', 'real', 'rial', 'C'),
(34, 114, '2', '1', '2', '3', '4', 'C'),
(35, 142, '1', '2', '3', '4', '5', 'A'),
(36, 142, '1', '2', '34', '4', '5', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `progress_tracking`
--

CREATE TABLE `progress_tracking` (
  `id_progress` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_pertemuan` int DEFAULT NULL,
  `id_materi` int DEFAULT NULL,
  `id_tugas` int DEFAULT NULL,
  `id_game` int DEFAULT NULL,
  `tipe_aktivitas` enum('materi','tugas','game','pretest','absen') NOT NULL,
  `status` enum('belum_mulai','sedang_dikerjakan','selesai') DEFAULT 'belum_mulai',
  `progress_percentage` int DEFAULT '0',
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime DEFAULT NULL,
  `durasi_pengerjaan` int DEFAULT NULL,
  `skor` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `progress_tracking`
--

INSERT INTO `progress_tracking` (`id_progress`, `id_siswa`, `id_pertemuan`, `id_materi`, `id_tugas`, `id_game`, `tipe_aktivitas`, `status`, `progress_percentage`, `waktu_mulai`, `waktu_selesai`, `durasi_pengerjaan`, `skor`, `created_at`) VALUES
(70, 8, 133, NULL, NULL, NULL, 'absen', 'selesai', 100, NULL, '2026-01-02 13:42:57', NULL, NULL, '2026-01-02 13:42:57'),
(75, 8, 138, NULL, NULL, NULL, 'absen', 'selesai', 100, NULL, '2026-01-14 09:55:19', NULL, NULL, '2026-01-14 09:55:19'),
(76, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-14 09:55:21', NULL, NULL, '2026-01-14 09:55:21'),
(77, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-14 09:55:28', NULL, NULL, '2026-01-14 09:55:28'),
(78, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-14 09:55:31', NULL, NULL, '2026-01-14 09:55:31'),
(79, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-14 09:55:34', NULL, NULL, '2026-01-14 09:55:34'),
(80, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-14 09:57:21', NULL, NULL, '2026-01-14 09:57:21'),
(81, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-15 14:27:17', NULL, NULL, '2026-01-15 14:27:17'),
(82, 8, 140, NULL, NULL, NULL, 'absen', 'selesai', 100, NULL, '2026-01-21 18:05:57', NULL, NULL, '2026-01-21 18:05:57'),
(83, 8, 136, NULL, NULL, NULL, 'absen', 'selesai', 100, NULL, '2026-01-21 18:30:47', NULL, NULL, '2026-01-21 18:30:47'),
(84, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-24 14:11:57', NULL, NULL, '2026-01-24 14:11:57'),
(85, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-24 14:12:01', NULL, NULL, '2026-01-24 14:12:01'),
(86, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-24 14:50:44', NULL, NULL, '2026-01-24 14:50:44'),
(87, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-24 14:50:47', NULL, NULL, '2026-01-24 14:50:47'),
(88, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-01-24 15:11:39', NULL, NULL, '2026-01-24 15:11:39'),
(89, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-02-19 08:52:41', NULL, NULL, '2026-02-19 08:52:41'),
(90, 8, 138, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-02-19 09:00:29', NULL, NULL, '2026-02-19 09:00:29'),
(91, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-02-19 09:00:33', NULL, NULL, '2026-02-19 09:00:33'),
(92, 8, 142, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-02-19 09:00:37', NULL, NULL, '2026-02-19 09:00:37'),
(93, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-02-19 09:03:55', NULL, NULL, '2026-02-19 09:03:55'),
(94, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-04-08 09:18:42', NULL, NULL, '2026-04-08 09:18:42'),
(95, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-04-08 09:18:54', NULL, NULL, '2026-04-08 09:18:54'),
(96, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-04-08 09:19:42', NULL, NULL, '2026-04-08 09:19:42'),
(97, 8, 114, NULL, NULL, NULL, 'tugas', 'sedang_dikerjakan', 50, NULL, '2026-04-08 09:28:42', NULL, NULL, '2026-04-08 09:28:42');

-- --------------------------------------------------------

--
-- Table structure for table `refleksi_pertemuan`
--

CREATE TABLE `refleksi_pertemuan` (
  `id_refleksi` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban` text,
  `tanggal` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `refleksi_pertemuan`
--

INSERT INTO `refleksi_pertemuan` (`id_refleksi`, `id_pertemuan`, `pertanyaan`, `jawaban`, `tanggal`) VALUES
(3, 114, 'tes', NULL, '2025-12-02 02:26:01'),
(4, 142, '1rwqrw', NULL, '2026-01-22 10:14:06');

-- --------------------------------------------------------

--
-- Table structure for table `sesi_absen`
--

CREATE TABLE `sesi_absen` (
  `id_sesi` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `kode_sesi` varchar(50) NOT NULL,
  `tanggal_buat` datetime DEFAULT CURRENT_TIMESTAMP,
  `status` enum('aktif','non-aktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sesi_absen`
--

INSERT INTO `sesi_absen` (`id_sesi`, `id_pertemuan`, `kode_sesi`, `tanggal_buat`, `status`) VALUES
(56, 114, 'ABS-20251202-733', '2023-11-16 00:00:00', 'aktif'),
(64, 122, 'ABS-20251214-862', '2025-12-14 19:15:40', 'aktif'),
(75, 133, 'ABS-20260102-225', '2026-01-02 13:41:09', 'aktif'),
(78, 136, 'ABS-20260113-407', '2026-01-11 00:00:00', 'aktif'),
(80, 138, 'ABS-20260114-798', '2026-01-14 09:54:49', 'aktif'),
(81, 139, 'ABS-20260121-300', '2026-01-23 00:00:00', 'aktif'),
(82, 140, 'ABS-20260121-607', '2026-01-22 00:00:00', 'aktif'),
(83, 141, 'ABS-20260122-231', '2026-01-22 17:44:33', 'aktif'),
(84, 142, 'ABS-20260122-645', '2026-01-29 00:00:00', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id_siswa` int NOT NULL,
  `id_murid` int DEFAULT NULL,
  `nama_siswa` varchar(100) NOT NULL,
  `kelas` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'alpa',
  `usia` int DEFAULT NULL,
  `jeniskelamin` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `nomor_hp` varchar(20) DEFAULT NULL,
  `angkatan` int DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `status_akun` enum('aktif','nonaktif','suspended') DEFAULT 'aktif',
  `tanggal_daftar` datetime DEFAULT CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `alamat` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id_siswa`, `id_murid`, `nama_siswa`, `kelas`, `password`, `status`, `usia`, `jeniskelamin`, `foto_profil`, `nomor_hp`, `angkatan`, `email`, `status_akun`, `tanggal_daftar`, `last_login`, `alamat`) VALUES
(1, 1, 'yuma', '9B', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Hadir', 17, '', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(2, 2, 'dhika', '9A', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'alpa', 16, 'Laki-laki', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(4, 9, 'Ibrahim', '9A', '$2y$10$HTJJK0z4z86JkvgslrXpuuugsgCl2YIoqu6.coY5to4DdAlK0voZu', 'alpa', 16, '', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(6, 2, 'dhika', '9A', 'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3', 'Hadir', 16, '', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(8, 7, 'kirk', '9A', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', 67, 'attack helicopter', '1773022880_Screenshot 2025-04-17 194104.png', NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(13, NULL, 'agartha', NULL, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', NULL, 'Laki-laki', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(14, NULL, 'aripin', NULL, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', NULL, 'Laki-laki', NULL, NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(15, NULL, 'tantoi ganteng', NULL, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', NULL, NULL, '1764135060_download (1).jpeg', NULL, NULL, NULL, 'aktif', '2025-12-01 06:45:46', NULL, NULL),
(16, NULL, 'low', NULL, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'alpa', NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2026-01-21 20:31:31', NULL, NULL),
(17, NULL, 'hgfkhf', NULL, 'a86e230abaf965b13d8a90b3b0127031e7f9cf1ad1776a5d850b5c3959d29564', 'alpa', NULL, NULL, NULL, NULL, NULL, NULL, 'aktif', '2026-02-08 13:43:03', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_achievements`
--

CREATE TABLE `siswa_achievements` (
  `id_siswa_achievement` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_achievement` int NOT NULL,
  `tanggal_dapat` datetime DEFAULT CURRENT_TIMESTAMP,
  `id_pertemuan` int DEFAULT NULL COMMENT 'Pertemuan terkait achievement',
  `achievement_type` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa_achievements`
--

INSERT INTO `siswa_achievements` (`id_siswa_achievement`, `id_siswa`, `id_achievement`, `tanggal_dapat`, `id_pertemuan`, `achievement_type`) VALUES
(1, 8, 1, '2026-01-02 13:56:08', NULL, NULL),
(2, 8, 1, '2026-01-09 13:16:02', NULL, NULL),
(3, 8, 1, '2026-01-09 13:16:11', NULL, NULL),
(4, 8, 1, '2026-01-09 13:28:32', NULL, NULL),
(6, 8, 1, '2026-01-09 18:37:22', NULL, NULL),
(7, 8, 1, '2026-01-09 18:41:41', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `siswa_mapel`
--

CREATE TABLE `siswa_mapel` (
  `id` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_mapel` int NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'alpa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `siswa_mapel`
--

INSERT INTO `siswa_mapel` (`id`, `id_siswa`, `id_mapel`, `status`) VALUES
(1, 1, 2, 'Hadir'),
(2, 6, 1, 'Hadir'),
(4, 8, 4, 'alpa'),
(8, 4, 4, 'Hadir'),
(9, 1, 4, 'Hadir'),
(11, 14, 4, 'Hadir'),
(12, 13, 4, 'Hadir'),
(13, 2, 4, 'Hadir');

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `opsi_a` varchar(255) NOT NULL,
  `opsi_b` varchar(255) NOT NULL,
  `opsi_c` varchar(255) NOT NULL,
  `opsi_d` varchar(255) NOT NULL,
  `jawaban_benar` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `pertanyaan`, `opsi_a`, `opsi_b`, `opsi_c`, `opsi_d`, `jawaban_benar`) VALUES
(3, 'Hewan yang dapat terbang adalah?', 'Ikan', 'Ayam', 'Kucingasdfgdsxcv', 'Ular', 'B'),
(4, 'Lambang negara Indonesia adalah?', 'Harimau', 'Burung Garuda', 'Singa', 'Elang', 'B'),
(5, 'Planet terdekat dari matahari?', 'Mars', 'Venus', 'Merkurius', 'Bumi', 'C'),
(6, 'fdsafs', '345ertgh', '`1', '43565678', 'dvc', 'D'),
(7, 'coba', 'lagi', 'gua ', 'udah', 'muak', 'A'),
(8, 'mbg', 'aku', 'mbg', 'deafen', 'tes', 'A'),
(9, 'satu', '123', '222', '1', '3', 'C');

-- --------------------------------------------------------

--
-- Table structure for table `true_false_game`
--

CREATE TABLE `true_false_game` (
  `id_game` int NOT NULL,
  `id_guru` int NOT NULL,
  `judul` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `true_false_game`
--

INSERT INTO `true_false_game` (`id_game`, `id_guru`, `judul`, `created_at`) VALUES
(1, 1, 'Game Pertama Saya', '2025-10-22 10:28:35');

-- --------------------------------------------------------

--
-- Table structure for table `true_false_question`
--

CREATE TABLE `true_false_question` (
  `id_question` int NOT NULL,
  `id_game` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `true_false_question`
--

INSERT INTO `true_false_question` (`id_question`, `id_game`, `pertanyaan`, `jawaban`) VALUES
(1, 1, 'php = lambo', 1),
(2, 1, 'sadfghf', 1);

-- --------------------------------------------------------

--
-- Table structure for table `true_false_result`
--

CREATE TABLE `true_false_result` (
  `id_result` int NOT NULL,
  `id_siswa` int NOT NULL,
  `id_game` int NOT NULL,
  `skor` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `true_false_result`
--

INSERT INTO `true_false_result` (`id_result`, `id_siswa`, `id_game`, `skor`, `tanggal`) VALUES
(18, 1, 1, 2, '2025-10-22 14:14:56'),
(19, 1, 1, 2, '2025-10-22 14:14:56');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_pertemuan`
--

CREATE TABLE `tugas_pertemuan` (
  `id_tugas` int NOT NULL,
  `id_pertemuan` int NOT NULL,
  `judul_tugas` varchar(255) DEFAULT NULL,
  `deskripsi` text,
  `file_tugas` varchar(255) DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT CURRENT_TIMESTAMP,
  `deadline` datetime DEFAULT NULL,
  `allow_late` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tugas_pertemuan`
--

INSERT INTO `tugas_pertemuan` (`id_tugas`, `id_pertemuan`, `judul_tugas`, `deskripsi`, `file_tugas`, `tanggal_dibuat`, `deadline`, `allow_late`) VALUES
(1, 5, 'Tugas Kalimat', 'Buat 3 contoh kalimat efektif', NULL, '2025-10-31 01:34:51', NULL, 0),
(6, 38, 'RAMPAGE', 'RAMPAGE', NULL, '2025-11-15 11:22:29', '2025-11-15 14:00:00', 1),
(30, 114, 'tes', 'tes', '1764642361_tugas_69202ded561f65.19126965 (1).pdf', '2025-12-02 10:26:01', '2025-12-05 10:25:00', 1),
(31, 138, 'tes tugas', 'tes tugas', '1768355689_LEMBAR KERJA PESERTA DIDIK.docx', '2026-01-14 09:54:49', '2026-01-14 09:57:00', 1),
(32, 142, 'i', 'i', '1769076846_wait_for_it.wav', '2026-01-22 18:14:06', '2026-01-20 10:00:00', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen_pertemuan`
--
ALTER TABLE `absen_pertemuan`
  ADD PRIMARY KEY (`id_absen`);

--
-- Indexes for table `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id_achievement`);

--
-- Indexes for table `drag_drop_area`
--
ALTER TABLE `drag_drop_area`
  ADD PRIMARY KEY (`id_area`),
  ADD KEY `id_game` (`id_game`);

--
-- Indexes for table `drag_drop_game`
--
ALTER TABLE `drag_drop_game`
  ADD PRIMARY KEY (`id_game`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `drag_drop_item`
--
ALTER TABLE `drag_drop_item`
  ADD PRIMARY KEY (`id_item`),
  ADD KEY `id_game` (`id_game`),
  ADD KEY `correct_area_id` (`correct_area_id`);

--
-- Indexes for table `drag_drop_result`
--
ALTER TABLE `drag_drop_result`
  ADD PRIMARY KEY (`id_result`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id_guru`);

--
-- Indexes for table `jawaban_refleksi`
--
ALTER TABLE `jawaban_refleksi`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_refleksi` (`id_refleksi`),
  ADD KEY `id_pertemuan` (`id_pertemuan`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id_mapel`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `fk_mapel_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `materi_dilihat`
--
ALTER TABLE `materi_dilihat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materi_pertemuan`
--
ALTER TABLE `materi_pertemuan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `nilai_posttest`
--
ALTER TABLE `nilai_posttest`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `nilai_pretest`
--
ALTER TABLE `nilai_pretest`
  ADD PRIMARY KEY (`id_nilai`),
  ADD UNIQUE KEY `unique_siswa_pertemuan` (`id_siswa`,`id_pertemuan`),
  ADD KEY `fk_nilai_pretest_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `pembelajaran`
--
ALTER TABLE `pembelajaran`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD PRIMARY KEY (`id_pengumpulan`),
  ADD KEY `fk_pengumpulan_tugas_id_tugas` (`id_tugas`),
  ADD KEY `fk_pengumpulan_tugas_id_siswa` (`id_siswa`);

--
-- Indexes for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD PRIMARY KEY (`id_pertemuan`),
  ADD KEY `fk_pertemuan_mapel` (`id_mapel`);

--
-- Indexes for table `posttest_pertemuan`
--
ALTER TABLE `posttest_pertemuan`
  ADD PRIMARY KEY (`id_posttest`),
  ADD KEY `fk_posttest_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `pretest_pertemuan`
--
ALTER TABLE `pretest_pertemuan`
  ADD PRIMARY KEY (`id_pretest`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  ADD PRIMARY KEY (`id_progress`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_pertemuan` (`id_pertemuan`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_tugas` (`id_tugas`);

--
-- Indexes for table `refleksi_pertemuan`
--
ALTER TABLE `refleksi_pertemuan`
  ADD PRIMARY KEY (`id_refleksi`),
  ADD KEY `fk_refleksi_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `sesi_absen`
--
ALTER TABLE `sesi_absen`
  ADD PRIMARY KEY (`id_sesi`),
  ADD UNIQUE KEY `kode_sesi` (`kode_sesi`),
  ADD KEY `fk_sesi_absen_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id_siswa`);

--
-- Indexes for table `siswa_achievements`
--
ALTER TABLE `siswa_achievements`
  ADD PRIMARY KEY (`id_siswa_achievement`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_achievement` (`id_achievement`),
  ADD KEY `id_pertemuan` (`id_pertemuan`);

--
-- Indexes for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `siswa_mapel_unique` (`id_siswa`,`id_mapel`),
  ADD KEY `id_mapel` (`id_mapel`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `true_false_game`
--
ALTER TABLE `true_false_game`
  ADD PRIMARY KEY (`id_game`),
  ADD KEY `id_guru` (`id_guru`);

--
-- Indexes for table `true_false_question`
--
ALTER TABLE `true_false_question`
  ADD PRIMARY KEY (`id_question`),
  ADD KEY `id_game` (`id_game`);

--
-- Indexes for table `true_false_result`
--
ALTER TABLE `true_false_result`
  ADD PRIMARY KEY (`id_result`);

--
-- Indexes for table `tugas_pertemuan`
--
ALTER TABLE `tugas_pertemuan`
  ADD PRIMARY KEY (`id_tugas`),
  ADD UNIQUE KEY `id_pertemuan` (`id_pertemuan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absen_pertemuan`
--
ALTER TABLE `absen_pertemuan`
  MODIFY `id_absen` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id_achievement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `drag_drop_area`
--
ALTER TABLE `drag_drop_area`
  MODIFY `id_area` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `drag_drop_game`
--
ALTER TABLE `drag_drop_game`
  MODIFY `id_game` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drag_drop_item`
--
ALTER TABLE `drag_drop_item`
  MODIFY `id_item` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `drag_drop_result`
--
ALTER TABLE `drag_drop_result`
  MODIFY `id_result` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id_guru` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jawaban_refleksi`
--
ALTER TABLE `jawaban_refleksi`
  MODIFY `id_jawaban` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id_mapel` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `materi_dilihat`
--
ALTER TABLE `materi_dilihat`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi_pertemuan`
--
ALTER TABLE `materi_pertemuan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `nilai_posttest`
--
ALTER TABLE `nilai_posttest`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `nilai_pretest`
--
ALTER TABLE `nilai_pretest`
  MODIFY `id_nilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `pembelajaran`
--
ALTER TABLE `pembelajaran`
  MODIFY `id_materi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  MODIFY `id_pengumpulan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pertemuan`
--
ALTER TABLE `pertemuan`
  MODIFY `id_pertemuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `posttest_pertemuan`
--
ALTER TABLE `posttest_pertemuan`
  MODIFY `id_posttest` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `pretest_pertemuan`
--
ALTER TABLE `pretest_pertemuan`
  MODIFY `id_pretest` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  MODIFY `id_progress` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `refleksi_pertemuan`
--
ALTER TABLE `refleksi_pertemuan`
  MODIFY `id_refleksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sesi_absen`
--
ALTER TABLE `sesi_absen`
  MODIFY `id_sesi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id_siswa` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `siswa_achievements`
--
ALTER TABLE `siswa_achievements`
  MODIFY `id_siswa_achievement` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `true_false_game`
--
ALTER TABLE `true_false_game`
  MODIFY `id_game` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `true_false_question`
--
ALTER TABLE `true_false_question`
  MODIFY `id_question` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `true_false_result`
--
ALTER TABLE `true_false_result`
  MODIFY `id_result` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tugas_pertemuan`
--
ALTER TABLE `tugas_pertemuan`
  MODIFY `id_tugas` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `drag_drop_area`
--
ALTER TABLE `drag_drop_area`
  ADD CONSTRAINT `drag_drop_area_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `drag_drop_game` (`id_game`) ON DELETE CASCADE;

--
-- Constraints for table `drag_drop_game`
--
ALTER TABLE `drag_drop_game`
  ADD CONSTRAINT `drag_drop_game_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`);

--
-- Constraints for table `drag_drop_item`
--
ALTER TABLE `drag_drop_item`
  ADD CONSTRAINT `drag_drop_item_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `drag_drop_game` (`id_game`) ON DELETE CASCADE,
  ADD CONSTRAINT `drag_drop_item_ibfk_2` FOREIGN KEY (`correct_area_id`) REFERENCES `drag_drop_area` (`id_area`) ON DELETE CASCADE;

--
-- Constraints for table `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `fk_mapel_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`) ON DELETE CASCADE;

--
-- Constraints for table `materi_pertemuan`
--
ALTER TABLE `materi_pertemuan`
  ADD CONSTRAINT `materi_pertemuan_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_posttest`
--
ALTER TABLE `nilai_posttest`
  ADD CONSTRAINT `nilai_posttest_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_posttest_ibfk_2` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `nilai_pretest`
--
ALTER TABLE `nilai_pretest`
  ADD CONSTRAINT `fk_nilai_pretest_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_nilai_pretest_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `pengumpulan_tugas`
--
ALTER TABLE `pengumpulan_tugas`
  ADD CONSTRAINT `fk_pengumpulan_tugas_id_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pengumpulan_tugas_id_tugas` FOREIGN KEY (`id_tugas`) REFERENCES `tugas_pertemuan` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertemuan`
--
ALTER TABLE `pertemuan`
  ADD CONSTRAINT `fk_pertemuan_mapel` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Constraints for table `posttest_pertemuan`
--
ALTER TABLE `posttest_pertemuan`
  ADD CONSTRAINT `fk_posttest_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `pretest_pertemuan`
--
ALTER TABLE `pretest_pertemuan`
  ADD CONSTRAINT `pretest_pertemuan_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `progress_tracking`
--
ALTER TABLE `progress_tracking`
  ADD CONSTRAINT `progress_tracking_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`),
  ADD CONSTRAINT `progress_tracking_ibfk_2` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`),
  ADD CONSTRAINT `progress_tracking_ibfk_3` FOREIGN KEY (`id_materi`) REFERENCES `pembelajaran` (`id_materi`);

--
-- Constraints for table `refleksi_pertemuan`
--
ALTER TABLE `refleksi_pertemuan`
  ADD CONSTRAINT `refleksi_pertemuan_fk_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `sesi_absen`
--
ALTER TABLE `sesi_absen`
  ADD CONSTRAINT `fk_sesi_absen_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;

--
-- Constraints for table `siswa_achievements`
--
ALTER TABLE `siswa_achievements`
  ADD CONSTRAINT `fk_siswa_achievements_achievement` FOREIGN KEY (`id_achievement`) REFERENCES `achievements` (`id_achievement`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_siswa_achievements_pertemuan` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_siswa_achievements_siswa` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE;

--
-- Constraints for table `siswa_mapel`
--
ALTER TABLE `siswa_mapel`
  ADD CONSTRAINT `siswa_mapel_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `siswa` (`id_siswa`) ON DELETE CASCADE,
  ADD CONSTRAINT `siswa_mapel_ibfk_2` FOREIGN KEY (`id_mapel`) REFERENCES `mapel` (`id_mapel`) ON DELETE CASCADE;

--
-- Constraints for table `true_false_game`
--
ALTER TABLE `true_false_game`
  ADD CONSTRAINT `true_false_game_ibfk_1` FOREIGN KEY (`id_guru`) REFERENCES `guru` (`id_guru`);

--
-- Constraints for table `true_false_question`
--
ALTER TABLE `true_false_question`
  ADD CONSTRAINT `true_false_question_ibfk_1` FOREIGN KEY (`id_game`) REFERENCES `true_false_game` (`id_game`);

--
-- Constraints for table `tugas_pertemuan`
--
ALTER TABLE `tugas_pertemuan`
  ADD CONSTRAINT `tugas_pertemuan_ibfk_1` FOREIGN KEY (`id_pertemuan`) REFERENCES `pertemuan` (`id_pertemuan`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
