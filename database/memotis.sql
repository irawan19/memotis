-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 21, 2023 at 11:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `memotis`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `master_akses`
--

CREATE TABLE `master_akses` (
  `id_akses` bigint(20) UNSIGNED NOT NULL,
  `level_sistems_id` bigint(20) UNSIGNED NOT NULL,
  `fiturs_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_akses`
--

INSERT INTO `master_akses` (`id_akses`, `level_sistems_id`, `fiturs_id`, `created_at`, `updated_at`) VALUES
(98, 1, 49, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(99, 1, 51, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(100, 1, 50, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(101, 1, 52, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(102, 1, 53, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(103, 1, 54, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(104, 1, 43, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(105, 1, 45, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(106, 1, 44, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(107, 1, 46, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(108, 1, 47, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(109, 1, 48, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(110, 1, 18, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(111, 1, 19, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(112, 1, 20, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(113, 1, 21, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(114, 1, 22, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(115, 1, 23, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(116, 1, 24, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(117, 1, 25, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(118, 1, 26, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(119, 1, 27, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(120, 1, 28, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(121, 1, 29, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(122, 1, 30, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(123, 1, 31, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(124, 1, 32, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(125, 1, 33, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(126, 1, 2, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(127, 1, 4, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(128, 1, 3, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(129, 1, 5, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(130, 1, 6, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(131, 1, 34, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(132, 1, 35, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(133, 1, 36, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(134, 1, 37, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(135, 1, 7, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(136, 1, 9, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(137, 1, 8, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(138, 1, 10, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(139, 1, 11, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(140, 1, 12, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(141, 1, 14, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(142, 1, 13, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(143, 1, 15, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(144, 1, 16, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(145, 1, 55, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(146, 1, 56, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(147, 1, 57, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(148, 1, 58, '2023-07-21 05:39:58', '2023-07-21 05:39:58'),
(149, 1, 17, '2023-07-21 05:39:58', '2023-07-21 05:39:58');

-- --------------------------------------------------------

--
-- Table structure for table `master_derajat_surats`
--

CREATE TABLE `master_derajat_surats` (
  `id_derajat_surats` bigint(20) UNSIGNED NOT NULL,
  `nama_derajat_surats` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_derajat_surats`
--

INSERT INTO `master_derajat_surats` (`id_derajat_surats`, `nama_derajat_surats`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biasa', '2023-07-20 05:40:22', NULL, NULL),
(2, 'Segera', '2023-07-20 05:40:26', NULL, NULL),
(3, 'Sangat Segera', '2023-07-20 05:40:29', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_disposisi_surats`
--

CREATE TABLE `master_disposisi_surats` (
  `id_disposisi_surats` bigint(20) UNSIGNED NOT NULL,
  `nama_disposisi_surats` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_disposisi_surats`
--

INSERT INTO `master_disposisi_surats` (`id_disposisi_surats`, `nama_disposisi_surats`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Untuk Diketahui/digunakan', '2023-07-20 05:38:55', NULL, NULL),
(2, 'Untuk Arsip/file', '2023-07-20 05:39:01', NULL, NULL),
(3, 'Minta Saran/pertimbangan', '2023-07-20 05:39:14', NULL, NULL),
(4, 'Siapkan Bahan', '2023-07-20 05:39:18', NULL, NULL),
(5, 'Harap Selesaikan/ditindaklanjuti', '2023-07-20 05:39:26', NULL, NULL),
(6, 'Harap Mewakili/hadiri/tugaskan staff', '2023-07-20 05:39:38', NULL, NULL),
(7, 'Selesaikan sesuai disposisi pimpinan', '2023-07-20 05:39:47', NULL, NULL),
(8, 'Jadwalkan/agendakan', '2023-07-20 05:39:54', NULL, NULL),
(9, 'Koordinasikan Dengan Es. 1 terkait', '2023-07-20 05:40:05', NULL, NULL),
(10, 'Hadir Bersama', '2023-07-20 05:40:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_divisis`
--

CREATE TABLE `master_divisis` (
  `id_divisis` bigint(20) UNSIGNED NOT NULL,
  `nama_divisis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_divisis`
--

INSERT INTO `master_divisis` (`id_divisis`, `nama_divisis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Direktur Utama', '2023-07-20 06:02:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_fiturs`
--

CREATE TABLE `master_fiturs` (
  `id_fiturs` bigint(20) UNSIGNED NOT NULL,
  `menus_id` bigint(20) UNSIGNED NOT NULL,
  `nama_fiturs` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_fiturs`
--

INSERT INTO `master_fiturs` (`id_fiturs`, `menus_id`, `nama_fiturs`, `created_at`, `updated_at`) VALUES
(1, 1, 'lihat', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(2, 2, 'lihat', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(3, 2, 'tambah', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(4, 2, 'baca', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(5, 2, 'edit', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(6, 2, 'hapus', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(7, 3, 'lihat', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(8, 3, 'tambah', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(9, 3, 'baca', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(10, 3, 'edit', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(11, 3, 'hapus', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(12, 4, 'lihat', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(13, 4, 'tambah', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(14, 4, 'baca', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(15, 4, 'edit', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(16, 4, 'hapus', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(17, 5, 'lihat', '2022-08-06 20:52:45', '2022-08-06 20:52:45'),
(18, 8, 'lihat', NULL, NULL),
(19, 8, 'tambah', NULL, NULL),
(20, 8, 'edit', NULL, NULL),
(21, 8, 'hapus', NULL, NULL),
(22, 9, 'lihat', NULL, NULL),
(23, 9, 'tambah', NULL, NULL),
(24, 9, 'edit', NULL, NULL),
(25, 9, 'hapus', NULL, NULL),
(26, 10, 'lihat', NULL, NULL),
(27, 10, 'tambah', NULL, NULL),
(28, 10, 'edit', NULL, NULL),
(29, 10, 'hapus', NULL, NULL),
(30, 11, 'lihat', NULL, NULL),
(31, 11, 'tambah', NULL, NULL),
(32, 11, 'edit', NULL, NULL),
(33, 11, 'hapus', NULL, NULL),
(34, 12, 'lihat', NULL, NULL),
(35, 12, 'tambah', NULL, NULL),
(36, 12, 'edit', NULL, NULL),
(37, 12, 'hapus', NULL, NULL),
(43, 14, 'lihat', NULL, NULL),
(44, 14, 'tambah', NULL, NULL),
(45, 14, 'baca', NULL, NULL),
(46, 14, 'edit', NULL, NULL),
(47, 14, 'hapus', NULL, NULL),
(48, 14, 'cetak', NULL, NULL),
(49, 13, 'lihat', NULL, '2023-07-21 04:34:51'),
(50, 13, 'tambah', NULL, '2023-07-21 04:34:51'),
(51, 13, 'baca', NULL, '2023-07-21 04:34:51'),
(52, 13, 'edit', NULL, '2023-07-21 04:34:51'),
(53, 13, 'hapus', NULL, '2023-07-21 04:34:51'),
(54, 13, 'cetak', NULL, '2023-07-21 04:34:51'),
(55, 15, 'lihat', NULL, NULL),
(56, 15, 'tambah', NULL, NULL),
(57, 15, 'edit', NULL, NULL),
(58, 15, 'hapus', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_klasifikasi_surats`
--

CREATE TABLE `master_klasifikasi_surats` (
  `id_klasifikasi_surats` bigint(20) UNSIGNED NOT NULL,
  `nama_klasifikasi_surats` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_klasifikasi_surats`
--

INSERT INTO `master_klasifikasi_surats` (`id_klasifikasi_surats`, `nama_klasifikasi_surats`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Surat Kuasa', '2023-07-20 05:37:14', NULL, NULL),
(2, 'Surat Tugas', '2023-07-20 05:37:23', NULL, NULL),
(3, 'Surat Edaran', '2023-07-20 05:37:26', NULL, NULL),
(4, 'Surat Keterangan', '2023-07-20 05:37:31', NULL, NULL),
(5, 'Surat Peringatan', '2023-07-20 05:37:37', NULL, NULL),
(6, 'Surat Perjanjian', '2023-07-20 05:37:42', NULL, NULL),
(7, 'Surat Undangan', '2023-07-20 05:37:46', NULL, NULL),
(8, 'Nota Dinas', '2023-07-20 05:37:51', NULL, NULL),
(9, 'Surat Lain-Lain', '2023-07-20 05:38:03', NULL, NULL),
(10, 'Draft Pembahasan', '2023-07-20 05:38:08', NULL, NULL),
(11, 'Surat Keputusan', '2023-07-20 05:38:12', NULL, NULL),
(12, 'Laporan', '2023-07-20 05:38:17', NULL, NULL),
(13, 'Surat Rahasia', '2023-07-20 05:38:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_konfigurasi_aplikasis`
--

CREATE TABLE `master_konfigurasi_aplikasis` (
  `id_konfigurasi_aplikasis` bigint(20) UNSIGNED NOT NULL,
  `nama_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `email_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `telepon_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `deskripsi_konfigurasi_aplikasis` longtext NOT NULL,
  `keywords_konfigurasi_aplikasis` longtext NOT NULL,
  `icon_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `logo_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `logo_text_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `background_website_konfigurasi_aplikasis` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_konfigurasi_aplikasis`
--

INSERT INTO `master_konfigurasi_aplikasis` (`id_konfigurasi_aplikasis`, `nama_konfigurasi_aplikasis`, `email_konfigurasi_aplikasis`, `telepon_konfigurasi_aplikasis`, `deskripsi_konfigurasi_aplikasis`, `keywords_konfigurasi_aplikasis`, `icon_konfigurasi_aplikasis`, `logo_konfigurasi_aplikasis`, `logo_text_konfigurasi_aplikasis`, `background_website_konfigurasi_aplikasis`, `created_at`, `updated_at`) VALUES
(1, 'Memotis', 'info@memotis.com', '022-872-45817', 'Organize your entire life', 'memotis,agenda,eagenda,gys,graha,yasa,selaras,graha yasa selaras,laravel,app', 'logo/icon.png', 'logo/logo.png', 'logo/logotext.png', 'logo/2023072112480320230307232409bg.jpg', NULL, '2023-07-21 05:48:03');

-- --------------------------------------------------------

--
-- Table structure for table `master_level_sistems`
--

CREATE TABLE `master_level_sistems` (
  `id_level_sistems` bigint(20) UNSIGNED NOT NULL,
  `level_sistems_id` bigint(20) UNSIGNED DEFAULT NULL,
  `divisis_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_level_sistems` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_level_sistems`
--

INSERT INTO `master_level_sistems` (`id_level_sistems`, `level_sistems_id`, `divisis_id`, `nama_level_sistems`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, NULL, NULL, 'Developer', '2023-07-19 12:36:53', '2023-07-21 05:39:58', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_menus`
--

CREATE TABLE `master_menus` (
  `id_menus` bigint(20) UNSIGNED NOT NULL,
  `menus_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_menus` varchar(255) NOT NULL,
  `icon_menus` varchar(255) NOT NULL,
  `link_menus` varchar(255) NOT NULL,
  `order_menus` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_menus`
--

INSERT INTO `master_menus` (`id_menus`, `menus_id`, `nama_menus`, `icon_menus`, `link_menus`, `order_menus`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Konfigurasi', 'cil-settings', '', 3, '2022-08-06 20:52:45', '2023-07-20 02:36:50'),
(2, 1, 'Menu', 'cil-border-all', 'menu', 5, '2022-08-06 20:52:45', '2023-07-21 05:39:45'),
(3, 1, 'Level Sistem', 'cil-lan', 'level_sistem', 7, '2022-08-06 20:52:45', '2023-07-21 05:39:45'),
(4, 1, 'Admin', 'cil-user', 'admin', 8, '2022-08-06 20:52:45', '2023-07-21 05:39:45'),
(5, 1, 'Konfigurasi Aplikasi', 'cil-applications-settings', 'konfigurasi_aplikasi', 10, '2022-08-06 20:52:45', '2023-07-21 05:39:45'),
(6, NULL, 'Apps', 'cil-applications', '', 1, '2023-07-20 02:35:07', '2023-07-21 04:34:03'),
(8, 1, 'Klasifikasi Surat', 'cil-tag', 'klasifikasi_surat', 1, '2023-07-20 03:46:50', '2023-07-21 05:39:45'),
(9, 1, 'Disposisi Surat', 'cil-check', 'disposisi_surat', 2, '2023-07-20 03:47:24', '2023-07-21 05:39:45'),
(10, 1, 'Derajat Surat', 'cil-tags', 'derajat_surat', 3, '2023-07-20 03:47:44', '2023-07-21 05:39:45'),
(11, 1, 'Sifat Surat', 'cil-share-alt', 'sifat_surat', 4, '2023-07-20 03:48:04', '2023-07-21 05:39:45'),
(12, 1, 'Divisi', 'cil-asterisk-circle', 'divisi', 6, '2023-07-20 06:09:35', '2023-07-21 05:39:45'),
(13, 6, 'Surat', 'cil-envelope-open', 'surat', 1, '2023-07-21 04:34:27', '2023-07-21 04:34:51'),
(14, 6, 'MOM', 'cil-notes', 'mom', 2, '2023-07-21 04:34:47', '2023-07-21 04:34:47'),
(15, 1, 'Sosial Media', 'cil-share-all', 'sosial_media', 9, '2023-07-21 05:39:41', '2023-07-21 05:39:45');

-- --------------------------------------------------------

--
-- Table structure for table `master_sifat_surats`
--

CREATE TABLE `master_sifat_surats` (
  `id_sifat_surats` bigint(20) UNSIGNED NOT NULL,
  `nama_sifat_surats` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `master_sifat_surats`
--

INSERT INTO `master_sifat_surats` (`id_sifat_surats`, `nama_sifat_surats`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Biasa', '2023-07-20 05:40:41', NULL, NULL),
(2, 'Rahasia', '2023-07-20 05:40:46', NULL, NULL),
(3, 'Sangat Rahasia', '2023-07-20 05:40:53', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `master_sosial_medias`
--

CREATE TABLE `master_sosial_medias` (
  `id_sosial_medias` bigint(20) UNSIGNED NOT NULL,
  `icon_sosial_medias` varchar(255) NOT NULL,
  `nama_sosial_medias` varchar(255) NOT NULL,
  `url_sosial_medias` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_01_01_000000_create_master_level_sistems_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(4, '2014_10_12_200000_add_two_factor_columns_to_users_table', 1),
(5, '2019_08_19_000000_create_failed_jobs_table', 1),
(6, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(7, '2023_07_19_121759_create_sessions_table', 1),
(8, '2023_07_19_122751_create_master_konfigurasi_aplikasis_table', 1),
(9, '2023_07_19_122818_create_master_menus_table', 1),
(10, '2023_07_19_122824_create_master_fiturs_table', 1),
(11, '2023_07_19_122835_create_master_akses_table', 1),
(12, '2023_07_20_102220_create_master_klasifikasi_surats_table', 2),
(13, '2023_07_20_102241_create_master_disposisi_surats_table', 2),
(14, '2023_07_20_102302_create_master_derajat_surats_table', 2),
(15, '2023_07_20_102314_create_master_sifat_surats_table', 2),
(16, '2023_07_20_125405_create_master_divisis_table', 3),
(17, '2023_07_21_123504_create_master_sosial_media_table', 4),
(18, '2023_07_21_151451_create_moms_table', 5),
(19, '2023_07_21_160716_create_mom_users_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `moms`
--

CREATE TABLE `moms` (
  `id_moms` bigint(20) UNSIGNED NOT NULL,
  `judul_moms` varchar(255) NOT NULL,
  `tanggal_mulai_moms` datetime NOT NULL,
  `tanggal_selesai_moms` datetime NOT NULL,
  `venue_moms` varchar(255) NOT NULL,
  `deskripsi_moms` longtext NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mom_users`
--

CREATE TABLE `mom_users` (
  `id_mom_users` bigint(20) UNSIGNED NOT NULL,
  `moms_id` bigint(20) UNSIGNED DEFAULT NULL,
  `users_id` bigint(20) UNSIGNED DEFAULT NULL,
  `status_baca_mom_users` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H6LWg9NbgX1o9MptOZkt3a5sGPKZYeVBeNjrhGUh', 1, '::1', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/115.0.0.0 Safari/537.36', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoicHNnMTBabHNGUTNHZjNsT0hRdkJLbHJFVUJBZDN4TkZ3QjZmRUM1UyI7czozOiJ1cmwiO2E6MDp7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjEzMzoiaHR0cDovL2xvY2FsaG9zdC9tZW1vdGlzL3B1YmxpYy9kYXNoYm9hcmQvZXZlbnRjYWxlbmRhcj9lbmQ9MjAyMy0wOC0wN1QwMCUzQTAwJTNBMDAlMkIwNyUzQTAwJnN0YXJ0PTIwMjMtMDYtMjZUMDAlM0EwMCUzQTAwJTJCMDclM0EwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoyMToicGFzc3dvcmRfaGFzaF9zYW5jdHVtIjtzOjYwOiIkMnkkMTAkRVFTakllRXFnZXVtUDhMaDBrNWFJTzc4OEY4eDFaWk90MkJkMkpRcVFQV2c3VUNySy9ybkMiO3M6NzoiaGFsYW1hbiI7czo0NjoiaHR0cDovL2xvY2FsaG9zdC9tZW1vdGlzL3B1YmxpYy9kYXNoYm9hcmQvbWVudSI7fQ==', 1689930103);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `level_sistems_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint(20) UNSIGNED DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `level_sistems_id`, `username`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `remember_token`, `current_team_id`, `profile_photo_path`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'developer', 'Developer', 'developer@memotis.com', NULL, '$2y$10$EQSjIeEqgeumP8Lh0k5aIO788F8x1ZZOt2Bd2JQqQPWg7UCrK/rnC', NULL, NULL, NULL, 'GABGsMSCq1dWGldUam99ZbS9Q3XLF93Mfq6qlUYuthcUY5tWS3REsWCseO7Z', NULL, NULL, '2023-07-19 12:37:07', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `master_akses`
--
ALTER TABLE `master_akses`
  ADD PRIMARY KEY (`id_akses`),
  ADD KEY `master_akses_level_sistems_id_index` (`level_sistems_id`),
  ADD KEY `master_akses_fiturs_id_index` (`fiturs_id`);

--
-- Indexes for table `master_derajat_surats`
--
ALTER TABLE `master_derajat_surats`
  ADD PRIMARY KEY (`id_derajat_surats`);

--
-- Indexes for table `master_disposisi_surats`
--
ALTER TABLE `master_disposisi_surats`
  ADD PRIMARY KEY (`id_disposisi_surats`);

--
-- Indexes for table `master_divisis`
--
ALTER TABLE `master_divisis`
  ADD PRIMARY KEY (`id_divisis`);

--
-- Indexes for table `master_fiturs`
--
ALTER TABLE `master_fiturs`
  ADD PRIMARY KEY (`id_fiturs`),
  ADD KEY `master_fiturs_menus_id_index` (`menus_id`);

--
-- Indexes for table `master_klasifikasi_surats`
--
ALTER TABLE `master_klasifikasi_surats`
  ADD PRIMARY KEY (`id_klasifikasi_surats`);

--
-- Indexes for table `master_konfigurasi_aplikasis`
--
ALTER TABLE `master_konfigurasi_aplikasis`
  ADD PRIMARY KEY (`id_konfigurasi_aplikasis`);

--
-- Indexes for table `master_level_sistems`
--
ALTER TABLE `master_level_sistems`
  ADD PRIMARY KEY (`id_level_sistems`),
  ADD KEY `master_level_sistems_level_sistems_id_index` (`level_sistems_id`) USING BTREE,
  ADD KEY `master_level_sistems_divisis_id_index` (`divisis_id`) USING BTREE;

--
-- Indexes for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD PRIMARY KEY (`id_menus`),
  ADD KEY `master_menus_menus_id_index` (`menus_id`);

--
-- Indexes for table `master_sifat_surats`
--
ALTER TABLE `master_sifat_surats`
  ADD PRIMARY KEY (`id_sifat_surats`);

--
-- Indexes for table `master_sosial_medias`
--
ALTER TABLE `master_sosial_medias`
  ADD PRIMARY KEY (`id_sosial_medias`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `moms`
--
ALTER TABLE `moms`
  ADD PRIMARY KEY (`id_moms`);

--
-- Indexes for table `mom_users`
--
ALTER TABLE `mom_users`
  ADD PRIMARY KEY (`id_mom_users`),
  ADD KEY `mom_users_moms_id_index` (`moms_id`),
  ADD KEY `mom_users_users_id_index` (`users_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_level_sistems_id_index` (`level_sistems_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_akses`
--
ALTER TABLE `master_akses`
  MODIFY `id_akses` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT for table `master_derajat_surats`
--
ALTER TABLE `master_derajat_surats`
  MODIFY `id_derajat_surats` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_disposisi_surats`
--
ALTER TABLE `master_disposisi_surats`
  MODIFY `id_disposisi_surats` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `master_divisis`
--
ALTER TABLE `master_divisis`
  MODIFY `id_divisis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_fiturs`
--
ALTER TABLE `master_fiturs`
  MODIFY `id_fiturs` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `master_klasifikasi_surats`
--
ALTER TABLE `master_klasifikasi_surats`
  MODIFY `id_klasifikasi_surats` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `master_konfigurasi_aplikasis`
--
ALTER TABLE `master_konfigurasi_aplikasis`
  MODIFY `id_konfigurasi_aplikasis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_level_sistems`
--
ALTER TABLE `master_level_sistems`
  MODIFY `id_level_sistems` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `master_menus`
--
ALTER TABLE `master_menus`
  MODIFY `id_menus` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `master_sifat_surats`
--
ALTER TABLE `master_sifat_surats`
  MODIFY `id_sifat_surats` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `master_sosial_medias`
--
ALTER TABLE `master_sosial_medias`
  MODIFY `id_sosial_medias` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `moms`
--
ALTER TABLE `moms`
  MODIFY `id_moms` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mom_users`
--
ALTER TABLE `mom_users`
  MODIFY `id_mom_users` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `master_akses`
--
ALTER TABLE `master_akses`
  ADD CONSTRAINT `master_akses_fiturs_id_foreign` FOREIGN KEY (`fiturs_id`) REFERENCES `master_fiturs` (`id_fiturs`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `master_akses_level_sistems_id_foreign` FOREIGN KEY (`level_sistems_id`) REFERENCES `master_level_sistems` (`id_level_sistems`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_fiturs`
--
ALTER TABLE `master_fiturs`
  ADD CONSTRAINT `master_fiturs_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `master_menus` (`id_menus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_level_sistems`
--
ALTER TABLE `master_level_sistems`
  ADD CONSTRAINT `master_level_sistems_divisis_id_foreign` FOREIGN KEY (`divisis_id`) REFERENCES `master_divisis` (`id_divisis`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `master_level_sistems_level_sistems_id_foreign` FOREIGN KEY (`level_sistems_id`) REFERENCES `master_level_sistems` (`id_level_sistems`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD CONSTRAINT `master_menus_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `master_menus` (`id_menus`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `mom_users`
--
ALTER TABLE `mom_users`
  ADD CONSTRAINT `mom_users_moms_id_foreign` FOREIGN KEY (`moms_id`) REFERENCES `moms` (`id_moms`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `mom_users_users_id_foreign` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_level_sistems_id_foreign` FOREIGN KEY (`level_sistems_id`) REFERENCES `master_level_sistems` (`id_level_sistems`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
