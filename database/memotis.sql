-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 19, 2023 at 02:31 PM
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
  `logo_text_konfigurasi_aplikasis` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `master_level_sistems`
--

CREATE TABLE `master_level_sistems` (
  `id_level_sistems` bigint(20) UNSIGNED NOT NULL,
  `nama_level_sistems` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
(11, '2023_07_19_122835_create_master_akses_table', 1);

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
-- Indexes for table `master_fiturs`
--
ALTER TABLE `master_fiturs`
  ADD PRIMARY KEY (`id_fiturs`),
  ADD KEY `master_fiturs_menus_id_index` (`menus_id`);

--
-- Indexes for table `master_konfigurasi_aplikasis`
--
ALTER TABLE `master_konfigurasi_aplikasis`
  ADD PRIMARY KEY (`id_konfigurasi_aplikasis`);

--
-- Indexes for table `master_level_sistems`
--
ALTER TABLE `master_level_sistems`
  ADD PRIMARY KEY (`id_level_sistems`);

--
-- Indexes for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD PRIMARY KEY (`id_menus`),
  ADD KEY `master_menus_menus_id_index` (`menus_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_akses` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_fiturs`
--
ALTER TABLE `master_fiturs`
  MODIFY `id_fiturs` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_konfigurasi_aplikasis`
--
ALTER TABLE `master_konfigurasi_aplikasis`
  MODIFY `id_konfigurasi_aplikasis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_level_sistems`
--
ALTER TABLE `master_level_sistems`
  MODIFY `id_level_sistems` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `master_menus`
--
ALTER TABLE `master_menus`
  MODIFY `id_menus` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

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
-- Constraints for table `master_menus`
--
ALTER TABLE `master_menus`
  ADD CONSTRAINT `master_menus_menus_id_foreign` FOREIGN KEY (`menus_id`) REFERENCES `master_menus` (`id_menus`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_level_sistems_id_foreign` FOREIGN KEY (`level_sistems_id`) REFERENCES `master_level_sistems` (`id_level_sistems`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
