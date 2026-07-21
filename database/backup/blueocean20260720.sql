-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 20, 2026 at 07:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blueocean`
--

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `text` varchar(255) NOT NULL,
  `placement` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blacklists`
--

CREATE TABLE `blacklists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `mobile` varchar(15) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `type` enum('mobile','ip') DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `requested_by` int(10) UNSIGNED DEFAULT NULL,
  `requested_at` datetime DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `therapist_id` int(10) UNSIGNED NOT NULL,
  `treatment_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(14) NOT NULL,
  `postcode` varchar(50) NOT NULL,
  `flat_no` varchar(50) DEFAULT NULL,
  `street_number` varchar(50) NOT NULL,
  `street_name` varchar(50) DEFAULT NULL,
  `town` varchar(100) NOT NULL,
  `comments` longtext DEFAULT NULL,
  `booking_datetime` datetime NOT NULL,
  `appointment_start` datetime NOT NULL,
  `appointment_finish` datetime NOT NULL,
  `duration` int(11) NOT NULL,
  `extra_duration` int(11) NOT NULL DEFAULT 0,
  `amount` decimal(10,2) NOT NULL,
  `discount_amount` decimal(10,2) DEFAULT NULL,
  `discount_code` varchar(50) DEFAULT NULL,
  `payable_amount` decimal(10,2) DEFAULT NULL,
  `travel_supp` decimal(10,2) DEFAULT NULL,
  `fee_platform` decimal(10,2) NOT NULL,
  `fee_therapist` decimal(10,2) NOT NULL,
  `fee_platform_extension` decimal(10,2) DEFAULT NULL,
  `fee_therapist_extension` decimal(10,2) DEFAULT NULL,
  `gift_discount_amount` decimal(10,2) DEFAULT NULL,
  `gift_discount_remaining_amount` decimal(8,2) DEFAULT NULL,
  `gift_discount_code` varchar(100) DEFAULT NULL,
  `paid_by_therapist` tinyint(1) NOT NULL DEFAULT 0,
  `therapist_conf_sms` tinyint(1) NOT NULL DEFAULT 0,
  `status` enum('new','cancelled','processing') DEFAULT NULL,
  `late_reason` text DEFAULT NULL,
  `cancel_reason` text DEFAULT NULL,
  `cancellation_requested_at` datetime DEFAULT NULL,
  `is_extension_paid` tinyint(1) DEFAULT NULL,
  `therapist_rating` tinyint(4) DEFAULT NULL,
  `client_rating` tinyint(4) DEFAULT NULL,
  `device` enum('mobile','desktop') DEFAULT NULL,
  `client_ip_address` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `therapist_id`, `treatment_id`, `name`, `email`, `phone`, `postcode`, `flat_no`, `street_number`, `street_name`, `town`, `comments`, `booking_datetime`, `appointment_start`, `appointment_finish`, `duration`, `extra_duration`, `amount`, `discount_amount`, `discount_code`, `payable_amount`, `travel_supp`, `fee_platform`, `fee_therapist`, `fee_platform_extension`, `fee_therapist_extension`, `gift_discount_amount`, `gift_discount_remaining_amount`, `gift_discount_code`, `paid_by_therapist`, `therapist_conf_sms`, `status`, `late_reason`, `cancel_reason`, `cancellation_requested_at`, `is_extension_paid`, `therapist_rating`, `client_rating`, `device`, `client_ip_address`, `created_at`, `updated_at`) VALUES
(1, NULL, 31, 10, 'Abhishek', NULL, '07400123456', 'N1C 4AG', NULL, '10', 'Kings Road', 'London', NULL, '2026-07-24 10:00:00', '2026-07-24 10:00:00', '2026-07-24 12:00:00', 120, 0, '110.00', '0.00', NULL, '110.00', '0.00', '45.00', '65.00', NULL, NULL, '0.00', NULL, NULL, 0, 0, 'processing', NULL, NULL, NULL, NULL, NULL, NULL, 'desktop', '127.0.0.1', '2026-07-20 10:41:13', '2026-07-20 10:41:13'),
(2, NULL, 31, 10, 'Abhishek', NULL, '07400123456', 'N1C 4AG', NULL, '10', 'Kings Road', 'London', NULL, '2026-07-24 10:00:00', '2026-07-24 10:00:00', '2026-07-24 12:00:00', 120, 0, '110.00', '0.00', NULL, '110.00', '0.00', '45.00', '65.00', NULL, NULL, '0.00', NULL, NULL, 0, 1, 'new', NULL, NULL, NULL, NULL, NULL, NULL, 'desktop', '127.0.0.1', '2026-07-20 10:42:06', '2026-07-20 10:42:39');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:3:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";}s:11:\"permissions\";a:6:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"Manage Booking\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:16:\"Manage Therapist\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"Manage User\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:14:\"Manage Setting\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:14:\"Manage Content\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:11:\"View Report\";s:1:\"c\";s:3:\"web\";}}s:5:\"roles\";a:0:{}}', 1784646898);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 'What areas of London do you cover?', 'We provide mobile massage services across most areas of Greater London. Simply enter your postcode to check therapist availability in your area.', 1, 1, '2026-07-14 00:08:25', '2026-07-14 00:08:25'),
(2, 'Do you bring a massage table?', 'This depends on the therapist. Some therapists bring a massage table, others provide a massage mat or face cradle, and some dont cary any equipment and perform treatments using the client\'s bed or suitable surface. Each therapist\'s profile clearly states what equipment they provide or if she didnt provide anyone.', 1, 2, '2026-07-14 00:08:44', '2026-07-14 00:08:44'),
(3, 'Can I book a massage in a hotel?', 'Absolutely. We regularly provide treatments in hotels, offices, serviced apartments, and private residences throughout London.', 1, 3, '2026-07-14 00:09:05', '2026-07-14 00:09:05'),
(4, 'How do I choose the right treatment?', 'Each treatment is designed to achieve different goals, from relaxation and stress relief to muscle recovery and improved mobility. If you\'re unsure, we\'ll help you select the most suitable option.', 1, 4, '2026-07-14 00:09:25', '2026-07-14 00:09:25'),
(5, 'Can I request a male or female therapist?', 'Yes, subject to availability.', 1, 5, '2026-07-14 00:09:46', '2026-07-14 00:09:46'),
(6, 'Are your therapists qualified?', 'Yes. All therapists are required to hold relevant qualifications and professional insurance before joining the platform.', 1, 6, '2026-07-14 00:10:03', '2026-07-14 00:10:03'),
(7, 'Do you offer couples massages?', 'Yes. Our Time Together experience allows two clients to enjoy treatments side-by-side.', 1, 7, '2026-07-14 00:10:20', '2026-07-14 00:10:20'),
(8, 'What should I prepare before my appointment?', 'Simply provide some fresh towels usually three larges and two small, one pillow, a comfortable and suitable space for your treatment. If your therapist brings a massage table, enough room should be available for setup. Your therapist will bring all necessary equipment and supplies.', 1, 8, '2026-07-14 00:10:37', '2026-07-14 00:10:37'),
(9, 'What payment methods do you accept?', 'Payments can be processed securely online during booking. Depending on the therapist, payment may also be made directly upon arrival by cash.', 1, 9, '2026-07-14 00:10:54', '2026-07-14 00:10:54'),
(10, 'What is your cancellation policy?', 'Appointments may be cancelled or rescheduled in accordance with our cancellation policy. Full details are provided during the booking process.', 1, 10, '2026-07-14 00:11:12', '2026-07-14 00:11:12'),
(11, 'Do you offer same-day bookings?', 'Yes, subject to therapist availability.', 1, 11, '2026-07-14 00:11:26', '2026-07-14 00:11:26'),
(12, 'Can I request the same therapist again?', 'Absolutely. Returning clients can rebook their preferred therapist whenever availability permits.', 1, 12, '2026-07-14 00:11:41', '2026-07-14 00:11:41');

-- --------------------------------------------------------

--
-- Table structure for table `gift_certificates`
--

CREATE TABLE `gift_certificates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` smallint(5) UNSIGNED NOT NULL,
  `recipient_name` varchar(255) NOT NULL,
  `recipient_email` varchar(255) NOT NULL,
  `sender_name` varchar(255) NOT NULL,
  `sender_email` varchar(255) NOT NULL,
  `gift_amount` double NOT NULL,
  `message` text DEFAULT NULL,
  `used_amount` double NOT NULL,
  `remaining_amount` double NOT NULL,
  `gift_code` varchar(255) NOT NULL,
  `payment_status` enum('in_progress','paid','failed') NOT NULL,
  `payment_method` enum('paypal','stripe','apple_pay') NOT NULL,
  `charge_id` varchar(255) DEFAULT NULL,
  `send_at` datetime DEFAULT NULL,
  `expire_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

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
  `finished_at` int(11) DEFAULT NULL
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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_20_055850_create_user_profiles_table', 1),
(5, '2026_01_20_055851_create_user_verify_table', 1),
(6, '2026_01_20_055856_create_permission_tables', 1),
(9, '2026_01_27_071933_create_treatment_treatment_category_table', 1),
(10, '2026_01_27_083906_create_postcode_districts_table', 1),
(11, '2026_01_27_090045_create_postcodes_table', 1),
(12, '2026_01_27_102710_create_postcode_zones_table', 1),
(13, '2026_01_27_102739_create_postcode_zones_postcodes_table', 1),
(14, '2026_02_03_064541_create_therapist_profiles_table', 1),
(15, '2026_02_09_171119_create_therapists_treatments_table', 1),
(16, '2026_02_09_181601_create_therapists_postcodes_table', 1),
(17, '2026_02_09_184033_create_therapist_schedule_table', 1),
(18, '2026_02_09_190645_create_therapists_holidays_table', 1),
(19, '2026_02_09_190646_create_therapists_mandates', 1),
(20, '2026_02_24_135415_create_posts_table', 1),
(21, '2026_02_24_135425_create_post_comments_table', 1),
(22, '2026_02_24_135450_create_post_tags_table', 1),
(23, '2026_02_24_175952_create_reviews_table', 1),
(24, '2026_02_24_180017_create_faqs_table', 1),
(25, '2026_02_24_180034_create_tariff_plans_table', 1),
(26, '2026_02_24_180438_create_gift_certificates_table', 1),
(27, '2026_02_24_180447_create_blacklists_table', 1),
(28, '2026_03_11_100708_create_bookings_table', 1),
(29, '2026_03_13_052530_create_payments_table', 1),
(30, '2026_03_13_052531_create_payment_received_table', 1),
(31, '2026_06_26_120225_create_settings_table', 1),
(32, '2026_06_29_054319_create_banners_table', 1),
(33, '2026_01_27_071910_create_treatments_table', 2),
(34, '2026_01_27_071915_create_treatment_categories_table', 3),
(35, '2026_07_17_113526_create_therapist_applications_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 21),
(2, 'App\\Models\\User', 22),
(2, 'App\\Models\\User', 23),
(2, 'App\\Models\\User', 24),
(2, 'App\\Models\\User', 25),
(2, 'App\\Models\\User', 26),
(2, 'App\\Models\\User', 27),
(2, 'App\\Models\\User', 28),
(2, 'App\\Models\\User', 29),
(2, 'App\\Models\\User', 30),
(2, 'App\\Models\\User', 31),
(3, 'App\\Models\\User', 2),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 4),
(3, 'App\\Models\\User', 5),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 7),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 10),
(3, 'App\\Models\\User', 11),
(3, 'App\\Models\\User', 12),
(3, 'App\\Models\\User', 13),
(3, 'App\\Models\\User', 14),
(3, 'App\\Models\\User', 15),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 19),
(3, 'App\\Models\\User', 20);

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
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` int(10) UNSIGNED NOT NULL,
  `amount` int(11) NOT NULL,
  `gift_discount_amount` decimal(8,2) NOT NULL DEFAULT 0.00,
  `refund_amount` int(11) DEFAULT NULL,
  `payment_type` enum('cash','credit','stripe','gift_voucher') NOT NULL,
  `status` enum('pending','completed','failed','refunded') NOT NULL,
  `charge_id` varchar(150) DEFAULT NULL COMMENT 'Stripe Charge ID',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `booking_id`, `amount`, `gift_discount_amount`, `refund_amount`, `payment_type`, `status`, `charge_id`, `created_at`, `updated_at`) VALUES
(1, 1, 11000, '0.00', NULL, 'stripe', 'pending', NULL, '2026-07-20 10:41:13', '2026-07-20 10:41:13'),
(2, 2, 11000, '0.00', NULL, 'stripe', 'completed', 'pi_3TvIrtRftFaIqZYc0DnSqawR', '2026-07-20 10:42:06', '2026-07-20 10:42:38');

-- --------------------------------------------------------

--
-- Table structure for table `payment_received`
--

