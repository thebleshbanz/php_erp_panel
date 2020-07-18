-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2020 at 08:50 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wardrobe_wizard`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_category`
--

CREATE TABLE `tbl_category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL DEFAULT '',
  `category_slug` varchar(255) NOT NULL DEFAULT '',
  `categosty_status` enum('0','1') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact_us`
--

CREATE TABLE `tbl_contact_us` (
  `contact_id` int(11) NOT NULL,
  `contact_name` varchar(255) NOT NULL,
  `contact_email` varchar(255) NOT NULL DEFAULT '',
  `contact_decription` text NOT NULL,
  `seen_status` enum('0','1') DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_search_count`
--

CREATE TABLE `tbl_search_count` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `total_search` int(11) NOT NULL DEFAULT 0,
  `search_date` date DEFAULT NULL,
  `api_key` varchar(255) NOT NULL DEFAULT '',
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_search_count`
--

INSERT INTO `tbl_search_count` (`id`, `user_id`, `total_search`, `search_date`, `api_key`, `created_at`, `updated_at`) VALUES
(1, 3, 4, '2020-07-16', 'AIzaSyCNPrfPF28EAd2cxl0xkZXwDFEUYinMpRU', '2020-07-16', '2020-07-16'),
(2, 2, 2, '2020-07-16', 'AIzaSyCNPrfPF28EAd2cxl0xkZXwDFEUYinMpRU', '2020-07-16', '2020-07-16');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_search_user_2`
--

CREATE TABLE `tbl_search_user_2` (
  `search_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `search_query` varchar(255) NOT NULL DEFAULT '',
  `search_category` varchar(255) NOT NULL DEFAULT '',
  `search_limit` int(11) NOT NULL DEFAULT 10,
  `search_start` int(11) NOT NULL DEFAULT 1,
  `color_code` varchar(255) NOT NULL DEFAULT '',
  `nearest_color_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_search_user_2`
--

INSERT INTO `tbl_search_user_2` (`search_id`, `user_id`, `search_query`, `search_category`, `search_limit`, `search_start`, `color_code`, `nearest_color_name`, `created_at`, `updated_at`) VALUES
(1, 2, 'Black Shirt For Men', '', 10, 1, '#000000', 'Black', '2020-07-10 14:47:38', '2020-07-10 14:47:38'),
(2, 2, 'Black T-Shirt For Men', '', 10, 1, '#000000', 'Black', '2020-07-10 14:47:39', '2020-07-10 14:47:39'),
(3, 2, 'White Jeans For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:17:45', '2020-07-16 15:17:45'),
(4, 2, 'White Pants For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:17:46', '2020-07-16 15:17:46'),
(5, 2, 'White Jeans For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:19:12', '2020-07-16 15:19:12'),
(6, 2, 'White Pants For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:19:12', '2020-07-16 15:19:12'),
(7, 2, 'White Jeans For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:19:27', '2020-07-16 15:19:27'),
(8, 2, 'White Pants For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:19:28', '2020-07-16 15:19:28'),
(9, 2, 'White Jeans For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:31:28', '2020-07-16 15:31:28'),
(10, 2, 'White Pants For Men', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:31:29', '2020-07-16 15:31:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_search_user_3`
--

CREATE TABLE `tbl_search_user_3` (
  `search_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `search_query` varchar(255) NOT NULL DEFAULT '',
  `search_category` varchar(255) NOT NULL DEFAULT '',
  `search_limit` int(11) NOT NULL DEFAULT 10,
  `search_start` int(11) NOT NULL DEFAULT 1,
  `color_code` varchar(255) NOT NULL DEFAULT '',
  `nearest_color_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_search_user_3`
--

INSERT INTO `tbl_search_user_3` (`search_id`, `user_id`, `search_query`, `search_category`, `search_limit`, `search_start`, `color_code`, `nearest_color_name`, `created_at`, `updated_at`) VALUES
(1, 3, 'Black Shirt For Women', '', 10, 1, '#000000', 'Black', '2020-07-10 14:48:34', '2020-07-10 14:48:34'),
(2, 3, 'Black T-Shirt For Women', '', 10, 1, '#000000', 'Black', '2020-07-10 14:48:35', '2020-07-10 14:48:35'),
(3, 3, 'Black Shirt For Women', '', 10, 1, '#000000', 'Black', '2020-07-10 14:50:17', '2020-07-10 14:50:17'),
(4, 3, 'Black T-Shirt For Women', '', 10, 1, '#000000', 'Black', '2020-07-10 14:50:17', '2020-07-10 14:50:17'),
(5, 3, 'White Jeans For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:20:39', '2020-07-16 15:20:39'),
(6, 3, 'White Pants For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:20:40', '2020-07-16 15:20:40'),
(7, 3, 'White Jeans For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:30:39', '2020-07-16 15:30:39'),
(8, 3, 'White Pants For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:30:39', '2020-07-16 15:30:39'),
(9, 3, 'White Jeans For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:31:01', '2020-07-16 15:31:01'),
(10, 3, 'White Pants For Women', '', 10, 1, '#ffffff', 'White', '2020-07-16 15:31:02', '2020-07-16 15:31:02');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_search_user_5`
--

CREATE TABLE `tbl_search_user_5` (
  `search_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `search_query` varchar(255) NOT NULL DEFAULT '',
  `search_category` varchar(255) NOT NULL DEFAULT '',
  `search_limit` int(11) NOT NULL DEFAULT 10,
  `search_start` int(11) NOT NULL DEFAULT 1,
  `color_code` varchar(255) NOT NULL DEFAULT '',
  `nearest_color_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_search_user_5`
--

INSERT INTO `tbl_search_user_5` (`search_id`, `user_id`, `search_query`, `search_category`, `search_limit`, `search_start`, `color_code`, `nearest_color_name`, `created_at`, `updated_at`) VALUES
(1, 5, 'Black Shirt For Men', '', 10, 1, '#000000', 'Black', '2020-07-10 15:27:36', '2020-07-10 15:27:36'),
(2, 5, 'Black T-Shirt For Men', '', 10, 1, '#000000', 'Black', '2020-07-10 15:27:37', '2020-07-10 15:27:37');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_mobile` varchar(255) DEFAULT '',
  `gender` enum('male','female') DEFAULT NULL,
  `password` varchar(255) DEFAULT '',
  `user_status` enum('0','1','2') DEFAULT NULL,
  `user_type` enum('admin','user') DEFAULT NULL,
  `token_key` varchar(255) NOT NULL DEFAULT '',
  `user_otp` int(11) DEFAULT NULL,
  `search_tbl_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `user_name`, `user_email`, `user_mobile`, `gender`, `password`, `user_status`, `user_type`, `token_key`, `user_otp`, `search_tbl_name`, `created_at`, `updated_at`) VALUES
(1, 'Master Admin', 'admin@gmail.com', '1234567890', 'male', '0192023a7bbd73250516f069df18b500', '1', 'admin', '', NULL, '', '2020-07-07 00:00:00', '2020-07-07 00:00:00'),
(2, 'aashish_banjare', 'aashish.banjare@gmail.com', '1234567890', 'male', 'e10adc3949ba59abbe56e057f20f883e', '0', 'user', 'e1b7ca792770019fed3fb9e3a423f7a1', NULL, 'tbl_search_user_2', '2020-07-10 14:07:46', '2020-07-10 14:07:46'),
(3, 'mike_holmes', 'mike_holmes@gmail.com', '1234567890', 'female', 'e10adc3949ba59abbe56e057f20f883e', '0', 'user', '0433f83be2242a71f04121007172b586', NULL, 'tbl_search_user_3', '2020-07-10 14:09:56', '2020-07-10 14:09:56'),
(5, 'max_holmes', 'max_holmes@gmail.com', '1234567890', 'male', 'e10adc3949ba59abbe56e057f20f883e', '0', 'user', 'a1262ab45c4ea70ddae0111519d6dea5', NULL, 'tbl_search_user_5', '2020-07-10 15:20:19', '2020-07-10 15:20:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_measurements`
--

CREATE TABLE `tbl_user_measurements` (
  `um_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `collar_type` varchar(255) NOT NULL DEFAULT '',
  `chest` varchar(255) NOT NULL DEFAULT '',
  `waist` varchar(255) NOT NULL DEFAULT '',
  `sleeve_length` varchar(255) NOT NULL DEFAULT '',
  `inseam` varchar(255) NOT NULL DEFAULT '',
  `shoe_size` varchar(255) NOT NULL DEFAULT '',
  `bust` varchar(255) NOT NULL DEFAULT '',
  `hips` varchar(255) NOT NULL DEFAULT '',
  `arm_length` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_measurements`
--

INSERT INTO `tbl_user_measurements` (`um_id`, `user_id`, `collar_type`, `chest`, `waist`, `sleeve_length`, `inseam`, `shoe_size`, `bust`, `hips`, `arm_length`, `created_at`, `updated_at`) VALUES
(1, 2, 'spread collar', '50', '34', '15', '26', '10', '', '', '', NULL, NULL),
(2, 5, 'spread collar', '50', '34', '15', '26', '10', '', '', '', '2020-07-10 15:32:32', '2020-07-10 15:32:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_products`
--

CREATE TABLE `tbl_user_products` (
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `product_name` varchar(255) NOT NULL DEFAULT '',
  `category_id` int(11) NOT NULL DEFAULT 0,
  `decription` text NOT NULL,
  `product_img` varchar(255) NOT NULL DEFAULT '',
  `product_status` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_search_tables`
--

CREATE TABLE `tbl_user_search_tables` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `model_type` enum('search','history') NOT NULL DEFAULT 'search',
  `table_name` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `tbl_search_count`
--
ALTER TABLE `tbl_search_count`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_search_user_2`
--
ALTER TABLE `tbl_search_user_2`
  ADD PRIMARY KEY (`search_id`);

--
-- Indexes for table `tbl_search_user_3`
--
ALTER TABLE `tbl_search_user_3`
  ADD PRIMARY KEY (`search_id`);

--
-- Indexes for table `tbl_search_user_5`
--
ALTER TABLE `tbl_search_user_5`
  ADD PRIMARY KEY (`search_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indexes for table `tbl_user_measurements`
--
ALTER TABLE `tbl_user_measurements`
  ADD PRIMARY KEY (`um_id`),
  ADD KEY `user_measurement_relation` (`user_id`);

--
-- Indexes for table `tbl_user_products`
--
ALTER TABLE `tbl_user_products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_category_relation` (`category_id`);

--
-- Indexes for table `tbl_user_search_tables`
--
ALTER TABLE `tbl_user_search_tables`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_contact_us`
--
ALTER TABLE `tbl_contact_us`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_search_count`
--
ALTER TABLE `tbl_search_count`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_search_user_2`
--
ALTER TABLE `tbl_search_user_2`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_search_user_3`
--
ALTER TABLE `tbl_search_user_3`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_search_user_5`
--
ALTER TABLE `tbl_search_user_5`
  MODIFY `search_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_user_measurements`
--
ALTER TABLE `tbl_user_measurements`
  MODIFY `um_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_user_products`
--
ALTER TABLE `tbl_user_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_user_search_tables`
--
ALTER TABLE `tbl_user_search_tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_user_measurements`
--
ALTER TABLE `tbl_user_measurements`
  ADD CONSTRAINT `user_measurement_relation` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`) ON UPDATE NO ACTION;

--
-- Constraints for table `tbl_user_products`
--
ALTER TABLE `tbl_user_products`
  ADD CONSTRAINT `product_category_relation` FOREIGN KEY (`category_id`) REFERENCES `tbl_category` (`category_id`) ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
