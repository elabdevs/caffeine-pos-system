-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 18 Eyl 2025, 15:40:16
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `caffeine`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(120) NOT NULL,
  `resource` varchar(160) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `branches`
--

INSERT INTO `branches` (`id`, `name`, `address`, `phone`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Aliağa Şube', 'İzmir, Aliağa Merkez', '+90 232 123 45 67', 1, '2025-09-16 06:05:30', '2025-09-17 12:21:27'),
(2, 'Karşıyaka Şube', 'İzmir, Karşıyaka Çarşı', '+90 232 765 43 21', 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(120) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `categories`
--

INSERT INTO `categories` (`id`, `name`, `sort_order`, `is_active`) VALUES
(1, 'Kahve', 1, 1),
(2, 'Tatlı', 2, 1),
(3, 'Sandviç', 3, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ingredients`
--

CREATE TABLE `ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `unit` enum('ml','l','gr','kg','pcs') NOT NULL DEFAULT 'gr',
  `stock_quantity` decimal(12,3) NOT NULL DEFAULT 0.000,
  `min_threshold` decimal(12,3) NOT NULL DEFAULT 0.000,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `ingredients`
--

INSERT INTO `ingredients` (`id`, `name`, `unit`, `stock_quantity`, `min_threshold`, `supplier_id`, `updated_at`) VALUES
(1, 'Kahve Çekirdeği', 'kg', 20.000, 5.000, 1, '2025-09-16 06:05:30'),
(2, 'Süt', 'l', 50.000, 10.000, 2, '2025-09-16 06:05:30'),
(3, 'Şeker', 'kg', 15.000, 3.000, NULL, '2025-09-16 06:05:30'),
(4, 'Mascarpone', 'kg', 5.000, 2.000, NULL, '2025-09-16 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(80) NOT NULL,
  `channel` enum('email','sms','push') NOT NULL,
  `recipient_user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`payload`)),
  `status` enum('active','disabled') NOT NULL DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `channel`, `recipient_user_id`, `payload`, `status`, `created_at`) VALUES
(1, 'low_stock', 'email', 1, '{\"ingredient\": \"Mascarpone\", \"remaining\": 5}', 'active', '2025-09-16 06:05:30'),
(2, 'daily_report', 'email', 1, '{\"sales\": \"195.00\", \"date\": \"2025-09-16\"}', 'active', '2025-09-16 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `table_no` varchar(20) DEFAULT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('cash','card','qr','meal_card') DEFAULT NULL,
  `status` enum('pending','paid','cancelled','refunded') NOT NULL DEFAULT 'pending',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `paid_at` datetime DEFAULT NULL,
  `cancelled_at` datetime DEFAULT NULL,
  `refunded_at` datetime DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `branch_id`, `user_id`, `table_no`, `total_amount`, `payment_method`, `status`, `created_at`, `paid_at`, `cancelled_at`, `refunded_at`, `note`) VALUES
(17, 1, 1, 'T1', 95.00, 'cash', 'pending', '2025-09-18 14:46:49', '2025-09-18 14:46:58', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `unit_price` decimal(12,2) NOT NULL,
  `line_total` decimal(12,2) NOT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `unit_price`, `line_total`, `note`) VALUES
(22, 17, 6, 1, 95.00, 95.00, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `table_no` varchar(50) DEFAULT NULL,
  `method` enum('cash','card','qr','meal') NOT NULL,
  `amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` enum('pending','completed','failed') NOT NULL DEFAULT 'completed',
  `txn_ref` varchar(191) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `payments`
--

INSERT INTO `payments` (`id`, `order_id`, `branch_id`, `table_no`, `method`, `amount`, `status`, `txn_ref`, `note`, `created_at`, `updated_at`) VALUES
(11, 17, 1, 'T1', 'cash', 95.00, 'completed', '', '', '2025-09-18 11:46:58', '2025-09-18 11:46:58');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `sku` varchar(80) DEFAULT NULL,
  `barcode` varchar(80) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `price`, `sku`, `barcode`, `image_url`, `active`, `created_at`, `updated_at`) VALUES
(1, 1, 'Latte', 65.00, 'CF001', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30'),
(2, 1, 'Espresso', 45.00, 'CF002', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30'),
(3, 1, 'Cappuccino', 60.00, 'CF003', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30'),
(4, 2, 'Cheesecake', 80.00, 'DS001', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30'),
(5, 2, 'Tiramisu', 85.00, 'DS002', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30'),
(6, 3, 'Tavuklu Sandviç', 95.00, 'SW001', NULL, NULL, 1, '2025-09-16 06:05:30', '2025-09-16 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_ingredients`
--

CREATE TABLE `product_ingredients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `ingredient_id` bigint(20) UNSIGNED NOT NULL,
  `quantity_used` decimal(12,3) NOT NULL DEFAULT 0.000
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `product_ingredients`
--

INSERT INTO `product_ingredients` (`id`, `product_id`, `ingredient_id`, `quantity_used`) VALUES
(1, 1, 1, 0.018),
(2, 1, 2, 0.200),
(3, 2, 1, 0.018),
(4, 3, 1, 0.018),
(5, 3, 2, 0.150),
(6, 4, 3, 0.050),
(7, 4, 2, 0.100),
(8, 5, 4, 0.100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_options`
--

CREATE TABLE `product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT 0,
  `multiple` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `name`, `required`, `multiple`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 1, 'Boy', 1, 0, 1, '2025-09-17 13:34:41', '2025-09-17 13:34:43'),
(3, 1, 'Ekstra', 0, 1, 2, '2025-09-17 13:34:30', '2025-09-17 13:34:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `option_id` bigint(20) UNSIGNED NOT NULL,
  `label` varchar(100) NOT NULL,
  `price_delta` decimal(10,2) NOT NULL DEFAULT 0.00,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `product_option_values`
--

INSERT INTO `product_option_values` (`id`, `option_id`, `label`, `price_delta`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 2, 'Küçük Boy', 0.00, 1, '2025-09-17 13:33:42', '2025-09-17 13:33:42'),
(2, 2, 'Büyük Boy', 25.00, 2, '2025-09-17 13:33:42', '2025-09-17 13:35:24'),
(3, 3, 'Laktozsuz Süt', 0.00, 1, '2025-09-17 13:35:13', '2025-09-17 13:35:13'),
(4, 3, 'Ekstra Espresso Shot', 25.00, 2, '2025-09-17 13:35:45', '2025-09-17 13:35:45');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(80) NOT NULL,
  `permissions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`permissions`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `roles`
--

INSERT INTO `roles` (`id`, `name`, `permissions`) VALUES
(1, 'admin', '{\"orders.create\": true, \"users.manage\": true, \"reports.view\": true}'),
(2, 'cashier', '{\"orders.create\": true, \"orders.refund\": true}'),
(3, 'waiter', '{\"orders.create\": true}');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(64) NOT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sections`
--

INSERT INTO `sections` (`id`, `branch_id`, `name`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 1, 'Bahçe', 1, '2025-09-17 12:27:35', '2025-09-17 12:27:37');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `skey` varchar(120) NOT NULL,
  `svalue` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`svalue`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `settings`
--

INSERT INTO `settings` (`id`, `skey`, `svalue`) VALUES
(1, 'currency', '\"TRY\"'),
(2, 'tax_rate', '\"0.08\"'),
(3, 'service_charge', '\"0.10\"'),
(4, 'language', '\"tr\"');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(160) NOT NULL,
  `contact_info` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`contact_info`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `contact_info`, `created_at`) VALUES
(1, 'Kahve Toptancısı A.Ş.', '{\"phone\": \"+90 212 111 22 33\", \"email\": \"info@kahvetoptanci.com\"}', '2025-09-16 06:05:30'),
(2, 'Süt Dağıtım Ltd.', '{\"phone\": \"+90 212 444 55 66\", \"email\": \"siparis@sutdagitim.com\"}', '2025-09-16 06:05:30');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tables`
--

CREATE TABLE `tables` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED DEFAULT NULL,
  `code` varchar(32) NOT NULL,
  `label` varchar(80) DEFAULT NULL,
  `capacity` tinyint(3) UNSIGNED NOT NULL DEFAULT 4,
  `status` enum('available','occupied','reserved','cleaning','disabled') NOT NULL DEFAULT 'available',
  `pos_x` int(11) DEFAULT NULL,
  `pos_y` int(11) DEFAULT NULL,
  `notes` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `tables`
--

INSERT INTO `tables` (`id`, `branch_id`, `section_id`, `code`, `label`, `capacity`, `status`, `pos_x`, `pos_y`, `notes`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, 'T1', 'Masa 1', 4, 'cleaning', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-18 11:46:58', NULL),
(2, 1, 2, 'T2', 'Masa 2', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-18 10:10:38', NULL),
(3, 1, 2, 'T3', 'Masa 3', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-18 08:27:53', NULL),
(4, 1, 2, 'T4', 'Masa 4', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(5, 1, 2, 'T5', 'Masa 5', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(6, 1, 2, 'T6', 'Masa 6', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(7, 1, 2, 'T7', 'Masa 7', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(8, 1, 2, 'T8', 'Masa 8', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(9, 1, 2, 'T9', 'Masa 9', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(10, 1, 2, 'T10', 'Masa 10', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(11, 1, 2, 'T11', 'Masa 11', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(12, 1, 2, 'T12', 'Masa 12', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(13, 1, 2, 'T13', 'Masa 13', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(14, 1, 2, 'T14', 'Masa 14', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(15, 1, 2, 'T15', 'Masa 15', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(16, 1, 2, 'T16', 'Masa 16', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(17, 1, 2, 'T17', 'Masa 17', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(18, 1, 2, 'T18', 'Masa 18', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(19, 1, 2, 'T19', 'Masa 19', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL),
(20, 1, 2, 'T20', 'Masa 20', 4, 'available', NULL, NULL, NULL, '2025-09-17 12:28:48', '2025-09-17 12:28:48', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `name` varchar(120) NOT NULL,
  `email` varchar(190) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `session_version` varchar(64) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `branch_id`, `username`, `name`, `email`, `password_hash`, `status`, `last_login_at`, `created_at`, `updated_at`, `session_version`) VALUES
(1, 1, 'reality1111', 'Admin User', 'admin@cafe.com', 'JGFyZ29uMmlkJHY9MTkkbT02NTUzNix0PTQscD0xJFUySkZZMWcwYW1KV1NqTklWVlE0Y2ckUzNNc2lVRHhDY3VGb2hrcGlaWmFCL2NGcXZrYlBRdThCVG55K0p4dTUxcw==', 'active', NULL, '2025-09-16 06:05:30', '2025-09-17 12:19:40', '12'),
(2, 1, 'garson', 'Test Garsonu', 'garson@cafe.com', '$2y$10$04W367PTKNz7HehaPvHZluHSwfdzjGQQlNKPFSL4fG.ANqHoZDtxO', 'active', NULL, '2025-09-16 06:05:30', '2025-09-17 12:12:31', '1'),
(3, 2, '0', 'Garson Ayşe', 'ayse@cafe.com', '$2y$10$abc...hash...', 'active', NULL, '2025-09-16 06:05:30', '2025-09-16 06:05:30', '1');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_roles`
--

CREATE TABLE `user_roles` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `user_roles`
--

INSERT INTO `user_roles` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Görünüm yapısı durumu `vw_low_stock`
-- (Asıl görünüm için aşağıya bakın)
--
CREATE TABLE `vw_low_stock` (
`id` bigint(20) unsigned
,`name` varchar(160)
,`unit` enum('ml','l','gr','kg','pcs')
,`stock_quantity` decimal(12,3)
,`min_threshold` decimal(12,3)
,`is_low` int(1)
,`supplier_name` varchar(160)
);

-- --------------------------------------------------------

--
-- Görünüm yapısı `vw_low_stock`
--
DROP TABLE IF EXISTS `vw_low_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_low_stock`  AS SELECT `i`.`id` AS `id`, `i`.`name` AS `name`, `i`.`unit` AS `unit`, `i`.`stock_quantity` AS `stock_quantity`, `i`.`min_threshold` AS `min_threshold`, `i`.`stock_quantity`< `i`.`min_threshold` AS `is_low`, `s`.`name` AS `supplier_name` FROM (`ingredients` `i` left join `suppliers` `s` on(`s`.`id` = `i`.`supplier_id`)) WHERE `i`.`stock_quantity` < `i`.`min_threshold` ;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_audit_user_created` (`user_id`,`created_at`);

--
-- Tablo için indeksler `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_categories_name` (`name`),
  ADD KEY `idx_categories_active` (`is_active`,`sort_order`);

--
-- Tablo için indeksler `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_ingredients_name` (`name`),
  ADD KEY `idx_ingredients_stock` (`stock_quantity`),
  ADD KEY `idx_ingredients_supplier` (`supplier_id`);

--
-- Tablo için indeksler `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_notifications_user` (`recipient_user_id`),
  ADD KEY `idx_notifications_type_status` (`type`,`status`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_branch` (`branch_id`),
  ADD KEY `idx_orders_user` (`user_id`),
  ADD KEY `idx_orders_status_created` (`status`,`created_at`),
  ADD KEY `idx_orders_paid_at` (`paid_at`),
  ADD KEY `idx_orders_created_at` (`created_at`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_order_items_order` (`order_id`),
  ADD KEY `idx_order_items_product` (`product_id`);

--
-- Tablo için indeksler `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_payments_order` (`order_id`),
  ADD KEY `fk_branch_id` (`branch_id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_products_name` (`name`),
  ADD KEY `idx_products_category` (`category_id`,`active`),
  ADD KEY `idx_products_sku` (`sku`),
  ADD KEY `idx_products_barcode` (`barcode`);

--
-- Tablo için indeksler `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_product_ingredient` (`product_id`,`ingredient_id`),
  ADD KEY `fk_pi_ingredient` (`ingredient_id`);

--
-- Tablo için indeksler `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Tablo için indeksler `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `option_id` (`option_id`);

--
-- Tablo için indeksler `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_roles_name` (`name`);

--
-- Tablo için indeksler `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_section` (`branch_id`,`name`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_settings_skey` (`skey`);

--
-- Tablo için indeksler `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_suppliers_name` (`name`);

--
-- Tablo için indeksler `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_table_code` (`branch_id`,`code`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `idx_branch_status` (`branch_id`,`status`),
  ADD KEY `idx_branch_section` (`branch_id`,`section_id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_users_email` (`email`),
  ADD KEY `idx_users_branch` (`branch_id`);

--
-- Tablo için indeksler `user_roles`
--
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `fk_user_roles_role` (`role_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `product_ingredients`
--
ALTER TABLE `product_ingredients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `tables`
--
ALTER TABLE `tables`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `fk_audit_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `ingredients`
--
ALTER TABLE `ingredients`
  ADD CONSTRAINT `fk_ingredients_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_user` FOREIGN KEY (`recipient_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `fk_branch_id` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_ingredients`
--
ALTER TABLE `product_ingredients`
  ADD CONSTRAINT `fk_pi_ingredient` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pi_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD CONSTRAINT `product_option_values_ibfk_1` FOREIGN KEY (`option_id`) REFERENCES `product_options` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `tables`
--
ALTER TABLE `tables`
  ADD CONSTRAINT `tables_ibfk_1` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tables_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE SET NULL;

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_branch` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Tablo kısıtlamaları `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `fk_user_roles_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_user_roles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