CREATE TABLE `payment_received` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `cash` decimal(8,2) NOT NULL,
  `online` decimal(8,2) NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `tmr_commission` decimal(8,2) NOT NULL,
  `therapist_commission` decimal(8,2) NOT NULL,
  `vat` decimal(8,2) NOT NULL,
  `total_hours` decimal(8,2) NOT NULL,
  `stripe_payment_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `stripe_code` varchar(255) DEFAULT NULL,
  `is_settled` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Manage Booking', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(2, 'Manage Therapist', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(3, 'Manage User', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(4, 'Manage Setting', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(5, 'Manage Content', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(6, 'View Report', 'web', '2026-07-13 07:30:45', '2026-07-13 07:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `postcodes`
--

CREATE TABLE `postcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `postcode` varchar(255) NOT NULL,
  `district_id` int(11) NOT NULL,
  `travel_supp` decimal(10,2) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcodes`
--

INSERT INTO `postcodes` (`id`, `postcode`, `district_id`, `travel_supp`, `active`, `created_at`, `updated_at`) VALUES
(1, 'EC1A', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(2, 'EC1M', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(3, 'EC1N', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(4, 'EC1P', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(5, 'EC1R', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(6, 'EC1V', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(7, 'EC1Y', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(8, 'EC2A', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(9, 'EC2M', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(10, 'EC2N', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(11, 'EC2P', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(12, 'EC2R', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(13, 'EC2V', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(14, 'EC2Y', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(15, 'EC3A', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(16, 'EC3B', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(17, 'EC3M', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(18, 'EC3N', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(19, 'EC3P', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(20, 'EC3R', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(21, 'EC3V', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(22, 'EC4A', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(23, 'EC4M', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(24, 'EC4N', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(25, 'EC4P', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(26, 'EC4R', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(27, 'EC4V', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(28, 'EC4Y', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(29, 'EC50', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(30, 'EC88', 1, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(31, 'WC1A', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(32, 'WC1B', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(33, 'WC1E', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(34, 'WC1H', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(35, 'WC1N', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(36, 'WC1R', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(37, 'WC1V', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(38, 'WC1X', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(39, 'WC2A', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(40, 'WC2B', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(41, 'WC2E', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(42, 'WC2H', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(43, 'WC2N', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(44, 'WC2R', 2, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(45, 'E1', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(46, 'E1W', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(47, 'E2', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(48, 'E3', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(49, 'E4', 3, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(50, 'E5', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(51, 'E6', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(52, 'E7', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(53, 'E8', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(54, 'E9', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(55, 'E10', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(56, 'E11', 3, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(57, 'E12', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(58, 'E13', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(59, 'E14', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(60, 'E15', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(61, 'E16', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(62, 'E17', 3, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(63, 'E18', 3, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(64, 'E20', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(65, 'E77', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(66, 'E98', 3, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(67, 'N1', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(68, 'N1P', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(69, 'N1C', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(70, 'N2', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(71, 'N3', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(72, 'N4', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(73, 'N5', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(74, 'N6', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(75, 'N7', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(76, 'N8', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(77, 'N9', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(78, 'N10', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(79, 'N11', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(80, 'N12', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(81, 'N13', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(82, 'N14', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(83, 'N15', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(84, 'N16', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(85, 'N17', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(86, 'N18', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(87, 'N19', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(88, 'N20', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(89, 'N21', 4, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(90, 'N22', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(91, 'N81', 4, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(92, 'NW1', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(93, 'NW1W', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(94, 'NW2', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(95, 'NW3', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(96, 'NW4', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(97, 'NW5', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(98, 'NW6', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(99, 'NW7', 5, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(100, 'NW8', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(101, 'NW9', 5, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(102, 'NW10', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(103, 'NW11', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(104, 'NW26', 5, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(105, 'SE1', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(106, 'SE1P', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(107, 'SE2', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(108, 'SE3', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(109, 'SE4', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(110, 'SE5', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(111, 'SE6', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(112, 'SE7', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(113, 'SE8', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(114, 'SE9', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(115, 'SE10', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(116, 'SE11', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(117, 'SE12', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(118, 'SE13', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(119, 'SE14', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(120, 'SE15', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(121, 'SE16', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(122, 'SE17', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(123, 'SE18', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(124, 'SE19', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(125, 'SE20', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(126, 'SE21', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(127, 'SE22', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(128, 'SE23', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(129, 'SE24', 6, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(130, 'SE25', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(131, 'SE26', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(132, 'SE27', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(133, 'SE28', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(134, 'SE99', 6, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(135, 'SW1V', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(136, 'SW1X', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(137, 'SW1P', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(138, 'SW1H', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(139, 'SW1E', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(140, 'SW1A', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(141, 'SW1Y', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(142, 'SW1W', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(143, 'SW2', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(144, 'SW3', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(145, 'SW4', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(146, 'SW5', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(147, 'SW6', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(148, 'SW7', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(149, 'SW8', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(150, 'SW9', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(151, 'SW10', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(152, 'SW11', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(153, 'SW12', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(154, 'SW13', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(155, 'SW14', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(156, 'SW15', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(157, 'SW16', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(158, 'SW17', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(159, 'SW18', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(160, 'SW19', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(161, 'SW20', 7, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(162, 'SW95', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(163, 'SW99', 7, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(164, 'W1P', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(165, 'W1K', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(166, 'W1M', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(167, 'W1N', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(168, 'W1R', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(169, 'W1S', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(170, 'W1T', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(171, 'W1U', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(172, 'W1V', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(173, 'W1W', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(174, 'W1X', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(175, 'W1Y', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(176, 'W1J', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(177, 'W1H', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(178, 'W1A', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(179, 'W1B', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(180, 'W1C', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(181, 'W1D', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(182, 'W1E', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(183, 'W1F', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(184, 'W1G', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(185, 'W2', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(186, 'W3', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(187, 'W4', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(188, 'W5', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(189, 'W6', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(190, 'W7', 8, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(191, 'W8', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(192, 'W9', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(193, 'W10', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(194, 'W11', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(195, 'W12', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(196, 'W13', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(197, 'W14', 8, NULL, 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(198, 'BR1', 9, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(199, 'BR2', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(200, 'BR3', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(201, 'BR4', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(202, 'BR5', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(203, 'BR6', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(204, 'BR7', 9, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(205, 'BR8', 9, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(206, 'BR98', 9, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(207, 'CR0', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(208, 'CR2', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(209, 'CR3', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(210, 'CR4', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(211, 'CR5', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(212, 'CR6', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(213, 'CR7', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(214, 'CR8', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(215, 'CR9', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(216, 'CR44', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(217, 'CR90', 10, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(218, 'DA1', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(219, 'DA2', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(220, 'DA3', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(221, 'DA4', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(222, 'DA5', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(223, 'DA6', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(224, 'DA7', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(225, 'DA8', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(226, 'DA9', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(227, 'DA10', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(228, 'DA11', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(229, 'DA12', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(230, 'DA13', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(231, 'DA14', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(232, 'DA15', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(233, 'DA16', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(234, 'DA17', 11, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(235, 'DA18', 11, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(236, 'EN1', 12, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(237, 'EN2', 12, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(238, 'EN3', 12, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(239, 'EN4', 12, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(240, 'EN5', 12, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(241, 'EN6', 12, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(242, 'EN7', 12, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(243, 'EN8', 12, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(244, 'EN9', 12, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(245, 'EN10', 12, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(246, 'EN11', 12, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(247, 'EN77', 12, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(248, 'HA0', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(249, 'HA1', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(250, 'HA2', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(251, 'HA3', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(252, 'HA4', 13, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(253, 'HA5', 13, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(254, 'HA6', 13, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(255, 'HA7', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(256, 'HA8', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(257, 'HA9', 13, '5.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(258, 'IG1', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(259, 'IG2', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(260, 'IG3', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(261, 'IG4', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(262, 'IG5', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(263, 'IG6', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(264, 'IG7', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(265, 'IG8', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(266, 'IG9', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(267, 'IG10', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(268, 'IG11', 14, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(269, 'KT1', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(270, 'KT2', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(271, 'KT3', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(272, 'KT4', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(273, 'KT5', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(274, 'KT6', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(275, 'KT7', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(276, 'KT8', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(277, 'KT9', 15, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(278, 'KT10', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(279, 'KT11', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(280, 'KT12', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(281, 'KT13', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(282, 'KT14', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(283, 'KT15', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(284, 'KT16', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(285, 'KT17', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(286, 'KT18', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(287, 'KT19', 15, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(288, 'KT20', 15, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(289, 'KT21', 15, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(290, 'KT22', 15, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(291, 'KT23', 15, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(292, 'KT24', 15, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(293, 'RM1', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(294, 'RM2', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(295, 'RM3', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(296, 'RM4', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(297, 'RM5', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(298, 'RM6', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(299, 'RM7', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(300, 'RM8', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(301, 'RM9', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(302, 'RM10', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(303, 'RM11', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(304, 'RM12', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(305, 'RM13', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(306, 'RM14', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(307, 'RM15', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(308, 'RM16', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(309, 'RM17', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(310, 'RM18', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(311, 'RM19', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(312, 'RM20', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(313, 'RM50', 16, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(314, 'SM1', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(315, 'SM2', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(316, 'SM3', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(317, 'SM4', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(318, 'SM5', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(319, 'SM6', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(320, 'SM7', 17, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(321, 'TW1', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(322, 'TW2', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(323, 'TW3', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(324, 'TW4', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(325, 'TW5', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(326, 'TW6', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(327, 'TW7', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(328, 'TW8', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(329, 'TW9', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(330, 'TW10', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(331, 'TW11', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(332, 'TW12', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(333, 'TW13', 18, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(334, 'TW14', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(335, 'TW15', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(336, 'TW16', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(337, 'TW17', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(338, 'TW18', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(339, 'TW19', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(340, 'TW20', 18, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(341, 'UB1', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(342, 'UB2', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(343, 'UB3', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(344, 'UB4', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(345, 'UB5', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(346, 'UB6', 19, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(347, 'UB7', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(348, 'UB8', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(349, 'UB9', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(350, 'UB10', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(351, 'UB11', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(352, 'UB18', 19, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(353, 'WD1', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(354, 'WD2', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(355, 'WD3', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(356, 'WD4', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(357, 'WD5', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(358, 'WD6', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(359, 'WD7', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(360, 'WD17', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(361, 'WD18', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(362, 'WD19', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(363, 'WD23', 20, '25.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(364, 'WD24', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(365, 'WD25', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(366, 'WD99', 20, '20.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(367, 'CM1', 21, '25.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(368, 'SL1', 21, '35.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(369, 'SL2', 21, '35.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(370, 'MK14', 21, '15.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(371, 'MK1', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(372, 'MK2', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(373, 'MK3', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(374, 'MK4', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(375, 'MK5', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(376, 'MK6', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(377, 'MK7', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(378, 'MK8', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(379, 'MK9', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(380, 'MK10', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(381, 'MK11', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(382, 'MK12', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(383, 'MK15', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46'),
(384, 'MK13', 21, '10.00', 1, '2026-07-13 13:00:46', '2026-07-13 13:00:46');

-- --------------------------------------------------------

--
-- Table structure for table `postcode_districts`
--

CREATE TABLE `postcode_districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `postcode_area` varchar(255) NOT NULL,
  `district_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcode_districts`
--

