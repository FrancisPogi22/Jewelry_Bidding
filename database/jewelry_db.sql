-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2024 at 10:31 AM
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
-- Database: `jewelry_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `auction_categories`
--

CREATE TABLE `auction_categories` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction_categories`
--

INSERT INTO `auction_categories` (`id`, `name`) VALUES
(6, 'kian'),
(7, 'try');

-- --------------------------------------------------------

--
-- Table structure for table `auction_products`
--

CREATE TABLE `auction_products` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `start_bid` float NOT NULL,
  `regular_price` float NOT NULL,
  `bid_end_datetime` datetime NOT NULL,
  `img_fname` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `auction_products`
--

INSERT INTO `auction_products` (`id`, `category_id`, `name`, `description`, `start_bid`, `regular_price`, `bid_end_datetime`, `img_fname`, `date_created`) VALUES
(35, 7, '1', '1', 10, 10, '2024-05-13 09:14:00', 'coowner.jpg', '2024-05-13 08:14:42'),
(36, 7, 'RING 1', 'RING2', 10, 10, '2024-05-13 08:53:00', 'img_6639c4b21b54a.png', '2024-05-13 08:52:24'),
(37, 7, 'SENIOR', 'JERSEY', 500, 750, '2024-05-13 10:54:00', 'senior.png', '2024-05-13 08:54:16'),
(38, 7, 'junior', 'JUNIOR', 60, 60, '2024-05-13 11:40:00', 'img_664164b87c532.png', '2024-05-13 10:40:14'),
(39, 6, 'SUPER SENIOR', 'FINAL', 850, 850, '2024-05-13 11:43:00', 'JUNIOR.png', '2024-05-13 10:43:42'),
(40, 7, 'try', 'gheh', 10, 10, '2024-05-13 15:51:00', '439557647_7350323168396875_1275562588771386244_n.jpg', '2024-05-13 15:50:29');

-- --------------------------------------------------------

--
-- Table structure for table `bids`
--

