-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Dec 12, 2025 at 12:43 PM
-- Server version: 11.8.3-MariaDB-log
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u762094078_transamota`
--

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
('transamota-cache-8f1579a0484e5662172e0b070af0f1550fd6419d', 'i:1;', 1765543029),
('transamota-cache-8f1579a0484e5662172e0b070af0f1550fd6419d:timer', 'i:1765543029;', 1765543029),
('transamota-cache-a9a7e807d87e707ea3da20e96a60f47a2a20e2f6', 'i:1;', 1765543021),
('transamota-cache-a9a7e807d87e707ea3da20e96a60f47a2a20e2f6:timer', 'i:1765543021;', 1765543021),
('transamota-cache-da5a82d5796aa0923950405a4d2151e57aeb83e1', 'i:1;', 1765543087),
('transamota-cache-da5a82d5796aa0923950405a4d2151e57aeb83e1:timer', 'i:1765543087;', 1765543087);

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `description` text DEFAULT NULL,
  `icon` varchar(500) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `created_at`, `updated_at`) VALUES
(1, 'Electronics', 'electronics', 'Electronic devices and components', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(2, 'Clothing & Textiles', 'clothing-textiles', 'Apparel, fabrics and textile materials', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(3, 'Home & Garden', 'home-garden', 'Home improvement and garden supplies', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(4, 'Automotive', 'automotive', 'Car parts and accessories', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 13l4 4L19 7\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(5, 'Sports & Outdoors', 'sports-outdoors', 'Sporting goods and outdoor equipment', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(6, 'Beauty & Personal Care', 'beauty-personal-care', 'Cosmetics and personal care products', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(7, 'Industrial & Scientific', 'industrial-scientific', 'Industrial equipment and supplies', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(8, 'Food & Beverage', 'food-beverage', 'Food products and beverages', '<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-8 w-8\" fill=\"none\" viewBox=\"0 0 24 24\" stroke=\"currentColor\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M21 15.546c-.523 0-1.046.151-1.5.454a2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.704 2.704 0 00-3 0 2.704 2.704 0 01-3 0 2.701 2.701 0 00-1.5-.454M9 6v2m3-2v2m3-2v2M9 3h6a3 3 0 013 3v12a3 3 0 01-3 3H6a3 3 0 01-3-3V6a3 3 0 013-3h3zm-2 9h10m-5 5v-2\" /></svg>', '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(9, 'Accessories', 'accessories', 'Fashion and utility accessories', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(10, 'Footwear', 'footwear', 'Shoes and footwear products', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(11, 'Grains & Pulses', 'grains-pulses', 'Various grains and pulses for food and trade', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(12, 'Spices', 'spices', 'Spices and seasonings for cooking and food preparation', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(13, 'Fruits & Vegetables', 'fruits-vegetables', 'Fresh and processed fruits and vegetables', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(14, 'Handicrafts', 'handicrafts', 'Traditional and handmade crafts and products', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(15, 'Kitchen & Household Items', 'kitchen-household-items', 'Kitchenware and household products', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(16, 'Machines & Spare Parts', 'machines-spare-parts', 'Industrial machines and mechanical spare parts', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(17, 'Chemicals', 'chemicals', 'Chemical products and industrial chemicals', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(18, 'Fashion & Beauty', 'fashion-beauty', 'Fashion items and beauty products', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00'),
(19, 'New Test Category', 'new-test-category', 'A test category', NULL, '2025-12-12 12:29:00', '2025-12-12 12:29:00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversations`
--

CREATE TABLE `conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `buyer_id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `last_message` text DEFAULT NULL,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
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
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_chats`
--

CREATE TABLE `group_chats` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_chats`
--

