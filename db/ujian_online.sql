-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Mar 10, 2025 at 03:01 AM
-- Server version: 9.2.0
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ujian_online`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'ccit.itech01@gmail.com', '$2y$12$iPEAaYBgnBFn23gMf/UZruPk6RKj9eVt5EcTle6oowYDMJIGtpy/C', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lomba`
--

CREATE TABLE `lomba` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_lomba` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('not_started','in_progress','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'not_started',
  `deskripsi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `harga_pendaftaran` decimal(10,2) NOT NULL DEFAULT '0.00',
  `waktu_lomba` timestamp NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `durasi` int NOT NULL DEFAULT '60' COMMENT 'Durasi lomba dalam menit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lomba`
--

INSERT INTO `lomba` (`id`, `nama_lomba`, `status`, `deskripsi`, `gambar`, `harga_pendaftaran`, `waktu_lomba`, `created_at`, `updated_at`, `durasi`) VALUES
('35b7729b-740b-4a81-af4e-6bf37dbeba37', 'Lomba Fisika', 'completed', 'Lomba Fisika', 'gambar-lomba/o9RaUhc0tvDvJUBHH1QsIb02SeiioDhW0hR5s1Ew.jpg', 50000.00, '2025-03-09 16:00:00', '2025-03-09 14:28:11', '2025-03-09 17:00:39', 60);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_26_063810_add_registration_fields_to_users_table', 1),
(5, '2024_12_22_180952_create_admins_table', 1),
(6, '2024_12_22_181107_add_type_to_users_table', 1),
(7, '2024_12_23_131020_create_lomba_table', 1),
(8, '2024_12_23_134453_add_harga_pendaftaran_to_lomba_table', 1),
(9, '2024_12_24_041632_create_pendaftaran_lomba_table', 1),
(10, '2024_12_24_140846_create_soal_table', 1),
(11, '2024_12_27_112120_add_status_to_lomba_table', 1),
(12, '2025_02_27_224628_room_tes', 1),
(13, '2025_03_06_102926_add_durasi_to_lomba_table', 1),
(14, '2025_03_10_001647_create_sertifikats_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pendaftaran_lomba`
--

CREATE TABLE `pendaftaran_lomba` (
  `id` bigint UNSIGNED NOT NULL,
  `id_lomba` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_siswa` bigint UNSIGNED NOT NULL,
  `bukti_transfer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_transfer` date DEFAULT NULL,
  `status` enum('verified','unverified','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unverified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran_lomba`
--

INSERT INTO `pendaftaran_lomba` (`id`, `id_lomba`, `id_siswa`, `bukti_transfer`, `tanggal_transfer`, `status`, `created_at`, `updated_at`) VALUES
(1, '35b7729b-740b-4a81-af4e-6bf37dbeba37', 1, 'bukti-transfer/OllH7WkqQ4iC9TjD5zpiSzJ4bbk2W88i263fijAw.jpg', '2025-03-09', 'verified', '2025-03-09 14:34:45', '2025-03-09 14:35:13'),
(2, '35b7729b-740b-4a81-af4e-6bf37dbeba37', 2, 'bukti-transfer/8omSVBSCq8R39ZH3ri7lN9EZL9gTquOeb4Ntafbx.jpg', '2025-03-09', 'verified', '2025-03-09 15:02:37', '2025-03-09 15:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `room_tes`
--

CREATE TABLE `room_tes` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_lomba` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_siswa` bigint UNSIGNED NOT NULL,
  `nama_room` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `durasi` int DEFAULT NULL COMMENT 'Durasi dalam menit',
  `status` enum('draft','selesai') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `soal_terjawab` json DEFAULT NULL,
  `nilai` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `room_tes`
--

INSERT INTO `room_tes` (`id`, `id_lomba`, `id_siswa`, `nama_room`, `waktu_selesai`, `durasi`, `status`, `soal_terjawab`, `nilai`, `created_at`, `updated_at`) VALUES
('c05d8daf-bc80-4015-9b0d-88394b742634', '35b7729b-740b-4a81-af4e-6bf37dbeba37', 2, 'Room Tes - Lomba Fisika', '2025-03-09 17:00:39', 60, 'selesai', '[{\"id\": \"e7da29f5-8813-466e-ba65-7c7ffcdfd768\", \"pertanyaan\": \"<p>1+4</p>\", \"jawaban_di_pilih\": \"<p>5</p>\"}, {\"id\": \"363231ac-9c87-43e9-94f1-cdd9c46b72bb\", \"pertanyaan\": \"<p>1+10</p>\", \"jawaban_di_pilih\": \"<p>11</p>\"}, {\"id\": \"bce9b69d-ae4a-4c24-948d-17bc4dc8a069\", \"pertanyaan\": \"<p>2x4</p>\", \"jawaban_di_pilih\": \"<p>8</p>\"}, {\"id\": \"00168d93-6119-4a79-89a3-1ea6ee5dca54\", \"pertanyaan\": \"<p>4+4</p>\", \"jawaban_di_pilih\": \"<p>7</p>\"}]', 3, '2025-03-09 15:03:28', '2025-03-09 17:00:39'),
('d747bc98-c458-405f-bb19-9083f64d6930', '35b7729b-740b-4a81-af4e-6bf37dbeba37', 1, 'Room Tes - Lomba Fisika', '2025-03-09 17:00:39', 60, 'selesai', '[{\"id\": \"e7da29f5-8813-466e-ba65-7c7ffcdfd768\", \"pertanyaan\": \"<p>1+4</p>\", \"jawaban_di_pilih\": \"<p>5</p>\"}, {\"id\": \"363231ac-9c87-43e9-94f1-cdd9c46b72bb\", \"pertanyaan\": \"<p>1+10</p>\", \"jawaban_di_pilih\": \"<p>11</p>\"}]', 2, '2025-03-09 14:38:03', '2025-03-09 17:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `sertifikats`
--

CREATE TABLE `sertifikats` (
  `id` bigint UNSIGNED NOT NULL,
  `id_lomba` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_room` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_siswa` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nilai` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sertifikats`
--

INSERT INTO `sertifikats` (`id`, `id_lomba`, `id_room`, `id_siswa`, `nilai`, `created_at`, `updated_at`) VALUES
(3, '35b7729b-740b-4a81-af4e-6bf37dbeba37', 'c05d8daf-bc80-4015-9b0d-88394b742634', '2', 3, '2025-03-09 18:07:19', '2025-03-09 18:07:19'),
(4, '35b7729b-740b-4a81-af4e-6bf37dbeba37', 'd747bc98-c458-405f-bb19-9083f64d6930', '1', 2, '2025-03-09 18:07:19', '2025-03-09 18:07:19');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Ao77uMnQ0CI5rwHuLOD9aEfpKCKXhmVZyA8wBrtP', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiR04xRExEdWo5TFVqbzRSTkNISWVWazlOcm5FWm5SOHZ4R3B1cHZiWSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozNDoiaHR0cDovL2xvY2FsaG9zdDo4MDAwL2RhZnRhci1sb21iYSI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjI3OiJodHRwOi8vbG9jYWxob3N0OjgwMDAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1741573899),
('h9AWeeByNJNFsPHP5hUqFB5L4lpacSr8XJ0TUsoF', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVTU5a3puS3J1cDc1eEE2WndobnpXelFLek5TZlRwNUFrUlpjSE5mYSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9kYWZ0YXItbG9tYmEiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO30=', 1741545986);

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_lomba` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `soal` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `soal`
--

INSERT INTO `soal` (`id`, `id_lomba`, `soal`, `created_at`, `updated_at`) VALUES
('99277e2a-bd4e-46f3-915a-945e4400f7e7', '35b7729b-740b-4a81-af4e-6bf37dbeba37', '[{\"id\": \"e7da29f5-8813-466e-ba65-7c7ffcdfd768\", \"jawaban\": [\"<p>2</p>\", \"<p>3</p>\", \"<p>5</p>\", \"<p>6</p>\"], \"pertanyaan\": \"<p>1+4</p>\", \"jawaban_yang_benar\": \"<p>5</p>\"}, {\"id\": \"bce9b69d-ae4a-4c24-948d-17bc4dc8a069\", \"jawaban\": [\"<p>8</p>\", \"<p>6</p>\", \"<p>2</p>\", \"<p>4</p>\"], \"pertanyaan\": \"<p>2x4</p>\", \"jawaban_yang_benar\": \"<p>8</p>\"}, {\"id\": \"363231ac-9c87-43e9-94f1-cdd9c46b72bb\", \"jawaban\": [\"<p>12</p>\", \"<p>11</p>\", \"<p>13</p>\", \"<p>14</p>\"], \"pertanyaan\": \"<p>1+10</p>\", \"jawaban_yang_benar\": \"<p>11</p>\"}, {\"id\": \"00168d93-6119-4a79-89a3-1ea6ee5dca54\", \"jawaban\": [\"<p>10</p>\", \"<p>9</p>\", \"<p>7</p>\", \"<p>8</p>\"], \"pertanyaan\": \"<p>4+4</p>\", \"jawaban_yang_benar\": \"<p>8</p>\"}]', '2025-03-09 14:44:28', '2025-03-09 14:46:22');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `jenis_kelamin` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci,
  `sekolah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'siswa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `sekolah`, `kelas`, `type`) VALUES
(1, 'Jono', 'ugiispoyo@gmail.com', NULL, '$2y$12$JDRhOSSpQ2Lt7uRsv.KPXODhItGti9IT6hrqGiE7VMpQ4gzgGxq/6', NULL, '2025-03-09 14:30:32', '2025-03-09 14:30:32', 'Laki-laki', '2014-08-20', 'Depok', 'SMPN 2 Depok', '9', 'siswa'),
(2, 'Dono', 'ugi.ispoyowidodo@gmail.com', NULL, '$2y$12$ZqJXfhuniDw79iMWChCQ6OeeyJor11UBF6nlL8nNLIGKVZKaX2Jau', NULL, '2025-03-09 15:02:09', '2025-03-09 15:02:09', 'Laki-laki', '2010-09-08', 'Depok', 'SMPN 1 Depok', '9', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lomba`
--
ALTER TABLE `lomba`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `pendaftaran_lomba`
--
ALTER TABLE `pendaftaran_lomba`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pendaftaran_lomba_id_lomba_foreign` (`id_lomba`),
  ADD KEY `pendaftaran_lomba_id_siswa_foreign` (`id_siswa`);

--
-- Indexes for table `room_tes`
--
ALTER TABLE `room_tes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_tes_id_lomba_foreign` (`id_lomba`),
  ADD KEY `room_tes_id_siswa_foreign` (`id_siswa`);

--
-- Indexes for table `sertifikats`
--
ALTER TABLE `sertifikats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `soal_id_lomba_foreign` (`id_lomba`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `pendaftaran_lomba`
--
ALTER TABLE `pendaftaran_lomba`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sertifikats`
--
ALTER TABLE `sertifikats`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pendaftaran_lomba`
--
ALTER TABLE `pendaftaran_lomba`
  ADD CONSTRAINT `pendaftaran_lomba_id_lomba_foreign` FOREIGN KEY (`id_lomba`) REFERENCES `lomba` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pendaftaran_lomba_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `room_tes`
--
ALTER TABLE `room_tes`
  ADD CONSTRAINT `room_tes_id_lomba_foreign` FOREIGN KEY (`id_lomba`) REFERENCES `lomba` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `room_tes_id_siswa_foreign` FOREIGN KEY (`id_siswa`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_id_lomba_foreign` FOREIGN KEY (`id_lomba`) REFERENCES `lomba` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