CREATE TABLE `bids` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `bid_amount` float NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=bid,2=confirmed,3=cancelled',
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bids`
--

INSERT INTO `bids` (`id`, `user_id`, `product_id`, `bid_amount`, `status`, `date_created`) VALUES
(30, 3, 30, 100, 1, '2024-05-12 11:50:23'),
(32, 3, 6, 50, 1, '2024-05-12 12:47:11'),
(33, 3, 6, 50, 1, '2024-05-12 12:48:13'),
(37, 3, 40, 100, 1, '2024-05-13 15:50:44');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(30) NOT NULL,
  `user_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `colour_id` int(30) NOT NULL,
  `size_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `colour_id`, `size_id`, `qty`, `price`, `ip_address`, `date_created`) VALUES
(4, 2, 2, 1, 2, 1, 3500, '', '2020-11-12 17:14:18');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(30) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date_created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `date_created`) VALUES
(1, 'Rings', '<div data-dobid=\"dfn\" style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 14px; display: inline;\">A small circular band, typically of precious metal and often set with one or more&nbsp;<span class=\"AraNOb\" style=\"text-decoration-line: underline;\"><a class=\"rMNQNe\" href=\"https://www.google.com/search?sca_esv=7477cf2eeab98e7f&amp;rlz=1C1GCEA_enPH1020PH1020&amp;sxsrf=ACQVn08BO3lIX5e51sPGFxY4k9RWXpphpA:1710071676434&amp;q=gemstones&amp;si=AKbGX_onJk-q0LQUYzV7-GRhpJ5D3gM4haJJZjxaYFzv6E3L5afWVGC-4MNPyVF_UezUoTfSPwoFoErUu1NmvCJnQ36weerF8jvKR9SwHBof_1UBY0onm50%3D&amp;expnd=1\" tabindex=\"0\" data-ved=\"2ahUKEwjGvsG20emEAxWwS2cHHbPdC1gQyecJegQILxAO\" style=\"color: inherit; -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1); outline: 0px;\">gemstones</a></span>, worn on a finger as an ornament or a&nbsp;<span class=\"AraNOb\" style=\"text-decoration-line: underline;\"><a class=\"rMNQNe\" href=\"https://www.google.com/search?sca_esv=7477cf2eeab98e7f&amp;rlz=1C1GCEA_enPH1020PH1020&amp;sxsrf=ACQVn08BO3lIX5e51sPGFxY4k9RWXpphpA:1710071676434&amp;q=token&amp;si=AKbGX_qy882wphGEk_Dxwohm5Oan6GC8cozP8tVzYOqOEu88AN9NqTE0dZMTw8V8ShuO4uh0COSVmmr22Hz81HVGt9xLVz9U-A%3D%3D&amp;expnd=1\" tabindex=\"0\" data-ved=\"2ahUKEwjGvsG20emEAxWwS2cHHbPdC1gQyecJegQILxAP\" style=\"color: inherit; -webkit-tap-highlight-color: rgba(0, 0, 0, 0.1); outline: 0px;\">token</a></span>&nbsp;of marriage, engagement, or authority.</div><div class=\"vmod\" style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 14px;\"></div><div><div data-dobid=\"dfn\" style=\"color: rgb(32, 33, 36); font-family: arial, sans-serif; font-size: 14px; display: inline;\"><br></div></div>', '0000-00-00 00:00:00'),
(2, 'Necklace', '<span style=\"background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(4, 12, 40); font-family: &quot;Google Sans&quot;, arial, sans-serif;\">A </span><font color=\"#000000\" style=\"\"><span style=\"font-family: &quot;Google Sans&quot;, arial, sans-serif;\">piece of jewelry consisting of a string of stones, beads, jewels, or the like, or a chain of gold, silver, or other metal, for wearing around the neck</span><span style=\"font-family: &quot;Google Sans&quot;, arial, sans-serif;\">.</span></font></span>', '0000-00-00 00:00:00'),
(3, 'Bracelet', '<span style=\"background-color: rgb(255, 255, 255);\"><span style=\"color: rgb(77, 81, 86); font-family: &quot;Google Sans&quot;, arial, sans-serif;\">A bracelet is an article of jewellery that is worn around the wrist. Bracelets may serve different uses, such as being&nbsp;</span><span style=\"color: rgb(4, 12, 40); font-family: &quot;Google Sans&quot;, arial, sans-serif;\">worn as an ornament</span><span style=\"color: rgb(77, 81, 86); font-family: &quot;Google Sans&quot;, arial, sans-serif;\">.&nbsp;</span></span>', '0000-00-00 00:00:00'),
(4, 'Earrings', '<span style=\"color: rgb(77, 81, 86); font-family: &quot;Google Sans&quot;, arial, sans-serif;\">Earring, a personal ornament worn pendent from the ear, usually suspended by means of a ring or hook passing through a pierced hole in the lobe of the ear or, in modern times, often by means of a screwed clip on the lobe.&nbsp;</span>', '0000-00-00 00:00:00'),
(5, 'Best Seller', '<font color=\"#000000\" style=\"background-color: rgb(255, 255, 255);\"><span style=\"font-family: &quot;Google Sans&quot;, arial, sans-serif;\">A&nbsp;</span><span style=\"font-family: &quot;Google Sans&quot;, arial, sans-serif;\">product that is extremely popular and has sold in very large numbers</span></font>', '0000-00-00 00:00:00'),
(6, 'New Arrival', '<span style=\"color: rgb(0, 0, 0);\">New things that the shop didn\'t previously sell.</span>															', '0000-00-00 00:00:00'),
(7, 'Watches', '<span style=\"color: rgb(0, 0, 0);\">A watch is a portable timepiece intended to be carried or worn by a person. It is designed to keep a consistent movement despite the motions caused by the person\'s activities.</span>															', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `colours`
--

CREATE TABLE `colours` (
  `id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `color` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colours`
--

INSERT INTO `colours` (`id`, `product_id`, `color`, `date_created`) VALUES
(2, 2, 'Gold', '2020-11-12 13:00:31'),
(4, 4, 'Silver', '2020-11-12 13:49:10'),
(5, 5, '', '2020-11-12 13:49:40'),
(6, 6, '', '2024-01-14 08:06:06'),
(7, 11, '', '2024-01-23 20:09:04'),
(8, 23, '', '2024-01-23 20:26:43'),
(9, 27, '', '2024-01-23 20:29:13'),
(10, 28, '', '2024-01-23 20:29:34'),
(12, 40, '', '2024-01-23 20:36:44'),
(13, 41, '', '2024-01-23 20:38:44'),
(14, 42, '', '2024-03-24 11:18:18'),
(15, 43, '', '2024-03-24 11:18:47'),
(16, 44, '', '2024-03-24 11:22:17'),
(24, 54, '', '2024-04-10 09:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `upload_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image_url`, `upload_date`) VALUES
(5, '3.jpg', '2024-04-13 15:09:02'),
(6, 'slider1.png', '2024-04-13 15:09:10'),
(7, 'slider2.png', '2024-04-13 15:09:13'),
(8, 'slider3.png', '2024-04-13 15:09:16'),
(9, 'slider4.png', '2024-04-13 15:09:19'),
(10, 'slider5.png', '2024-04-13 15:09:22');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(30) NOT NULL,
  `ref_id` varchar(200) NOT NULL,
  `user_id` int(30) NOT NULL,
  `delivery_address` text NOT NULL,
  `note` varchar(200) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `ref_id`, `user_id`, `delivery_address`, `note`, `status`, `date_created`) VALUES
(11, 'UeLawRXEvGc0MslZ', 3, 'Capipisa,Tanza,Cavite', 'note', 4, '2024-04-10 09:40:01'),
(12, 'kchAu9L27PRX4jtb', 3, 'Capipisa,Tanza,Cavite', 'note', 4, '2024-04-10 09:40:20'),
(13, 'R7e3A8UQNcFC5BSv', 3, 'Capipisa,Tanza,Cavite', 'note', 3, '2024-04-10 09:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(30) NOT NULL,
  `order_id` int(30) NOT NULL,
  `product_id` int(30) NOT NULL,
  `colour_id` int(30) NOT NULL,
  `size_id` int(30) NOT NULL,
  `qty` int(30) NOT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `colour_id`, `size_id`, `qty`, `price`, `date_created`) VALUES
(14, 11, 54, 24, 29, 1, 19999, '2024-04-10 09:40:01'),
(15, 12, 54, 24, 29, 1, 19999, '2024-04-10 09:40:20'),
(16, 13, 54, 24, 29, 1, 19999, '2024-04-10 09:40:31');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(30) NOT NULL,
  `category_id` int(30) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `item_code` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `description`, `item_code`, `price`, `date_created`) VALUES
(54, 5, 'try', '															', 'als84Eo01dKJnh7z', 19999, '2024-04-10 09:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `product_id` int(30) NOT NULL,
  `size` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `product_id`, `size`, `date_created`) VALUES
(3, 2, '6 (.65\"/1.65cm)', '2020-11-12 12:13:24'),
(4, 2, '7 (.98\"/1.73cm)', '2020-11-12 12:13:24'),
(6, 4, '5 (.62\"/1.57cm)', '2020-11-12 13:49:10'),
(7, 4, '7 (.98\"/1.73cm)', '2020-11-12 13:49:10'),
(8, 5, '', '2020-11-12 13:49:40'),
(9, 6, '12', '2024-01-14 08:06:06'),
(10, 28, '', '2024-01-23 20:29:34'),
(12, 40, '16,18,20,22,24', '2024-01-23 20:36:43'),
(13, 41, '16,18,20,22,24', '2024-01-23 20:38:44'),
(14, 42, '12', '2024-03-24 11:17:23'),
(15, 43, '', '2024-03-24 11:18:47'),
(16, 44, '12', '2024-03-24 11:22:17'),
(29, 54, '', '2024-04-10 09:39:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 2 COMMENT '1=Admin,2= users',
  `avatar` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `middlename`, `address`, `email`, `password`, `contact`, `type`, `avatar`, `date_created`) VALUES
(1, 'Burgos', 'Jewelry Shop', '', 'Sample', 'admin@admin.com', '0192023a7bbd73250516f069df18b500', '+12354654787', 1, '1710071220_logo.jpg', '2020-11-11 15:35:19'),
(3, 'templar', 'lanaya', 'Henes', 'Capipisa,Tanza,Cavite', 'temparlanaya0@gmail.com', '0192023a7bbd73250516f069df18b500', '1231111111111', 2, '', '2024-01-14 08:04:09'),
(4, 'Kian', 'Aratan', 'Cyrus', 'PHILIPPINES\r\nPHILIPPIlNES', 'kiancyrus08@gmail.com', '4297f44b13955235245b2497399d7a93', '09665363633', 2, '', '2024-05-11 16:55:29'),
(5, 'qew', 'qwe', 'qwe', 'qwe', 'qweq@gmail.com', 'efe6398127928f1b2e9ef3207fb82663', '09665363633', 2, '', '2024-05-13 08:25:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction_categories`
--
ALTER TABLE `auction_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auction_products`
--
ALTER TABLE `auction_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bids`
--
ALTER TABLE `bids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `colours`
--
ALTER TABLE `colours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction_categories`
--
ALTER TABLE `auction_categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `auction_products`
--
ALTER TABLE `auction_products`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `bids`
--
ALTER TABLE `bids`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `colours`
--
ALTER TABLE `colours`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