INSERT INTO `group_chats` (`id`, `name`, `description`, `category`, `created_at`, `updated_at`) VALUES
(1, 'Grains & Pulses Group Chat', 'Discussion group for Grains & Pulses related products and trades', 'Grains & Pulses', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(2, 'Spices Group Chat', 'Discussion group for Spices related products and trades', 'Spices', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(3, 'Fruits & Vegetables Group Chat', 'Discussion group for Fruits & Vegetables related products and trades', 'Fruits & Vegetables', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(4, 'Handicrafts Group Chat', 'Discussion group for Handicrafts related products and trades', 'Handicrafts', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(5, 'Kitchen & Household Items Group Chat', 'Discussion group for Kitchen & Household Items related products and trades', 'Kitchen & Household Items', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(6, 'Textiles Group Chat', 'Discussion group for Textiles related products and trades', 'Textiles', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(7, 'Machines & Spare Parts Group Chat', 'Discussion group for Machines & Spare Parts related products and trades', 'Machines & Spare Parts', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(8, 'Electronics Group Chat', 'Discussion group for Electronics related products and trades', 'Electronics', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(9, 'Chemicals Group Chat', 'Discussion group for Chemicals related products and trades', 'Chemicals', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(10, 'Fashion & Beauty Group Chat', 'Discussion group for Fashion & Beauty related products and trades', 'Fashion & Beauty', '2025-12-02 00:31:26', '2025-12-02 00:31:26'),
(12, 'Grains & Pulses Traders', 'Discussion forum for grains and pulses traders', 'Grains & Pulses', '2025-12-02 03:26:49', '2025-12-02 03:26:49'),
(13, 'Spices Marketplace', 'Connect with spice suppliers and buyers', 'Spices', '2025-12-02 03:26:49', '2025-12-02 03:26:49'),
(14, 'Fresh Produce Network', 'Fresh fruits and vegetables trading community', 'Fruits & Vegetables', '2025-12-02 03:26:49', '2025-12-02 03:26:49'),
(15, 'Handicrafts Artisans', 'Platform for handicrafts artisans and collectors', 'Handicrafts', '2025-12-02 03:26:49', '2025-12-02 03:26:49'),
(16, 'Kitchen Essentials', 'Trading hub for kitchen and household items', 'Kitchen & Household Items', '2025-12-02 03:26:49', '2025-12-02 03:26:49');

-- --------------------------------------------------------

--
-- Table structure for table `group_chat_messages`
--

CREATE TABLE `group_chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_chat_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message_type` varchar(255) NOT NULL DEFAULT 'text',
  `message_text` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `group_chat_users`
--

CREATE TABLE `group_chat_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `group_chat_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `group_chat_users`
--

INSERT INTO `group_chat_users` (`id`, `group_chat_id`, `user_id`, `is_admin`, `created_at`, `updated_at`) VALUES
(1, 1, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(2, 2, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(3, 3, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(4, 4, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(5, 5, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(6, 6, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(7, 7, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(8, 8, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(9, 9, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(10, 10, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(11, 12, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(12, 13, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(13, 14, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(14, 15, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33'),
(15, 16, 15, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `notes` text DEFAULT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message_type` varchar(255) NOT NULL DEFAULT 'text',
  `message_text` longtext DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `seen` tinyint(1) NOT NULL DEFAULT 0,
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `seller_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `subcategory_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `slug` varchar(180) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `moq` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `origin_country` varchar(100) NOT NULL,
  `status` enum('active','inactive','pending') NOT NULL DEFAULT 'pending',
  `verification_status` varchar(255) NOT NULL DEFAULT 'pending',
  `rejection_reason` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `seller_id`, `category_id`, `subcategory_id`, `name`, `slug`, `description`, `price`, `moq`, `unit`, `origin_country`, `status`, `verification_status`, `rejection_reason`, `is_featured`, `created_at`, `updated_at`) VALUES
(6, 1, 8, 14, 'White Rice', 'white-rice-1764155309', 'White Rice 100% Broken - Premium Export Grade, 25 Kg', 20500.00, 1, 'ton', 'india', 'active', 'approved', NULL, 0, '2025-11-26 05:38:29', '2025-11-26 06:25:33'),
(7, 1, 8, 14, 'Basmati Rice', 'basmati-rice-1764155643', 'Ir 64 Non Basmati Rice, 25 Kg', 35.00, 20, 'kg', 'india', 'active', 'approved', NULL, 0, '2025-11-26 05:44:03', '2025-11-26 06:27:31'),
(8, 1, 8, 14, 'Sella Basmati Rice', 'sella-basmati-rice-1764156071', '1718 Sella Basmati Rice, 50 Kg', 69.00, 10, 'kg', 'india', 'active', 'approved', NULL, 0, '2025-11-26 05:51:11', '2025-11-26 06:25:50'),
(9, 1, 8, 14, 'Golden Sella Basmati Rice', 'golden-sella-basmati-rice-1764156414', 'Skystar Golden Sella XXXL Basmati Rice', 91.00, 1, 'kg', 'india', 'active', 'approved', NULL, 0, '2025-11-26 05:56:54', '2025-11-26 06:25:57'),
(10, 1, 2, 11, 'Shirts Couple Combo', 'shirts-couple-combo-1764160077', 'Shirts Couple Combo - Matching Mens And Womens Outfits - Laila Majanu, Cotton', 639.00, 10, 'pair', 'india', 'active', 'approved', NULL, 0, '2025-11-26 06:57:57', '2025-11-26 08:27:04'),
(11, 1, 2, 8, '3 Piece Suit', '3-piece-suit-1764160269', 'Raxon Men\'s Premium Blue Checked 3-Piece Suit, Terry Rayon', 3400.00, 5, 'set', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:01:09', '2025-11-26 08:27:11'),
(12, 1, 2, 9, 'Ladies Pakistani Suits', 'ladies-pakistani-suits-1764160469', 'Ladies Designer Pakistani Suits DN 1097', 1200.00, 10, 'set', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:04:29', '2025-11-26 08:27:17'),
(13, 1, 1, 6, 'Electric Fan', 'electric-fan-1764160964', 'Water Sheild Drum Electric Fans, 100 W', 600.00, 10, 'set', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:12:44', '2025-11-26 08:27:23'),
(14, 1, 1, 6, 'Foldable Fan', 'foldable-fan-1764161153', 'TELESCOPIC FOLDABLE FAN', 210.00, 20, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:15:53', '2025-11-26 08:27:29'),
(15, 1, 1, 5, 'LED Light', 'led-light-1764161391', 'LED 20w Cob Zoom Light', 492.00, 20, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:19:51', '2025-11-26 08:27:36'),
(16, 1, 3, 13, 'Protein', 'protein-1764161906', 'Protein With Low Fat', 450.00, 5, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:28:26', '2025-11-26 08:30:37'),
(17, 1, 3, 13, 'Weight Gainer', 'weight-gainer-1764162104', 'Weight Gain Powder', 250.00, 20, 'box', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:31:44', '2025-11-26 08:27:51'),
(18, 1, 1, 7, 'iPhone Charging Cable', 'iphone-chargin-cable-1764162387', 'iPhone USB C Type Cable', 185.00, 20, 'box', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:36:27', '2025-11-26 08:27:58'),
(19, 1, 9, 16, 'iPhone 17 Air Back Cover', 'iphone-17-air-back-cover-1764163120', 'iPhone 17 Air Back Cover with Premium Protection', 180.00, 10, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:48:40', '2025-11-26 08:28:05'),
(20, 1, 9, 16, 'USB Cable', 'usb-cable-1764163511', 'Type C USB Data Cable', 13.00, 20, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:55:11', '2025-11-26 08:28:46'),
(21, 1, 9, 16, 'Mobile Stand', 'mobile-stand-1764163714', 'Phone/Tab 360 Rotatable Mobile Stand', 500.00, 10, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 07:58:34', '2025-11-26 08:28:52'),
(22, 1, 2, 12, 'Trapstar Trouser', 'trapstar-trouser-1764164118', 'Plain Black Trapstar Trousers, Casual Wear, Unisex', 400.00, 10, 'piece', 'india', 'active', 'approved', NULL, 0, '2025-11-26 08:05:18', '2025-11-26 08:28:58'),
(23, 1, 10, 17, 'Leather Shoes', 'leather-shoes-1764164451', 'Derby PU Sole Black Leather S1 Safety Shoes', 825.00, 5, 'pair', 'india', 'active', 'approved', NULL, 0, '2025-11-26 08:10:51', '2025-11-26 08:29:06'),
(24, 1, 10, 18, 'Slipper', 'slipper-1764164675', 'Esd Anti Static Slippers', 135.00, 10, 'pair', 'india', 'active', 'approved', NULL, 0, '2025-11-26 08:14:35', '2025-11-26 08:29:12'),
(25, 1, 8, 15, 'Mixed Dry Fruits', 'mixed-dry-fruits-1764165386', 'Mixed Dry Fruits - (Figs, Raisins, Almond, Cashew, Walnut)', 1280.00, 10, 'kg', 'india', 'active', 'approved', NULL, 0, '2025-11-26 08:26:26', '2025-11-26 08:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `is_primary` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_path`, `is_primary`, `created_at`, `updated_at`) VALUES
(22, 6, 'products/1764155309_0_6926dfad4cd69.webp', 1, '2025-11-26 05:38:29', '2025-11-26 05:38:29'),
(23, 6, 'products/1764155309_1_6926dfadb84ff.webp', 0, '2025-11-26 05:38:30', '2025-11-26 05:38:30'),
(24, 7, 'products/1764155643_0_6926e0fb1e62f.webp', 1, '2025-11-26 05:44:03', '2025-11-26 05:44:03'),
(25, 7, 'products/1764155643_1_6926e0fb8d68e.webp', 0, '2025-11-26 05:44:04', '2025-11-26 05:44:04'),
(26, 8, 'products/1764156071_0_6926e2a77b714.webp', 1, '2025-11-26 05:51:12', '2025-11-26 05:51:12'),
(27, 8, 'products/1764156072_1_6926e2a8485e8.webp', 0, '2025-11-26 05:51:12', '2025-11-26 05:51:12'),
(28, 9, 'products/1764156414_0_6926e3fe57871.webp', 1, '2025-11-26 05:56:55', '2025-11-26 05:56:55'),
(29, 9, 'products/1764156415_1_6926e3ff06801.webp', 0, '2025-11-26 05:56:55', '2025-11-26 05:56:55'),
(30, 10, 'products/1764160077_0_6926f24defba6.webp', 1, '2025-11-26 06:57:58', '2025-11-26 06:57:58'),
(31, 10, 'products/1764160078_1_6926f24e45ace.webp', 0, '2025-11-26 06:57:58', '2025-11-26 06:57:58'),
(32, 10, 'products/1764160078_2_6926f24e7fd91.webp', 0, '2025-11-26 06:57:58', '2025-11-26 06:57:58'),
(33, 11, 'products/1764160269_0_6926f30d33f1d.webp', 1, '2025-11-26 07:01:09', '2025-11-26 07:01:09'),
(34, 11, 'products/1764160269_1_6926f30d6ae93.webp', 0, '2025-11-26 07:01:09', '2025-11-26 07:01:09'),
(35, 11, 'products/1764160269_2_6926f30d9d0cf.webp', 0, '2025-11-26 07:01:09', '2025-11-26 07:01:09'),
(36, 12, 'products/1764160469_0_6926f3d5e33c4.webp', 1, '2025-11-26 07:04:30', '2025-11-26 07:04:30'),
(37, 12, 'products/1764160470_1_6926f3d64aa96.webp', 0, '2025-11-26 07:04:30', '2025-11-26 07:04:30'),
(38, 12, 'products/1764160470_2_6926f3d693441.webp', 0, '2025-11-26 07:04:30', '2025-11-26 07:04:30'),
(39, 13, 'products/1764160964_0_6926f5c485de7.webp', 1, '2025-11-26 07:12:44', '2025-11-26 07:12:44'),
(40, 13, 'products/1764160964_1_6926f5c4c592d.webp', 0, '2025-11-26 07:12:45', '2025-11-26 07:12:45'),
(41, 13, 'products/1764160965_2_6926f5c50fe4a.webp', 0, '2025-11-26 07:12:45', '2025-11-26 07:12:45'),
(42, 14, 'products/1764161153_0_6926f68158497.webp', 1, '2025-11-26 07:15:53', '2025-11-26 07:15:53'),
(43, 14, 'products/1764161153_1_6926f681806a2.webp', 0, '2025-11-26 07:15:53', '2025-11-26 07:15:53'),
(44, 15, 'products/1764161391_0_6926f76f0c06e.webp', 1, '2025-11-26 07:19:51', '2025-11-26 07:19:51'),
(45, 15, 'products/1764161391_1_6926f76f4e2d4.webp', 0, '2025-11-26 07:19:51', '2025-11-26 07:19:51'),
(46, 16, 'products/1764161906_0_6926f9723574d.webp', 1, '2025-11-26 07:28:26', '2025-11-26 07:28:26'),
(47, 16, 'products/1764161906_1_6926f97273ef7.webp', 0, '2025-11-26 07:28:26', '2025-11-26 07:28:26'),
(48, 17, 'products/1764162104_0_6926fa388aebe.webp', 1, '2025-11-26 07:31:44', '2025-11-26 07:31:44'),
(49, 18, 'products/1764162387_0_6926fb5357143.webp', 1, '2025-11-26 07:36:27', '2025-11-26 07:36:27'),
(50, 19, 'products/1764163120_0_6926fe3087b61.webp', 1, '2025-11-26 07:48:40', '2025-11-26 07:48:40'),
(51, 19, 'products/1764163120_1_6926fe30c4b25.webp', 0, '2025-11-26 07:48:41', '2025-11-26 07:48:41'),
(52, 20, 'products/1764163511_0_6926ffb7ab867.webp', 1, '2025-11-26 07:55:11', '2025-11-26 07:55:11'),
(53, 20, 'products/1764163511_1_6926ffb7e0577.webp', 0, '2025-11-26 07:55:12', '2025-11-26 07:55:12'),
(54, 21, 'products/1764163714_0_69270082f29b9.webp', 1, '2025-11-26 07:58:35', '2025-11-26 07:58:35'),
(55, 21, 'products/1764163715_1_692700834292b.webp', 0, '2025-11-26 07:58:35', '2025-11-26 07:58:35'),
(56, 22, 'products/1764164118_0_69270216cd416.webp', 1, '2025-11-26 08:05:19', '2025-11-26 08:05:19'),
(57, 22, 'products/1764164119_1_6927021725f0c.webp', 0, '2025-11-26 08:05:19', '2025-11-26 08:05:19'),
(58, 23, 'products/1764164451_0_69270363c3124.webp', 1, '2025-11-26 08:10:51', '2025-11-26 08:10:51'),
(59, 24, 'products/1764164675_0_692704439568c.webp', 1, '2025-11-26 08:14:35', '2025-11-26 08:14:35'),
(60, 25, 'products/1764165386_0_6927070aef976.webp', 1, '2025-11-26 08:26:27', '2025-11-26 08:26:27'),
(61, 25, 'products/1764165387_1_6927070bbff5e.webp', 0, '2025-11-26 08:26:28', '2025-11-26 08:26:28');

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
('0T86vinoF5SLH1v2U8VtX8b858mHt2GuSJUwWlZ5', 15, '2401:4900:88c7:ff5:a1c5:77d:1987:3503', 'Mozilla/5.0 (iPhone; CPU iPhone OS 26_1_0 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) CriOS/143.0.7499.92 Mobile/15E148 Safari/604.1', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUTVqRXExMmJNdUpIVjFGU3g1eEl2b3V2cWU1VDhZRERpVWtNbGpKOCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20vYnV5ZXIvcGVuZGluZy1hcHByb3ZhbCI7czo1OiJyb3V0ZSI7czoyMjoiYnV5ZXIucGVuZGluZy1hcHByb3ZhbCI7fX0=', 1765542961),
('2nwgD387DBwze8tj1qsd9FcFm46J94rMhXpAqarq', 15, '106.51.113.228', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiVE4xVTJ3UUFzdzhBejhSMGdvVlluYlNvcVBDWmZmeTk1YkhHNFFTYyI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDU6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20vYnV5ZXIvcGVuZGluZy1hcHByb3ZhbCI7czo1OiJyb3V0ZSI7czoyMjoiYnV5ZXIucGVuZGluZy1hcHByb3ZhbCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765542970),
('5M0UoFmHlRQIfXIDptjvlxqQC87dh1e7y1PR1ZJq', 15, '49.44.78.171', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoibWZVZ3FUNTNUdWpGY0I3TnhuaXZFSkdvV0RVYWZJaFRMazVnWTNlVCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTU7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6Mzg6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20vYnV5ZXIvZGFzaGJvYXJkIjtzOjU6InJvdXRlIjtzOjE1OiJidXllci5kYXNoYm9hcmQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1765543028),
('cuJjVUqTkbB0W82UjwzPenfInpBxvGIhSuMnyv6j', NULL, '205.169.39.11', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/117.0.5938.132 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZE1lbElBajlZaE5mZFlldmJ6bXpRRllEdFBibFFJRWtXY21DbElXViI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20iO3M6NToicm91dGUiO3M6Nzoid2VsY29tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765542700),
('jaRCUrXgkz3ztr2pexpLZ0JkDntMPBtzbUmqG8y2', NULL, '89.104.101.62', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/94.0.4606.61 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQzNoMlo1OUt6R29mejViM3cxWFFjOGVndFFkeEUwb3NvTzI1aWlpYSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjI6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20iO3M6NToicm91dGUiO3M6Nzoid2VsY29tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1765542528),
('Jql2qqS4UEd3g7WpgbG70JsQCWgVgTlJ8WEoP4qR', 2, '2401:4900:88c7:ff5:808b:68df:3d1e:e49a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiRW5NSjJyc0VxbXozMUc4TkVnS1ROQXRpNFo2YmwwTVpBMFdaS3RJSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20vYWRtaW4vdmVyaWZpY2F0aW9ucy91c2VycyI7czo1OiJyb3V0ZSI7czozMToiYWRtaW4udmVyaWZpY2F0aW9ucy51c2Vycy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1765543008),
('VuAAc6J96N7KYJKDnba1gTS2chYHKBvTGmMbJwcP', 15, '2401:4900:88c7:ff5:808b:68df:3d1e:e49a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSm1mWHVuQVlGRDJ3OGZRZ2F2NmFUWWh3TTVqZzlEYTJqaG9ORHFYOCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vdHJhbnNhbW90YS5jb20vZ3JvdXAtY2hhdC8xIjtzOjU6InJvdXRlIjtzOjE1OiJncm91cC1jaGF0LnNob3ciO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxNTt9', 1765543026);

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(120) NOT NULL,
  `icon` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `icon`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Smartphones', 'smartphones', NULL, 'Mobile phones and smartphones', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(2, 1, 'Laptops', 'laptops', NULL, 'Notebooks and computers', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(3, 1, 'Cameras', 'cameras', NULL, 'Digital cameras and accessories', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(4, 1, 'Audio Equipment', 'audio-equipment', NULL, 'Speakers and audio devices', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(5, 1, 'LED Lights', 'led-lights', NULL, 'LED bulbs and lighting products', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(6, 1, 'Fans', 'fans', NULL, 'Electric fans and coolers', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(7, 1, 'Mobile Accessories', 'mobile-accessories', NULL, 'Covers, chargers, and more', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(8, 2, 'Men\'s Clothing', 'mens-clothing', NULL, 'Clothing for men', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(9, 2, 'Women\'s Clothing', 'womens-clothing', NULL, 'Clothing for women', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(10, 2, 'Children\'s Clothing', 'childrens-clothing', NULL, 'Clothing for kids', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(11, 2, 'Couple Clothing', 'couple-clothing', NULL, 'Matching outfits for couples', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(12, 2, 'Unisex Clothing', 'unisex-clothing', NULL, 'Unisex apparel', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(13, 3, 'Supplements', 'supplements', NULL, 'Health and nutrition supplements', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(14, 8, 'Rice', 'rice', NULL, 'Various rice types', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(15, 8, 'Dry Fruits', 'dry-fruits', NULL, 'Dry fruit items', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(16, 9, 'Fashion Accessories', 'fashion-accessories', NULL, 'Bags, belts, jewelry', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(17, 10, 'Shoes', 'shoes', NULL, 'Shoes for men and women', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(18, 10, 'Slippers', 'slippers', NULL, 'Indoor and outdoor slippers', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(19, 11, 'Wheat', 'wheat', NULL, 'Different varieties of wheat', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(20, 11, 'Lentils', 'lentils', NULL, 'Various lentils and pulses', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(21, 12, 'Whole Spices', 'whole-spices', NULL, 'Whole spice varieties', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(22, 12, 'Ground Spices', 'ground-spices', NULL, 'Powdered spices', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(23, 13, 'Fresh Fruits', 'fresh-fruits', NULL, 'Seasonal fruits', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(24, 13, 'Fresh Vegetables', 'fresh-vegetables', NULL, 'Organic and fresh vegetables', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(25, 14, 'Wooden Crafts', 'wooden-crafts', NULL, 'Handmade wooden artworks', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(26, 15, 'Cookware', 'cookware', NULL, 'Cooking utensils and pots', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(27, 16, 'Industrial Machinery', 'industrial-machinery', NULL, 'Heavy-duty machinery', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(28, 17, 'Industrial Chemicals', 'industrial-chemicals', NULL, 'Industrial chemical products', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(29, 18, 'Cosmetics', 'cosmetics', NULL, 'Makeup and beauty items', '2025-12-12 12:29:13', '2025-12-12 12:29:13'),
(30, 19, 'Test Subcategory', 'test-subcategory', NULL, 'For testing purposes', '2025-12-12 12:29:13', '2025-12-12 12:29:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  `company_name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `timezone` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `company_name`, `phone`, `city`, `country`, `profile_image`, `is_verified`, `timezone`, `verified`) VALUES
(2, 'Admin', 'admin@admin.com', NULL, '$2y$12$ZIyNveShJDgIrxGAZAL/hen2XDbWsE1LxBh61u2khwRPC6.TIfQxS', NULL, '2025-11-20 02:20:21', '2025-11-20 02:22:28', 'admin', 'Transamota Admin', '+1234567890', 'Admin City', 'Admin Country', NULL, 1, NULL, 0),
(15, 'Salim', 'salimsandhey@gmail.com', '2025-12-12 12:36:01', '$2y$12$sXyMROvN8b/um8cFbEeeD.CeQgSRSpfR41DlfxdsZeuUZ5eeHd1iu', NULL, '2025-12-12 12:35:33', '2025-12-12 12:36:48', 'buyer', 'Flipoo', '09877231183', 'malerkotla', 'India', NULL, 1, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `product_categories` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`product_categories`)),
  `products_offered` text DEFAULT NULL,
  `products_interested` text DEFAULT NULL,
  `buying_frequency` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `gst_no` varchar(255) DEFAULT NULL,
  `verification_doc` varchar(255) DEFAULT NULL,
  `verification_doc_type` varchar(255) DEFAULT NULL,
  `verified_by_admin` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `business_type`, `product_categories`, `products_offered`, `products_interested`, `buying_frequency`, `website`, `gst_no`, `verification_doc`, `verification_doc_type`, `verified_by_admin`, `created_at`, `updated_at`) VALUES
(1, 15, NULL, NULL, NULL, 'Mobiles', 'monthly', NULL, NULL, NULL, NULL, 0, '2025-12-12 12:35:33', '2025-12-12 12:35:33');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversations`
--
ALTER TABLE `conversations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `conversations_slug_unique` (`slug`),
  ADD KEY `conversations_seller_id_foreign` (`seller_id`),
  ADD KEY `conversations_buyer_id_seller_id_index` (`buyer_id`,`seller_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_product_id_unique` (`user_id`,`product_id`),
  ADD KEY `favorites_product_id_foreign` (`product_id`);

--
-- Indexes for table `group_chats`
--
ALTER TABLE `group_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_chat_messages`
--
ALTER TABLE `group_chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_chat_messages_group_chat_id_index` (`group_chat_id`),
  ADD KEY `group_chat_messages_sender_id_index` (`sender_id`);

--
-- Indexes for table `group_chat_users`
--
ALTER TABLE `group_chat_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_chat_users_group_chat_id_user_id_unique` (`group_chat_id`,`user_id`),
  ADD KEY `group_chat_users_user_id_foreign` (`user_id`);

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `inquiries_conversation_id_product_id_unique` (`conversation_id`,`product_id`),
  ADD KEY `inquiries_product_id_foreign` (`product_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_conversation_id_index` (`conversation_id`),
  ADD KEY `messages_sender_id_index` (`sender_id`);

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
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_seller_id_foreign` (`seller_id`),
  ADD KEY `products_category_id_foreign` (`category_id`),
  ADD KEY `products_subcategory_id_foreign` (`subcategory_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subcategories_category_id_foreign` (`category_id`);

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
  ADD KEY `user_profiles_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversations`
--
ALTER TABLE `conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chats`
--
ALTER TABLE `group_chats`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `group_chat_messages`
--
ALTER TABLE `group_chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `group_chat_users`
--
ALTER TABLE `group_chat_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversations`
--
ALTER TABLE `conversations`
  ADD CONSTRAINT `conversations_buyer_id_foreign` FOREIGN KEY (`buyer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `conversations_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_chat_messages`
--
ALTER TABLE `group_chat_messages`
  ADD CONSTRAINT `group_chat_messages_group_chat_id_foreign` FOREIGN KEY (`group_chat_id`) REFERENCES `group_chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `group_chat_users`
--
ALTER TABLE `group_chat_users`
  ADD CONSTRAINT `group_chat_users_group_chat_id_foreign` FOREIGN KEY (`group_chat_id`) REFERENCES `group_chats` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_chat_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inquiries_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `products_subcategory_id_foreign` FOREIGN KEY (`subcategory_id`) REFERENCES `subcategories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