INSERT INTO `postcode_districts` (`id`, `postcode_area`, `district_name`, `created_at`, `updated_at`) VALUES
(1, 'EC', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(2, 'WC', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(3, 'E', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(4, 'N', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(5, 'NW', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(6, 'SE', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(7, 'SW', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(8, 'W', 'London', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(9, 'BR', 'Bromley', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(10, 'CR', 'Croydon', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(11, 'DA', 'Dartford', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(12, 'EN', 'Enfield', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(13, 'HA', 'Harrow', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(14, 'IG', 'Ilford', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(15, 'KT', 'Kingston', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(16, 'RM', 'Romford', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(17, 'SM', 'Sutton', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(18, 'TW', 'Twickenham', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(19, 'UB', 'Uxbridge', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(20, 'WD', 'Watford', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(21, 'XX', 'Other', '2026-07-13 07:30:46', '2026-07-13 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `postcode_zones`
--

CREATE TABLE `postcode_zones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcode_zones`
--

INSERT INTO `postcode_zones` (`id`, `name`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Zone 1', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(2, 'Zone 2', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(3, 'Zone 3', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(4, 'Zone 4', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(5, 'Zone 5', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(6, 'Zone 6', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `postcode_zones_postcodes`
--

CREATE TABLE `postcode_zones_postcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `postcode_zone_id` int(11) NOT NULL,
  `postcode_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `postcode_zones_postcodes`
--

INSERT INTO `postcode_zones_postcodes` (`id`, `postcode_zone_id`, `postcode_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 1, 8, NULL, NULL),
(9, 1, 9, NULL, NULL),
(10, 1, 10, NULL, NULL),
(11, 1, 11, NULL, NULL),
(12, 1, 12, NULL, NULL),
(13, 1, 13, NULL, NULL),
(14, 1, 14, NULL, NULL),
(15, 1, 15, NULL, NULL),
(16, 1, 16, NULL, NULL),
(17, 1, 17, NULL, NULL),
(18, 1, 18, NULL, NULL),
(19, 1, 19, NULL, NULL),
(20, 1, 20, NULL, NULL),
(21, 1, 21, NULL, NULL),
(22, 1, 22, NULL, NULL),
(23, 1, 23, NULL, NULL),
(24, 1, 24, NULL, NULL),
(25, 1, 25, NULL, NULL),
(26, 1, 26, NULL, NULL),
(27, 1, 27, NULL, NULL),
(28, 1, 28, NULL, NULL),
(29, 1, 29, NULL, NULL),
(30, 1, 30, NULL, NULL),
(31, 1, 31, NULL, NULL),
(32, 1, 32, NULL, NULL),
(33, 1, 33, NULL, NULL),
(34, 1, 34, NULL, NULL),
(35, 1, 35, NULL, NULL),
(36, 1, 36, NULL, NULL),
(37, 1, 37, NULL, NULL),
(38, 1, 38, NULL, NULL),
(39, 1, 39, NULL, NULL),
(40, 1, 40, NULL, NULL),
(41, 1, 41, NULL, NULL),
(42, 1, 42, NULL, NULL),
(43, 1, 43, NULL, NULL),
(44, 1, 44, NULL, NULL),
(45, 1, 45, NULL, NULL),
(46, 1, 46, NULL, NULL),
(47, 1, 65, NULL, NULL),
(48, 1, 66, NULL, NULL),
(49, 1, 67, NULL, NULL),
(50, 1, 68, NULL, NULL),
(51, 1, 69, NULL, NULL),
(52, 1, 92, NULL, NULL),
(53, 1, 93, NULL, NULL),
(54, 1, 105, NULL, NULL),
(55, 1, 106, NULL, NULL),
(56, 1, 135, NULL, NULL),
(57, 1, 136, NULL, NULL),
(58, 1, 137, NULL, NULL),
(59, 1, 138, NULL, NULL),
(60, 1, 139, NULL, NULL),
(61, 1, 140, NULL, NULL),
(62, 1, 141, NULL, NULL),
(63, 1, 142, NULL, NULL),
(64, 1, 144, NULL, NULL),
(65, 1, 148, NULL, NULL),
(66, 1, 164, NULL, NULL),
(67, 1, 165, NULL, NULL),
(68, 1, 166, NULL, NULL),
(69, 1, 167, NULL, NULL),
(70, 1, 168, NULL, NULL),
(71, 1, 169, NULL, NULL),
(72, 1, 170, NULL, NULL),
(73, 1, 171, NULL, NULL),
(74, 1, 172, NULL, NULL),
(75, 1, 173, NULL, NULL),
(76, 1, 174, NULL, NULL),
(77, 1, 175, NULL, NULL),
(78, 1, 176, NULL, NULL),
(79, 1, 177, NULL, NULL),
(80, 1, 178, NULL, NULL),
(81, 1, 179, NULL, NULL),
(82, 1, 180, NULL, NULL),
(83, 1, 181, NULL, NULL),
(84, 1, 182, NULL, NULL),
(85, 1, 183, NULL, NULL),
(86, 1, 184, NULL, NULL),
(87, 1, 191, NULL, NULL),
(88, 2, 45, NULL, NULL),
(89, 2, 46, NULL, NULL),
(90, 2, 47, NULL, NULL),
(91, 2, 50, NULL, NULL),
(92, 2, 53, NULL, NULL),
(93, 2, 54, NULL, NULL),
(94, 2, 59, NULL, NULL),
(95, 2, 72, NULL, NULL),
(96, 2, 73, NULL, NULL),
(97, 2, 75, NULL, NULL),
(98, 2, 94, NULL, NULL),
(99, 2, 95, NULL, NULL),
(100, 2, 97, NULL, NULL),
(101, 2, 98, NULL, NULL),
(102, 2, 100, NULL, NULL),
(103, 2, 116, NULL, NULL),
(104, 2, 120, NULL, NULL),
(105, 2, 121, NULL, NULL),
(106, 2, 122, NULL, NULL),
(107, 2, 143, NULL, NULL),
(108, 2, 145, NULL, NULL),
(109, 2, 146, NULL, NULL),
(110, 2, 147, NULL, NULL),
(111, 2, 148, NULL, NULL),
(112, 2, 149, NULL, NULL),
(113, 2, 150, NULL, NULL),
(114, 2, 151, NULL, NULL),
(115, 2, 152, NULL, NULL),
(116, 2, 156, NULL, NULL),
(117, 2, 159, NULL, NULL),
(118, 2, 185, NULL, NULL),
(119, 2, 189, NULL, NULL),
(120, 2, 192, NULL, NULL),
(121, 2, 193, NULL, NULL),
(122, 2, 194, NULL, NULL),
(123, 2, 195, NULL, NULL),
(124, 2, 197, NULL, NULL),
(125, 3, 48, NULL, NULL),
(126, 3, 50, NULL, NULL),
(127, 3, 51, NULL, NULL),
(128, 3, 52, NULL, NULL),
(129, 3, 55, NULL, NULL),
(130, 3, 57, NULL, NULL),
(131, 3, 58, NULL, NULL),
(132, 3, 60, NULL, NULL),
(133, 3, 61, NULL, NULL),
(134, 3, 62, NULL, NULL),
(135, 3, 64, NULL, NULL),
(136, 3, 70, NULL, NULL),
(137, 3, 74, NULL, NULL),
(138, 3, 76, NULL, NULL),
(139, 3, 83, NULL, NULL),
(140, 3, 84, NULL, NULL),
(141, 3, 85, NULL, NULL),
(142, 3, 87, NULL, NULL),
(143, 3, 90, NULL, NULL),
(144, 3, 91, NULL, NULL),
(145, 3, 101, NULL, NULL),
(146, 3, 102, NULL, NULL),
(147, 3, 103, NULL, NULL),
(148, 3, 104, NULL, NULL),
(149, 3, 108, NULL, NULL),
(150, 3, 109, NULL, NULL),
(151, 3, 110, NULL, NULL),
(152, 3, 111, NULL, NULL),
(153, 3, 112, NULL, NULL),
(154, 3, 113, NULL, NULL),
(155, 3, 115, NULL, NULL),
(156, 3, 117, NULL, NULL),
(157, 3, 118, NULL, NULL),
(158, 3, 119, NULL, NULL),
(159, 3, 124, NULL, NULL),
(160, 3, 126, NULL, NULL),
(161, 3, 127, NULL, NULL),
(162, 3, 128, NULL, NULL),
(163, 3, 129, NULL, NULL),
(164, 3, 130, NULL, NULL),
(165, 3, 131, NULL, NULL),
(166, 3, 132, NULL, NULL),
(167, 3, 153, NULL, NULL),
(168, 3, 154, NULL, NULL),
(169, 3, 155, NULL, NULL),
(170, 3, 157, NULL, NULL),
(171, 3, 158, NULL, NULL),
(172, 3, 160, NULL, NULL),
(173, 3, 161, NULL, NULL),
(174, 3, 186, NULL, NULL),
(175, 3, 187, NULL, NULL),
(176, 3, 188, NULL, NULL),
(177, 3, 329, NULL, NULL),
(178, 3, 330, NULL, NULL),
(179, 4, 56, NULL, NULL),
(180, 4, 63, NULL, NULL),
(181, 4, 71, NULL, NULL),
(182, 4, 77, NULL, NULL),
(183, 4, 78, NULL, NULL),
(184, 4, 79, NULL, NULL),
(185, 4, 80, NULL, NULL),
(186, 4, 81, NULL, NULL),
(187, 4, 82, NULL, NULL),
(188, 4, 86, NULL, NULL),
(189, 4, 88, NULL, NULL),
(190, 4, 89, NULL, NULL),
(191, 4, 96, NULL, NULL),
(192, 4, 99, NULL, NULL),
(193, 4, 101, NULL, NULL),
(194, 4, 107, NULL, NULL),
(195, 4, 114, NULL, NULL),
(196, 4, 120, NULL, NULL),
(197, 4, 121, NULL, NULL),
(198, 4, 122, NULL, NULL),
(199, 4, 123, NULL, NULL),
(200, 4, 125, NULL, NULL),
(201, 4, 133, NULL, NULL),
(202, 4, 190, NULL, NULL),
(203, 4, 248, NULL, NULL),
(204, 4, 255, NULL, NULL),
(205, 4, 256, NULL, NULL),
(206, 4, 257, NULL, NULL),
(207, 4, 258, NULL, NULL),
(208, 4, 259, NULL, NULL),
(209, 4, 260, NULL, NULL),
(210, 4, 261, NULL, NULL),
(211, 4, 262, NULL, NULL),
(212, 4, 263, NULL, NULL),
(213, 4, 265, NULL, NULL),
(214, 4, 323, NULL, NULL),
(215, 4, 327, NULL, NULL),
(216, 4, 328, NULL, NULL),
(217, 4, 329, NULL, NULL),
(218, 4, 330, NULL, NULL),
(219, 5, 249, NULL, NULL),
(220, 5, 250, NULL, NULL),
(221, 5, 251, NULL, NULL),
(222, 5, 264, NULL, NULL),
(223, 5, 266, NULL, NULL),
(224, 5, 269, NULL, NULL),
(225, 5, 270, NULL, NULL),
(226, 5, 271, NULL, NULL),
(227, 5, 272, NULL, NULL),
(228, 5, 314, NULL, NULL),
(229, 5, 315, NULL, NULL),
(230, 5, 321, NULL, NULL),
(231, 5, 322, NULL, NULL),
(232, 6, 207, NULL, NULL),
(233, 6, 208, NULL, NULL),
(234, 6, 209, NULL, NULL),
(235, 6, 210, NULL, NULL),
(236, 6, 211, NULL, NULL),
(237, 6, 212, NULL, NULL),
(238, 6, 213, NULL, NULL),
(239, 6, 214, NULL, NULL),
(240, 6, 215, NULL, NULL),
(241, 6, 216, NULL, NULL),
(242, 6, 217, NULL, NULL),
(243, 6, 252, NULL, NULL),
(244, 6, 253, NULL, NULL),
(245, 6, 254, NULL, NULL),
(246, 6, 267, NULL, NULL),
(247, 6, 268, NULL, NULL),
(248, 6, 274, NULL, NULL),
(249, 6, 275, NULL, NULL),
(250, 6, 276, NULL, NULL),
(251, 6, 277, NULL, NULL),
(252, 6, 278, NULL, NULL),
(253, 6, 316, NULL, NULL),
(254, 6, 317, NULL, NULL),
(255, 6, 318, NULL, NULL),
(256, 6, 319, NULL, NULL),
(257, 6, 320, NULL, NULL),
(258, 6, 324, NULL, NULL),
(259, 6, 325, NULL, NULL),
(260, 6, 326, NULL, NULL),
(261, 6, 331, NULL, NULL),
(262, 6, 332, NULL, NULL),
(263, 6, 333, NULL, NULL),
(264, 6, 334, NULL, NULL),
(265, 6, 335, NULL, NULL),
(266, 6, 336, NULL, NULL),
(267, 6, 337, NULL, NULL),
(268, 6, 341, NULL, NULL),
(269, 6, 342, NULL, NULL),
(270, 6, 343, NULL, NULL),
(271, 6, 344, NULL, NULL),
(272, 6, 345, NULL, NULL),
(273, 6, 346, NULL, NULL),
(274, 6, 347, NULL, NULL),
(275, 6, 348, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `comments_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `page_meta_title` varchar(255) DEFAULT NULL,
  `page_meta_description` text DEFAULT NULL,
  `page_extra_meta_tags` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `slug`, `title`, `content`, `author`, `active`, `comments_enabled`, `image`, `image_alt`, `image_title`, `page_meta_title`, `page_meta_description`, `page_extra_meta_tags`, `created_at`, `updated_at`) VALUES
(1, 'hotel-massage-in-london-luxury-wellness-delivered-to-your-room', 'Hotel Massage in London: Luxury Wellness Delivered to Your Room', '<p>Whether you\'re visiting London for business, leisure, or a special occasion, travel can be surprisingly demanding. Long flights, jet lag, busy schedules, and hours of walking often leave the body tired and the mind overloaded.</p>\r\n<p>A hotel massage offers a simple solution: professional wellness delivered directly to your room.</p>\r\n<p>Instead of travelling to a spa, waiting for an appointment, and making your way back afterwards, you can enjoy a personalised treatment in complete comfort and privacy. Once your session is finished, all you need to do is relax, enjoy your evening, or drift into a restful night\'s sleep.</p>\r\n<p>The best massage depends on how you\'re feeling.</p>\r\n<p>Arrived with jet lag? Many travellers choose Aromatherapy Massage, Reflexology, Relaxing Massage, or Indian Head Massage to help them unwind after long-haul flights and adjust to a new time zone.<br />Feeling mentally exhausted? Indian Head Massage, Aromatherapy Massage, Swedish Massage, and Lomi Lomi Massage are excellent choices for calming a busy mind and promoting deep relaxation.<br />Carrying tension in your neck and shoulders? Deep Tissue Massage, Trigger Point Therapy, Myofascial Release, and Barefoot Ashiatsu Massage can help release stubborn muscular tightness caused by travel, work, or long hours sitting.</p>\r\n<p>Feeling stiff after a flight? Sports Massage, Thai Massage, and Deep Tissue Massage are popular options for improving mobility and helping the body feel lighter and more comfortable.</p>\r\n<p>At Blue Ocean Mobile Massage, every treatment is tailored to your individual needs, ensuring you receive the right therapy at the right moment.</p>\r\n<p>We provide professional mobile massage services throughout Central London, including Mayfair, Knightsbridge, Kensington, Chelsea, Belgravia, Westminster, and Canary Wharf.<br />Luxury is not just about where you stay&mdash;it\'s about how you feel during your stay.</p>', 'BlueOcean', 1, 1, 'head-massage.jpg', 'Hotel Massage in London: Luxury Wellness Delivered to Your Room', 'Hotel Massage in London: Luxury Wellness Delivered to Your Room', 'Hotel Massage in London: Luxury Wellness Delivered to Your Room', 'Hotel Massage in London: Luxury Wellness Delivered to Your Room', NULL, '2026-07-14 00:38:53', '2026-07-14 00:52:28'),
(2, 'what-to-expect-from-a-professional-mobile-massage-appointment', 'What to Expect from a Professional Mobile Massage Appointment', '<p>If you\'ve never booked a mobile massage before, you may wonder what actually happens on the day of your appointment.<br />Here\'s a simple step-by-step guide.</p>\r\n<p>Step 1: Tell Us How You Feel</p>\r\n<p>Rather than focusing on massage names, start by thinking about what you would like help with.<br />For example:</p>\r\n<p>Jet lag after a long flight</p>\r\n<p>Stress and mental fatigue</p>\r\n<p>Tight neck and shoulders</p>\r\n<p>Stiffness and reduced mobility</p>\r\n<p>Sports recovery</p>\r\n<p>Pure relaxation</p>\r\n<p>Based on your goals, your therapist can recommend the most suitable treatment.</p>\r\n<p>Step 2: Prepare a Comfortable Space</p>\r\n<p>You don\'t need a large room.<br />A hotel room, bedroom, living room, or serviced apartment is usually more than sufficient.<br />The therapist simply needs enough space to move comfortably around the treatment area.</p>\r\n<p>Step 3: Your Therapist Arrives</p>\r\n<p>Your therapist arrives with everything required for your session.<br />Depending on the treatment, this may include:</p>\r\n<ul>\r\n<li>Professional massage table</li>\r\n<li>Massage mat</li>\r\n<li>Face cradle and head support</li>\r\n<li>Massage oils</li>\r\n<li>Essential oils</li>\r\n<li>Hot stones</li>\r\n<li>Oil warmer</li>\r\n<li>Additional equipment for specialised treatments</li>\r\n</ul>\r\n<p>The setup process is quick and discreet.</p>\r\n<p>Step 4: Personal Consultation</p>\r\n<p>Before the session begins, you\'ll have a brief consultation.<br />Your therapist may ask:</p>\r\n<p>What would you like to achieve today?</p>\r\n<p>Are there any areas of discomfort?</p>\r\n<p>How much pressure do you prefer?</p>\r\n<p>Are there any injuries or health conditions to consider?</p>\r\n<p>This ensures the treatment is tailored specifically to your needs.</p>\r\n<p>Step 5: Relax and Enjoy Your Treatment</p>\r\n<p>To ensure your comfort, guests are kindly asked to provide:</p>\r\n<p>Three large towels, two small towels, and one pillow</p>\r\n<p>or</p>\r\n<p>Two single sheets, two small towels, and one pillow</p>\r\n<p>Once you\'re comfortable, your massage begins.<br />Whether you\'ve chosen Aromatherapy Massage for jet lag, Deep Tissue Massage for tension, Indian Head Massage for stress, or Lomi Lomi Massage for deep relaxation, the treatment is adapted throughout the session to ensure maximum comfort and benefit.</p>\r\n<p>Step 6: After the Session</p>\r\n<p>When the treatment is finished, your therapist will give you a moment to sit up slowly while packing away equipment and products.<br />Many clients immediately notice:</p>\r\n<p>Less tension</p>\r\n<p>Greater relaxation</p>\r\n<p>Improved mobility</p>\r\n<p>A calmer mind</p>\r\n<p>Increased comfort</p>\r\n<p>You may also receive personalised aftercare recommendations.</p>\r\n<p>Step 7: The Luxury of Staying Exactly Where You Are</p>\r\n<p>Unlike a spa visit, there is no journey home.<br />No traffic.<br />No Tube.<br />No rushing anywhere.<br />Simply remain in your hotel room or home, continue relaxing, enjoy a warm shower, or settle into a peaceful night\'s sleep.<br />For many clients, this uninterrupted relaxation is the greatest benefit of all.<br />At Blue Ocean Mobile Massage, we bring professional wellness directly to your door, creating a seamless experience from arrival to complete relaxation.</p>', 'BlueOcean', 1, 1, 'what-to-expect.jpg', 'What to Expect from a Professional Mobile Massage Appointment', 'What to Expect from a Professional Mobile Massage Appointment', 'What to Expect from a Professional Mobile Massage Appointment', 'What to Expect from a Professional Mobile Massage Appointment', NULL, '2026-07-14 00:58:22', '2026-07-14 03:04:08'),
(3, 'how-to-choose-the-right-massage-for-your-needs', 'How to Choose the Right Massage for Your Needs', '<p>With so many massage options available, choosing the right treatment can feel overwhelming. The easiest way to decide is not by looking at the name of the massage, but by asking yourself one simple question:<br />How do I feel today?</p>\r\n<p>My Mind Won\'t Switch Off</p>\r\n<p>If you\'re feeling stressed, overwhelmed, anxious, or mentally exhausted, choose a treatment designed to calm the nervous system.<br />Recommended treatments:</p>\r\n<p>Aromatherapy Massage</p>\r\n<p>Swedish Massage</p>\r\n<p>Relaxing Massage</p>\r\n<p>Indian Head Massage</p>\r\n<p>Lomi Lomi Massage</p>\r\n<p>These treatments focus on relaxation, helping you slow down, recharge, and disconnect from the pressures of daily life.</p>\r\n<p>My Neck and Shoulders Feel Tight</p>\r\n<p>Hours spent working, travelling, or looking at screens often create tension in the upper body.<br />Recommended treatments:</p>\r\n<p>Deep Tissue Massage</p>\r\n<p>Trigger Point Therapy</p>\r\n<p>Myofascial Release</p>\r\n<p>Barefoot Ashiatsu Massage</p>\r\n<p>These therapies focus on releasing muscular tightness and improving comfort and mobility.</p>\r\n<p>I Wake Up Feeling Stiff</p>\r\n<p>If your body feels rigid in the morning or after long periods of sitting, you may benefit from treatments that improve movement and flexibility.<br />Recommended treatments:</p>\r\n<p>Thai Massage</p>\r\n<p>Sports Massage</p>\r\n<p>Deep Tissue Massage</p>\r\n<p>These techniques help improve mobility and reduce stiffness throughout the body.</p>\r\n<p>I\'m Suffering from Jet Lag</p>\r\n<p>Long flights can leave you feeling physically tired, mentally foggy, and unable to relax properly.<br />Recommended treatments:</p>\r\n<p>Aromatherapy Massage</p>\r\n<p>Relaxing Massage</p>\r\n<p>Reflexology</p>\r\n<p>Indian Head Massage</p>\r\n<p>Hot Stone Massage</p>\r\n<p>These treatments are popular among travellers looking to recover after a journey and enjoy a more restful stay.</p>\r\n<p>I Want Pure Relaxation</p>\r\n<p>Sometimes there is no specific problem to solve&mdash;you simply want to feel wonderful.<br />Recommended treatments:</p>\r\n<p>Hot Stone Massage</p>\r\n<p>Lomi Lomi Massage</p>\r\n<p>Swedish Massage</p>\r\n<p>Relaxing Massage</p>\r\n<p>These treatments focus on comfort, relaxation, and overall wellbeing.<br />Still unsure? A professional therapist can help you choose the treatment that best matches your needs, goals, and preferences.</p>', 'BlueOcean', 1, 1, 'needed-massage.jpg', 'How to Choose the Right Massage for Your Needs', 'How to Choose the Right Massage for Your Needs', 'How to Choose the Right Massage for Your Needs', 'How to Choose the Right Massage for Your Needs', NULL, '2026-07-14 01:09:22', '2026-07-14 03:03:17'),
(4, 'massage-for-better-sleep-does-it-really-work', 'Massage for Better Sleep: Does It Really Work?', '<p>If you\'ve ever struggled to fall asleep, found yourself waking up during the night, or felt exhausted despite spending hours in bed, you\'re not alone. Sleep difficulties affect millions of people and are often linked to stress, anxiety, physical tension, travel, jet lag, and overstimulation from modern life.<br />While massage is not a treatment for insomnia or medical sleep disorders, research suggests that massage therapy may help improve sleep quality by reducing stress, calming the nervous system, decreasing muscle tension, and promoting relaxation.<br />The key is choosing the right type of massage for the reason you\'re not sleeping well.</p>\r\n<p>If Your Mind Won\'t Switch Off</p>\r\n<p>Many people don\'t struggle with sleep because they\'re not tired&mdash;they struggle because their minds are still active.<br />Work deadlines, travel, family responsibilities, and constant screen exposure can keep the nervous system in a heightened state of alertness.<br />The most suitable treatments are:</p>\r\n<p>Aromatherapy Massage</p>\r\n<p>Aromatherapy Massage combines massage therapy with carefully selected essential oils. Certain aromas, particularly lavender, bergamot, and chamomile, have been studied for their calming effects and may help reduce feelings of stress and anxiety.</p>\r\n<p>Swedish Massage</p>\r\n<p>Swedish Massage uses long, flowing movements and gentle to moderate pressure designed to encourage relaxation throughout the body. Studies have shown that relaxation-focused massage may help reduce cortisol, often referred to as the body\'s primary stress hormone.</p>\r\n<p>Indian Head Massage</p>\r\n<p>This treatment focuses on the scalp, neck, shoulders, and upper back&mdash;areas where many people unknowingly carry stress. Clients frequently report feeling mentally lighter and deeply relaxed after a session.</p>\r\n<p>If Physical Tension Is Keeping You Awake</p>\r\n<p>Sometimes the problem isn\'t the mind&mdash;it\'s the body.<br />Tight shoulders, neck discomfort, back pain, and muscular stiffness can make it difficult to find a comfortable sleeping position.<br />The most suitable treatments are:</p>\r\n<p>Deep Tissue Massage</p>\r\n<p>Deep Tissue Massage targets deeper layers of muscle and connective tissue. By reducing areas of chronic muscular tension, it may help improve physical comfort during sleep.</p>\r\n<p>Trigger Point Therapy</p>\r\n<p>Trigger points are sensitive areas within muscles that can refer discomfort to other parts of the body. Releasing these points may reduce pain and help the body relax more fully.</p>\r\n<p>Myofascial Release</p>\r\n<p>This technique focuses on restrictions within the fascia, the connective tissue surrounding muscles. Many clients describe feeling looser, lighter, and more comfortable after treatment.</p>\r\n<p>If You\'re Struggling with Jet Lag</p>\r\n<p>Travelling across time zones can disrupt your body\'s natural sleep-wake cycle.<br />While massage cannot eliminate jet lag, it can help support recovery by promoting relaxation and reducing the physical stress associated with travel.<br />The most popular options include:</p>\r\n<p>Reflexology</p>\r\n<p>Reflexology focuses on specific points of the feet believed to correspond with different areas of the body. Many travellers find it deeply relaxing after long flights.</p>\r\n<p>Aromatherapy Massage</p>\r\n<p>Particularly popular among international travellers looking to unwind after a busy journey.</p>\r\n<p>Indian Head Massage</p>\r\n<p>Helpful for relieving travel-related tension in the neck, scalp, shoulders, and upper back.</p>\r\n<p>If You Want the Most Relaxing Experience Possible</p>\r\n<p>Some treatments are chosen simply because they feel incredibly soothing.</p>\r\n<p>Hot Stone Massage</p>\r\n<p>The warmth of smooth heated stones helps muscles relax while creating a comforting and deeply calming experience. Many clients choose Hot Stone Massage specifically as part of an evening self-care routine.</p>\r\n<p>Lomi Lomi Massage</p>\r\n<p>Originating in Hawaii, Lomi Lomi uses flowing, rhythmic movements that many clients find deeply nurturing and restorative. It is often chosen by people seeking emotional relaxation as well as physical comfort.</p>\r\n<p>Can Massage Really Help You Sleep Better?</p>\r\n<p>Scientific research suggests that massage may support better sleep by:</p>\r\n<p>Reducing stress and anxiety</p>\r\n<p>Lowering muscle tension</p>\r\n<p>Encouraging relaxation</p>\r\n<p>Supporting nervous system regulation</p>\r\n<p>Improving overall wellbeing</p>\r\n<p>For many people, the result is not simply sleeping longer, but falling asleep more easily and waking feeling more refreshed.<br />At Blue Ocean Mobile Massage, we tailor every treatment to your individual needs, helping create the ideal conditions for relaxation, recovery, and restorative sleep&mdash;whether you\'re at home, in a serviced apartment, or staying in a London hotel.</p>', 'BlueOcean', 1, 1, 'sleep-massage.jpg', 'Massage for Better Sleep: Does It Really Work?', 'Massage for Better Sleep: Does It Really Work?', 'Massage for Better Sleep: Does It Really Work?', 'Massage for Better Sleep: Does It Really Work?', NULL, '2026-07-14 01:10:14', '2026-07-14 03:02:28'),
(5, 'the-best-massage-after-a-long-haul-flight', 'The Best Massage After a Long-Haul Flight', '<p>Few things are more exciting than arriving in London. Unfortunately, after spending 8, 10, or even 14 hours on a plane, your body may not feel quite as enthusiastic as your travel plans.<br />Long-haul flights place unusual demands on the body. Sitting for extended periods can leave muscles stiff, joints restricted, circulation sluggish, and energy levels depleted. Add jet lag, disrupted sleep, dehydration, and airport stress, and it\'s easy to understand why many travellers feel far from their best after arrival.<br />The good news is that not all post-flight discomfort feels the same, and the best massage depends on what your body needs most.</p>\r\n<p>If Your Legs Feel Heavy or Tired</p>\r\n<p>Hours spent sitting can leave the legs feeling sluggish and uncomfortable.<br />Many travellers choose Reflexology after a flight because it focuses on the feet, helping create a sense of relaxation and recovery after long periods of immobility.<br />A gentle Swedish Massage may also help the body feel refreshed and re-energised after travel.</p>\r\n<p>If Your Neck and Shoulders Feel Like Stone</p>\r\n<p>One awkward sleeping position on a plane can create hours&mdash;or days&mdash;of discomfort.<br />If you\'re experiencing tight shoulders, a stiff neck, or upper back tension, treatments such as Deep Tissue Massage, Trigger Point Therapy, or Myofascial Release may help address areas of muscular tightness created during travel.<br />For guests who enjoy stronger pressure, Barefoot Ashiatsu Massage can provide a uniquely effective treatment for broad areas of tension across the back.</p>\r\n<p>If Your Whole Body Feels Stiff</p>\r\n<p>After sitting for an extended period, many travellers describe feeling \"locked up\" rather than sore.<br />In these cases, treatments that focus on movement can be particularly beneficial.<br />Thai Massage, Sports Massage, and Assisted Stretching are often chosen by guests who want to feel looser, lighter, and more mobile after a journey.<br />These treatments focus on restoring comfortable movement rather than simply relaxing muscles.</p>\r\n<p>If You\'re Exhausted but Can\'t Sleep</p>\r\n<p>One of the most frustrating parts of jet lag is feeling tired while being completely unable to switch off.<br />When the body and brain are operating on different time zones, relaxation-focused treatments are often the preferred choice.<br />Aromatherapy Massage combines therapeutic touch with carefully selected essential oils to create a calming experience.<br />Indian Head Massage focuses on the scalp, neck, shoulders, and upper back&mdash;areas that often accumulate tension during travel.<br />Many travellers choose these treatments on their first evening in London to help unwind after a long journey.</p>\r\n<p>If You Simply Want to Feel Human Again</p>\r\n<p>Sometimes the goal isn\'t to target a specific problem.<br />You just want to arrive, unpack, take a deep breath, and feel comfortable again.<br />In this situation, Hot Stone Massage and Lomi Lomi Massage are popular choices. Both focus on creating a deeply restorative experience that helps guests transition from travel mode into holiday mode.</p>\r\n<p>The First Evening Matters</p>\r\n<p>Many experienced travellers know that the first evening after arrival often shapes the rest of the trip.<br />Recover well, sleep well, and your stay begins on the right note.<br />At Blue Ocean Mobile Massage, we provide personalised massage treatments directly to your hotel room, residence, or serviced apartment across Central London. Whether you\'re recovering from a long-haul flight, adjusting to a new time zone, or simply looking to relax after travelling, we\'ll help you choose the treatment that best suits your needs.<br />Because the sooner your body arrives, the sooner your trip can truly begin.</p>', 'BlueOcean', 1, 1, 'jet-lag.jpg', 'The Best Massage After a Long-Haul Flight', 'The Best Massage After a Long-Haul Flight', 'The Best Massage After a Long-Haul Flight', 'The Best Massage After a Long-Haul Flight', NULL, '2026-07-14 01:10:50', '2026-07-14 03:01:17');

-- --------------------------------------------------------

--
-- Table structure for table `post_comments`
--

CREATE TABLE `post_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `author` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `post_post_tag`
--

CREATE TABLE `post_post_tag` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `post_tag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_post_tag`
--

INSERT INTO `post_post_tag` (`id`, `post_id`, `post_tag_id`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, NULL),
(2, 1, 1, NULL, NULL),
(3, 2, 2, NULL, NULL),
(4, 2, 1, NULL, NULL),
(5, 3, 2, NULL, NULL),
(6, 3, 1, NULL, NULL),
(7, 4, 2, NULL, NULL),
(8, 4, 1, NULL, NULL),
(9, 5, 2, NULL, NULL),
(10, 5, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `post_tags`
--

CREATE TABLE `post_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `post_tags`
--

INSERT INTO `post_tags` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Luxury Wellness', 'luxury-wellness', '2026-07-14 00:34:59', '2026-07-14 00:34:59'),
(2, 'Hotel Massage', 'hotel-massage', '2026-07-14 00:35:16', '2026-07-14 00:35:16');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profession` varchar(255) DEFAULT NULL,
  `company` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `location` varchar(255) NOT NULL,
  `comment` longtext NOT NULL,
  `evaluation` tinyint(4) DEFAULT NULL,
  `ip_address` varchar(255) NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `first_name`, `last_name`, `email`, `profession`, `company`, `photo`, `location`, `comment`, `evaluation`, `ip_address`, `active`, `created_at`, `updated_at`) VALUES
(1, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'It was very very good. Massage so good in fact I actually had her treating an ongoing injury I have. Would happily see her again.', 5, '127.0.0.1', 1, '2026-07-15 01:03:42', '2026-07-15 01:19:35'),
(2, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'It was very nice. Thank you!', 4, '127.0.0.1', 1, '2026-07-15 01:19:14', '2026-07-15 01:19:14'),
(3, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'Fabulous time. Will be back.Thanks so much.', 5, '127.0.0.1', 1, '2026-07-15 01:20:10', '2026-07-15 01:20:10'),
(4, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'Fantastic. Great technique and personality.', 5, '127.0.0.1', 1, '2026-07-15 01:20:54', '2026-07-15 01:20:54'),
(5, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'Excellent Service. Very good. Thank you!', 5, '127.0.0.1', 1, '2026-07-15 01:21:37', '2026-07-15 01:21:37'),
(6, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'Super good professional massage. Good recommendation. Thank you.', 5, '127.0.0.1', 1, '2026-07-15 01:22:42', '2026-07-15 01:22:42'),
(7, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'She was very good. Thank you!', 5, '127.0.0.1', 1, '2026-07-15 01:23:32', '2026-07-15 01:23:32'),
(8, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'It was amazing. One of the best. She was very very good.', 5, '127.0.0.1', 1, '2026-07-15 01:24:10', '2026-07-15 01:24:10'),
(9, 'BlueOcean User', NULL, NULL, NULL, NULL, NULL, 'London', 'Was best massage I\'ve had from any of the girls. Proper deep tissue, she clearly knows what sher is doing.', 5, '127.0.0.1', 1, '2026-07-15 01:25:13', '2026-07-15 01:37:10'),
(10, 'Abhishek', 'Purohit', 'abhishek@mailinator.com', NULL, NULL, NULL, 'London', 'Very nice service', 4, '127.0.0.1', 1, '2026-07-15 06:39:30', '2026-07-15 06:40:05'),
(11, 'Abhishek', 'Purohit', 'abhishek5@mailinator.com', NULL, NULL, NULL, 'London', 'We take pride in providing exceptional massage services to our clients. Here are some of the reviews and testimonials from our satisfied customers.', 4, '127.0.0.1', 1, '2026-07-15 06:47:17', '2026-07-15 06:54:29');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', 1, '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(2, 'Therapist', 'web', 1, '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(3, 'Customer', 'web', 1, '2026-07-13 07:30:45', '2026-07-13 07:30:45');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
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
('ue4yTqP40JLkYFyt7Z2uyzKBhYYMtu9gZksJQqNx', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoick9LZnVEV29xeEZBdWtuRmd2MGRBTGxnaFdDRUdIS2tpOG9kdjFDbiI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vYmx1ZW9jZWFuLmxvY2FsL2pvaW4tdXMiO3M6NToicm91dGUiO3M6Nzoiam9pbl91cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1784569190),
('x6JraIzGiPT55bpo3sNRzg0ARKqUYSTyjaYQLyfH', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:152.0) Gecko/20100101 Firefox/152.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoickVLeUF2VUhSUDllNzdXOEFXVlV6YVdYcU9BS2lVajJEWmNrSkZwciI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vYmx1ZW9jZWFuLmxvY2FsL2FkbWluL3BheW1lbnRzIjtzOjU6InJvdXRlIjtzOjIwOiJhZG1pbi5wYXltZW50cy5pbmRleCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==', 1784568635);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `param_key` varchar(55) NOT NULL,
  `param_value` varchar(55) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `param_key`, `param_value`, `created_at`, `updated_at`) VALUES
(1, 'admin_email', 'admin@blueocean.com', '2026-07-17 13:40:49', '2026-07-17 13:40:55'),
(2, 'admin_mobile', '+447444727208', '2026-07-17 13:40:52', '2026-07-17 13:40:57'),
(3, 'extend_cost', '30', '2026-07-17 13:41:48', '2026-07-17 13:41:48'),
(4, 'vat_number', '123456', '2026-07-17 13:41:48', '2026-07-17 13:41:48'),
(5, 'vat_rate', '20', '2026-07-17 13:42:29', '2026-07-17 13:42:29');

-- --------------------------------------------------------

--
-- Table structure for table `tariff_plans`
--

CREATE TABLE `tariff_plans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `duration` int(10) UNSIGNED NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `fee` decimal(10,2) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tariff_plans`
--

INSERT INTO `tariff_plans` (`id`, `name`, `duration`, `amount`, `fee`, `active`, `created_at`, `updated_at`) VALUES
(1, 'price_60min', 60, '59.00', '21.00', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(2, 'price_90min', 90, '80.00', '32.00', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(3, 'price_120min', 120, '110.00', '45.00', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(4, 'price_150min', 150, '145.00', '62.50', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(5, 'price_180min', 180, '170.00', '70.00', 1, '2026-07-13 07:30:46', '2026-07-13 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `therapists_holidays`
--

CREATE TABLE `therapists_holidays` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapists_holidays`
--

INSERT INTO `therapists_holidays` (`id`, `user_id`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 31, '2026-07-22 00:00:00', '2026-07-22 23:59:00', '2026-07-20 02:16:15', '2026-07-20 02:16:15');

-- --------------------------------------------------------

--
-- Table structure for table `therapists_mandates`
--

CREATE TABLE `therapists_mandates` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `therapist_id` int(11) DEFAULT NULL,
  `stripe_customer_id` varchar(255) NOT NULL,
  `checkout_session_id` varchar(255) DEFAULT NULL,
  `payment_method_id` varchar(255) DEFAULT NULL,
  `mandate_id` varchar(255) DEFAULT NULL,
  `setup_intent_id` varchar(255) DEFAULT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `bank_last_four_digits` varchar(255) DEFAULT NULL,
  `stripe_status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `therapists_postcodes`
--

CREATE TABLE `therapists_postcodes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `postcode_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapists_postcodes`
--

INSERT INTO `therapists_postcodes` (`id`, `user_id`, `postcode_id`, `created_at`, `updated_at`) VALUES
(1, 31, 1, NULL, NULL),
(2, 31, 2, NULL, NULL),
(3, 31, 3, NULL, NULL),
(4, 31, 4, NULL, NULL),
(5, 31, 5, NULL, NULL),
(6, 31, 6, NULL, NULL),
(7, 31, 7, NULL, NULL),
(8, 31, 8, NULL, NULL),
(9, 31, 9, NULL, NULL),
(10, 31, 10, NULL, NULL),
(11, 31, 11, NULL, NULL),
(12, 31, 12, NULL, NULL),
(13, 31, 13, NULL, NULL),
(14, 31, 14, NULL, NULL),
(15, 31, 15, NULL, NULL),
(16, 31, 16, NULL, NULL),
(17, 31, 17, NULL, NULL),
(18, 31, 18, NULL, NULL),
(19, 31, 19, NULL, NULL),
(20, 31, 20, NULL, NULL),
(21, 31, 21, NULL, NULL),
(22, 31, 22, NULL, NULL),
(23, 31, 23, NULL, NULL),
(24, 31, 24, NULL, NULL),
(25, 31, 25, NULL, NULL),
(26, 31, 26, NULL, NULL),
(27, 31, 27, NULL, NULL),
(28, 31, 28, NULL, NULL),
(29, 31, 29, NULL, NULL),
(30, 31, 30, NULL, NULL),
(31, 31, 67, NULL, NULL),
(32, 31, 68, NULL, NULL),
(33, 31, 69, NULL, NULL),
(34, 31, 70, NULL, NULL),
(35, 31, 71, NULL, NULL),
(36, 31, 72, NULL, NULL),
(37, 31, 73, NULL, NULL),
(38, 31, 74, NULL, NULL),
(39, 31, 75, NULL, NULL),
(40, 31, 76, NULL, NULL),
(41, 31, 77, NULL, NULL),
(42, 31, 78, NULL, NULL),
(43, 31, 79, NULL, NULL),
(44, 31, 80, NULL, NULL),
(45, 31, 81, NULL, NULL),
(46, 31, 82, NULL, NULL),
(47, 31, 83, NULL, NULL),
(48, 31, 84, NULL, NULL),
(49, 31, 85, NULL, NULL),
(50, 31, 86, NULL, NULL),
(51, 31, 87, NULL, NULL),
(52, 31, 88, NULL, NULL),
(53, 31, 89, NULL, NULL),
(54, 31, 90, NULL, NULL),
(55, 31, 91, NULL, NULL),
(56, 30, 67, NULL, NULL),
(57, 30, 68, NULL, NULL),
(58, 30, 69, NULL, NULL),
(59, 30, 70, NULL, NULL),
(60, 30, 71, NULL, NULL),
(61, 30, 72, NULL, NULL),
(62, 30, 73, NULL, NULL),
(63, 30, 74, NULL, NULL),
(64, 30, 75, NULL, NULL),
(65, 30, 76, NULL, NULL),
(66, 30, 77, NULL, NULL),
(67, 30, 78, NULL, NULL),
(68, 30, 79, NULL, NULL),
(69, 30, 80, NULL, NULL),
(70, 30, 81, NULL, NULL),
(71, 30, 82, NULL, NULL),
(72, 30, 83, NULL, NULL),
(73, 30, 84, NULL, NULL),
(74, 30, 85, NULL, NULL),
(75, 30, 86, NULL, NULL),
(76, 30, 87, NULL, NULL),
(77, 30, 88, NULL, NULL),
(78, 30, 89, NULL, NULL),
(79, 30, 90, NULL, NULL),
(80, 30, 91, NULL, NULL),
(81, 29, 1, NULL, NULL),
(82, 29, 2, NULL, NULL),
(83, 29, 3, NULL, NULL),
(84, 29, 4, NULL, NULL),
(85, 29, 5, NULL, NULL),
(86, 29, 6, NULL, NULL),
(87, 29, 7, NULL, NULL),
(88, 29, 8, NULL, NULL),
(89, 29, 9, NULL, NULL),
(90, 29, 10, NULL, NULL),
(91, 29, 11, NULL, NULL),
(92, 29, 12, NULL, NULL),
(93, 29, 13, NULL, NULL),
(94, 29, 14, NULL, NULL),
(95, 29, 15, NULL, NULL),
(96, 29, 16, NULL, NULL),
(97, 29, 17, NULL, NULL),
(98, 29, 18, NULL, NULL),
(99, 29, 19, NULL, NULL),
(100, 29, 20, NULL, NULL),
(101, 29, 21, NULL, NULL),
(102, 29, 22, NULL, NULL),
(103, 29, 23, NULL, NULL),
(104, 29, 24, NULL, NULL),
(105, 29, 25, NULL, NULL),
(106, 29, 26, NULL, NULL),
(107, 29, 27, NULL, NULL),
(108, 29, 28, NULL, NULL),
(109, 29, 29, NULL, NULL),
(110, 29, 30, NULL, NULL),
(111, 29, 67, NULL, NULL),
(112, 29, 68, NULL, NULL),
(113, 29, 69, NULL, NULL),
(114, 29, 70, NULL, NULL),
(115, 29, 71, NULL, NULL),
(116, 29, 72, NULL, NULL),
(117, 29, 73, NULL, NULL),
(118, 29, 74, NULL, NULL),
(119, 29, 75, NULL, NULL),
(120, 29, 76, NULL, NULL),
(121, 29, 77, NULL, NULL),
(122, 29, 78, NULL, NULL),
(123, 29, 79, NULL, NULL),
(124, 29, 80, NULL, NULL),
(125, 29, 81, NULL, NULL),
(126, 29, 82, NULL, NULL),
(127, 29, 83, NULL, NULL),
(128, 29, 84, NULL, NULL),
(129, 29, 85, NULL, NULL),
(130, 29, 86, NULL, NULL),
(131, 29, 87, NULL, NULL),
(132, 29, 88, NULL, NULL),
(133, 29, 89, NULL, NULL),
(134, 29, 90, NULL, NULL),
(135, 29, 91, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `therapists_treatments`
--

CREATE TABLE `therapists_treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `treatment_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapists_treatments`
--

INSERT INTO `therapists_treatments` (`id`, `user_id`, `treatment_id`, `created_at`, `updated_at`) VALUES
(1, 31, 10, NULL, NULL),
(2, 30, 10, NULL, NULL),
(3, 30, 6, NULL, NULL),
(4, 29, 10, NULL, NULL),
(5, 29, 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `therapist_applications`
--

CREATE TABLE `therapist_applications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT 0,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `therapist_profiles`
--

CREATE TABLE `therapist_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) NOT NULL,
  `about` longtext DEFAULT NULL,
  `notes` longtext DEFAULT NULL,
  `health_renewal_date` date DEFAULT NULL,
  `health_professional` tinyint(1) NOT NULL DEFAULT 0,
  `extend_cost` decimal(10,2) DEFAULT NULL,
  `fee_therapist_60` decimal(10,2) DEFAULT NULL,
  `fee_therapist_90` decimal(10,2) DEFAULT NULL,
  `fee_therapist_120` decimal(10,2) DEFAULT NULL,
  `fee_therapist_150` decimal(10,2) DEFAULT NULL,
  `fee_therapist_180` decimal(10,2) DEFAULT NULL,
  `fee_therapist_210` decimal(10,2) DEFAULT NULL,
  `on_therapist_page` tinyint(1) NOT NULL DEFAULT 0,
  `soothing` tinyint(1) NOT NULL DEFAULT 0,
  `strong` tinyint(1) NOT NULL DEFAULT 0,
  `z_chair` tinyint(1) NOT NULL DEFAULT 0,
  `massage_table` tinyint(1) NOT NULL DEFAULT 0,
  `gender` tinyint(1) NOT NULL DEFAULT 0,
  `avg_rating` decimal(2,1) DEFAULT NULL,
  `bonus_eligible` tinyint(1) DEFAULT NULL,
  `bonus_amount` decimal(8,2) DEFAULT NULL,
  `page_meta_title` varchar(255) NOT NULL,
  `page_meta_tag` longtext NOT NULL,
  `extra_meta_tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapist_profiles`
--

INSERT INTO `therapist_profiles` (`id`, `user_id`, `slug`, `about`, `notes`, `health_renewal_date`, `health_professional`, `extend_cost`, `fee_therapist_60`, `fee_therapist_90`, `fee_therapist_120`, `fee_therapist_150`, `fee_therapist_180`, `fee_therapist_210`, `on_therapist_page`, `soothing`, `strong`, `z_chair`, `massage_table`, `gender`, `avg_rating`, `bonus_eligible`, `bonus_amount`, `page_meta_title`, `page_meta_tag`, `extra_meta_tags`, `created_at`, `updated_at`) VALUES
(1, 21, 'fernandozieme', 'Excepturi natus et maxime cupiditate rerum. Accusamus voluptatem corrupti facilis iusto. Ut molestiae voluptas sed vero qui ratione repellat.\n\nAmet voluptas aspernatur accusamus exercitationem quia. Repellat dolor tempore rerum. Dolorem nihil commodi voluptatum repellat iure facere.\n\nQui dolorem quasi maxime aut commodi mollitia. In delectus natus tenetur neque doloremque. Optio dolorum ratione et et eligendi minima consequuntur.', 'Consequatur ea nemo quis similique quos odio veritatis.', '1988-06-20', 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 0, 0, 1, '4.8', NULL, '259.82', 'Professional Therapist - Fernando Zieme', 'alias optio aliquam animi ad aliquam sed velit culpa nemo', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(2, 22, 'maevebartoletti', 'Sunt laudantium sit ut suscipit non. Qui cupiditate voluptate explicabo hic dolorem et numquam maxime. Ex voluptatum placeat mollitia vero velit. Et nobis voluptatibus voluptatibus totam.\n\nEt incidunt necessitatibus enim. Suscipit hic occaecati adipisci id tenetur. Tempora aut ad reprehenderit.\n\nIllo soluta nisi et est. Illo consequatur soluta itaque soluta. Eos id ut nemo rerum omnis. Mollitia aliquid id saepe quia ab sit beatae qui.', 'Temporibus impedit et odit in.', NULL, 0, '47.88', '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 1, 0, 0, 0, 0, NULL, NULL, NULL, 'Professional Therapist - Maeve Bartoletti', 'deleniti aspernatur omnis hic cum aliquid repellendus hic qui voluptatem', 'sequi impedit facere exercitationem at', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(3, 23, 'osbaldotremblay', 'Iure quos vero aut quia magnam. Praesentium hic mollitia placeat. Autem natus dolor aliquam aut ut. Expedita aperiam molestias eveniet sed.\n\nSunt sunt et eveniet quo illo voluptatibus. Iusto sed voluptates asperiores fugit nostrum quis. Velit fugit nostrum impedit vitae accusantium. Qui quis accusantium quasi suscipit dolorem et quo. Vitae alias quisquam sunt consectetur animi voluptas eligendi.\n\nCum modi quod id consequatur corrupti ullam. Repudiandae eum incidunt laboriosam sint distinctio. Omnis minima sit vel. Facere et aperiam est.', 'Minus odio aliquid sed.', NULL, 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 1, 1, 0, '3.7', 1, '63.40', 'Professional Therapist - Osbaldo Tremblay', 'dolorem quis voluptas id ipsa quae dolores laborum repudiandae iusto', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(4, 24, 'litzymclaughlin', 'Qui vero dolor velit repellendus explicabo. Et qui ex non maiores officiis. Ut ut sit qui et.\n\nPossimus totam quos quo est iure qui. Quas ducimus possimus voluptas et voluptatem fuga. Sunt necessitatibus dolorem molestiae eum modi. Est ullam nostrum dolor a sit ut.\n\nBlanditiis ducimus hic facere quam voluptas rem blanditiis rem. Repudiandae aperiam quidem dolor occaecati sit et qui. Autem et et illo necessitatibus aperiam tempore.', NULL, NULL, 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 1, 1, 0, NULL, NULL, '235.41', 'Professional Therapist - Litzy McLaughlin', 'voluptas eum culpa commodi aperiam asperiores sequi vero iste ex', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(5, 25, 'trevorbreitenberg', 'Fugiat aspernatur porro aliquid. Totam blanditiis eveniet quia eius et.\n\nIpsam quos necessitatibus nisi sed. Occaecati consequatur fuga aut eum. Eos maiores porro quia fugit voluptate.\n\nEos iusto repellat debitis pariatur quis iste et. Facere numquam iure numquam voluptatem nesciunt. Quia et et maxime consectetur voluptatibus quod eius voluptatem.', 'Perferendis et et dignissimos dolores veniam ut cum.', '2012-04-19', 0, '45.98', '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 1, 0, 0, 0, 0, NULL, 1, '286.46', 'Professional Therapist - Trevor Breitenberg', 'qui odit consequatur dolores consequatur sapiente doloribus optio sit suscipit', 'nam quia qui ratione repellendus', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(6, 26, 'richmondnader', 'Ducimus voluptatem unde iste quia. Inventore quia omnis atque inventore incidunt quo reiciendis. Voluptatem cumque accusamus culpa amet labore sint voluptatem.\n\nSed vel sit voluptatem. Quia eaque quod consequatur vel laudantium. Accusamus aut omnis dolores et ipsa qui. Omnis necessitatibus magni deserunt. Id sit veritatis cumque sequi.\n\nPerspiciatis nobis laudantium aut ipsum quia aut omnis qui. Qui sed eos sit minima. Similique aspernatur id neque incidunt. Officia corporis adipisci ea quam.', 'A et consequatur quaerat neque consequatur ipsam.', '1977-11-29', 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 0, 1, 0, 0, 1, 0, NULL, 1, '307.87', 'Professional Therapist - Richmond Nader', 'eveniet distinctio neque quaerat omnis nemo consequatur ut corporis et', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(7, 27, 'claudiablanda', 'Magnam ut id quasi asperiores delectus. Est occaecati soluta debitis voluptas at earum dolorem. Culpa ipsa voluptatem sint deserunt et. Sit sed consectetur quo corporis aspernatur enim maxime.\n\nPraesentium tempora quisquam earum mollitia rerum amet est. Reprehenderit facilis cupiditate dolor est ad modi. Fuga aut vitae quam omnis. Ut omnis repellendus numquam ipsum cum eaque. Veritatis quis commodi debitis velit natus.\n\nMagni sed enim aut autem ea possimus totam. Facere reprehenderit animi ipsum dolorum. Cum ad voluptas temporibus ea dolores asperiores fuga.', 'Vitae dolores enim dolor qui ducimus totam harum.', NULL, 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 0, 1, 1, 0, 1, 1, NULL, NULL, NULL, 'Professional Therapist - Claudia Blanda', 'velit aut dicta consectetur odio quas nihil debitis quo aliquid', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(8, 28, 'andrewindler', 'Tempora voluptatum officia maiores omnis sequi dolores explicabo et. Temporibus voluptas ut laborum eos commodi sed maiores. Eveniet doloribus commodi unde quia vel necessitatibus.\n\nOfficiis nesciunt illum consequatur fuga cumque asperiores. Similique dolore rerum quia eligendi est officiis laborum qui. Est sunt repudiandae velit odit et. Aspernatur et ut doloribus dolor fugit commodi nihil.\n\nEst iure earum praesentium qui. Vitae veritatis quia quam est. Dolorem ea laudantium laudantium non ullam libero totam voluptas. Quia quisquam laudantium corrupti rem.', NULL, NULL, 1, '30.82', '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 0, 0, 0, '4.6', NULL, NULL, 'Professional Therapist - Andre Windler', 'consequatur veritatis doloribus earum illum occaecati suscipit et ex voluptatem', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(9, 29, 'romazulauf', 'Modi magni ipsa dolor mollitia. Eligendi in vel dolores illo aut.\n\nMollitia eius vero atque aut enim. Ea expedita iusto aut a.\n\nCorrupti recusandae tempore omnis. Molestiae provident atque ratione quae illo iste quia mollitia. Aut eum aliquid sapiente temporibus doloremque fuga.', 'Velit porro vero voluptas repellendus delectus iusto.', NULL, 0, '29.18', '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 0, 0, 1, '4.4', NULL, NULL, 'Professional Therapist - Roma Zulauf', 'ullam mollitia vel blanditiis soluta quo delectus eos dicta repudiandae', NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(10, 30, 'shanonroob', 'Et consequatur delectus rerum enim quo necessitatibus perspiciatis voluptas. Hic consequatur qui atque numquam omnis voluptates eos explicabo. Dolore asperiores eum nihil omnis. Enim non est totam ad voluptatem necessitatibus accusantium. Dolores rerum ipsam ipsa labore.\n\nQuo dolorum quo corrupti incidunt. Impedit ratione neque modi at inventore quia est. Quae voluptas maxime expedita. Unde omnis officia aut explicabo a.\n\nEaque ducimus ut soluta. Sint architecto quia quas sunt debitis. Non mollitia voluptatem rerum consectetur rerum quia nihil. Quia quos esse beatae molestiae animi.', NULL, NULL, 0, '19.56', '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 1, 0, 1, 1, 1, 0, NULL, NULL, NULL, 'Professional Therapist - Shanon Roob', 'voluptas omnis vitae minus sapiente et et fugiat dignissimos nobis', 'voluptatem non et aut eos', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(11, 31, 'reaganbruen', 'Ut quo nesciunt alias illo. Reprehenderit animi sed repellat possimus et at. Architecto quia eum quibusdam impedit similique ab.\n\nSit ratione quia veritatis omnis. Voluptas explicabo sed quidem quia sed ut. Est corporis adipisci distinctio quos accusantium.\n\nSit itaque ut repellendus aperiam. Quia saepe at provident aut. Iste in deleniti nulla eum.', NULL, NULL, 0, NULL, '60.00', '90.00', '120.00', '150.00', '180.00', '210.00', 0, 1, 1, 0, 0, 1, NULL, NULL, '198.34', 'Professional Therapist - Reagan Bruen', 'iure consequatur ducimus reiciendis vel necessitatibus soluta numquam rerum a', 'et cumque explicabo similique sunt', '2026-07-13 07:30:46', '2026-07-13 07:30:46');

-- --------------------------------------------------------

--
-- Table structure for table `therapist_schedule`
--

CREATE TABLE `therapist_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `mon` varchar(255) NOT NULL,
  `tue` varchar(255) NOT NULL,
  `wed` varchar(255) NOT NULL,
  `thu` varchar(255) NOT NULL,
  `fri` varchar(255) NOT NULL,
  `sat` varchar(255) NOT NULL,
  `sun` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapist_schedule`
--

INSERT INTO `therapist_schedule` (`id`, `user_id`, `mon`, `tue`, `wed`, `thu`, `fri`, `sat`, `sun`, `created_at`, `updated_at`) VALUES
(1, 21, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(2, 22, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(3, 23, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(4, 24, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(5, 25, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(6, 26, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(7, 27, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(8, 28, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(9, 29, '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '11:00,11:30,12:00,12:30,13:00,13:30,14:00', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(10, 30, '14:00,14:30', '14:00,14:30', '14:00,14:30', '14:00,14:30', '14:00,14:30', '14:00,14:30', '14:00,14:30', '2026-07-13 07:30:46', '2026-07-20 05:00:45'),
(11, 31, '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '10:00,10:30,11:00,11:30,12:00,12:30,13:00,13:30,14:00,14:30,15:00,15:30,16:00,16:30,17:00', '2026-07-13 07:30:46', '2026-07-20 07:05:34');

-- --------------------------------------------------------

--
-- Table structure for table `treatments`
--

CREATE TABLE `treatments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `technique` longtext NOT NULL,
  `ideal_for` longtext NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `on_treatment_page` tinyint(1) NOT NULL DEFAULT 0,
  `page_meta_title` varchar(255) NOT NULL,
  `page_meta_description` longtext NOT NULL,
  `page_extra_meta_tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatments`
--

INSERT INTO `treatments` (`id`, `name`, `title`, `slug`, `description`, `technique`, `ideal_for`, `image`, `image_alt`, `image_title`, `active`, `on_treatment_page`, `page_meta_title`, `page_meta_description`, `page_extra_meta_tags`, `created_at`, `updated_at`) VALUES
(1, 'BODY TUNE-UP', 'Neuro-Muscular Alignment', 'body-tune-up', '<p>Body engineering applied to wellbeing. Targeted deep tissue techniques combine with traditional Shiatsu pressure points to release chronic muscular knots, alleviate trigger points, restore mobility, and rebalance the body&rsquo;s natural alignment.</p>', 'Deep Tissue Massage,Shiatsu Pressure Point Therapy', 'Lower back pain,neck and shoulder tension from desk work, postural strain, morning stiffness.', 'body-and-tune.png', NULL, NULL, 1, 1, 'Deep Tissue Massage,Shiatsu Pressure Point Therapy', 'Deep Tissue Massage,Shiatsu Pressure Point Therapy', NULL, '2026-07-16 10:24:24', '2026-07-16 10:26:05'),
(2, 'MUSCLE RESET', 'Hyper-Recovery Session', 'muscle-reset', '<p>A dynamic combination of rhythmic compressions, sports stretching, and myofascial release techniques designed to oxygenate tissues, reduce muscular fatigue, improve circulation, and accelerate post-workout recovery.</p>', 'Sports Massage, Myofascial Release, Percussive Therapy (Optional Enhancement)', 'Amateur and professional athletes, runners, gym-goers, high-performance lifestyles.', 'muscle-reset.png', NULL, NULL, 1, 1, 'Sports Massage, Myofascial Release, Percussive Therapy (Optional Enhancement)', 'Sports Massage, Myofascial Release, Percussive Therapy (Optional Enhancement)', NULL, '2026-07-16 10:27:33', '2026-07-16 10:27:33'),
(3, 'MYO-FLOW', 'The Thai Kinetic Experience', 'myo-flow', '<p>Often described as &ldquo;passive yoga,&rdquo; this treatment combines sustained pressure techniques and intensive therapeutic stretches performed on a floor mat without oils. The session helps release fascial restrictions, improve flexibility, and restore freedom of movement throughout the body.</p>', 'Traditional Thai Massage, Fascial Release Therapy', 'Muscle tightness, limited flexibility, postural correction, mobility enhancement.', 'massage-at-home2.jpg', NULL, NULL, 1, 1, 'Traditional Thai Massage, Fascial Release Therapy', 'Traditional Thai Massage, Fascial Release Therapy', NULL, '2026-07-16 10:29:19', '2026-07-16 10:29:19'),
(4, 'THE DRIFT AWAY', 'The Reset & Glow Ritual', 'the-drift-away', '<p>The perfect union of deep relaxation and aesthetic wellbeing. Long, flowing massage strokes ease muscular tension throughout the body while helping to reduce stress and lower cortisol levels. The ritual is completed with gentle facial lymphatic drainage techniques to reduce puffiness, eliminate toxins, and restore a naturally radiant glow.</p>\r\n<p>A beautiful treatment designed to quiet the outside world and bring the body back into balance.</p>', 'Full-Body Swedish Massage, Facial Lymphatic Drainage', 'First-time clients, general relaxation, stress relief, post-travel recovery, jet lag, fluid retention after flights, restoring a healthy facial glow.', 'drift-away.png', NULL, NULL, 1, 1, 'Full-Body Swedish Massage, Facial Lymphatic Drainage', 'Full-Body Swedish Massage, Facial Lymphatic Drainage', NULL, '2026-07-16 10:30:32', '2026-07-16 10:30:32'),
(5, 'AROMA-PATHWAY', 'Sensory Botanical Journey', 'aroma-pathway', '<p>A fully personalised sensory journey created with carefully selected essential oil blends tailored to your needs. The full-body treatment is elevated by a deeply relaxing scalp and facial massage enhanced with warm aromatic compresses, helping to calm an overactive mind and soothe the nervous system.</p>', 'Aromatherapy Massage,Aromatherapeutic Scalp & Facial Fusion', 'Stress, anxiety, difficulty switching off from work, jet lag, sleep disruption, restoring natural circadian rhythms', 'massage-at-home2.jpg', NULL, NULL, 1, 1, 'Aromatherapy Massage,Aromatherapeutic Scalp & Facial Fusion', 'Aromatherapy Massage,Aromatherapeutic Scalp & Facial Fusion', NULL, '2026-07-16 10:32:07', '2026-07-16 10:32:07'),
(6, 'TIME TOGETHER', 'The Shared Sanctuary', 'time-together', '<p>Two therapists, one peaceful space. A side-by-side wellness experience designed for couples, friends, or family members seeking meaningful relaxation together. The treatment begins with a flowing relaxation massage and concludes with a dedicated reflexology sequence for the feet, helping to release everyday tension and promote total wellbeing.</p>\r\n<p>The experience may be completed with an aromatic refreshment, such as gourmet tea or sparkling wine, creating a memorable finishing touch.</p>', 'Synchronized Relaxation or Swedish Massage for Couples,Integrated Foot Reflexology', 'Anniversaries, special occasions, romantic getaways, luxury hotel stays, thoughtful gifts.', 'time-together.png', NULL, NULL, 1, 1, 'Synchronized Relaxation or Swedish Massage for Couples,Integrated Foot Reflexology', 'Synchronized Relaxation or Swedish Massage for Couples,Integrated Foot Reflexology', NULL, '2026-07-16 10:33:26', '2026-07-16 10:33:26'),
(7, 'OCEAN EMBRACE', 'The Wave Ritual', 'ocean-embrace', '<p>A deeply immersive ritual featuring long, flowing movements performed with the hands and forearms, echoing the rhythm of ocean waves to encourage emotional release and profound relaxation. The experience culminates with warm hydrothermal compresses applied to the neck and shoulders, followed by a soothing Indian head massage designed to completely quiet the mind.</p>', 'Hawaiian Lomi Lomi,Indian Head Massage,Hydrothermal Compresses', 'Chronic stress, burnout, mental fatigue, emotional exhaustion.', 'ocean-embrace.png', NULL, NULL, 1, 1, 'Hawaiian Lomi Lomi,Indian Head Massage,Hydrothermal Compresses', 'Hawaiian Lomi Lomi,Indian Head Massage,Hydrothermal Compresses', NULL, '2026-07-16 10:34:40', '2026-07-16 10:34:40'),
(8, 'ASHI-BALANCE', 'Deep Gravity Therapy', 'ashi-balance', '<p>A high-pressure therapeutic experience where the therapist uses their feet and body weight instead of their hands to deliver deep, broad compressions across the body. This unique fusion of Ashiatsu and assisted stretching helps restore structural balance, improve posture, and release deeply held muscular tension.</p>', 'Ashiatsu Barefoot Massage,Assisted Passive Stretching', 'Fighters, weightlifters, CrossFit athletes, golfers, football and rugby players, anyone who enjoys exceptionally deep pressure.', 'massage-at-home2.jpg', NULL, NULL, 1, 1, 'Ashiatsu Barefoot Massage,Assisted Passive Stretching', 'Ashiatsu Barefoot Massage,Assisted Passive Stretching', NULL, '2026-07-16 10:36:16', '2026-07-16 10:36:16'),
(9, 'STONE MELT', 'Thermal Grounding Experience', 'stone-melt', '<p>Perfectly polished volcanic stones, heated to the ideal temperature, glide across the body with warm botanical oils, instantly melting muscular tension and stiffness. The ritual concludes with a soothing facial and scalp massage, grounding the body and mind in a state of complete relaxation and restoration.</p>', 'Hot Stone Therapy,Craniofacial Massage,Warm Botanical Oils', 'Stress relief, poor circulation, cold-weather relaxation, chronic aches and pains, jet lag, deep muscular stiffness following long flights', 'massage-at-home2.jpg', NULL, NULL, 1, 1, 'Hot Stone Therapy,Craniofacial Massage,Warm Botanical Oils', 'Hot Stone Therapy,Craniofacial Massage,Warm Botanical Oils', NULL, '2026-07-16 10:38:23', '2026-07-16 10:38:23'),
(10, 'SYMPHONIC TOUCH', 'The Four-Hands Ritual', 'symphonic-touch', '<p>A masterpiece of bodywork. Two therapists work in perfect symmetry and rhythmic synchronicity, creating a continuous wave of movement that envelops your entire body simultaneously. A choreographed ultra-luxury experience designed to positively overwhelm the senses and induce the deepest state of relaxation known</p>', 'Symmetrical Four-Hands Massage (Two Therapists),Premium Aromatherapy.', 'Extreme burnout, ultimate luxury seekers, severe jet lag, total mental overload, deeply rooted muscular tension', 'massage-at-home2.jpg', 'Symmetrical Four-Hands Massage (Two Therapists),Premium Aromatherapy.', 'Symmetrical Four-Hands Massage (Two Therapists),Premium Aromatherapy.', 1, 1, 'Symmetrical Four-Hands Massage (Two Therapists),Premium Aromatherapy.', 'Symmetrical Four-Hands Massage (Two Therapists),Premium Aromatherapy.', NULL, '2026-07-16 10:39:48', '2026-07-16 10:48:54');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_categories`
--

CREATE TABLE `treatment_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatment_categories`
--

INSERT INTO `treatment_categories` (`id`, `name`, `slug`, `description`, `image`, `image_alt`, `image_title`, `active`, `created_at`, `updated_at`) VALUES
(1, 'Therapeutic and performance', 'therapeutic-and-performance', 'Designed for measurable results, recovery, and optimal body function.', 'therapeutic-and-performance.jpg', NULL, NULL, 1, '2026-07-16 06:15:29', '2026-07-16 10:17:05'),
(2, 'Relax and Connection', 'relax-and-connection', 'Focused on sensory wellbeing, relaxation and meaningful moments of connection.', 'relax-and-connection.jpg', NULL, NULL, 1, '2026-07-16 10:14:17', '2026-07-16 10:17:23'),
(3, 'Signature Experiences', 'signature-experiences', 'Exclusive rituals inspired by rare and exotic massage traditions.', 'signature-experience.jpg', NULL, NULL, 1, '2026-07-16 10:14:47', '2026-07-16 10:17:35');

-- --------------------------------------------------------

--
-- Table structure for table `treatment_treatment_category`
--

CREATE TABLE `treatment_treatment_category` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `treatment_id` int(10) UNSIGNED NOT NULL,
  `treatment_category_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `treatment_treatment_category`
--

INSERT INTO `treatment_treatment_category` (`id`, `treatment_id`, `treatment_category_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 1, NULL, NULL),
(3, 3, 1, NULL, NULL),
(4, 4, 2, NULL, NULL),
(5, 5, 2, NULL, NULL),
(6, 6, 2, NULL, NULL),
(7, 7, 3, NULL, NULL),
(8, 8, 3, NULL, NULL),
(9, 9, 3, NULL, NULL),
(10, 10, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `user_type` enum('Admin','Therapist','Customer') NOT NULL DEFAULT 'Customer',
  `ip_address` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `user_type`, `ip_address`, `remember_token`, `active`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'User', 'admin@blueocean.com', '2026-07-13 07:30:45', '$2y$12$Glm0TnjHdnLpxkiZ9Zy2y.FLaDUjLsLoKl0KAIytCHzHVHJpep8fy', 'Admin', '127.0.0.1', 'rxRPamPtCw6tdtlJy5B6LLOa2tgySZBsZKXE1HCVr8xcUZ96eTvDTK6fItdZ', 1, '2026-07-20 12:57:20', NULL, '2026-07-20 12:57:20'),
(2, 'Tierra', 'Nikolaus', 'green.jessy@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'QdBEIqgyN1', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(3, 'Richie', 'Hyatt', 'jmaggio@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'tCcL8gAQft', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(4, 'Mariela', 'Quigley', 'ubosco@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, '6yHOY86vwk', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(5, 'Giuseppe', 'Leannon', 'franecki.ari@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'zUxB5HhXej', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(6, 'Georgette', 'Rohan', 'pokeefe@example.org', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, '9KkAnmPvLI', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(7, 'Bert', 'Romaguera', 'braxton13@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'ym62yzaPGQ', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(8, 'Olaf', 'Baumbach', 'andrew.goyette@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'hb49KePGO2', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(9, 'Tremaine', 'Erdman', 'rosa.weber@example.org', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'FSd2cBQs8M', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(10, 'Jackson', 'Thiel', 'aiyana11@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'bXoFSVTuwR', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(11, 'Jerod', 'Marquardt', 'swaelchi@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'OVpSgu05l1', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(12, 'Cecil', 'Beier', 'howell.isadore@example.org', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'vJpoPizi0r', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(13, 'Giuseppe', 'Gleichner', 'reichel.angelita@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, '3sdk5yt2nb', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(14, 'Addie', 'Nikolaus', 'anderson.gerson@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'B9K9ODPHBf', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(15, 'Antone', 'Mills', 'hgreen@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'WhVhwenFA4', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(16, 'Verona', 'Kuphal', 'stevie.hirthe@example.org', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'iD6kyuMSQj', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(17, 'Genoveva', 'Hickle', 'wlittel@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'NxKMDGBz0C', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(18, 'Tiara', 'Pacocha', 'octavia.kunze@example.net', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'N2b24oNhWA', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(19, 'Karina', 'Kilback', 'mlesch@example.com', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'lIaHdiDbUq', 1, NULL, '2026-07-13 07:30:45', '2026-07-13 07:30:46'),
(20, 'Mylene', 'McClure', 'savanah58@example.org', '2026-07-13 07:30:45', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Customer', NULL, 'uIYsNHQDR4', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(21, 'Emmy', 'Blanda', 'gortiz@example.org', '2026-07-13 07:40:17', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'QYflj33ElQ', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:40:17'),
(22, 'Annetta', 'Wisoky', 'tristian26@example.net', '2026-07-13 07:40:32', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'zC5H3xzcTf', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:40:32'),
(23, 'Lauren', 'Wehner', 'emilie.jacobson@example.net', '2026-07-13 07:40:44', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'et3VRwtNgk', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:40:44'),
(24, 'Kayden', 'Cormier', 'will.allan@example.com', '2026-07-13 07:41:50', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'QpSjdUYpBX', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:41:50'),
(25, 'Garret', 'Rath', 'verdie75@example.org', '2026-07-13 07:43:47', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'FglcW95U2Q', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:43:47'),
(26, 'Erich', 'Gutkowski', 'lavada28@example.org', '2026-07-13 07:35:12', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'ZCwY1GQ4tM', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:35:12'),
(27, 'Jarrell', 'Reynolds', 'schmeler.geraldine@example.com', '2026-07-13 07:34:49', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'AVoh9e4rHV', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:34:49'),
(28, 'Marianna', 'Towne', 'kautzer.urban@example.org', '2026-07-13 07:34:33', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'za9gR0GWQB', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:34:33'),
(29, 'Lee', 'Miller', 'delphia03@example.org', '2026-07-13 07:34:17', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'HJBHxVziSI', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:34:17'),
(30, 'Angelica', 'Rath', 'etremblay@example.net', '2026-07-13 07:33:49', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', NULL, 'rydmkJsnop', 1, NULL, '2026-07-13 07:30:46', '2026-07-13 07:33:49'),
(31, 'Jaqueline', 'Considine', 'sylvan.terry@example.org', '2026-07-13 07:33:34', '$2y$12$bnR0wKDZJp.8JKr8ADeHOu8Kzr.Cfc.2774HE0g3MKDUgu4QE1Gwm', 'Therapist', '127.0.0.1', 'sl8fGpyJUKMMZiV6usZNAHZHxR4pfnUfAHDEhc2M4cYwIuSlumbLdFfnRVZO', 1, '2026-07-20 02:13:50', '2026-07-13 07:30:46', '2026-07-20 02:13:50');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `image_alt` varchar(255) DEFAULT NULL,
  `image_title` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `postcode` varchar(255) DEFAULT NULL,
  `flat_no` varchar(255) DEFAULT NULL,
  `street_no` varchar(255) DEFAULT NULL,
  `street_name` varchar(255) DEFAULT NULL,
  `town` varchar(255) DEFAULT NULL,
  `avg_rating` decimal(2,1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `image`, `image_alt`, `image_title`, `birthday`, `mobile`, `postcode`, `flat_no`, `street_no`, `street_name`, `town`, `avg_rating`, `created_at`, `updated_at`) VALUES
(1, 2, 'https://placehold.co/400x400', NULL, NULL, '2022-02-14', '458.763.8115', '33495-0222', '58157', 'Leuschke Burg', '895 Pouros Springs Suite 455', 'Lake Salvatore', '1.2', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(2, 3, 'https://placehold.co/400x400', NULL, NULL, '2023-09-30', '+18722317054', '35088-5658', '231', 'Kelsi Inlet', '2601 O\'Hara Ferry', 'New Gust', '3.0', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(3, 4, 'https://placehold.co/400x400', NULL, NULL, '1994-03-29', '+16468590040', '20482', '918', 'D\'Amore Pines', '1352 Emilia Club Apt. 695', 'Savannafurt', '4.3', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(4, 5, 'https://placehold.co/400x400', NULL, NULL, '2002-03-25', '+13126167504', '13895', '649', 'Lindgren Divide', '3415 D\'Amore Point Suite 010', 'South Allisonport', '1.9', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(5, 6, 'https://placehold.co/400x400', NULL, NULL, '2026-06-16', '1-678-485-6738', '73753', '785', 'Ferry Summit', '946 Greenfelder Throughway', 'Ravenchester', '2.5', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(6, 7, 'https://placehold.co/400x400', NULL, NULL, '1991-06-29', '+12676931682', '00205-9128', '2198', 'Rosenbaum Spur', '335 Sammy Unions Suite 092', 'New Vivianside', '2.9', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(7, 8, 'https://placehold.co/400x400', NULL, NULL, '1982-01-09', '409.877.9453', '56395', '248', 'Graham Run', '9613 Jakubowski Manors', 'Westland', '1.9', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(8, 9, 'https://placehold.co/400x400', NULL, NULL, '2010-12-01', '(628) 777-5168', '67953-5847', '109', 'Lexus Stream', '4479 Kilback Radial', 'Eleazarville', '2.3', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(9, 10, 'https://placehold.co/400x400', NULL, NULL, '2004-05-04', '+1.201.570.3246', '02154-4309', '8486', 'Will Forges', '708 Parker Orchard Suite 385', 'Lake Lonzomouth', '4.4', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(10, 11, 'https://placehold.co/400x400', NULL, NULL, '1973-11-01', '+1 (531) 942-3929', '25079', '4651', 'Casimir Forge', '323 Joanie View', 'South Marquise', '1.3', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(11, 12, 'https://placehold.co/400x400', NULL, NULL, '1974-02-01', '+1-870-334-7164', '21143', '573', 'Arnoldo Curve', '79374 Kacie Square Apt. 488', 'Edwinshire', '3.5', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(12, 13, 'https://placehold.co/400x400', NULL, NULL, '1988-08-27', '+1-754-666-1807', '45025-3658', '25536', 'Champlin Locks', '304 Lue Hollow Suite 268', 'Lake Hallie', '3.1', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(13, 14, 'https://placehold.co/400x400', NULL, NULL, '2019-01-28', '1-940-394-2283', '36943', '285', 'Shields Forks', '9273 Bridgette Port', 'New Gladyceview', '4.3', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(14, 15, 'https://placehold.co/400x400', NULL, NULL, '2013-06-06', '1-832-681-8320', '84173', '387', 'Goldner Mountains', '755 Aron Mills Apt. 378', 'Lake Anissaville', '1.4', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(15, 16, 'https://placehold.co/400x400', NULL, NULL, '2011-02-22', '+1 (651) 889-3144', '09400-0283', '26015', 'Greenfelder Corner', '35873 Precious Plaza', 'North Eunashire', '2.1', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(16, 17, 'https://placehold.co/400x400', NULL, NULL, '1976-09-15', '351.716.5471', '09419', '479', 'Jailyn Island', '678 Bednar Shoals', 'South Kelsiemouth', '2.0', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(17, 18, 'https://placehold.co/400x400', NULL, NULL, '1996-02-17', '(248) 707-9469', '84810-5108', '791', 'Kyra Ports', '7775 Hyatt Trafficway', 'Port Sienna', '1.1', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(18, 19, 'https://placehold.co/400x400', NULL, NULL, '1984-02-08', '+1 (442) 803-9004', '07595-8433', '100', 'Lemke Lodge', '8029 Bogisich Port', 'Mosciskihaven', '4.3', '2026-07-13 07:30:45', '2026-07-13 07:30:45'),
(19, 20, 'https://placehold.co/400x400', NULL, NULL, '2007-02-27', '+1-657-681-7159', '66601-8281', '621', 'Kozey Trail', '237 Lucienne Knoll', 'Glendamouth', '4.8', '2026-07-13 07:30:46', '2026-07-13 07:30:46'),
(20, 21, 'tresha.jpg', NULL, NULL, '2011-10-20', '(864) 235-9269', '75788', '693', 'Braun Radial', '1027 Ruecker Valley', 'Assuntachester', '1.3', '2026-07-13 07:30:46', '2026-07-13 07:40:17'),
(21, 22, 'knock.jpg', NULL, NULL, '1986-09-11', '929-204-6237', '63356-3869', '64338', 'Mozell Mews', '440 Shyanne Locks', 'Hilpertfort', '4.7', '2026-07-13 07:30:46', '2026-07-13 07:40:32'),
(22, 23, 'mariana.jpg', NULL, NULL, '2013-01-01', '(205) 866-3198', '68563', '6958', 'Anastacio Burg', '7373 Lehner Island', 'East Chelsey', '4.0', '2026-07-13 07:30:46', '2026-07-13 07:40:45'),
(23, 24, 'angy.jpg', NULL, NULL, '2025-04-09', '(469) 770-8533', '27060', '46400', 'Emie Port', '5159 Makenzie Park', 'East Tiffanyton', '1.3', '2026-07-13 07:30:46', '2026-07-13 07:41:50'),
(24, 25, 'krystina.jpg', NULL, NULL, '2010-03-21', '941-247-3072', '20132-9677', '336', 'Jakayla Streets', '21484 Moen Camp', 'Hermanfort', '4.8', '2026-07-13 07:30:46', '2026-07-13 07:43:47'),
(25, 26, 'therapist-margery.jpg', NULL, NULL, '1985-04-17', '(251) 773-7643', '35672', '3886', 'Mckayla Parks', '18551 Gerhold Village Suite 604', 'Troytown', '4.3', '2026-07-13 07:30:46', '2026-07-13 07:35:12'),
(26, 27, 'therapist-jane.jpg', NULL, NULL, '1978-01-24', '1-517-460-4774', '30356-0781', '9886', 'Brakus Square', '6790 Sibyl Common', 'Ronnyville', '1.4', '2026-07-13 07:30:46', '2026-07-13 07:34:49'),
(27, 28, 'therapist-hope.jpg', NULL, NULL, '1974-02-10', '339-925-0628', '34321-9837', '30547', 'Clarabelle Common', '908 Tremayne Square', 'New Prudenceside', '3.3', '2026-07-13 07:30:46', '2026-07-13 07:34:33'),
(28, 29, 'therapist-autinia.jpg', NULL, NULL, '1999-09-01', '7817056090', '10242-1552', '3430', 'Sherwood Estates', '26725 Leannon Hollow Suite 136', 'Jamesonburgh', '1.7', '2026-07-13 07:30:46', '2026-07-13 07:34:17'),
(29, 30, 'therapist-angelina.jpg', NULL, NULL, '1992-06-30', '630-755-9664', '18557', '74967', 'Kunze Knoll', '954 Rutherford Circles Apt. 353', 'Roselynfort', '3.9', '2026-07-13 07:30:46', '2026-07-13 07:33:49'),
(30, 31, 'therapist-amber.jpg', NULL, NULL, '2012-05-24', '(754) 512-0283', '14719-4811', '4904', 'Lelia Heights', '32016 Nolan Forges', 'West Harrison', '4.0', '2026-07-13 07:30:46', '2026-07-13 07:33:35');

-- --------------------------------------------------------

--
-- Table structure for table `user_verify`
--

CREATE TABLE `user_verify` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blacklists`
--
ALTER TABLE `blacklists`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gift_certificates`
--
ALTER TABLE `gift_certificates`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_received`
--
ALTER TABLE `payment_received`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `postcodes`
--
ALTER TABLE `postcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcode_districts`
--
ALTER TABLE `postcode_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcode_zones`
--
ALTER TABLE `postcode_zones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postcode_zones_postcodes`
--
ALTER TABLE `postcode_zones_postcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `posts_slug_unique` (`slug`);

--
-- Indexes for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_comments_post_id_foreign` (`post_id`);

--
-- Indexes for table `post_post_tag`
--
ALTER TABLE `post_post_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_post_tag_post_id_foreign` (`post_id`),
  ADD KEY `post_post_tag_post_tag_id_foreign` (`post_tag_id`);

--
-- Indexes for table `post_tags`
--
ALTER TABLE `post_tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_tags_name_unique` (`name`),
  ADD UNIQUE KEY `post_tags_slug_unique` (`slug`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tariff_plans`
--
ALTER TABLE `tariff_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapists_holidays`
--
ALTER TABLE `therapists_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapists_mandates`
--
ALTER TABLE `therapists_mandates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapists_postcodes`
--
ALTER TABLE `therapists_postcodes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapists_treatments`
--
ALTER TABLE `therapists_treatments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapist_applications`
--
ALTER TABLE `therapist_applications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `therapist_profiles`
--
ALTER TABLE `therapist_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `therapist_profiles_user_id_unique` (`user_id`),
  ADD UNIQUE KEY `therapist_profiles_slug_unique` (`slug`);

--
-- Indexes for table `therapist_schedule`
--
ALTER TABLE `therapist_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatments`
--
ALTER TABLE `treatments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `treatments_slug_unique` (`slug`);

--
-- Indexes for table `treatment_categories`
--
ALTER TABLE `treatment_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment_treatment_category`
--
ALTER TABLE `treatment_treatment_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_profiles_user_id_unique` (`user_id`);

--
-- Indexes for table `user_verify`
--
ALTER TABLE `user_verify`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blacklists`
--
ALTER TABLE `blacklists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `gift_certificates`
--
ALTER TABLE `gift_certificates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payment_received`
--
ALTER TABLE `payment_received`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `postcodes`
--
ALTER TABLE `postcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=385;

--
-- AUTO_INCREMENT for table `postcode_districts`
--
ALTER TABLE `postcode_districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `postcode_zones`
--
ALTER TABLE `postcode_zones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `postcode_zones_postcodes`
--
ALTER TABLE `postcode_zones_postcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=276;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `post_post_tag`
--
ALTER TABLE `post_post_tag`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `post_tags`
--
ALTER TABLE `post_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tariff_plans`
--
ALTER TABLE `tariff_plans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `therapists_holidays`
--
ALTER TABLE `therapists_holidays`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `therapists_mandates`
--
ALTER TABLE `therapists_mandates`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `therapists_postcodes`
--
ALTER TABLE `therapists_postcodes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `therapists_treatments`
--
ALTER TABLE `therapists_treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `therapist_applications`
--
ALTER TABLE `therapist_applications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `therapist_profiles`
--
ALTER TABLE `therapist_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `therapist_schedule`
--
ALTER TABLE `therapist_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `treatments`
--
ALTER TABLE `treatments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `treatment_categories`
--
ALTER TABLE `treatment_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `treatment_treatment_category`
--
ALTER TABLE `treatment_treatment_category`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `user_verify`
--
ALTER TABLE `user_verify`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `post_post_tag`
--
ALTER TABLE `post_post_tag`
  ADD CONSTRAINT `post_post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_post_tag_post_tag_id_foreign` FOREIGN KEY (`post_tag_id`) REFERENCES `post_tags` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `therapist_profiles`
--
ALTER TABLE `therapist_profiles`
  ADD CONSTRAINT `therapist_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
