-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 07, 2025 at 08:09 PM
-- Server version: 10.11.10-MariaDB-cll-lve
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `n1574432_bintang_vespa`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `user_id`, `name`, `phone`, `email`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 7, 'Luthfi Ihdalhusnayain', '0895322316585', 'luthfi.ihdalhusnayain98@gmail.com', '2023-03-22 08:21:45', NULL, NULL),
(3, 8, 'Siti Aiysah', '085890836201', 'aisyahsiti461@gmail.com', '2023-03-23 05:47:01', NULL, NULL),
(4, 9, 'Customer 1', '0895322316585', 'customer@gmail.com', '2023-03-24 04:04:56', NULL, NULL),
(5, 10, 'Siti Aisyah', '085928238011', 'aisyahhh@gmail.com', '2023-03-24 06:47:15', NULL, NULL),
(6, 11, 'bintang', '081226160742', 'bntngkrnwn@gmail.com', '2023-03-24 14:21:35', NULL, NULL),
(7, 12, 'Customer Baru', '0000000000', 'cust-new@gmail.com', '2023-03-29 06:05:53', NULL, NULL),
(8, 13, 'Fatimah Diniyanti', '086734560451', 'fatimah@gmail.com', '2023-03-29 06:19:59', NULL, NULL),
(9, 14, 'Citra Kirana', '08978675676', 'citrakirana@gmail.com', '2023-04-17 19:52:13', NULL, NULL),
(10, 15, 'tes 123', '123123123123', '123123@gmail.com', '2023-04-18 11:19:48', '2023-04-18 13:28:44', NULL),
(11, 16, 'tes 2', '123321', '123321@gmail.com', '2023-04-18 13:04:33', NULL, NULL),
(12, 17, 'pelanggan', '085890836201', 'aisyahsiti461@gmail.com', '2023-05-18 20:14:44', NULL, NULL),
(13, 18, 'virgo vajar', '081226160742', 'virgofajar@gmail.com', '2023-05-22 11:36:18', NULL, NULL),
(14, 19, 'tito', '082136160223', 'titosunu@gmail.com', '2023-05-22 18:55:42', NULL, NULL),
(15, 20, 'bintang kurniawan', '081226160742', 'bintangkyrnawwan@gmmail.com', '2023-05-23 15:35:35', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaction`
--

CREATE TABLE `detail_transaction` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_id` int(10) UNSIGNED NOT NULL,
  `sparepart_id` int(10) UNSIGNED NOT NULL,
  `qty` tinyint(4) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_transaction`
--

INSERT INTO `detail_transaction` (`id`, `transaction_id`, `sparepart_id`, `qty`, `price`) VALUES
(1, 1, 1, 1, 50000),
(2, 2, 1, 2, 50000),
(3, 2, 2, 1, 10000),
(4, 7, 2, 1, 115000),
(5, 10, 21, 1, 155000),
(6, 13, 3, 1, 115000),
(7, 13, 4, 1, 95000),
(8, 13, 12, 1, 2795000),
(9, 15, 3, 1, 115000),
(10, 15, 4, 1, 95000),
(11, 3, 2, 1, 115000),
(12, 16, 4, 1, 95000),
(13, 16, 8, 1, 795000),
(14, 16, 13, 1, 120000),
(15, 16, 17, 1, 2550000),
(16, 17, 3, 1, 115000),
(17, 17, 14, 1, 185000),
(18, 18, 4, 1, 95000),
(19, 18, 14, 1, 185000),
(20, 18, 2, 1, 115000),
(21, 18, 3, 1, 115000),
(22, 18, 13, 1, 120000),
(23, 19, 21, 1, 155000),
(24, 23, 2, 1, 115000),
(25, 24, 3, 1, 115000),
(26, 25, 4, 1, 95000),
(27, 26, 2, 1, 115000),
(28, 28, 2, 1, 115000),
(29, 28, 3, 1, 115000),
(30, 28, 4, 1, 95000);

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id_menu` int(10) UNSIGNED NOT NULL,
  `menu_title` varchar(25) NOT NULL,
  `menu_url` varchar(50) NOT NULL,
  `have_link` enum('yes','no') NOT NULL DEFAULT 'no',
  `icon` varchar(25) NOT NULL,
  `sort` varchar(5) NOT NULL,
  `menu_parent` int(11) NOT NULL,
  `type` enum('cms','public') NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id_menu`, `menu_title`, `menu_url`, `have_link`, `icon`, `sort`, `menu_parent`, `type`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'Setting', '#', '', '#', '4', 0, 'cms', '2022-04-18 10:09:22', 0, '2023-03-23 05:58:16', NULL, NULL, NULL),
(2, 'Menu', '#', '', 'list', '1', 1, 'cms', '2022-04-18 10:10:01', 0, '2023-03-15 19:18:55', NULL, NULL, NULL),
(3, 'List Menu', 'cms/data-menu', 'yes', '#', '1', 2, 'cms', '2022-04-18 10:10:33', 0, '2022-07-30 12:23:58', NULL, NULL, NULL),
(4, 'Sorting Menu', 'cms/sorting-menu', 'yes', '#', '2', 2, 'cms', '2022-04-18 10:10:53', 0, '2022-07-30 12:23:27', NULL, NULL, NULL),
(5, 'User Management', '#', '', 'user-shield', '2', 1, 'cms', '2022-04-18 10:15:56', 0, '2023-03-15 19:18:55', NULL, NULL, NULL),
(6, 'List User', 'cms/data-user', 'yes', '#', '1', 5, 'cms', '2022-04-18 10:16:47', 0, '2022-07-30 12:23:47', NULL, NULL, NULL),
(7, 'List Role', 'cms/data-role', 'yes', '#', '2', 5, 'cms', '2022-04-18 10:17:09', 0, '2022-07-30 12:23:52', NULL, NULL, NULL),
(39, 'Master Data', '#', '', '#', '2', 0, 'cms', '2023-03-15 18:54:06', 0, '2023-03-23 05:58:16', NULL, NULL, NULL),
(40, 'Data Pelanggan', 'cms/data-customer', 'yes', 'users', '1', 39, 'cms', '2023-03-15 18:54:57', 0, '2023-03-15 19:18:11', NULL, NULL, NULL),
(41, 'Data Bengkel', 'cms/data-workshop', 'yes', 'building', '2', 39, 'cms', '2023-03-15 19:01:52', 0, '2023-03-15 19:18:55', NULL, NULL, NULL),
(42, 'Transaksi', '#', '', '#', '3', 0, 'cms', '2023-03-15 19:12:15', 0, '2023-03-23 05:58:16', NULL, NULL, NULL),
(43, 'Booking Servis', 'cms/data-booking', 'yes', 'list', '1', 42, 'cms', '2023-03-15 19:12:58', 0, '2023-03-15 19:18:33', NULL, NULL, NULL),
(44, 'Riwayat Transaksi', 'cms/data-history', 'yes', 'history', '2', 42, 'cms', '2023-03-15 19:14:02', 0, '2023-03-15 19:18:40', NULL, NULL, NULL),
(45, 'Website', 'cms/web-setting', 'yes', 'globe', '3', 1, 'cms', '2023-03-15 19:14:57', 0, '2023-03-16 05:52:42', NULL, NULL, NULL),
(46, 'Data Vespa', 'cms/data-vespa', 'yes', 'motorcycle', '3', 39, 'cms', '2023-03-22 21:49:39', 0, NULL, NULL, NULL, NULL),
(47, 'Dashboard', 'cms/dashboard', 'yes', 'home', '1', 0, 'cms', '2023-03-23 05:57:46', 0, '2023-03-23 05:58:41', NULL, NULL, NULL),
(48, 'Data Sparepart', 'cms/data-sparepart', 'yes', 'wrench', '4', 39, 'cms', '2023-03-23 12:33:26', 0, NULL, NULL, NULL, NULL),
(49, 'Laporan', 'cms/report', 'yes', 'file', '3', 42, 'cms', '2023-03-25 08:17:01', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(10) UNSIGNED NOT NULL,
  `role_name` varchar(25) NOT NULL,
  `description_role` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id_role`, `role_name`, `description_role`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(0, 'Pelanggan', 'Role Pelanggan', '2023-03-22 06:43:35', 1, '2023-03-22 08:20:44', NULL, NULL, NULL),
(1, 'Full Adminstrator', 'Administrator System', '2022-04-19 13:07:22', 1, '2022-08-29 05:57:03', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE `setting` (
  `id_web` int(10) UNSIGNED NOT NULL,
  `website_name` varchar(25) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `logo` varchar(100) NOT NULL,
  `about` text NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `link_map` text NOT NULL,
  `link_ig` text DEFAULT NULL,
  `link_tiktok` text DEFAULT NULL,
  `link_fb` text DEFAULT NULL,
  `link_twitter` text NOT NULL,
  `nama_ig` varchar(100) NOT NULL,
  `nama_fb` varchar(100) NOT NULL,
  `nama_tiktok` varchar(100) NOT NULL,
  `nama_twitter` varchar(100) NOT NULL,
  `keyword` text NOT NULL,
  `deskripsi` text NOT NULL,
  `g_tag` text NOT NULL,
  `script_g_tag` text NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id_web`, `website_name`, `icon`, `logo`, `about`, `email`, `phone`, `address`, `link_map`, `link_ig`, `link_tiktok`, `link_fb`, `link_twitter`, `nama_ig`, `nama_fb`, `nama_tiktok`, `nama_twitter`, `keyword`, `deskripsi`, `g_tag`, `script_g_tag`, `updated_at`, `updated_by`) VALUES
(1, 'Bintang Vespa', '1b70de932f4746d828fd5f1373512f8d.png', 'dcbf6ac7a3d438b0a50df53528227968.png', 'Bintang Vespa adalah bengkel spesialis yang melayani perbaikan kendaraan Vespa, serta menyediakan sukucadang dan aksesoris asli Vespa berkualitas tinggi untuk kebutuhan pelanggan.', 'bintang-vespa@gmail.com', '081226160742', 'Jl. Timoho Raya No.11B, Bulusan, Kec. Tembalang Semarang', 'https://goo.gl/maps/KoBQWVLg5d8gvBSR9', 'https://instagram.com/doyanvespasmg?igshid=ZWQyN2ExYTkwZQ==', 'https://www.tiktok.com/@k3ncuss?_t=8cWqsPFE5fV&_r=1', '', 'https://twitter.com/regaardless?s=21&t=0Bbsfwx336D6RD6CksRVlA', 'doyanvespasmg', 'doyan vespa', 'doyan vespa', 'doyan vespa', 'bengkel, vespa, antrian, booked', 'Bengkel vespa paling bagus di semarang', '', '', '2023-05-22 19:11:34', 1);

-- --------------------------------------------------------

--
-- Table structure for table `spareparts`
--

CREATE TABLE `spareparts` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `stock` tinyint(4) NOT NULL,
  `price` int(10) UNSIGNED NOT NULL,
  `image` varchar(100) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `spareparts`
--

INSERT INTO `spareparts` (`id`, `name`, `slug`, `stock`, `price`, `image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Busi - CMR7A', 'busi-cmr7a', 10, 35000, NULL, '2023-03-23 15:47:00', '2023-03-24 20:22:21', NULL),
(2, 'Filter udara - 1B001283', 'filter-udara-1b001283', 14, 115000, NULL, '2023-03-23 15:47:38', '2024-03-12 23:00:50', NULL),
(3, 'Kampas rem - 1C002754', 'kampas-rem-1c002754', 6, 115000, NULL, '2023-03-24 20:23:14', '2024-03-12 23:01:18', NULL),
(4, 'Oli Mesin - 1L001370', 'oli-mesin-1l001370', 7, 95000, NULL, '2023-03-24 20:24:45', '2024-03-12 23:01:18', NULL),
(5, 'Top box Vespa Primavera/Sprint/GTS - 1B001346', 'top-box-vespa-primaverasprintgts-1b001346', 2, 4550000, NULL, '2023-03-24 20:25:15', NULL, NULL),
(6, 'Velg Vespa Chrome Ring - 1B000834', 'velg-vespa-chrome-ring-1b000834', 2, 1750000, NULL, '2023-03-24 20:25:44', NULL, NULL),
(7, 'Shockbreaker  LX - 1C002734', 'shockbreaker-lx-1c002734', 2, 695000, NULL, '2023-03-24 20:26:23', NULL, NULL),
(8, 'Shockbreaker   Primavera/Sprint - 1B004439', 'shockbreaker-primaverasprint-1b004439', 1, 795000, NULL, '2023-03-24 20:26:50', '2023-05-14 05:37:58', NULL),
(9, 'Shockbreaker  GTS Super 150 - 1C002734', 'shockbreaker-gts-super-150-1c002734', 2, 1295000, NULL, '2023-03-24 20:31:19', NULL, NULL),
(10, 'Shockbreaker  GTS Super Tech 300 - 1C004027', 'shockbreaker-gts-super-tech-300-1c004027', 3, 2495000, NULL, '2023-03-24 20:33:23', NULL, NULL),
(11, 'Shockbreaker  GTS 300 Super - 1C004027', 'shockbreaker-gts-300-super-1c004027', 2, 2495000, '64238e167e41e-shockbreaker-gts-300-super-1c004027-23-03-29.png', '2023-03-24 20:34:01', '2023-03-29 08:02:14', NULL),
(12, 'Shockbreaker  GTS Super Racing Sixties - 1C004027', 'shockbreaker-gts-super-racing-sixties-1c004027', 1, 2795000, NULL, '2023-03-24 20:34:28', '2023-04-17 22:43:34', NULL),
(13, 'Roller CVT - 1C003815', 'roller-cvt-1c003815', 3, 120000, NULL, '2023-03-24 20:35:50', '2023-05-15 08:32:42', NULL),
(14, 'V-Belt CVT - 1A003593', 'v-belt-cvt-1a003593', 4, 185000, NULL, '2023-03-24 20:36:07', '2023-05-15 08:32:42', NULL),
(15, 'Pulley Set - 1A000521', 'pulley-set-1a000521', 5, 865000, NULL, '2023-03-24 20:36:28', NULL, NULL),
(16, 'Kampas Kopling - 1B004440', 'kampas-kopling-1b004440', 12, 135000, NULL, '2023-03-24 20:36:49', NULL, NULL),
(17, 'Piston Set - 1B000685', 'piston-set-1b000685', 2, 2550000, NULL, '2023-03-24 20:37:08', '2023-05-14 05:37:58', NULL),
(18, 'Bearing Kruk As - 1A000470', 'bearing-kruk-as-1a000470', 5, 85000, NULL, '2023-03-24 20:37:27', NULL, NULL),
(19, 'Cylinder head - 1B003696', 'cylinder-head-1b003696', 5, 1550000, NULL, '2023-03-24 20:37:44', '2023-03-24 20:37:53', NULL),
(20, 'Gasket Mesin - 1B003398', 'gasket-mesin-1b003398', 10, 60000, NULL, '2023-03-24 20:38:12', NULL, NULL),
(21, 'Kabel Gas - 1B003101', 'kabel-gas-1b003101', 3, 155000, NULL, '2023-03-24 20:38:29', '2023-05-17 08:39:30', NULL),
(22, 'Ban Dalam Mahal', 'ban-dalam-mahal', 20, 45000, '642378283d3e8-ban-dalam-23-03-29.jpg', '2023-03-29 06:28:40', '2023-03-29 06:29:41', '2023-03-29 06:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(10) UNSIGNED NOT NULL,
  `transaction_code` varchar(20) NOT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `workshop_id` int(10) UNSIGNED NOT NULL,
  `vespa_id` int(10) UNSIGNED NOT NULL,
  `service_date` date NOT NULL,
  `service_time` time NOT NULL,
  `work_estimate` varchar(10) DEFAULT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `concern` text NOT NULL,
  `repair_service` int(10) UNSIGNED DEFAULT NULL,
  `total` int(10) UNSIGNED DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Booked',
  `is_general_check` tinyint(1) NOT NULL,
  `send_notif` tinyint(1) NOT NULL,
  `user_lat` float DEFAULT NULL,
  `user_long` float DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `transaction_code`, `customer_id`, `workshop_id`, `vespa_id`, `service_date`, `service_time`, `work_estimate`, `start_time`, `finish_time`, `concern`, `repair_service`, `total`, `status`, `is_general_check`, `send_notif`, `user_lat`, `user_long`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '20230323-00001', 2, 2, 12, '2023-03-23', '15:33:05', '30', '2023-03-23 11:42:21', '2023-03-23 19:40:11', 'Oli Bocor, Upgrade Pengereman', 75000, 50000, 'Finished', 0, 0, -6.2114, 106.845, '2023-03-23 05:33:50', '2023-03-23 19:40:11', NULL),
(2, '20230323-00002', 3, 2, 11, '2023-03-23', '16:03:05', '60', '2023-03-23 19:40:13', '2023-03-23 20:10:00', 'Tidak Bisa Nyalah', 25000, 110000, 'Finished', 0, 0, -6.12067, 106.971, '2023-03-23 05:55:14', '2023-03-23 20:10:00', NULL),
(3, '20230323-00001', 2, 2, 12, '2023-05-16', '12:00:00', '45', '2023-05-13 08:12:46', '2023-05-13 08:14:43', 'Ganti Oli, Kampas, Lampu, Servis berkala', 75000, 115000, 'Finished', 1, 1, -6.12308, 106.961, '2023-03-23 20:46:08', '2023-05-13 08:14:43', NULL),
(4, '20230324-00001', 4, 2, 10, '2023-03-24', '08:00:00', '50', '2023-03-24 04:07:12', '2023-03-29 12:25:14', 'Service Besar', 0, NULL, 'Finished', 0, 0, -6.12306, 106.961, '2023-03-24 04:05:48', '2023-03-29 12:25:14', NULL),
(5, '20230324-00002', 5, 2, 2, '2023-03-24', '17:00:00', '60', '2023-05-18 19:52:12', '2023-05-18 19:52:42', 'Rusak', 45000, NULL, 'Finished', 1, 0, 0, 0, '2023-03-24 06:49:50', '2023-05-18 19:52:42', NULL),
(6, '20230324-00003', 6, 2, 2, '2023-03-24', '16:00:00', NULL, '2023-03-24 14:31:58', '2023-03-24 14:32:05', 'ganti oli', NULL, NULL, 'Finished', 0, 0, -7.03939, 110.411, '2023-03-24 14:29:21', '2023-03-24 14:32:05', NULL),
(7, '20230329-00001', 7, 1, 9, '2023-03-30', '08:00:00', '60', '2023-03-29 06:11:02', '2023-03-29 06:13:22', 'Service Rutin', 50000, 115000, 'Finished', 0, 0, -6.2114, 106.845, '2023-03-29 06:07:14', '2023-03-29 06:13:22', NULL),
(8, '20230329-00002', 2, 2, 11, '2023-03-30', '09:00:00', '60', '2023-03-29 06:33:51', '2023-03-29 12:25:09', 'Ganti Oli', 0, NULL, 'Finished', 0, 0, -6.2114, 106.845, '2023-03-29 06:10:20', '2023-03-29 12:25:09', NULL),
(9, '20230329-00003', 8, 2, 2, '2023-03-30', '09:00:00', '60', NULL, NULL, 'gabisa nyala', 0, NULL, 'Booked', 0, 0, -6.22592, 106.807, '2023-03-29 06:21:57', '2023-03-29 06:35:26', NULL),
(10, '20230329-00003', 8, 1, 3, '2023-03-30', '07:00:00', '30', '2023-03-29 06:30:19', '2023-03-29 06:33:04', 'test', 50000, 155000, 'Finished', 0, 0, -6.22592, 106.807, '2023-03-29 06:25:24', '2023-03-29 06:33:04', NULL),
(11, '20230329-00001', 6, 2, 3, '2023-03-29', '12:57:34', '45', NULL, NULL, 'ganti oli', 150000, NULL, 'Booked', 0, 0, -7.01072, 110.411, '2023-03-29 12:22:55', '2023-03-29 12:24:42', NULL),
(12, '20230329-00002', 8, 1, 10, '2023-03-29', '13:42:34', NULL, NULL, NULL, 'test', NULL, NULL, 'Booked', 0, 0, -6.22592, 106.807, '2023-03-29 12:33:45', NULL, NULL),
(13, '20230417-00001', 9, 2, 12, '2023-04-18', '08:00:00', '60', NULL, NULL, 'rem habis, ganti oli', 0, 3005000, 'Booked', 0, 0, 0, 0, '2023-04-17 19:58:38', '2023-04-17 22:47:08', NULL),
(14, '20230418-00002', 10, 1, 2, '2023-04-18', '09:00:00', NULL, NULL, NULL, 'tes', NULL, NULL, 'Booked', 0, 0, -6.2292, 106.712, '2023-04-18 12:04:33', NULL, NULL),
(15, '20230426-00001', 9, 1, 1, '2023-04-26', '07:02:05', '60', NULL, NULL, 'rem, oli', 100, 210000, 'Booked', 0, 0, -6.58338, 106.719, '2023-04-26 07:02:36', '2023-04-26 07:11:36', NULL),
(16, '20230513-00002', 2, 1, 10, '2023-05-16', '12:45:00', '35', '2023-05-14 05:37:12', '2023-05-14 05:52:38', 'Tarikan terasa berat', 250000, 3560000, 'Finished', 1, 1, -6.5945, 106.789, '2023-05-13 17:10:10', '2023-05-14 05:52:38', NULL),
(17, '20230514-00001', 2, 1, 12, '2023-05-19', '14:00:00', '35', '2023-05-14 22:36:40', '2023-05-14 22:37:30', 'Motor Gredek', 350000, 300000, 'Finished', 1, 1, -6.1231, 106.959, '2023-05-14 22:35:47', '2023-05-14 22:37:30', NULL),
(18, '20230515-00001', 2, 2, 11, '2023-05-15', '16:00:00', '60', '2023-05-15 08:31:53', '2023-05-15 08:32:47', 'Motor Berisik', 120000, 630000, 'Finished', 1, 1, -6.2114, 106.845, '2023-05-15 08:31:17', '2023-05-15 08:32:47', NULL),
(19, '20230517-00001', 2, 2, 9, '2023-05-17', '10:00:00', '60', '2023-05-17 08:39:04', '2023-05-17 08:39:35', '', 75000, 155000, 'Finished', 1, 1, -6.2114, 106.845, '2023-05-17 08:38:15', '2023-05-17 08:39:35', NULL),
(20, '20230518-00001', 3, 1, 12, '2023-05-22', '10:00:00', '45', NULL, NULL, '', 0, NULL, 'Booked', 1, 1, -6.2114, 106.845, '2023-05-18 20:00:59', '2023-05-18 20:01:22', NULL),
(21, '20230518-00002', 2, 1, 12, '2023-05-22', '16:15:00', '45', '2023-07-06 08:20:44', NULL, '', 0, NULL, 'In Progress', 1, 1, -6.2114, 106.845, '2023-05-18 20:03:11', '2023-07-06 08:20:44', NULL),
(22, '20230518-00003', 3, 1, 12, '2023-05-22', '11:30:00', '45', NULL, NULL, 'Keluhan', 0, NULL, 'Booked', 1, 1, -6.2114, 106.845, '2023-05-18 20:10:20', '2023-05-18 20:10:43', NULL),
(23, '20230518-00001', 12, 1, 2, '2023-05-18', '20:14:46', '60', '2023-05-18 20:17:25', '2023-05-18 20:18:17', '', 150000, 115000, 'Finished', 1, 1, 0, 0, '2023-05-18 20:15:25', '2023-05-18 20:18:17', NULL),
(24, '20230522-00004', 13, 1, 8, '2023-05-22', '12:15:00', '120', '2023-05-22 11:47:56', '2023-05-22 11:48:32', '', 150000, 115000, 'Finished', 1, 1, -7.00515, 110.438, '2023-05-22 11:37:52', '2023-05-22 11:48:32', NULL),
(25, '20230522-00005', 14, 1, 7, '2023-05-22', '14:15:00', '120', '2023-05-22 19:00:41', '2023-05-22 19:01:13', 'akinya mati', 600000, 95000, 'Finished', 0, 1, -6.99371, 110.412, '2023-05-22 18:57:55', '2023-05-22 19:01:13', NULL),
(26, '20230523-00001', 15, 2, 3, '2023-05-23', '15:35:36', '60', NULL, NULL, 'ganti aki', 50000, 115000, 'Booked', 0, 1, -6.98591, 110.414, '2023-05-23 15:37:57', '2023-05-23 15:41:11', NULL),
(27, '', 2, 1, 12, '2023-05-26', '02:39:17', NULL, NULL, NULL, '', NULL, NULL, 'Booked', 1, 0, -6.2114, 106.845, '2023-05-26 02:39:31', '2023-05-26 02:39:39', '2023-05-26 02:39:39'),
(28, '20240312-00001', 4, 2, 10, '2024-03-14', '14:00:00', '30', '2024-03-12 23:00:59', '2024-03-12 23:01:26', '', 30000, 325000, 'Finished', 1, 0, -6.12311, 106.959, '2024-03-12 22:58:53', '2024-03-12 23:01:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(60) NOT NULL,
  `backup_password` varchar(100) DEFAULT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(13) NOT NULL,
  `profile_picture` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `otp` char(4) DEFAULT NULL,
  `expired_otp` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `backup_password`, `fullname`, `email`, `phone`, `profile_picture`, `role_id`, `nickname`, `status`, `otp`, `expired_otp`, `created_at`, `created_by`, `updated_at`, `updated_by`, `deleted_at`, `deleted_by`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', NULL, 'Administrator', 'bntngkrnwn@gmail.com', '081226160742', 'default.png', 1, 'ADM', 'Active', NULL, NULL, '2022-04-19 13:08:35', 1, '2023-03-24 14:27:21', 1, NULL, NULL),
(7, 'luthfiihdal98', '83f6a7afc966c52dc835692a7508d534585757b0', 'eHIrakFqbDZKc2xQRkp0NlliQ3dYUT09', 'Luthfi Ihdalhusnayain', 'luthfi.ihdalhusnayain98@gmail.com', '0895322316585', 'default.png', 0, 'LI', 'Active', '7016', '2023-05-18 19:57:34', '2023-03-22 08:21:45', 0, '2023-05-18 19:55:01', NULL, NULL, NULL),
(8, 'aisyah0207', '83f6a7afc966c52dc835692a7508d534585757b0', 'eHIrakFqbDZKc2xQRkp0NlliQ3dYUT09', 'Siti Aiysah', 'aisyahasiti461@gmail.com', '085890836201', 'default.png', 0, 'SA', 'Active', NULL, NULL, '2023-03-23 05:47:01', 0, '2023-05-18 20:13:58', NULL, NULL, NULL),
(9, 'cust1', '2d2d3bef7dee2a80a53bcba944bcfc6dfb6f9ac9', 'cmQwYTdpdEpBRnJTUW5Md041RDYzZz09', 'Customer 1', 'customer@gmail.com', '0895322316585', 'default.png', 0, 'C1', 'Active', NULL, NULL, '2023-03-24 04:04:56', 0, '2024-03-12 22:57:56', 1, NULL, NULL),
(10, 'cust123', '94ac0ce281af3b58160234122b68bb79a36674ee', 'bityZklYdm1tTE1vZmR6eWhMaXBodz09', 'Siti Aisyah', 'aisyahhh@gmail.com', '085928238011', 'default.png', 0, 'SA', 'Active', NULL, NULL, '2023-03-24 06:47:15', 0, NULL, NULL, NULL, NULL),
(11, 'bintang', '30f3c0f9a874bcba9eade8825086443f36c00be7', 'Y3A5MDF2QWN0UFpwaDFQdU45bWZLUT09', 'bintang', 'bntngkrnwn@gmail.com', '081226160742', 'default.png', 0, 'b', 'Active', NULL, NULL, '2023-03-24 14:21:35', 0, NULL, NULL, NULL, NULL),
(12, 'custnew', '92a65450d21bfad9137fad4c9946a4e49afdf3f9', 'dGVWM2tPaXhRQ25wWDhnQW9PZ29wZz09', 'Customer Baru', 'cust-new@gmail.com', '0000000000', 'default.png', 0, 'CB', 'Active', NULL, NULL, '2023-03-29 06:05:53', 0, NULL, NULL, NULL, NULL),
(13, 'fatimah123', '4de57d7ce4162f883917d2d512434873e357d3d5', 'UTF6QU53M3RPY3dmTWFBOFQvSXMrQT09', 'Fatimah Diniyanti', 'fatimah@gmail.com', '086734560451', 'default.png', 0, 'FD', 'Active', NULL, NULL, '2023-03-29 06:19:59', 0, NULL, NULL, NULL, NULL),
(14, 'citrakirana', '5c7284312cd510103d51e698f581bc87b363b405', 'Y3NRUlYyZWhOYXQ0OVVrWXVXRjhXdz09', 'Citra Kirana', 'citrakirana@gmail.com', '08978675676', 'default.png', 0, 'CK', 'Active', NULL, NULL, '2023-04-17 19:52:13', 0, NULL, NULL, NULL, NULL),
(15, 'user123', 'cd027069371cdb4f80c68dcfb37e6f4a1bdb0222', 'NHJRNFNrTWVQTmhNUE12b3YxVTZxZz09', 'tes 123', '123123@gmail.com', '123123123123', 'default.png', 0, 't1', 'Active', NULL, NULL, '2023-04-18 11:19:48', 0, '2023-04-18 13:28:44', NULL, NULL, NULL),
(16, 'user1234', 'bb70729af79c563675e873ec7d6d3a63cb5dab28', 'MEhHZHE1Y0FxUnJGdDBrcmhrbW9RUT09', 'tes 2', '123321@gmail.com', '123321', 'default.png', 0, 't2', 'Active', NULL, NULL, '2023-04-18 13:04:33', 0, NULL, NULL, NULL, NULL),
(17, 'pelanggan1', '72ad587c8670b8e69bc10076bda80e4865e9dfb7', 'VXV5endIdGNUcE1OVG9VSzNoR2JYZz09', 'pelanggan', 'aisyahsiti461@gmail.com', '085890836201', 'default.png', 0, 'p', 'Active', '5874', '2023-09-07 18:52:14', '2023-05-18 20:14:44', 0, '2023-09-07 18:49:16', NULL, NULL, NULL),
(18, 'virgo', 'fe5cd39228d2f4cd66e0d38a3a6969b7bf1a00d6', 'SmtRRmVhVUZUUTFDZ29NYnRMdGQ2UT09', 'virgo vajar', 'virgofajar@gmail.com', '081226160742', 'default.png', 0, 'vv', 'Active', NULL, NULL, '2023-05-22 11:36:18', 0, NULL, NULL, NULL, NULL),
(19, 'titoo', '42592e49f79679c8671e211878eef61d3055594b', 'b2NOazBJdHc5U1ZGb3NMUlV2VDRZUT09', 'tito', 'titosunu@gmail.com', '082136160223', 'default.png', 0, 't', 'Active', NULL, NULL, '2023-05-22 18:55:42', 0, NULL, NULL, NULL, NULL),
(20, 'bintang77', 'dc227f188dd1e7533dd59fd0a2ff46418461a520', 'OVlSRTNyY0psZ0dEKzRjcFZybDN4Zz09', 'bintang kurniawan', 'bintangkyrnawwan@gmmail.com', '081226160742', 'default.png', 0, 'bk', 'Active', NULL, NULL, '2023-05-23 15:35:35', 0, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users_access`
--

CREATE TABLE `users_access` (
  `id_user_access` int(10) UNSIGNED NOT NULL,
  `menu_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_access`
--

INSERT INTO `users_access` (`id_user_access`, `menu_id`, `role_id`) VALUES
(33, 42, 0),
(34, 43, 0),
(35, 44, 0),
(36, 47, 0),
(87, 47, 1),
(88, 39, 1),
(89, 40, 1),
(90, 41, 1),
(91, 46, 1),
(92, 48, 1),
(93, 42, 1),
(94, 43, 1),
(95, 44, 1),
(96, 49, 1),
(97, 1, 1),
(98, 2, 1),
(99, 3, 1),
(100, 4, 1),
(101, 5, 1),
(102, 6, 1),
(103, 7, 1),
(104, 45, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vespa`
--

CREATE TABLE `vespa` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `year` year(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vespa`
--

INSERT INTO `vespa` (`id`, `name`, `description`, `year`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Vespa LX 150ie', 'Vespa LX 150ie adalah model matic yang didesain dengan gaya klasik dan elegan. Dilengkapi dengan mesin 150cc dan teknologi injeksi bahan bakar, Vespa LX 150ie memberikan performa yang baik dan efisien dalam penggunaannya.', '2012', '2023-03-22 21:56:18', '2023-03-24 19:52:37', NULL),
(2, 'Vespa S 150ie', 'Vespa S 150ie adalah model matic yang menawarkan tampilan sporty dan modern. Dibekali dengan mesin 150cc dan teknologi injeksi bahan bakar, Vespa S 150ie menjanjikan performa yang handal dan nyaman digunakan.', '2012', '2023-03-22 21:56:55', '2023-03-24 19:53:02', NULL),
(3, 'Vespa Primavera 150', 'Vespa Primavera 150 adalah model matic yang dilengkapi dengan mesin 150cc dan teknologi injeksi bahan bakar. Vespa Primavera 150 menawarkan desain yang elegan dan modern, serta fitur-fitur canggih seperti sistem pengereman ABS dan lampu LED.', '2013', '2023-03-22 21:57:10', '2023-03-24 19:53:36', NULL),
(4, 'Vespa Sprint 150', 'Vespa Sprint 150 adalah model matic yang menampilkan desain yang sporty dan agresif. Ditenagai oleh mesin 150cc dan teknologi injeksi bahan bakar, Vespa Sprint 150 menawarkan performa yang handal dan nyaman digunakan.', '2014', '2023-03-22 21:57:34', '2023-03-24 19:58:22', NULL),
(5, 'Vespa GTS 300ie Super Sport', 'Vespa GTS 300ie Super Sport adalah model matic yang dilengkapi dengan mesin 300cc dan teknologi injeksi bahan bakar. Vespa GTS 300ie Super Sport menawarkan desain yang sporty dan agresif, serta fitur-fitur canggih seperti sistem pengereman ABS dan lampu LED.', '2015', '2023-03-22 21:57:59', '2023-03-24 19:59:00', NULL),
(6, 'Vespa GTS 300ie', 'Vespa GTS 300ie adalah model matic yang menampilkan desain yang elegan dan modern. Ditenagai oleh mesin 300cc dan teknologi injeksi bahan bakar, Vespa GTS 300ie menawarkan performa yang handal dan nyaman digunakan.', '2016', '2023-03-22 21:58:12', '2023-03-24 19:59:22', NULL),
(7, 'Vespa Sei Giorni II Edition', 'Vespa Sei Giorni II Edition adalah model matic yang mengambil inspirasi dari motor balap Vespa Sei Giorni yang legendaris. Dilengkapi dengan mesin 300cc dan teknologi injeksi bahan bakar, Vespa Sei Giorni II Edition menawarkan performa yang handal dan desain yang klasik.', '2018', '2023-03-22 21:58:25', '2023-03-24 19:59:51', NULL),
(8, 'Vespa Primavera S 125', 'Vespa Primavera S 125 adalah model matic yang menampilkan desain yang elegan dan modern. Dilengkapi dengan mesin 125cc dan teknologi injeksi bahan bakar, Vespa Primavera S 125 menawarkan performa yang handal dan nyaman digunakan.', '2020', '2023-03-22 21:58:36', '2023-03-24 20:04:31', NULL),
(9, 'Vespa Sprint S 125', 'Vespa Sprint S 125 adalah model matic yang menampilkan desain yang sporty dan agresif. Ditenagai oleh mesin 125cc dan teknologi injeksi bahan bakar, espa Sprint S 125 menawarkan performa yang handal dan nyaman digunakan. Model ini juga dilengkapi dengan fitur-fitur canggih seperti sistem pengereman ABS dan lampu LED.', '2020', '2023-03-22 21:58:51', '2023-03-24 20:05:09', NULL),
(10, 'Vespa GTS Super Tech 300', 'Vespa GTS Super Tech 300 adalah model matic yang dilengkapi dengan mesin 300cc dan teknologi injeksi bahan bakar. Vespa GTS Super Tech 300 menampilkan desain yang elegan dan modern, serta dilengkapi dengan fitur-fitur canggih seperti layar TFT yang terhubung dengan smartphone dan sistem pengereman ABS.', '2020', '2023-03-22 21:59:05', '2023-03-24 20:05:38', NULL),
(11, 'Vespa GTS 300 Super', 'Vespa GTS 300 Super adalah model matic yang menampilkan desain yang sporty dan agresif. Dilengkapi dengan mesin 300cc dan teknologi injeksi bahan bakar, Vespa GTS 300 Super menawarkan performa yang handal dan nyaman digunakan.', '2020', '2023-03-22 21:59:15', '2023-03-24 20:06:05', NULL),
(12, 'Vespa GTS Super Racing Sixties', 'Vespa GTS Super Racing Sixties adalah model matic yang menampilkan desain yang unik dan klasik dengan sentuhan sporty. Ditenagai oleh mesin 300cc dan teknologi injeksi bahan bakar, Vespa GTS Super Racing Sixties menawarkan performa yang handal dan dilengkapi dengan fitur-fitur canggih seperti sistem pengereman ABS dan lampu LED. Model ini juga dilengkapi dengan aksen warna dan logo khusus yang mengingatkan pada era balap Vespa pada tahun 1960-an.', '2021', '2023-03-22 21:59:27', '2023-03-24 20:06:26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `workshops`
--

CREATE TABLE `workshops` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `status` enum('Aktif','Tidak Aktif','Buka','Tutup') NOT NULL,
  `lat` float DEFAULT NULL,
  `long` float DEFAULT NULL,
  `link` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workshops`
--

INSERT INTO `workshops` (`id`, `name`, `phone`, `email`, `address`, `status`, `lat`, `long`, `link`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Doyan vespa', '081326035377', 'doyan-vespa@gmail.com', 'Jl. Timoho Raya No.11B, Bulusan, Kec. Tembalang, Kota Semarang, Jawa Tengah 50277', 'Aktif', -7.0605, 110.443, NULL, '2023-03-16 12:47:01', '2023-03-24 18:33:56', NULL),
(2, 'Doyan vespa pak yanto', '000000000', 'doyan.vespa.pak.yanto@gmail.com', 'Jl. Pancursari I, Jangli, Kec. Tembalang, Kota Semarang, Jawa Tengah 50274', 'Aktif', -7.01989, 110.442, NULL, '2023-03-16 13:45:41', '2023-03-24 18:36:44', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_transaction`
--
ALTER TABLE `detail_transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Indexes for table `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`id_web`);

--
-- Indexes for table `spareparts`
--
ALTER TABLE `spareparts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `users_access`
--
ALTER TABLE `users_access`
  ADD PRIMARY KEY (`id_user_access`);

--
-- Indexes for table `vespa`
--
ALTER TABLE `vespa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `workshops`
--
ALTER TABLE `workshops`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `detail_transaction`
--
ALTER TABLE `detail_transaction`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id_menu` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `setting`
--
ALTER TABLE `setting`
  MODIFY `id_web` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `spareparts`
--
ALTER TABLE `spareparts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users_access`
--
ALTER TABLE `users_access`
  MODIFY `id_user_access` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `vespa`
--
ALTER TABLE `vespa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `workshops`
--
ALTER TABLE `workshops`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
