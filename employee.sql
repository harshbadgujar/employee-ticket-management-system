-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: May 22, 2026 at 06:13 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employee`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_05_21_091808_add_custom_fields_to_users_table', 1),
(5, '2026_05_21_091815_add_custom_fields_to_users_table', 1),
(6, '2026_05_21_091823_create_tickets_table', 1),
(7, '2026_05_21_163000_add_department_to_users_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('OM0vyhFBuKm7Tokl0H8H6NxbHqpJ7oxhDWM6AeKl', 5, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJ2eHZSb0JzN2ZNdDlFcEJOU0F4RXhjdGk3MzFtNzZHT3hmZEwwZnlzIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cL2xvY2FsaG9zdDo4MDAwXC9kYXNoYm9hcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sInVybCI6W10sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjo1fQ==', 1779427837),
('RvbiRHImNjjRLuZPDezgV9xqt02Hf0Lj1IpE6A2W', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJhVk8xM2VsOVVIcWx1MDRiaGpLV2FMRUlUUmJRSzRrbm9ucTBtRDFEIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2xvZ2luIiwicm91dGUiOiJsb2dpbiJ9fQ==', 1779430317);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
CREATE TABLE IF NOT EXISTS `tickets` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'open',
  `priority` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'medium',
  `assigned_to` bigint UNSIGNED DEFAULT NULL,
  `created_by` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tickets_assigned_to_foreign` (`assigned_to`),
  KEY `tickets_created_by_foreign` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tickets`
--

INSERT INTO `tickets` (`id`, `title`, `description`, `status`, `priority`, `assigned_to`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Critical: Payment Gateway Timeout in Production', 'Users are reporting 504 gateway timeouts when attempting credit card checkouts. This is affecting the stripe integration flow. Urgent attention is needed.', 'open', 'high', 2, 1, '2026-05-21 03:52:15', '2026-05-21 03:52:15'),
(2, 'Feature Request: Add Dark Mode toggler in Profile', 'Users want the ability to switch between dark and light themes in their profile settings. Currently, it defaults to light only.', 'open', 'medium', 3, 1, '2026-05-21 03:52:15', '2026-05-21 06:50:04'),
(3, 'Bug: Profile image is not updating immediately', 'When a user updates their profile picture, the old image is cached in the browser for up to an hour. We should add cache-busting query params to the URL.', 'resolved', 'low', 4, 1, '2026-05-21 03:52:15', '2026-05-21 06:51:52'),
(4, 'SMTP Configuration Issue', 'The emails are currently falling back to the log driver. We should configure the Google SMTP or Mailgun parameters inside the config environment to go live.', 'open', 'high', 2, 2, '2026-05-21 03:52:15', '2026-05-21 03:52:15'),
(5, 'Typo on Landing Page Header', 'In resources/views/welcome.blade.php, on line 125, the word \"Empolyees\" is misspelled. It should be spelled \"Employees\".', 'open', 'low', 3, 1, '2026-05-21 03:52:15', '2026-05-21 06:48:21'),
(6, 'harsh', 'harah', 'open', 'low', NULL, 5, '2026-05-21 04:03:59', '2026-05-21 04:03:59'),
(7, 'code error', 'databaseproblem', 'open', 'medium', 2, 5, '2026-05-21 04:09:30', '2026-05-21 04:09:30'),
(8, 'ddsfdsaffdfd', 'dsfdf', 'open', 'medium', NULL, 6, '2026-05-21 04:21:48', '2026-05-21 04:21:48'),
(9, 'debug', 'runtime error', 'in_progress', 'low', 6, 5, '2026-05-22 00:25:53', '2026-05-22 00:26:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'employee',
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `department` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `phone`, `profile_image`, `department`) VALUES
(1, 'System Admin', 'admin@example.com', NULL, '$2y$12$GzaIwVZCczN3hH3kBKE.yuOk5PvYU0SXOY8.mkAyoUgEdIAJzSLP.', NULL, '2026-05-21 03:52:14', '2026-05-21 03:52:14', 'admin', '+1234567890', NULL, NULL),
(2, 'John Employee', 'employee@example.com', NULL, '$2y$12$urk8/6j.4.5kJV2Cmz3kFuZzPL7.7sJfVQyoYj1f3OM.tg.fQKAoi', NULL, '2026-05-21 03:52:14', '2026-05-21 07:22:35', 'employee', '+1112223333', NULL, 'IT'),
(3, 'Alice Support', 'alice@example.com', NULL, '$2y$12$mZLll/zFQzcg2iKz7rBM2embhBwPf0TNJGmK36WlFFUOea3yhz46S', NULL, '2026-05-21 03:52:15', '2026-05-21 06:46:03', 'employee', '+4445556666', NULL, 'Finance'),
(4, 'Bob Support', 'bob@example.com', NULL, '$2y$12$FRRZcJcGCAxbU4tN61TSY.InFHjw5RbScHsJE02r3r0ieEOj2.hVu', NULL, '2026-05-21 03:52:15', '2026-05-21 06:45:43', 'employee', '+7778889999', NULL, 'IT'),
(5, 'admin', 'admin@123gmail.com', NULL, '$2y$12$89GtLWujjr.ISH6Gp1qgU.CH6bn4zm1gOWV4eKYV1WIK.tEP3ix6u', NULL, '2026-05-21 04:01:39', '2026-05-21 04:01:39', 'admin', NULL, NULL, NULL),
(6, 'user', 'user@123gmail.com', NULL, '$2y$12$AKJp1iGnmDBfTqJm8U6u3.IULDFx7SZVyuFGbByr6QVzOqs2a1JOO', NULL, '2026-05-21 04:21:00', '2026-05-21 06:42:02', 'employee', '6567575858', NULL, 'QA'),
(7, 'harsh', 'harsh@123gmail.com', NULL, '$2y$12$7WLRNkCTIL0JwMUTCa9Ji.Ir9gwIcJPIm4vVvmt2vUzBxOqTxeJvG', NULL, '2026-05-21 04:53:09', '2026-05-21 06:41:30', 'employee', '467489399', 'avatars/LePQmck8NNQ97ToUzUOnZZkqq8tn3bx5lZrHsIUr.jpg', 'IT');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
