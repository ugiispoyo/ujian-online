-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql:3306
-- Generation Time: Dec 30, 2024 at 05:33 AM
-- Server version: 9.0.0
-- PHP Version: 8.2.8

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
(1, 'Super Admin', 'admin@example.com', '$2y$12$ll9K48j1CXHBuimyVNvMuuhh56hzHVTnwcr9QBvf3pGHjBH1lQ7KG', NULL, NULL);

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
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lomba`
--

INSERT INTO `lomba` (`id`, `nama_lomba`, `status`, `deskripsi`, `gambar`, `harga_pendaftaran`, `waktu_lomba`, `created_at`, `updated_at`) VALUES
('dbe85e8d-d5f6-470d-92d7-c2d02acbd249', 'Lomba bahasa inggris', 'not_started', 'Lomba ini untuk anak SD Kelas 5', 'gambar-lomba/AWZPwn1hYwrDrxNjMXNK4aPgWabKOldOd84XXFwj.png', 50000.00, '2025-01-11 10:00:00', '2024-12-24 05:12:09', '2024-12-30 10:58:53'),
('e7f10f4f-2503-40f1-80c4-22f6b30bc299', 'Lomba MTK SD Kelas 3', 'not_started', 'Ini untuk kelas 3 SD', 'gambar-lomba/WH2J19u6Sd8guhhh0QdSFurDZj3PFHlzYwEkUInQ.png', 50000.00, '2025-01-10 14:00:00', '2024-12-24 14:00:54', '2024-12-24 14:00:54');

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
(10, '2024_12_24_140846_create_soal_table', 2),
(11, '2024_12_27_112120_add_status_to_lomba_table', 3);

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
  `status` enum('verified','unverified','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'unverified',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pendaftaran_lomba`
--

