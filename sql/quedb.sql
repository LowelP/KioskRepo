-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 25, 2025 at 05:28 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `display_on_transfer_ticket` tinyint(1) DEFAULT 0,
  `backend_visible` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `counters`
--

CREATE TABLE `counters` (
  `id` int(11) NOT NULL,
  `counter_name` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `counters`
--

INSERT INTO `counters` (`id`, `counter_name`, `is_active`, `created_at`) VALUES
(1, 'counter 1', 1, '2025-06-20 10:08:05');

-- --------------------------------------------------------

--
-- Table structure for table `data_retention_policy`
--

CREATE TABLE `data_retention_policy` (
  `id` int(11) NOT NULL,
  `archive_after_days` int(11) DEFAULT NULL,
  `purge_after_days` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `available_slots` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `description`, `available_slots`) VALUES
(1, 'cashier', 'bayadan ng utang', 17),
(2, 'Admission', 'admission', 15),
(3, 'MIS', 'Mis', 39),
(4, 'Registrar', 'Registrar', 1);

-- --------------------------------------------------------

--
-- Table structure for table `department_videos`
--

CREATE TABLE `department_videos` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `display_start` datetime DEFAULT NULL,
  `display_end` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `email_api_settings`
--

CREATE TABLE `email_api_settings` (
  `id` int(11) NOT NULL,
  `provider_name` varchar(100) DEFAULT NULL,
  `api_key` text DEFAULT NULL,
  `sender_email` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `student_number` varchar(50) DEFAULT NULL,
  `department_visited` varchar(100) DEFAULT NULL,
  `date_of_visit` date DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holiday_calendar`
--

CREATE TABLE `holiday_calendar` (
  `id` int(11) NOT NULL,
  `holiday_name` varchar(100) DEFAULT NULL,
  `holiday_date` date DEFAULT NULL,
  `is_enabled` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` int(11) NOT NULL,
  `message_type` enum('BOOKING_CONFIRMATION','NO_SHOW_WARNING','REMINDER','FEEDBACK_ACK','ANNOUNCEMENT') DEFAULT NULL,
  `message_content` text DEFAULT NULL,
  `schedule_date` datetime DEFAULT NULL,
  `auto_dismiss_time` int(11) DEFAULT NULL,
  `max_per_user` int(11) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otp_verification`
--

CREATE TABLE `otp_verification` (
  `id` int(11) NOT NULL,
  `email_address` varchar(255) DEFAULT NULL,
  `otp_code` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) DEFAULT 0,
  `is_used` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promotional_videos`
--

CREATE TABLE `promotional_videos` (
  `id` int(11) NOT NULL,
  `title` varchar(150) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `video_path` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_configurations`
--

CREATE TABLE `queue_configurations` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `ideal_wait_time` int(11) DEFAULT NULL,
  `booking_day_count` int(11) DEFAULT NULL,
  `no_show_limit` int(11) DEFAULT 3,
  `allow_kiosk_when_blocked` tinyint(1) DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_configurations`
--

INSERT INTO `queue_configurations` (`id`, `department_id`, `ideal_wait_time`, `booking_day_count`, `no_show_limit`, `allow_kiosk_when_blocked`, `created_at`) VALUES
(1, 4, NULL, 5, 3, 1, '2025-07-28 19:35:48'),
(2, 1, NULL, 5, 3, 1, '2025-07-28 20:08:25'),
(3, 2, NULL, 5, 3, 1, '2025-07-28 20:08:45'),
(4, 3, NULL, 5, 3, 1, '2025-07-28 20:09:13');

-- --------------------------------------------------------

--
-- Table structure for table `queue_number`
--

CREATE TABLE `queue_number` (
  `id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `last_queue_number` varchar(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `queue_reservation_id` varchar(10) NOT NULL,
  `last_update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_number`
--

INSERT INTO `queue_number` (`id`, `department_id`, `last_queue_number`, `created_at`, `queue_reservation_id`, `last_update_date`) VALUES
(1, 1, '33', '2025-07-30 18:50:54', 'C1766', '2025-08-25 03:28:06'),
(2, 2, '35', '2025-07-30 19:24:10', 'A2141', '2025-08-25 04:40:01'),
(3, 3, '11', '2025-07-30 19:24:48', 'M1414', '2025-08-17 17:00:35'),
(4, 4, '50', '2025-07-30 19:25:23', 'R6382', '2025-08-25 05:09:27');

-- --------------------------------------------------------

--
-- Table structure for table `queue_reports`
--

CREATE TABLE `queue_reports` (
  `id` int(11) NOT NULL,
  `queue_id` int(11) DEFAULT NULL,
  `response_time` int(11) DEFAULT NULL,
  `wait_time` int(11) DEFAULT NULL,
  `closed_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `queue_reservations`
--

CREATE TABLE `queue_reservations` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `queue_number` varchar(10) DEFAULT NULL,
  `reservation_date` datetime DEFAULT current_timestamp(),
  `reservation_time` timestamp NULL DEFAULT current_timestamp(),
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `source` varchar(255) DEFAULT NULL,
  `student_id` int(11) DEFAULT NULL,
  `booking_type` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `queue_reservation_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `queue_reservations`
--

INSERT INTO `queue_reservations` (`id`, `full_name`, `email`, `address`, `department_id`, `transaction_id`, `queue_number`, `reservation_date`, `reservation_time`, `status`, `created_at`, `updated_at`, `source`, `student_id`, `booking_type`, `user_type`, `queue_reservation_id`) VALUES
(84, 'kabi', NULL, NULL, 3, 3, NULL, '2025-08-13 18:06:54', '2025-08-13 10:06:54', NULL, '2025-08-13 10:06:54', '2025-08-13 10:06:54', 'By Kiosk', NULL, '', 'new', 'M7230'),
(85, 'kabi', NULL, NULL, 3, 6, NULL, '2025-08-13 18:15:36', '2025-08-13 10:15:36', NULL, '2025-08-13 10:15:36', '2025-08-13 10:15:36', 'By Kiosk', NULL, '', 'new', 'M2268'),
(86, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-13 18:16:18', '2025-08-13 10:16:18', NULL, '2025-08-13 10:16:18', '2025-08-13 10:16:18', 'By Kiosk', NULL, '', 'old', 'C5488'),
(87, 'sad', NULL, NULL, 3, 3, NULL, '2025-08-13 18:16:56', '2025-08-13 10:16:56', NULL, '2025-08-13 10:16:56', '2025-08-13 10:16:56', 'By Kiosk', NULL, '', 'new', 'M6179'),
(88, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-13 18:20:24', '2025-08-13 10:20:24', NULL, '2025-08-13 10:20:24', '2025-08-13 10:20:24', 'By Kiosk', NULL, '', 'old', 'R7466'),
(89, 'sad', NULL, NULL, 1, 5, NULL, '2025-08-13 18:21:10', '2025-08-13 10:21:10', NULL, '2025-08-13 10:21:10', '2025-08-13 10:21:10', 'By Kiosk', NULL, '', 'new', 'C8191'),
(90, 'sad', NULL, NULL, 1, 1, NULL, '2025-08-13 18:24:31', '2025-08-13 10:24:31', NULL, '2025-08-13 10:24:31', '2025-08-13 10:24:31', 'By Kiosk', NULL, '', 'new', 'C1817'),
(91, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-13 18:28:41', '2025-08-13 10:28:41', NULL, '2025-08-13 10:28:41', '2025-08-13 10:28:41', 'By Kiosk', NULL, '', 'new', 'C1103'),
(92, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-13 18:30:29', '2025-08-13 10:30:29', NULL, '2025-08-13 10:30:29', '2025-08-13 10:30:29', 'By Kiosk', NULL, '', 'new', 'C2832'),
(93, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-13 18:54:03', '2025-08-13 10:54:03', NULL, '2025-08-13 10:54:03', '2025-08-13 10:54:03', 'By Kiosk', NULL, '', 'old', 'C5459'),
(94, 'sad', NULL, NULL, 1, 1, NULL, '2025-08-13 19:34:19', '2025-08-13 11:34:19', NULL, '2025-08-13 11:34:19', '2025-08-13 11:34:19', 'By Kiosk', NULL, '', 'old', 'C1129'),
(95, 'kabi', NULL, NULL, 3, 6, NULL, '2025-08-14 08:05:17', '2025-08-14 00:05:17', NULL, '2025-08-14 00:05:17', '2025-08-14 00:05:17', 'By Kiosk', NULL, '', 'new', 'M8937'),
(96, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-14 11:46:27', '2025-08-14 03:46:27', NULL, '2025-08-14 03:46:27', '2025-08-14 03:46:27', 'By Kiosk', NULL, '', 'new', 'R3243'),
(97, 'sad', NULL, NULL, 1, 5, NULL, '2025-08-14 11:54:15', '2025-08-14 03:54:15', NULL, '2025-08-14 03:54:15', '2025-08-14 03:54:15', 'By Kiosk', NULL, '', 'new', 'C3457'),
(98, 'sad', NULL, NULL, 3, 6, NULL, '2025-08-14 12:07:41', '2025-08-14 04:07:41', NULL, '2025-08-14 04:07:41', '2025-08-14 04:07:41', 'By Kiosk', NULL, '', 'new', 'M3965'),
(99, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-14 12:13:16', '2025-08-14 04:13:16', NULL, '2025-08-14 04:13:16', '2025-08-14 04:13:16', 'By Kiosk', NULL, '', 'new', 'R9070'),
(100, 'sad', NULL, NULL, 4, 4, NULL, '2025-08-14 12:27:56', '2025-08-14 04:27:56', NULL, '2025-08-14 04:27:56', '2025-08-14 04:27:56', 'By Kiosk', NULL, '', 'new', 'R9035'),
(101, 'sad', NULL, NULL, 1, 5, NULL, '2025-08-14 12:28:59', '2025-08-14 04:28:59', NULL, '2025-08-14 04:28:59', '2025-08-14 04:28:59', 'By Kiosk', NULL, '', 'new', 'C7136'),
(102, 'kabi', NULL, NULL, 3, 3, NULL, '2025-08-14 13:19:34', '2025-08-14 05:19:34', NULL, '2025-08-14 05:19:34', '2025-08-14 05:19:34', 'By Kiosk', NULL, '', 'new', 'M2209'),
(103, 'asddadsa', NULL, NULL, 4, 4, NULL, '2025-08-14 13:37:47', '2025-08-14 05:37:47', NULL, '2025-08-14 05:37:47', '2025-08-14 05:37:47', 'By Kiosk', NULL, '', 'old', 'R4150'),
(104, 'sad', NULL, NULL, 1, 1, NULL, '2025-08-17 14:50:09', '2025-08-17 06:50:09', NULL, '2025-08-17 06:50:09', '2025-08-17 06:50:09', 'By Kiosk', NULL, '', 'new', 'C2752'),
(105, 'sad', NULL, NULL, 3, 3, NULL, '2025-08-17 14:56:14', '2025-08-17 06:56:14', NULL, '2025-08-17 06:56:14', '2025-08-17 06:56:14', 'By Kiosk', NULL, '', 'old', 'M1494'),
(106, 'sad', NULL, NULL, 1, 1, NULL, '2025-08-17 14:56:37', '2025-08-17 06:56:37', NULL, '2025-08-17 06:56:37', '2025-08-17 06:56:37', 'By Kiosk', NULL, '', 'old', 'C4535'),
(107, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-17 22:38:50', '2025-08-17 14:38:50', NULL, '2025-08-17 14:38:50', '2025-08-17 14:38:50', 'By Kiosk', NULL, '', 'old', 'R2616'),
(108, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-17 22:39:58', '2025-08-17 14:39:58', NULL, '2025-08-17 14:39:58', '2025-08-17 14:39:58', 'By Kiosk', NULL, '', 'new', 'R1242'),
(109, 'kabi', NULL, NULL, 3, 6, NULL, '2025-08-17 22:40:38', '2025-08-17 14:40:38', NULL, '2025-08-17 14:40:38', '2025-08-17 14:40:38', 'By Kiosk', NULL, '', 'new', 'M6743'),
(110, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-17 22:41:58', '2025-08-17 14:41:58', NULL, '2025-08-17 14:41:58', '2025-08-17 14:41:58', 'By Kiosk', NULL, '', 'new', 'C9216'),
(111, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-17 22:49:36', '2025-08-17 14:49:36', NULL, '2025-08-17 14:49:36', '2025-08-17 14:49:36', 'By Kiosk', NULL, '', 'new', 'A1990'),
(112, 'kabi', NULL, NULL, 3, 6, NULL, '2025-08-17 23:00:35', '2025-08-17 15:00:35', NULL, '2025-08-17 15:00:35', '2025-08-17 15:00:35', 'By Kiosk', NULL, '', 'new', 'M1414'),
(113, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-17 23:09:11', '2025-08-17 15:09:11', NULL, '2025-08-17 15:09:11', '2025-08-17 15:09:11', 'By Kiosk', NULL, '', 'new', 'R7673'),
(114, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-17 23:13:43', '2025-08-17 15:13:43', NULL, '2025-08-17 15:13:43', '2025-08-17 15:13:43', 'By Kiosk', NULL, '', 'old', 'R5224'),
(115, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-17 23:18:05', '2025-08-17 15:18:05', NULL, '2025-08-17 15:18:05', '2025-08-17 15:18:05', 'By Kiosk', NULL, '', 'new', 'R1580'),
(116, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-17 23:35:17', '2025-08-17 15:35:17', NULL, '2025-08-17 15:35:17', '2025-08-17 15:35:17', 'By Kiosk', NULL, '', 'new', 'C3073'),
(117, 'kabi', NULL, NULL, 1, 5, NULL, '2025-08-17 23:39:44', '2025-08-17 15:39:44', NULL, '2025-08-17 15:39:44', '2025-08-17 15:39:44', 'By Kiosk', NULL, '', 'new', 'C3068'),
(118, 'qweq', NULL, NULL, 2, 2, NULL, '2025-08-18 00:02:51', '2025-08-17 16:02:51', NULL, '2025-08-17 16:02:51', '2025-08-17 16:02:51', 'By Kiosk', NULL, '', 'new', 'A8839'),
(119, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-18 00:04:01', '2025-08-17 16:04:01', NULL, '2025-08-17 16:04:01', '2025-08-17 16:04:01', 'By Kiosk', NULL, '', 'new', 'A8493'),
(120, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-18 00:10:36', '2025-08-17 16:10:36', NULL, '2025-08-17 16:10:36', '2025-08-17 16:10:36', 'By Kiosk', NULL, '', 'new', 'R1672'),
(121, 'weqweqw', NULL, NULL, 1, 1, NULL, '2025-08-18 12:21:49', '2025-08-18 04:21:49', NULL, '2025-08-18 04:21:49', '2025-08-18 04:21:49', 'By Kiosk', NULL, '', 'new', 'C6336'),
(122, 'weqweqw', NULL, NULL, 1, 5, NULL, '2025-08-18 12:23:16', '2025-08-18 04:23:16', NULL, '2025-08-18 04:23:16', '2025-08-18 04:23:16', 'By Kiosk', NULL, '', 'new', 'C5959'),
(123, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-18 12:27:12', '2025-08-18 04:27:12', NULL, '2025-08-18 04:27:12', '2025-08-18 04:27:12', 'By Kiosk', NULL, '', 'new', 'C9411'),
(124, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-18 12:27:35', '2025-08-18 04:27:35', NULL, '2025-08-18 04:27:35', '2025-08-18 04:27:35', 'By Kiosk', NULL, '', 'new', 'C4762'),
(125, 'sad', NULL, NULL, 1, 1, NULL, '2025-08-18 12:30:55', '2025-08-18 04:30:55', NULL, '2025-08-18 04:30:55', '2025-08-18 04:30:55', 'By Kiosk', NULL, '', 'new', 'C1771'),
(126, 'weqweqw', NULL, NULL, 4, 4, NULL, '2025-08-18 12:31:26', '2025-08-18 04:31:26', NULL, '2025-08-18 04:31:26', '2025-08-18 04:31:26', 'By Kiosk', NULL, '', 'new', 'R3876'),
(127, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-18 12:37:02', '2025-08-18 04:37:02', NULL, '2025-08-18 04:37:02', '2025-08-18 04:37:02', 'By Kiosk', NULL, '', 'new', 'C1181'),
(128, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-18 12:46:37', '2025-08-18 04:46:37', NULL, '2025-08-18 04:46:37', '2025-08-18 04:46:37', 'By Kiosk', NULL, '', 'new', 'C9974'),
(129, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-21 15:14:27', '2025-08-21 07:14:27', NULL, '2025-08-21 07:14:27', '2025-08-21 07:14:27', 'By Kiosk', NULL, '', 'old', 'C8863'),
(130, 'weqweqw', NULL, NULL, 2, 2, NULL, '2025-08-21 15:14:51', '2025-08-21 07:14:51', NULL, '2025-08-21 07:14:51', '2025-08-21 07:14:51', 'By Kiosk', NULL, '', 'new', 'A7311'),
(131, 'asdas', NULL, NULL, 2, 2, NULL, '2025-08-21 21:26:07', '2025-08-21 13:26:07', NULL, '2025-08-21 13:26:07', '2025-08-21 13:26:07', 'By Kiosk', NULL, '', 'new', 'A6502'),
(132, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-24 22:17:42', '2025-08-24 14:17:42', NULL, '2025-08-24 14:17:42', '2025-08-24 14:17:42', 'By Kiosk', NULL, '', 'old', 'A3525'),
(133, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-24 22:19:57', '2025-08-24 14:19:57', NULL, '2025-08-24 14:19:57', '2025-08-24 14:19:57', 'By Kiosk', NULL, '', 'new', 'A7386'),
(134, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-24 22:27:11', '2025-08-24 14:27:11', NULL, '2025-08-24 14:27:11', '2025-08-24 14:27:11', 'By Kiosk', NULL, '', 'new', 'A2515'),
(135, 'sad', NULL, NULL, 4, 4, NULL, '2025-08-24 22:49:02', '2025-08-24 14:49:02', NULL, '2025-08-24 14:49:02', '2025-08-24 14:49:02', 'By Kiosk', NULL, '', 'new', 'R3415'),
(136, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 00:20:10', '2025-08-24 16:20:10', NULL, '2025-08-24 16:20:10', '2025-08-24 16:20:10', 'By Kiosk', NULL, '', 'new', 'R5087'),
(137, 'kabi', NULL, NULL, 1, 1, NULL, '2025-08-25 09:28:06', '2025-08-25 01:28:06', NULL, '2025-08-25 01:28:06', '2025-08-25 01:28:06', 'By Kiosk', NULL, '', 'new', 'C1766'),
(138, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:14:37', '2025-08-25 02:14:37', NULL, '2025-08-25 02:14:37', '2025-08-25 02:14:37', 'By Kiosk', NULL, '', 'new', 'R5318'),
(139, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:22:40', '2025-08-25 02:22:40', NULL, '2025-08-25 02:22:40', '2025-08-25 02:22:40', 'By Kiosk', NULL, '', 'new', 'R6143'),
(140, 'sad', NULL, NULL, 4, 4, NULL, '2025-08-25 10:23:22', '2025-08-25 02:23:22', NULL, '2025-08-25 02:23:22', '2025-08-25 02:23:22', 'By Kiosk', NULL, '', 'parent', 'R6601'),
(141, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:27:33', '2025-08-25 02:27:33', NULL, '2025-08-25 02:27:33', '2025-08-25 02:27:33', 'By Kiosk', NULL, '', 'old', 'R5679'),
(142, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:33:01', '2025-08-25 02:33:01', NULL, '2025-08-25 02:33:01', '2025-08-25 02:33:01', 'By Kiosk', NULL, '', 'new', 'R9428'),
(143, 'sad', NULL, NULL, 4, 4, NULL, '2025-08-25 10:33:53', '2025-08-25 02:33:53', NULL, '2025-08-25 02:33:53', '2025-08-25 02:33:53', 'By Kiosk', NULL, '', 'new', 'R8955'),
(144, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:36:43', '2025-08-25 02:36:43', NULL, '2025-08-25 02:36:43', '2025-08-25 02:36:43', 'By Kiosk', NULL, '', 'old', 'R4508'),
(145, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:36:50', '2025-08-25 02:36:50', NULL, '2025-08-25 02:36:50', '2025-08-25 02:36:50', 'By Kiosk', NULL, '', 'old', 'R1855'),
(146, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:37:11', '2025-08-25 02:37:11', NULL, '2025-08-25 02:37:11', '2025-08-25 02:37:11', 'By Kiosk', NULL, '', 'new', 'R2372'),
(147, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:37:50', '2025-08-25 02:37:50', NULL, '2025-08-25 02:37:50', '2025-08-25 02:37:50', 'By Kiosk', NULL, '', 'new', 'R8298'),
(148, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:39:17', '2025-08-25 02:39:17', NULL, '2025-08-25 02:39:17', '2025-08-25 02:39:17', 'By Kiosk', NULL, '', 'new', 'R5167'),
(149, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 10:39:39', '2025-08-25 02:39:39', NULL, '2025-08-25 02:39:39', '2025-08-25 02:39:39', 'By Kiosk', NULL, '', 'new', 'R7642'),
(150, 'kabi', NULL, NULL, 2, 2, NULL, '2025-08-25 10:40:01', '2025-08-25 02:40:01', NULL, '2025-08-25 02:40:01', '2025-08-25 02:40:01', 'By Kiosk', NULL, '', 'new', 'A2141'),
(151, 'kabi', NULL, NULL, 4, 4, NULL, '2025-08-25 11:09:27', '2025-08-25 03:09:27', NULL, '2025-08-25 03:09:27', '2025-08-25 03:09:27', 'By Kiosk', NULL, '', 'new', 'R6382');

-- --------------------------------------------------------

--
-- Table structure for table `service_hours`
--

CREATE TABLE `service_hours` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') DEFAULT NULL,
  `opening_time` time DEFAULT NULL,
  `closing_time` time DEFAULT NULL,
  `enable_day` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `password_hash` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `department_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `department_id`, `category_id`, `name`, `created_by`, `created_at`) VALUES
(1, 1, NULL, 'Payment for Enrollment', NULL, '2025-07-19 13:33:24'),
(2, 2, NULL, 'Application Submission', NULL, '2025-07-19 13:34:20'),
(3, 3, NULL, 'ID Application\r\n', NULL, '2025-07-19 13:35:22'),
(4, 4, NULL, 'Submission of Important Documents', NULL, '2025-07-19 13:35:54'),
(5, 1, NULL, 'Tuition Payment', NULL, '2025-07-20 10:14:56'),
(6, 3, NULL, 'Diploma Request', NULL, '2025-07-26 10:38:54');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `counter_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `lastname` varchar(200) DEFAULT NULL,
  `firstname` varchar(200) NOT NULL,
  `user_type` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1,
  `profile_photo` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `access_code` varchar(255) NOT NULL,
  `reset_password_attempt` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `counter_id`, `department_id`, `lastname`, `firstname`, `user_type`, `username`, `password`, `contact_number`, `email`, `address`, `status`, `profile_photo`, `created_at`, `access_code`, `reset_password_attempt`) VALUES
(1, 1, 1, 'uchiha', 'sarada', 'Admin', 'sarada@konoha.com', '$2a$12$afqVNeqI4CfcoZ9dyt9gIO7w6RKh.leuIB8dyv0YRESO3dgdzIcwe', '09533307696', 'department_head_cashier', 'konoha number 40', 1, NULL, '2025-06-20 10:10:26', '', 0),
(19, NULL, NULL, 'De Leon', 'Alexis', 'Student', 'ajcodalify@gmail.com', '$2y$10$nrqeXjU9TjtQ8dtfYInq1u9/qaof86TXcyXWGFjiE8uFs71KcNdeu', '09533307692', 'ajcodalify@gmail.com', NULL, 1, NULL, '2025-06-24 23:25:30', 'oWoaREbnHzqOQKwIJajfrvcewyfiBPDi', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `counters`
--
ALTER TABLE `counters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `counter_name` (`counter_name`);

--
-- Indexes for table `data_retention_policy`
--
ALTER TABLE `data_retention_policy`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `department_videos`
--
ALTER TABLE `department_videos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `department_id` (`department_id`,`video_id`),
  ADD KEY `video_id` (`video_id`);

--
-- Indexes for table `email_api_settings`
--
ALTER TABLE `email_api_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holiday_calendar`
--
ALTER TABLE `holiday_calendar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `otp_verification`
--
ALTER TABLE `otp_verification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `promotional_videos`
--
ALTER TABLE `promotional_videos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `queue_configurations`
--
ALTER TABLE `queue_configurations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `queue_number`
--
ALTER TABLE `queue_number`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue_reports`
--
ALTER TABLE `queue_reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `queue_id` (`queue_id`),
  ADD KEY `closed_by` (`closed_by`);

--
-- Indexes for table `queue_reservations`
--
ALTER TABLE `queue_reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `service_hours`
--
ALTER TABLE `service_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `counter_id` (`counter_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `counters`
--
ALTER TABLE `counters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `data_retention_policy`
--
ALTER TABLE `data_retention_policy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `department_videos`
--
ALTER TABLE `department_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `email_api_settings`
--
ALTER TABLE `email_api_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holiday_calendar`
--
ALTER TABLE `holiday_calendar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otp_verification`
--
ALTER TABLE `otp_verification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promotional_videos`
--
ALTER TABLE `promotional_videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_configurations`
--
ALTER TABLE `queue_configurations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queue_number`
--
ALTER TABLE `queue_number`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `queue_reports`
--
ALTER TABLE `queue_reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `queue_reservations`
--
ALTER TABLE `queue_reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `service_hours`
--
ALTER TABLE `service_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `department_videos`
--
ALTER TABLE `department_videos`
  ADD CONSTRAINT `department_videos_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `department_videos_ibfk_2` FOREIGN KEY (`video_id`) REFERENCES `promotional_videos` (`id`);

--
-- Constraints for table `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD CONSTRAINT `notification_settings_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `promotional_videos`
--
ALTER TABLE `promotional_videos`
  ADD CONSTRAINT `promotional_videos_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `queue_configurations`
--
ALTER TABLE `queue_configurations`
  ADD CONSTRAINT `queue_configurations_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `queue_reports`
--
ALTER TABLE `queue_reports`
  ADD CONSTRAINT `queue_reports_ibfk_1` FOREIGN KEY (`queue_id`) REFERENCES `queue_reservations` (`id`),
  ADD CONSTRAINT `queue_reports_ibfk_2` FOREIGN KEY (`closed_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `queue_reservations`
--
ALTER TABLE `queue_reservations`
  ADD CONSTRAINT `queue_reservations_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `queue_reservations_ibfk_2` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`),
  ADD CONSTRAINT `queue_reservations_ibfk_3` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

--
-- Constraints for table `service_hours`
--
ALTER TABLE `service_hours`
  ADD CONSTRAINT `service_hours_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`);

--
-- Constraints for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD CONSTRAINT `system_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`counter_id`) REFERENCES `counters` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
