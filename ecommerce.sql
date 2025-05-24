-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 04, 2025 at 01:47 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`, `updated_at`) VALUES
(1, 5, 1, 1, '2025-03-03 06:04:06', '2025-03-03 06:04:06'),
(2, 5, 2, 5, '2025-03-03 06:20:15', '2025-03-03 06:37:42');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `address` text NOT NULL,
  `payment_method` varchar(50) NOT NULL,
  `status` enum('Pending','Processing','Shipped','Delivered','Cancelled') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `total_price`, `address`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, 4, 218000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 09:14:09', '2025-03-03 09:33:11'),
(2, 4, 218000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 09:17:04', '2025-03-03 09:31:34'),
(3, 4, 43000.00, 'gudlavalleru', 'COD', 'Pending', '2025-03-03 09:21:26', '2025-03-03 09:21:26'),
(4, 4, 75000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 09:30:00', '2025-03-03 09:55:31'),
(5, 4, 52000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 09:35:54', '2025-03-03 09:43:35'),
(6, 4, 43000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 09:39:17', '2025-03-03 09:39:17'),
(7, 4, 216000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 09:58:41', '2025-03-03 09:58:41'),
(8, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:00:23', '2025-03-03 10:00:23'),
(9, 4, 52000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 10:00:51', '2025-03-03 13:32:55'),
(10, 4, 66000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:01:26', '2025-03-03 10:01:26'),
(11, 4, 66000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:05:39', '2025-03-03 10:05:39'),
(12, 4, 56000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:11:11', '2025-03-03 10:11:11'),
(13, 4, 100000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:13:52', '2025-03-03 10:13:52'),
(14, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:17:42', '2025-03-03 10:17:42'),
(15, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:18:13', '2025-03-03 10:18:13'),
(16, 4, 56000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 10:37:22', '2025-03-03 10:37:32'),
(17, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 10:47:15', '2025-03-03 10:47:15'),
(18, 4, 66000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:17:40', '2025-03-03 13:17:40'),
(19, 4, 52000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 13:20:56', '2025-03-03 13:32:26'),
(20, 4, 52000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 13:23:02', '2025-03-03 13:32:41'),
(21, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:24:04', '2025-03-03 13:24:04'),
(22, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:25:17', '2025-03-03 13:25:17'),
(23, 4, 100000.00, 'pamarru', 'COD', 'Pending', '2025-03-03 13:25:57', '2025-03-03 13:25:57'),
(24, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:28:03', '2025-03-03 13:28:03'),
(25, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:28:51', '2025-03-03 13:28:51'),
(26, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:30:40', '2025-03-03 13:30:40'),
(27, 4, 66000.00, 'vijayawada', 'COD', 'Pending', '2025-03-03 13:31:43', '2025-03-03 13:31:43'),
(28, 4, 66000.00, 'pamarru', 'COD', 'Pending', '2025-03-03 13:32:14', '2025-03-03 13:32:14'),
(29, 4, 66000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 13:40:10', '2025-03-03 13:40:10'),
(30, 4, 154000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-03 14:17:02', '2025-03-03 14:17:14'),
(31, 4, 66000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 15:10:20', '2025-03-03 15:10:20'),
(32, 4, 56000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 15:16:00', '2025-03-03 15:16:00'),
(33, 4, 100000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 15:55:16', '2025-03-03 15:55:16'),
(34, 4, 52000.00, 'gudivada', 'COD', 'Pending', '2025-03-03 17:08:57', '2025-03-03 17:08:57'),
(35, 4, 100000.00, 'gudivada', 'COD', 'Cancelled', '2025-03-04 00:19:00', '2025-03-04 00:19:32'),
(36, 4, 149999.00, 'gudivada', 'COD', 'Pending', '2025-03-04 00:22:56', '2025-03-04 00:22:56'),
(37, 4, 5000.00, 'gudivada', 'COD', 'Pending', '2025-03-04 00:36:53', '2025-03-04 00:36:53');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 2, 2, 1, 66000.00),
(2, 2, 4, 1, 52000.00),
(3, 2, 5, 1, 100000.00),
(4, 3, 10, 1, 43000.00),
(5, 4, 7, 1, 75000.00),
(6, 5, 4, 1, 52000.00),
(7, 6, 10, 1, 43000.00),
(8, 7, 6, 2, 56000.00),
(9, 7, 4, 2, 52000.00),
(10, 8, 4, 1, 52000.00),
(11, 9, 4, 1, 52000.00),
(12, 10, 2, 1, 66000.00),
(13, 11, 2, 1, 66000.00),
(14, 12, 6, 1, 56000.00),
(15, 13, 5, 1, 100000.00),
(16, 14, 4, 1, 52000.00),
(17, 15, 4, 1, 52000.00),
(18, 16, 6, 1, 56000.00),
(19, 17, 4, 1, 52000.00),
(20, 18, 2, 1, 66000.00),
(21, 19, 4, 1, 52000.00),
(22, 20, 4, 1, 52000.00),
(23, 21, 4, 1, 52000.00),
(24, 22, 4, 1, 52000.00),
(25, 23, 5, 1, 100000.00),
(26, 24, 4, 1, 52000.00),
(27, 25, 9, 1, 52000.00),
(28, 26, 9, 1, 52000.00),
(29, 27, 2, 1, 66000.00),
(30, 28, 2, 1, 66000.00),
(31, 29, 2, 1, 66000.00),
(32, 30, 13, 1, 154000.00),
(33, 31, 2, 1, 66000.00),
(34, 32, 6, 1, 56000.00),
(35, 33, 5, 1, 100000.00),
(36, 34, 4, 1, 52000.00),
(37, 35, 5, 1, 100000.00),
(38, 36, 12, 1, 149999.00),
(39, 37, 16, 2, 2500.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `created_at`) VALUES
(2, 'Hp VICTUS', 66000.00, 'intel i5,12th gen, 2050 Nvidia graphics', 'product1.jpg', '2025-03-03 06:15:36'),
(4, 'DELL', 52000.00, 'i5 12thgen,8GB ,512GB SSD', 'product3.jpg', '2025-03-03 08:16:45'),
(5, 'MAC (Air3)', 100000.00, '8GB,512GB ssd\r\n', 'product2.jpg', '2025-03-03 08:22:39'),
(6, 'Acer aspire5', 56000.00, 'Intel i5,12th gen,8GB RAM,512 GB SSD', 'product4.jpg', '2025-03-03 08:35:09'),
(7, 'ASUS TUF F15', 75000.00, 'Intel i5, 13th Gen, 16GB,512 GB SSD', 'product8.webp', '2025-03-03 08:50:11'),
(8, 'Asus TUF Gamer', 66000.00, 'Intel i5, 12th Gen, 8GB RAM,512 GB SSD', 'product7.jpg', '2025-03-03 08:51:13'),
(9, 'HP Pavilion', 52000.00, 'Intel i5, 12th gen, 8GB RAM, 512 GB SSD', 'product9.jpg', '2025-03-03 08:52:07'),
(10, 'ASUS VIVO BOOK', 43000.00, 'Intel i5, 12th Gen,8GB RAM, 512GB SSD', 'product6.webp', '2025-03-03 08:53:43'),
(11, 'Moto edge40 neo', 22000.00, '6.55 FHD+curved,p-OLEDdisplay,MediaTek Dimensity 7030 processor.\r\n', 'product10.jpg', '2025-03-03 13:50:59'),
(12, 'Samsung S23 ultra', 149999.00, '12GB RAM,Snapdragon 8gen,17.25cm (6.8\") flat display', 'product11.jpg', '2025-03-03 14:04:41'),
(13, 'iphone 15 pro max', 154000.00, 'Apple A17 Pro,6.7\", 1290 x 2796 Resolution,4441 mAh', 'product12.jpg', '2025-03-03 14:09:06'),
(14, 'Realme GT Neo 3T', 30000.00, 'realme GT Neo 3T (Shade Black, 128 GB)  (6 GB RAM)', 'product13.jpg', '2025-03-03 14:12:05'),
(15, 'Moto edge 50', 25000.00, '6.7″ display, Snapdragon 7 Gen 1 AE chipset, 5000 mAh battery, 512 GB storage, 12 GB RAM', 'product14.jpg', '2025-03-04 00:30:14'),
(16, 'Moto buds', 2500.00, 'Dolby Atmos® 1 , and Hi-Res Audio 2', 'product15.jpg', '2025-03-04 00:32:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('user','admin') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, '', 'atmaluripradeep0@gmail.com', '$2y$10$2vrHuXmZ/VLfBRImn2pLau1PcuqaW0gbkpMV8CJCCFcJkFn/GV.HS', '2025-03-03 04:27:40', 'user'),
(2, '', 'atmauripradeep0@gmail.com', '$2y$10$TTG8gpAXBgLObIhYeZFnROXS0XvVjW19bOH5rvbrUXgwmEuxh1TTS', '2025-03-03 04:33:43', 'user'),
(3, '', 'atmakuripradeep0@gmail.com', '$2y$10$Y2ewANlRC8S2o6JDvXvYQOqkAMt61HFUMzKY9P4fHUTbpX1P2J.K2', '2025-03-03 05:32:00', 'user'),
(4, '', 'pradeep@gmail.com', '$2y$10$//3XCqxAF9QwGkxwdkvtPOeXInfviISZ1FThXu.xZTkMlTFkvB6b2', '2025-03-03 05:33:01', 'user'),
(5, '', 'pradeep1@gmail.com', '$2y$10$6Jlhb7GblkNjOaSRMaw2/eQ3zwuXMlZ6QWduC3gQtTb0q4VupmqEm', '2025-03-03 05:33:42', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