INSERT INTO `pendaftaran_lomba` (`id`, `id_lomba`, `id_siswa`, `bukti_transfer`, `tanggal_transfer`, `status`, `created_at`, `updated_at`) VALUES
(2, 'dbe85e8d-d5f6-470d-92d7-c2d02acbd249', 1, 'bukti-transfer/EyPSKaVZ6mJEkAAMw5aUh6nZKzhVJGaz8s7qp6Zc.jpg', '2024-08-19', 'verified', '2024-12-24 13:02:41', '2024-12-24 13:14:01'),
(3, 'dbe85e8d-d5f6-470d-92d7-c2d02acbd249', 2, 'bukti-transfer/sBf2QCMDcuPmCxZtB1QcGJeGxQy0mUJf97pAjOsm.jpg', '2024-12-19', 'verified', '2024-12-27 09:37:40', '2024-12-30 11:12:18'),
(4, 'dbe85e8d-d5f6-470d-92d7-c2d02acbd249', 4, 'bukti-transfer/RXvpy5WkvZT6SPCimYnZPeDVjj2dB5ZrWxGXANVF.jpg', '2024-12-30', 'verified', '2024-12-30 11:00:36', '2024-12-30 11:08:14');

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
('20SoIih04R66yBk4qUa9ag6LuIxwlnjKm1WcZvCM', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/27.0 Chrome/125.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZlhJUHJXWVRXeHJ3bUdqTHhleWtaTlU1VXVNdnliZ1RVRURnUkVJZiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735530414),
('5SA5K738Z0hHRE2ZO4q9z8HszJiOIgNGM8KTsu3e', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibk1aU0haN1MyaWU3SGtMSFBPSElFRllaTmJLUkExR0JORllJVzJONCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzk0ZTItMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vOTRlMi0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529650),
('60239JAZ3C7XPH1wuDrTG7AtzhCGh9dblToQwEnz', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVG9vQUQzdTMzNkYwRjQ1Y0k4Vk5CY2tPR21wV2ppOXVwZGNHdjJ5UCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735530396),
('6nq6GXLruyHfvpGJd5ugHM5UTcevQkUuLQeogzIW', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSkIyWXRIb2tmWUhnSm9jcWdDb0IyYjJ3aTVHMWdFWjJoRmFpTmpvVyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzI4OWEtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjUxOiJodHRwOi8vMjg5YS0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2FkbWluL3NvYWwiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1735536670),
('aifVAhmt9rAdXwdoPPAAm7pzCF8UWQoOOP7TgMBu', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibzBoclJpZnhBdHg1SGFFZHN4QVh6OTVSczFIQzJpM3ZFaTNFQ2JBWCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzYzY2MtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vNjNjYy0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529485),
('B7urbroHc4RfTq3xBXZGBq7fPPri4xArzxXOWlFM', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTGRkWFFIQmhSU3ZabU81ZUM5bUI0YWxtMHpqN1RKSEJyaExZMXRXeCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTA0OiJodHRwOi8vMjg5YS0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2FkbWluL3NvYWwvY3JlYXRlP2lkX2xvbWJhPWU3ZjEwZjRmLTI1MDMtNDBmMS04MGM0LTIyZjZiMzBiYzI5OSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1735532460),
('cK43VsicuIRyCwcKUJxI5BV31G4TUObmGgTlzDYE', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiMGxwVVlYWVJsWlJDdGhVdE5KRkRKVUo1MXJFTWJnc1A5TU1WT3gzVCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovL2I2MGEtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjEwNDoiaHR0cDovL2I2MGEtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcC9hZG1pbi9zb2FsL2NyZWF0ZT9pZF9sb21iYT1lN2YxMGY0Zi0yNTAzLTQwZjEtODBjNC0yMmY2YjMwYmMyOTkiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1735531207),
('ctGdM95wqv0vXVds8My28z9615xuNB9e39Y7cpYf', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWQwbUxKd2hoVWl6TTJ4bHlZV2U4aTRTYVpmN0kwQzQ0RjVYbkpQayI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzYzY2MtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vNjNjYy0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529601),
('DDXSqqiC2M0rcI7nccfTdd6fk7fx28zqr4XmMyx6', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMnpVNzQ4OHQ4QVR3UjA1Y0kyYlhoYTVoNjMyVUZYZVFXREEzSUFidCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzMwMzgtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vMzAzOC0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735530136),
('eap8k0y3UGi9nDIVv0aRTj5mPUWCOaMVOK5adFvJ', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSkhoNnAzMmtXRVlGaEZzZzdIamg3WjBCajRjd0J3R0FObXJIUkNKeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735530583),
('EcGknwoyoK9I0sfUbBuUKI2Bl4nPHjzZqW1IL456', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTWhaN0Rmd3NTQmJDalZxN2g2dENvWXdCbmF5Mlk1NVFJZ3F1MENjaSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovLzEyNy4wLjAuMTo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735536080),
('eK9sJIEh8HjHwYIDTlBDW9ohdRgMxaP9vGOW89na', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMmpaTU5UU0tXbTMySHRXTkxpU2Q5a1cxa1BnSjhFTUUyNXpFMGxpSiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735530402),
('G2RlXeq2U0Z6gMhD1RVaL14r903mLoQ1H6fP9AsH', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/27.0 Chrome/125.0.0.0 Mobile Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWnAwYnNQSTduTlVuQ1JuRzd1RDc3VFNmQVJNeHl2bjJ0aHFta2ZiZyI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzYzY2MtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vNjNjYy0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529504),
('gFu9oBjq0EdPKMaQeT99dCHXkCAiHeb6iG83aAkO', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYXBTZWs1Zm51WHhLNWRaMFYyWkpQN1RTMUdTc0JLVThSelFtVWhkWCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzljNDItMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vOWM0Mi0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529832),
('gyLd0Dp7RZSgw6lQoC8axHEtcxghaDecrGgcDZGS', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRkVjNGVQVGJXYjRWV21GRVlXcmpac0VNOHV4aGRwbE15WXZ0TnJIbSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzRjODEtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ5OiJodHRwOi8vNGM4MS0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL3JlZ2lzdGVyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735530261),
('JoNy7Sj5L5ah38WC8TN6ZsKzoJWwAilYodZH9bKx', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY2xZNkZ5czc4Sm5FRW5vWGc4dXB4NFNoa2N5bk9aVkxTcVh2NjNuTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly9iNjBhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1735530751),
('kipAk4Y4W0OobCvBjyHGXqUcj4NBi9mHNLHrIC80', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFduMkx2a3pxSmZITEQweFE1WE5nUHlpMmJrT2JxTm5NWHQ1NVNIeCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzNlYTMtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vM2VhMy0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735530314),
('prnyn1PmYQa5QFUdpwn7mSYQdzy9KubuomlXMj03', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMFZHYTlWdXZrNnFDR2lZUHViRHBObEpmWDdCSUdxZ1ZCTWtBVFlJdCI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzYxNTctMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vNjE1Ny0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2xvZ2luIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529851),
('Si5YuQiLxzAFF0gvSpvK6AiwtOmk2MnF2uG5JHUl', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieFZCWnZjNU5GVGk4ZTJMWFlDTjduUVNqMHNVSGtJWHZrTmZBcmlMTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8yODlhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1735531299),
('U5TcEiKRrJHrcMx3chp0WlQANczkiPVsdt66hvA6', 4, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWkpDZGJiVGVjelJHOGZqNzRwcGpkaFQ1MHpBWHM4STczVVYxOVJvWCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTg6Imh0dHA6Ly9iNjBhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvc3RhdHVzLXBlbWJheWFyYW4iO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo0O30=', 1735531239),
('u6Gtg6EESnCTgTdvplzOTlbMpRdUbWrdiPzogDKz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUXVjNTl1dTlRd0ZOWFl3YzZWd0Z5Z1lDNnVDYWVQMlJtbXhzbmpDNCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTAyOiJodHRwOi8vMjg5YS0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwL2FkbWluL3NvYWwvZWRpdD9pZF9sb21iYT1kYmU4NWU4ZC1kNWY2LTQ3MGQtOTJkNy1jMmQwMmFjYmQyNDkiO31zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1735532216),
('UKe6lVCxHWHvdd4dNmAe7QAoz8ZGHFMhREuLG3Qs', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiYzdBWUxMYlY3eUpMTldpVjFSaXMwaUk0MGZhenlyeU5mT2NpVXZhRSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czoyMToiaHR0cDovL2xvY2FsaG9zdDo4MDAwIjt9czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1735530402),
('VUkU2pf4gOub56OQNtZ8gdW3MlSrko0xBqFZleJd', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVzFZOEZmTE1wdWhtZzBxWllaUFRHMmpnbzh4VU5jc2tYalBSSFdWRyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHA6Ly8yODlhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvYWRtaW4vbG9tYmEiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUyOiJsb2dpbl9hZG1pbl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1735534569),
('WeZqEE06Ffdb8GSUyUoZ82lCJa4zWvZtzDqrhAhK', NULL, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/27.0 Chrome/125.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYVUyaHhDOEE5WU1paHRBMmFGeDFra0tqYktaSndLRzFNNG85bzNCUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8yODlhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvbG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1735532158),
('WnS94tBGYoiNzfPaxYfkRVfoq1uHPKZjXEG855uN', 1, '127.0.0.1', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/27.0 Chrome/125.0.0.0 Mobile Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiNWdLcjVvZTByV3g0bjk5TWpwSVhtT0lhTnpkaUVJVEpWdVVtQmVudCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTY6Imh0dHA6Ly9iNjBhLTEwMy03Ni0xNTAtNTAubmdyb2stZnJlZS5hcHAvYWRtaW4vZGFzaGJvYXJkIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovL2I2MGEtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6NTI6ImxvZ2luX2FkbWluXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1735530808),
('x3AML9gX1cJQRKJByZyWfDPMjiNiZoovV7ZstRcE', NULL, '127.0.0.1', 'WhatsApp/2.23.20.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoia1lyNTBDNjNwZXhGdTcyMWg4WFAyN0ZYb0JjME1UVkN6UGhkdmlIWiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0MDoiaHR0cDovLzYzY2MtMTAzLTc2LTE1MC01MC5uZ3Jvay1mcmVlLmFwcCI7fXM6OToiX3ByZXZpb3VzIjthOjE6e3M6MzoidXJsIjtzOjQwOiJodHRwOi8vNjNjYy0xMDMtNzYtMTUwLTUwLm5ncm9rLWZyZWUuYXBwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1735529485),
('xKBZ9pYMLjQLzqvfUK23X6mXxTrnpAXqBvWfNUZk', NULL, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicGJ6NVAxdDNBczR3bnpZVHlxeFhtdXk4dFlqM3d1ajVEWXZpWER5TiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9sb2dpbiI7fX0=', 1735536542);

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
('46b67836-75f9-47dd-91ed-6cca066b209c', 'dbe85e8d-d5f6-470d-92d7-c2d02acbd249', '[{\"id\": \"ef65e563-06e5-420a-a4f0-2fb30440ad0d\", \"jawaban\": [\"<p>lilili</p>\", \"<p>lululu</p>\", \"<p>lelele</p>\"], \"pertanyaan\": \"<p>lalala</p>\", \"jawaban_yang_benar\": \"<p>lilili</p>\"}]', '2024-12-25 00:46:09', '2024-12-30 11:55:26'),
('6a04187e-c4b1-4c6a-b8c6-a38db6989233', 'e7f10f4f-2503-40f1-80c4-22f6b30bc299', '[{\"id\": \"25c71f34-42d7-4997-a821-1bf710fea270\", \"jawaban\": [\"<p>okeee</p>\", \"<p>iyaaa</p>\", \"<p>betull</p>\"], \"pertanyaan\": \"<p>apa yang?</p>\", \"jawaban_yang_benar\": \"<p>betull</p>\"}]', '2024-12-30 11:56:02', '2024-12-30 11:56:02');

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
  `nik` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `alamat`, `sekolah`, `kelas`, `type`) VALUES
(1, 'Budiman', 'budi@salset.com', NULL, '$2y$12$xsT4OXIhg3RSLBOVEM4FO.Xp9cmevftu/lO5Ov5Hw2dBLj8x.dbA2', NULL, '2024-12-24 05:13:27', '2024-12-24 05:13:27', '1234567890123456', 'Laki-laki', '2014-08-19', 'Depok', 'SDN Negri Depok 2', '5', 'siswa'),
(2, 'Joko', 'budi@gmail.com', NULL, '$2y$12$0CZ3JGlTpYOSehNjSD0xR.YtO53pfKeVJ5gObG.WY1Au8gyzsQPc2', NULL, '2024-12-27 09:36:58', '2024-12-27 09:36:58', '123233422212122222', 'Laki-laki', '2010-08-19', 'Depok', 'SMP IT Depok', '7', 'siswa'),
(3, 'testing', 'sd3@gmail.com', NULL, '$2y$12$rkVy2FHSz6qSCrfx7.glE.SUVsebU0W1MfAwZ7amLYucQAGmrNXwG', NULL, '2024-12-30 10:58:25', '2024-12-30 10:58:25', '22299911188', 'Laki-laki', '2024-12-26', 'jauh', 'sd', '3', 'siswa'),
(4, 'niko', 'nikopalkor@gmail.com', NULL, '$2y$12$gxVrS6LLvO05GLJxFBgYyei1ON00JYNXvZVa6tm2psDR0iyKKtcka', NULL, '2024-12-30 10:59:56', '2024-12-30 10:59:56', '33322211122', 'Laki-laki', '2024-12-11', 'cikarang', 'smp', '8', 'siswa');

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
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_nik_unique` (`nik`);

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
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pendaftaran_lomba`
--
ALTER TABLE `pendaftaran_lomba`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `soal_id_lomba_foreign` FOREIGN KEY (`id_lomba`) REFERENCES `lomba` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
