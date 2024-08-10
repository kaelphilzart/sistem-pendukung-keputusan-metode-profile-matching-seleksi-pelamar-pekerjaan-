-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Agu 2024 pada 19.44
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fix_rena`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bobot_gap`
--

CREATE TABLE `bobot_gap` (
  `id` int(11) NOT NULL,
  `selisih` double NOT NULL,
  `nilai_gap` double NOT NULL,
  `keterangan_gap` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bobot_gap`
--

INSERT INTO `bobot_gap` (`id`, `selisih`, `nilai_gap`, `keterangan_gap`, `created_at`, `updated_at`) VALUES
(4, 0, 5, 'Kompetensi sesuai harapan', '2024-05-18 08:50:50', '2024-07-08 07:57:44'),
(5, 1, 4.5, 'Kompetensi individu melampaui harapan 1 tingkat', '2024-05-18 08:55:22', '2024-07-08 07:57:57'),
(6, -1, 4, 'Kompetensi individu kurang dari harapan 1 tingkat', '2024-05-18 08:55:42', '2024-07-08 07:58:14'),
(7, 2, 3.5, 'Kompetensi individu melampaui harapan 2 tingkat', '2024-05-18 08:56:06', '2024-07-08 07:58:49'),
(8, -2, 3, 'Kompetensi individu kurang dari harapan 2 tingkat', '2024-05-18 08:56:29', '2024-07-08 07:59:17'),
(10, -3, 2, 'Kompetensi individu kurang dari harapan 3 tingkat', '2024-05-18 08:57:12', '2024-07-08 08:15:32'),
(11, 4, 1.5, 'Kompetensi individu melampaui harapan 4 tingkat', '2024-05-18 08:57:40', '2024-07-08 08:15:55'),
(12, -4, 1, 'Kompetensi individu kurang dari harapan 4 tingkat', '2024-05-18 08:58:03', '2024-07-08 08:16:15'),
(13, 3, 2.5, 'Kompetensi individu melampaui harapan 3 tingkat', '2024-07-08 07:59:47', '2024-07-08 07:59:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `hasil_akhir`
--

CREATE TABLE `hasil_akhir` (
  `id` int(11) NOT NULL,
  `id_lamar` int(11) NOT NULL,
  `id_loker` int(11) NOT NULL,
  `nilai` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama_kriteria` varchar(50) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `persentase` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama_kriteria`, `kode`, `persentase`, `created_at`, `updated_at`) VALUES
(4, 'aspek persyaratan dasar', 'PD', 30, '2024-05-01 10:41:34', '2024-07-08 07:20:10'),
(5, 'aspek keahlian', 'AK', 40, '2024-05-17 00:18:40', '2024-07-08 07:20:20'),
(6, 'aspek pengalaman dan kualifikasi', 'PK', 30, '2024-05-17 00:19:13', '2024-07-02 06:12:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lamar`
--

CREATE TABLE `lamar` (
  `id` int(11) NOT NULL,
  `id_pelamar` int(11) NOT NULL,
  `id_lowongan` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'proses',
  `nilai` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`nilai`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lamar`
--

INSERT INTO `lamar` (`id`, `id_pelamar`, `id_lowongan`, `status`, `nilai`, `created_at`, `updated_at`) VALUES
(33, 2, 2, 'proses', '\"[{\\\"id_jawab\\\":\\\"56\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761550_cover_1.jpg\\\",\\\"status\\\":\\\"diverifikasi\\\"},{\\\"id_jawab\\\":\\\"58\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_cover_3.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"61\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_kaos1.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"64\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_cover_1.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"66\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_cover_3.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"70\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_cover_3.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"73\\\",\\\"isi_detail\\\":\\\"xd\\\",\\\"status\\\":\\\"diverifikasi\\\"},{\\\"id_jawab\\\":\\\"75\\\",\\\"isi_detail\\\":\\\"storage\\\\\\/lamar\\\\\\/1721761551_cover_2.jpg\\\",\\\"status\\\":\\\"belum diverifikasi\\\"},{\\\"id_jawab\\\":\\\"82\\\",\\\"isi_detail\\\":\\\"d\\\",\\\"status\\\":\\\"belum diverifikasi\\\"}]\"', '2024-07-23 12:05:51', '2024-07-23 12:46:06');

--
-- Trigger `lamar`
--
DELIMITER $$
CREATE TRIGGER `lamar_lowongan` AFTER INSERT ON `lamar` FOR EACH ROW UPDATE lowongan
SET kuota = kuota - 1
WHERE id = NEW.id_lowongan
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lowongan`
--

CREATE TABLE `lowongan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `lowongan` varchar(255) NOT NULL,
  `kuota` int(11) NOT NULL,
  `status` varchar(255) NOT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lowongan`
--

INSERT INTO `lowongan` (`id`, `lowongan`, `kuota`, `status`, `tanggal_mulai`, `tanggal_berakhir`, `created_at`, `updated_at`) VALUES
(2, 'Staff Telemarketing', 5, 'Tidak Aktif', '2024-07-02', '2024-06-07', '2024-03-27 16:39:15', '2024-07-08 05:43:43'),
(3, 'Staff Administrasi', 0, 'aktif', '2024-07-08', '2024-07-19', '2024-05-06 09:05:46', '2024-07-08 08:17:48'),
(4, 'Customer Service', 25, 'aktif', '2024-07-18', '2024-07-26', '2024-05-17 00:17:09', '2024-07-01 21:31:31'),
(15, 'Tour Leader', 30, 'aktif', '2024-07-22', '2024-07-31', '2024-07-01 21:32:05', '2024-07-01 21:32:05'),
(16, 'IT Support', 15, 'aktif', '2024-07-22', '2024-08-10', '2024-07-01 21:32:39', '2024-07-01 21:32:39'),
(17, 'j', 3, 'aktif', '2024-07-16', '2024-07-30', '2024-07-23 20:06:02', '2024-07-23 20:06:02');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_03_23_060253_create_pelamar', 2),
(6, '2024_03_27_060339_create_lowongan', 3),
(7, '2024_03_28_062031_create_file_syarat', 4),
(8, '2024_03_28_062332_create_file_syarat', 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_isi`
--

CREATE TABLE `nilai_isi` (
  `id` int(11) NOT NULL,
  `id_sub` int(11) NOT NULL,
  `keterangan_isi` varchar(255) NOT NULL,
  `nilai_isi` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_isi`
--

INSERT INTO `nilai_isi` (`id`, `id_sub`, `keterangan_isi`, `nilai_isi`, `created_at`, `updated_at`) VALUES
(4, 4, 'cukup', 2, '2024-05-01 10:46:01', '2024-05-01 10:46:01'),
(5, 3, 'baik sekali', 4, '2024-05-01 10:46:28', '2024-05-01 10:46:28'),
(6, 3, 'cukup', 1, '2024-05-01 10:46:46', '2024-05-01 10:46:46'),
(7, 4, 'mampu', 5, '2024-05-01 10:46:58', '2024-05-01 10:46:58'),
(8, 5, '<14', 3, NULL, NULL),
(9, 6, 'abi', 4, NULL, NULL),
(10, 8, 'kristen', 2, '2024-05-08 18:33:30', '2024-05-08 18:33:30'),
(11, 7, 'cukup baik', 3, '2024-05-08 18:34:30', '2024-05-08 18:34:30'),
(12, 9, 'bidang pelayanan dan hospitality', 3, '2024-05-18 08:23:00', '2024-05-18 08:23:00'),
(13, 9, 'bidang operasional dan logistik', 2, '2024-05-18 08:23:21', '2024-05-18 08:23:21'),
(14, 9, 'bidang keagamaan dan pembinaan', 1, '2024-05-18 08:24:03', '2024-05-18 08:24:03'),
(15, 10, 'baik', 3, '2024-05-18 08:24:28', '2024-05-18 08:24:28'),
(16, 10, 'cukup baik', 2, '2024-05-18 08:24:47', '2024-05-18 08:24:47'),
(17, 10, 'kurang baik', 1, '2024-05-18 08:25:00', '2024-05-18 08:25:17'),
(18, 11, 'sehat', 3, '2024-05-18 08:26:23', '2024-05-18 08:26:23'),
(19, 11, 'memiliki riwayat penyakit', 2, '2024-05-18 08:26:42', '2024-05-18 08:26:42'),
(20, 11, 'memiliki gangguan mental', 1, '2024-05-18 08:27:04', '2024-05-18 08:27:04'),
(21, 12, 'baik', 3, '2024-05-18 08:27:20', '2024-05-18 08:27:20'),
(22, 12, 'cukup baik', 2, '2024-05-18 08:27:33', '2024-05-18 08:27:33'),
(23, 12, 'kurang baik', 1, '2024-05-18 08:28:29', '2024-05-18 08:28:29'),
(24, 13, 'baik', 3, '2024-05-18 08:29:15', '2024-05-18 08:29:15'),
(25, 13, 'cukup baik', 2, '2024-05-18 08:29:35', '2024-05-18 08:29:35'),
(26, 13, 'kurang baik', 1, '2024-05-18 08:29:56', '2024-05-18 08:29:56'),
(27, 14, 'baik', 3, '2024-05-18 08:30:08', '2024-05-18 08:30:08'),
(28, 14, 'cukup baik', 2, '2024-05-18 08:30:23', '2024-05-18 08:30:23'),
(29, 14, 'kurang baik', 1, '2024-05-18 08:30:39', '2024-05-18 08:30:39'),
(30, 15, 'mampu', 3, '2024-05-18 08:33:45', '2024-05-18 08:33:45'),
(31, 15, 'cukup mampu', 2, '2024-05-18 08:34:01', '2024-05-18 08:34:01'),
(32, 15, 'tidak bisa', 1, '2024-05-18 08:34:49', '2024-05-18 08:34:49'),
(33, 16, 'bisa bahasa inggris', 3, '2024-05-18 08:36:53', '2024-05-18 08:36:53'),
(34, 16, 'bisa bahasa arab', 2, '2024-05-18 08:37:32', '2024-05-18 08:37:32'),
(35, 16, 'tidak bisa semua', 1, '2024-05-18 08:37:46', '2024-05-18 08:37:46'),
(36, 17, 'baik', 3, '2024-05-18 08:38:12', '2024-05-18 08:38:12'),
(37, 17, 'cukup baik', 2, '2024-05-18 08:38:25', '2024-05-18 08:38:25'),
(38, 17, 'kurang baik', 1, '2024-05-18 08:39:19', '2024-05-18 08:39:19'),
(39, 18, 'S1-S3', 3, '2024-05-18 08:39:59', '2024-05-18 08:39:59'),
(40, 18, 'D3-D4', 2, '2024-05-18 08:40:19', '2024-05-18 08:40:19'),
(41, 18, 'SMA/SMK', 1, '2024-05-18 08:40:31', '2024-05-18 08:40:31'),
(42, 19, '30-40 tahun', 3, '2024-05-18 08:40:53', '2024-05-18 09:01:24'),
(43, 19, '25-34 tahun', 2, '2024-05-18 08:41:45', '2024-05-18 08:41:45'),
(44, 19, '25-29 tahun', 2, '2024-05-18 08:43:14', '2024-05-18 08:43:14'),
(46, 20, '3 tahun keatas', 3, '2024-05-18 08:46:29', '2024-05-18 08:46:29'),
(47, 20, '2 tahun', 2, '2024-05-18 08:46:51', '2024-05-18 08:46:51'),
(48, 20, '1 tahun', 1, '2024-05-18 08:47:03', '2024-05-18 08:47:03'),
(49, 22, '25 - 30', 4, '2024-05-27 22:27:55', '2024-05-27 22:42:16'),
(52, 24, 'punya', 5, '2024-05-31 05:39:44', '2024-05-31 05:39:44'),
(53, 23, 'baik sekali', 5, '2024-05-31 05:39:56', '2024-05-31 05:39:56'),
(54, 25, 'memiliki riwayat penyakit', 1, '2024-06-12 08:05:03', '2024-06-12 08:05:03'),
(55, 25, 'sehat dengan riwayat penyakit minor', 2, '2024-06-12 08:05:39', '2024-07-02 06:16:50'),
(56, 25, 'sehat', 3, '2024-06-12 08:05:51', '2024-06-12 08:05:51'),
(57, 26, 'sertifikat TOEIC dengan skor 600 - 700', 1, '2024-06-12 08:06:31', '2024-07-08 07:44:14'),
(58, 26, 'sertifikat TOEIC dengan skor 700 - 850', 2, '2024-06-12 08:06:43', '2024-07-08 07:44:26'),
(59, 26, 'sertifikat TOEIC dengan skor 850 - 990', 3, '2024-06-12 08:06:59', '2024-07-08 07:44:44'),
(60, 27, 'tidak bisa', 1, '2024-06-12 08:07:23', '2024-06-12 08:35:27'),
(61, 27, 'dasar', 2, '2024-06-12 08:07:35', '2024-06-12 08:35:36'),
(62, 27, 'lancar', 3, '2024-06-12 08:07:46', '2024-06-12 08:35:46'),
(63, 28, 'Di bawah Sarjana', 1, '2024-06-12 08:09:43', '2024-07-02 10:47:48'),
(64, 28, 'Sarjana (S1) di bidang lain', 2, '2024-06-12 08:09:55', '2024-07-02 10:48:04'),
(65, 28, 'Sarjana (S1) di bidang terkait', 3, '2024-06-12 08:10:13', '2024-07-02 10:48:20'),
(66, 29, 'Di atas 30 tahun', 1, '2024-06-12 08:13:32', '2024-07-02 10:49:23'),
(67, 29, 'Usia 25-30 tahun', 2, '2024-06-12 08:13:59', '2024-07-02 10:49:38'),
(68, 29, 'Usia 20-24 tahun', 3, '2024-06-12 08:14:28', '2024-07-02 10:49:52'),
(69, 30, 'Kurang dari 1 tahun', 1, '2024-06-12 08:15:45', '2024-07-02 10:50:43'),
(70, 30, '1-2 tahun', 2, '2024-06-12 08:16:09', '2024-07-02 10:50:59'),
(71, 30, 'lebih dari 2 tahun', 3, '2024-06-12 08:16:25', '2024-07-02 10:51:14'),
(72, 31, 'cukup', 1, '2024-06-12 08:17:29', '2024-07-02 10:53:03'),
(73, 31, 'baik', 2, '2024-06-12 08:17:43', '2024-07-02 10:53:15'),
(74, 31, 'sangat baik', 3, '2024-06-12 08:17:52', '2024-07-02 10:53:24'),
(75, 32, 'tidak bisa', 1, '2024-06-12 08:47:13', '2024-07-02 10:54:51'),
(76, 32, 'dasar', 2, '2024-06-12 08:47:23', '2024-07-02 10:55:05'),
(77, 32, 'mahir', 3, '2024-06-12 08:47:33', '2024-07-02 10:55:32'),
(78, 33, 'tidak bisa', 1, '2024-06-12 08:47:59', '2024-06-12 08:47:59'),
(79, 33, 'dasar', 2, '2024-06-12 08:48:09', '2024-06-12 08:48:09'),
(80, 33, 'lancar', 3, '2024-06-12 08:48:20', '2024-06-12 08:48:20'),
(81, 53, 'cukup', 1, '2024-07-02 10:56:43', '2024-07-02 10:56:43'),
(82, 53, 'baik', 2, '2024-07-02 10:56:51', '2024-07-02 10:56:51'),
(83, 53, 'sangat baik', 3, '2024-07-02 10:57:01', '2024-07-02 10:57:01'),
(84, 35, 'cukup', 1, '2024-07-08 07:45:25', '2024-07-08 07:45:56'),
(85, 35, 'baik', 2, '2024-07-08 07:46:06', '2024-07-08 07:46:06'),
(86, 35, 'sangat baik', 3, '2024-07-08 07:46:13', '2024-07-08 07:46:13'),
(87, 37, 'Pendidikan lain', 1, '2024-07-08 07:47:11', '2024-07-08 07:47:11'),
(88, 37, 'Diploma (D3) di bidang terkait', 2, '2024-07-08 07:47:23', '2024-07-08 07:47:23'),
(89, 37, 'Sarjana (S1) di bidang terkait', 3, '2024-07-08 07:47:36', '2024-07-08 07:47:36'),
(90, 38, 'Di atas 35 tahun', 1, '2024-07-08 07:48:36', '2024-07-08 07:48:36'),
(91, 38, 'Usia 29-35 tahun', 2, '2024-07-08 07:48:50', '2024-07-08 07:48:50'),
(92, 38, 'Usia 23-28 tahun', 3, '2024-07-08 07:50:24', '2024-07-08 07:50:24'),
(93, 39, 'kurang dari 1 tahun', 1, '2024-07-08 07:52:04', '2024-07-08 07:52:04'),
(94, 39, '1-2 tahun', 2, '2024-07-08 07:52:54', '2024-07-08 07:52:54'),
(95, 39, 'lebih dari 2 tahun', 3, '2024-07-08 07:53:07', '2024-07-08 07:53:07'),
(96, 40, 'cukup', 1, '2024-07-08 07:54:26', '2024-07-08 07:54:26'),
(97, 40, 'baik', 2, '2024-07-08 07:54:34', '2024-07-08 07:54:34'),
(98, 40, 'sangat baik', 3, '2024-07-08 07:54:47', '2024-07-08 07:54:47'),
(99, 41, 'cukup', 1, '2024-07-08 07:55:24', '2024-07-08 07:55:24'),
(100, 41, 'baik', 2, '2024-07-08 07:55:30', '2024-07-08 07:55:30'),
(101, 41, 'sangat baik', 3, '2024-07-08 07:55:37', '2024-07-08 07:55:37'),
(102, 42, 'dasar', 1, '2024-07-08 07:56:21', '2024-07-08 07:56:21'),
(103, 42, 'menengah', 2, '2024-07-08 07:56:30', '2024-07-08 07:56:30'),
(104, 42, 'mahir', 3, '2024-07-08 07:56:40', '2024-07-08 07:56:40'),
(105, 34, 'memiliki riwayat penyakit', 1, '2024-07-08 13:59:54', '2024-07-08 13:59:54'),
(106, 34, 'sehat dengan riwayat penyakit minor', 2, '2024-07-08 14:00:07', '2024-07-08 14:00:07'),
(107, 34, 'sehat', 3, '2024-07-08 14:00:20', '2024-07-08 14:00:20'),
(108, 36, 'sertifikat TOEIC dengan skor 600 - 700', 1, '2024-07-08 14:01:23', '2024-07-08 14:01:23'),
(109, 36, 'sertifikat TOEIC dengan skor 700 - 850', 2, '2024-07-08 14:01:39', '2024-07-08 14:01:39'),
(110, 36, 'sertifikat TOEIC dengan skor 850 - 990', 3, '2024-07-08 14:01:51', '2024-07-08 14:01:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelamar`
--

CREATE TABLE `pelamar` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pelamar`
--

INSERT INTO `pelamar` (`id`, `id_user`, `foto`, `nama_lengkap`, `alamat`, `tempat_lahir`, `tanggal_lahir`, `no_hp`, `created_at`, `updated_at`) VALUES
(2, 5, 'storage/foto/RENA EKA PUTRI_LISTENING TASK.png', 'asep', 'kediri', 'jombang', '2001-04-18', '085749880166', '2024-05-17 00:11:09', '2024-05-17 00:11:09'),
(3, 7, 'storage/foto/WIN_20230511_19_38_42_Pro.jpg', 'eka putri', 'kediri', 'blitar', '2000-06-21', '085812305075', '2024-06-12 09:06:28', '2024-06-12 09:06:28'),
(4, 8, 'storage/foto/1-2.jpg', 'putri', 'jombang', 'semarang', '2004-08-11', '085785299706', '2024-06-12 09:14:24', '2024-06-12 09:14:24'),
(5, 9, 'storage/foto/2022-07-26-014017696.jpg', 'eka jaya', 'blitar', 'surabaya', '2000-02-16', '085156565602', '2024-06-13 01:14:03', '2024-06-13 01:14:03'),
(6, 10, 'storage/foto/WIN_20230511_19_38_31_Pro.jpg', 'putri eja', 'blitar', 'kediri', '2001-06-12', '085812305075', '2024-06-26 05:48:06', '2024-06-26 05:48:06'),
(7, 11, 'storage/foto/rena eka putri.png', 'diazahro', 'jombang', 'mojokerto', '2003-09-17', '085785299706', '2024-06-26 06:05:35', '2024-06-26 06:05:35'),
(8, 12, 'storage/foto/5 sep.png', 'rena eka', 'kediri', 'sumba', '2005-04-07', '085749880166', '2024-06-26 06:08:37', '2024-06-26 06:08:37'),
(9, 13, 'storage/foto/f6a27118-4395-4ec7-a620-e609e03e67a9.jpeg', 'Rani Anggraeni', 'Jl. Melati No. 7, Kediri', 'Jombang', '1996-03-02', '081234567892', '2024-07-02 07:09:58', '2024-07-02 07:09:58'),
(10, 14, 'storage/foto/yuk bisa yuk.jpeg', 'Dina Putri', 'Jl. Mangga No. 12, Kediri', 'surabaya', '1995-01-02', '081234567890', '2024-07-02 08:00:27', '2024-07-02 08:00:27'),
(11, 15, 'storage/foto/f6a27118-4395-4ec7-a620-e609e03e67a9.jpeg', 'Sari Wulandari', 'Jl. Mawar No. 3, Kediri', 'blitar', '1994-02-03', '081234567891', '2024-07-02 11:08:22', '2024-07-02 11:08:22'),
(12, 16, 'storage/foto/7833f6ee-dd79-4f41-85eb-68350a594f0c.jpeg', 'Rini Anggraeni', 'Jl. Melati No. 7, Kediri', 'sidoarjo', '1996-03-03', '081234567892', '2024-07-02 11:20:53', '2024-07-02 11:20:53'),
(13, 17, 'storage/foto/0586e321-3ccc-46d6-9f37-38dde3d8411e.jpeg', 'Ahmad Fikri', 'Jl. Anggrek No. 15, Kediri', 'kertosono', '1990-06-03', '085749880166', '2024-07-02 11:27:05', '2024-07-02 11:27:05'),
(14, 18, 'storage/foto/Anang bakriyo.jpeg', 'Budi Santoso', 'nganjuk', 'madiun', '1992-07-25', '085749880166', '2024-07-02 11:35:09', '2024-07-02 11:35:09'),
(15, 21, 'storage/foto/9c74ba3b-9985-430c-b5dd-8a3a00933b44.jpeg', 'Aditya Nugraha', 'Jl. Dahlia No. 2, Kediri', 'nganjuk', '1996-11-14', '085749880166', '2024-07-08 13:53:34', '2024-07-08 13:53:34'),
(16, 22, 'storage/foto/f7272cc7-c945-4788-adf7-b3a7a1919f7c.jpeg', 'Rina Puspitasari', 'kediri', 'madiun', '1995-12-22', '081234567801', '2024-07-08 14:10:03', '2024-07-08 14:10:03'),
(17, 23, 'storage/foto/ba3538dc-f325-4e4c-9e45-72bc9d70c1a0.jpeg', 'Deni Kusuma Lintang', 'kediri', 'malang', '2000-01-07', '081234567802', '2024-07-08 14:17:24', '2024-07-08 14:17:24'),
(18, 24, 'storage/foto/2e3d6332-957a-45e9-b0c7-72d8f3d755c8.jpeg', 'Nita Pratiwi Larasati', 'mojoroto, kediri', 'surabaya', '2001-02-16', '081234567803', '2024-07-08 14:31:37', '2024-07-08 14:31:37'),
(19, 25, 'storage/foto/2af6a185-685b-4e45-802d-fd1b2998e953.jpeg', 'Susanti Dewi Pritiwi', 'Pesantren, Kediri', 'kertosono', '2003-05-12', '085749880166', '2024-07-08 14:37:16', '2024-07-08 14:37:16'),
(20, 26, 'storage/foto/1.jpg', 'dani', 'DDD', 'manado', '2024-07-26', '086543152261', '2024-07-23 12:10:36', '2024-07-23 12:10:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(11) NOT NULL,
  `id_hasil` int(11) NOT NULL,
  `status` varchar(20) NOT NULL,
  `tgl_wawancara` date DEFAULT NULL,
  `jam_wawancara` time DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `id_hasil`, `status`, `tgl_wawancara`, `jam_wawancara`, `created_at`, `updated_at`) VALUES
(7, 6, 'lolos', '2024-06-11', '07:00:00', '2024-06-05 04:45:28', '2024-06-05 04:45:28'),
(8, 8, 'lolos', '2024-06-20', '09:00:00', '2024-06-12 09:27:49', '2024-06-12 09:27:49'),
(9, 7, 'lolos', '2024-06-11', '09:00:00', '2024-06-13 01:21:33', '2024-06-13 01:21:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sub_kriteria`
--

CREATE TABLE `sub_kriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_loker` int(11) NOT NULL,
  `nama_sub_kriteria` varchar(100) NOT NULL,
  `nilai_standar` int(11) NOT NULL,
  `pengelompokan` varchar(20) NOT NULL,
  `input_pelamar` varchar(20) NOT NULL,
  `perintah` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `sub_kriteria`
--

INSERT INTO `sub_kriteria` (`id`, `id_kriteria`, `id_loker`, `nama_sub_kriteria`, `nilai_standar`, `pengelompokan`, `input_pelamar`, `perintah`, `created_at`, `updated_at`) VALUES
(26, 4, 2, 'kemampuan bahasa inggris', 3, 'core factor', 'file', 'silahkan upload sertifikat TOEFL, IELTS atau bukti kursus', '2024-06-11 08:49:11', '2024-07-02 06:21:32'),
(27, 4, 2, 'pengetahuan haji/umroh', 3, 'core factor', 'file', 'silahkan upload sertifikat anda', '2024-06-11 08:49:44', '2024-07-02 06:22:11'),
(28, 6, 2, 'Pendidikan Terakhir', 3, 'core factor', 'file', 'silahkan upload ijazah anda', '2024-06-11 08:50:35', '2024-06-11 08:50:35'),
(29, 6, 2, 'Usia', 2, 'secondary factor', 'file', 'silahkan upload KTP anda', '2024-06-11 08:51:00', '2024-07-02 06:23:15'),
(30, 6, 2, 'pengalaman', 3, 'core factor', 'file', 'silahkan upload CV, resume atau surat referensi kerja dari tempat kerja sebelumnya', '2024-06-11 08:51:34', '2024-07-02 06:24:00'),
(31, 5, 2, 'kemampuan penjualan', 3, 'core factor', 'text', 'Bisakah Anda ceritakan tentang pengalaman Anda sebelumnya dalam penjualan, terutama melalui telemarketing?', '2024-06-11 08:52:30', '2024-07-02 06:29:41'),
(32, 5, 2, 'Kemampuan mengedit', 2, 'secondary factor', 'file', 'silahkan upload portofolio proyek atau materi promosi yang pernah diedit', '2024-06-11 08:53:23', '2024-07-02 10:34:53'),
(34, 4, 3, 'kesehatan', 3, 'secondary factor', 'file', 'silahkan upload surat keterangan sehat', '2024-06-11 09:02:53', '2024-07-08 07:26:30'),
(35, 4, 3, 'Integritas', 3, 'core factor', '0', '0', '2024-06-11 09:03:20', '2024-07-08 06:52:50'),
(36, 4, 3, 'kemampuan bahasa inggris', 2, 'core factor', 'file', 'silahkan upload sertifikat TOEIC anda', '2024-06-11 09:03:44', '2024-07-08 14:04:02'),
(37, 6, 3, 'Pendidikan terakhir', 3, 'core factor', 'file', 'silahkan upload ijazah anda', '2024-06-11 09:16:37', '2024-06-11 09:16:37'),
(38, 6, 3, 'Usia', 3, 'secondary factor', 'file', 'silahkan upload KTP anda', '2024-06-11 09:16:58', '2024-07-08 06:56:54'),
(39, 6, 3, 'Pengalaman', 2, 'core factor', 'file', 'silahkan upload CV/resume anda', '2024-06-11 09:17:17', '2024-07-08 06:58:07'),
(40, 5, 3, 'Kemampuan komunikasi', 3, 'secondary factor', '0', '0', '2024-06-11 09:18:48', '2024-07-08 07:16:10'),
(41, 5, 3, 'kemampuan administratif', 3, 'core factor', 'file', 'Silahkan upload Sertifikat pelatihan administratif, bukti partisipasi dalam kursus administrasi, atau surat referensi yang menyatakan pengalaman administratif.', '2024-06-12 07:33:59', '2024-07-08 07:18:24'),
(42, 5, 3, 'Kemampuan MS Office', 3, 'core factor', 'file', 'silahkan upload sertifikat kursus atau dokumen membuat menggunakan MS Office', '2024-06-12 07:34:23', '2024-07-08 07:19:31'),
(43, 4, 4, 'kesehatan', 2, 'secondary factor', 'file', 'silahkan upload surat keterangan sehat', '2024-06-12 07:43:45', '2024-06-12 07:43:45'),
(44, 4, 4, 'Pengetahuan haji/umroh', 3, 'core factor', 'file', 'silahkan upload sertfikat', '2024-06-12 07:44:08', '2024-06-12 07:44:08'),
(45, 4, 4, 'Mampu mengoperasikan Microsoft office dan aplikasi berbasis android/ios', 3, 'core factor', 'file', 'silahkan upload sertifikat', '2024-06-12 07:44:34', '2024-06-12 07:44:34'),
(46, 6, 4, 'Pendidikan terakhir', 3, 'core factor', 'file', 'silahkan upload ijazah', '2024-06-12 07:45:06', '2024-06-12 07:45:06'),
(47, 6, 4, 'Usia', 2, 'secondary factor', 'text', 'silahkan tulis usia anda', '2024-06-12 07:45:26', '2024-06-12 07:45:26'),
(48, 6, 4, 'Pengalaman', 3, 'core factor', 'file', 'silahkan upload resume anda', '2024-06-12 07:45:44', '2024-06-12 07:45:44'),
(49, 5, 4, 'Kemampuan bahasa inggris', 3, 'core factor', 'file', 'silahkan upload sertifikat pelatihan', '2024-06-12 07:47:21', '2024-06-12 07:47:21'),
(50, 5, 4, 'Kemampuan problem solving', 3, 'core factor', 'file', '', '2024-06-12 07:47:50', '2024-06-12 07:47:50'),
(51, 5, 4, 'Memahami digital marketing', 2, 'secondary factor', 'file', '', '2024-06-12 07:48:20', '2024-06-12 07:48:20'),
(53, 5, 2, 'kemampuan negosiasi', 3, 'core factor', 'text', 'Jelaskan pemahaman Anda tentang negosiasi', '2024-07-02 10:34:24', '2024-07-02 10:34:24'),
(54, 4, 0, 'kesehatan', 6, 'secondary factor', 'file', 'upload', '2024-07-23 13:30:41', '2024-07-23 13:35:26'),
(56, 4, 15, 'Keadaan Tubuh', 3, 'core factor', 'text', 'd', '2024-07-23 19:49:28', '2024-07-23 19:49:28'),
(57, 4, 15, 's', 2, 'core factor', 'text', 'j', '2024-07-23 19:49:58', '2024-07-23 19:49:58'),
(58, 4, 15, 'k', 8, 'secondary factor', 'text', 'lkk', '2024-07-23 19:50:23', '2024-07-23 19:50:23'),
(59, 4, 15, 'dj', 3, 'secondary factor', 'text', 'sl', '2024-07-23 20:05:13', '2024-07-23 20:05:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `syarat_loker`
--

CREATE TABLE `syarat_loker` (
  `id` int(11) NOT NULL,
  `id_loker` int(11) NOT NULL,
  `syarat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `syarat_loker`
--

INSERT INTO `syarat_loker` (`id`, `id_loker`, `syarat`, `created_at`, `updated_at`) VALUES
(2, 2, 'Wanita berpenampilan menarik (20-30 tahun)', '2024-05-26 06:25:09', '2024-07-01 21:33:47'),
(5, 3, 'Usia antara 23-35 tahun.', '2024-05-26 22:58:07', '2024-07-01 21:35:55'),
(6, 2, 'Pendidikan minimal S1', '2024-06-11 07:52:20', '2024-07-01 21:34:03'),
(7, 2, 'Memiliki kemampuan komunikasi dan penjualan yang baik', '2024-06-11 07:52:36', '2024-07-01 21:34:22'),
(9, 2, 'Memiliki pengalaman sebagai sales lebih disukai 9 jam kerja', '2024-06-11 07:56:27', '2024-07-01 21:34:38'),
(10, 2, 'Memiliki keahlian di bidang editor', '2024-06-11 07:56:44', '2024-07-01 21:34:57'),
(11, 2, '- Mampu membuat marketing plan & strategi penjualan Umrah', '2024-06-11 07:57:10', '2024-06-11 07:57:10'),
(12, 2, 'Bisa bahasa Arab (nilai plus)', '2024-06-11 07:57:43', '2024-06-11 07:57:43'),
(13, 2, 'Gaji : Rp.4 – 5 Juta', '2024-06-11 07:58:12', '2024-06-11 07:58:12'),
(14, 2, 'Level Pekerjaan : Supervisor / Coordinator', '2024-06-11 07:58:23', '2024-06-11 07:58:23'),
(15, 2, 'Tipe Pekerjaan : Purna Waktu / Full Time', '2024-06-11 07:58:50', '2024-06-11 07:58:50'),
(16, 3, 'Pendidikan minimal D3/S1 dari jurusan terkait', '2024-06-11 08:58:36', '2024-07-01 21:37:12'),
(17, 3, 'Pengalaman minimal 1 tahun di bidang administrasi', '2024-06-11 08:58:48', '2024-07-01 21:37:05'),
(18, 3, 'Menguasai MS Office', '2024-06-11 08:59:13', '2024-07-01 21:37:54'),
(19, 3, 'Memiliki ketelitian', '2024-06-11 08:59:33', '2024-07-01 21:38:34'),
(20, 3, 'Kemampuan komunikasi baik', '2024-06-11 08:59:45', '2024-07-01 21:38:59'),
(26, 4, 'Deskripsi Pekerjaan:', '2024-06-12 07:36:16', '2024-07-01 21:41:00'),
(27, 4, '- Menangani keluhan dan pertanyaan pelanggan.', '2024-06-12 07:36:46', '2024-07-01 21:41:39'),
(28, 4, '- Memberikan informasi dan bantuan terkait layanan.', '2024-06-12 07:37:17', '2024-07-01 21:41:59'),
(29, 4, '- Memastikan kepuasan pelanggan melalui komunikasi efektif.', '2024-06-12 07:37:49', '2024-07-01 21:42:24'),
(30, 4, 'Kualifikasi:', '2024-06-12 07:38:10', '2024-07-01 21:42:42'),
(31, 4, '- Usia antara 22-30 tahun.', '2024-06-12 07:38:22', '2024-07-01 21:43:54'),
(32, 4, '- Pendidikan minimal SMA/SMK.', '2024-06-12 07:39:05', '2024-07-01 21:43:43'),
(33, 4, '- Pengalaman minimal 1 tahun di layanan pelanggan.', '2024-06-12 07:39:22', '2024-07-01 21:44:25'),
(34, 4, '- Memiliki komunikasi yang baik.', '2024-06-12 07:39:34', '2024-07-01 21:52:57'),
(35, 4, '- Kemampuan problem solving', '2024-06-12 07:39:48', '2024-07-01 21:55:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'rizal firdaus', 'zal@gmail.com', NULL, '$2y$12$Hbfz77PJfjMMhcEj5x.vS.TtrA56ia7b9E0kdJlZxrVPXgHEFBMRi', 'pemilik', NULL, '2024-02-28 15:17:43', '2024-02-28 15:17:43'),
(2, 'rena', 'rena@gmail.com', NULL, '$2y$12$gV7uaxMiKUGLxi8lz1Koteqxh2NB8JYxOV9THODdq1Vgxc3rw9so.', 'HRD', NULL, '2024-02-28 15:18:47', '2024-02-28 15:18:47'),
(5, 'asep', 'asep@gmail.com', NULL, '$2y$12$x.ISs0DgKYGz9A4wJNcxEeXjZ46tN86OX.98wdOzEirD9H4RC58Za', 'pelamar', NULL, '2024-05-17 00:09:21', '2024-05-17 00:09:21'),
(6, 'dias', 'dias@gmail.com', NULL, '$2y$12$xHTwAovZpmQZYisL8vxUWu4XHkRrczY6//ZKmTZFn1T4yyjx0qpve', 'pemilik', NULL, '2024-06-12 08:56:09', '2024-06-12 08:56:09'),
(14, 'Dina Putri', 'dina.putri@gmail.com', NULL, '$2y$12$IPEQhKdZgE7HzZmVu4xRS.1xhAavRQ1A6L7lmm9/zjyb/1na8KVRW', 'pelamar', NULL, '2024-07-02 07:58:48', '2024-07-02 07:58:48'),
(15, 'Sari Wulandari', 'sari.wulandari@example.com', NULL, '$2y$12$zRSUVHFiYsuLlil7vNAVFufQUQn7qFGYs9F/XrXGQV5kFD5hR0.yq', 'pelamar', NULL, '2024-07-02 11:06:13', '2024-07-02 11:06:13'),
(16, 'Rini Anggraeni', 'rini.anggraeni@gmail.com', NULL, '$2y$12$t3Mm.gcVCb03XE2s8TbzAOFFTJK3sK7/ZyrLDTQNqXNp6MLnFI7g6', 'pelamar', NULL, '2024-07-02 11:19:32', '2024-07-02 11:19:32'),
(17, 'Ahmad Fikri', 'ahmad.fikri@gmail.com', NULL, '$2y$12$ktQMtOA61kW06MHNs.iAg.6UlYHxQkIAZ/QruifAQITwauj/zdeFi', 'pelamar', NULL, '2024-07-02 11:25:39', '2024-07-02 11:25:39'),
(18, 'Budi Santoso', 'budi.santoso@gmail.com', NULL, '$2y$12$z/VWxpRowrAnQkcEOTfTn.IeugG7OYpWnji/qa3sl6jpPoYA6tQum', 'pelamar', NULL, '2024-07-02 11:33:39', '2024-07-02 11:33:39'),
(19, 'agus', 'agus@gmail.com', NULL, '$2y$12$4tJBecD9SMcNdPzGp22eZuQyNnUPHR1.E1fq8oPq6F46mpyIlX34q', 'pemilik', NULL, '2024-07-02 12:17:20', '2024-07-02 12:17:20'),
(20, 'javier', 'javier@gmail.com', NULL, '$2y$12$x8uSlMw1EPiO7HANBaSfkOtH5C1G7Caz2GHQfPX7U2eH72g.Pz9g6', 'pelamar', NULL, '2024-07-05 06:45:41', '2024-07-05 06:45:41'),
(21, 'Aditya Nugraha', 'aditya.nugraha@gmail.com', NULL, '$2y$12$hCd.QPsvhsMp7RRLo0MKf.uwaletkgFck.yuY5s8Uco8t3b73xy1O', 'pelamar', NULL, '2024-07-08 08:33:51', '2024-07-08 08:33:51'),
(22, 'Rina Puspitasari', 'rina.puspita@gmail.com', NULL, '$2y$12$d.korwBfCiSTrI5qYsixwOxtguaqZhmlMXNtRn78ZWYmybGyjdify', 'pelamar', NULL, '2024-07-08 14:08:39', '2024-07-08 14:08:39'),
(23, 'Deni Kusuma Lintang', 'denikusuma@gmail.com', NULL, '$2y$12$itvLEUJ/H31bDTpimyUKC.VkewLyC1ZeZGbtbii9jQRU.CyBjX4Hq', 'pelamar', NULL, '2024-07-08 14:14:54', '2024-07-08 14:14:54'),
(24, 'Nita Pratiwi Larasati', 'nitapratiwis@example.com', NULL, '$2y$12$gTVAoh0kGCavYt8Vmv9FVeYKh59mZvZ25/4yHo4OtyGZmPmlnrokq', 'pelamar', NULL, '2024-07-08 14:30:01', '2024-07-08 14:30:01'),
(25, 'Susanti Dewi Pritiwi', 'susanti@gmail.com', NULL, '$2y$12$55ChCZ167I1NjwNxxzRriuVQ6ljSVb.BYfnBR5XehZnt9ruw1lUeK', 'pelamar', NULL, '2024-07-08 14:35:48', '2024-07-08 14:35:48'),
(26, 'babi', 'babi@gmail.com', NULL, '$2y$12$4ottaKGFqpxgmtVj3GXkyO6kL/NKqlwMjIOdmmEFT.aMBo9xqjcO.', 'pelamar', NULL, '2024-07-23 12:10:02', '2024-07-23 12:10:02');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bobot_gap`
--
ALTER TABLE `bobot_gap`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lamar`
--
ALTER TABLE `lamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `nilai_isi`
--
ALTER TABLE `nilai_isi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `syarat_loker`
--
ALTER TABLE `syarat_loker`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bobot_gap`
--
ALTER TABLE `bobot_gap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `hasil_akhir`
--
ALTER TABLE `hasil_akhir`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `lamar`
--
ALTER TABLE `lamar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `lowongan`
--
ALTER TABLE `lowongan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `nilai_isi`
--
ALTER TABLE `nilai_isi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT untuk tabel `pelamar`
--
ALTER TABLE `pelamar`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sub_kriteria`
--
ALTER TABLE `sub_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `syarat_loker`
--
ALTER TABLE `syarat_loker`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
