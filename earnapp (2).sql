-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 13, 2022 at 09:12 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `earnapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_income`
--

CREATE TABLE `daily_income` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `credited_amount` double DEFAULT NULL,
  `credited_date` text DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `daily_income` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `valid` int(11) NOT NULL,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `daily_income`, `price`, `valid`, `last_updated`, `date_created`) VALUES
(1, 30, 600, 90, NULL, '2022-04-12 13:26:24'),
(2, 65, 1200, 90, NULL, '2022-04-12 13:27:14'),
(3, 130, 2400, 90, NULL, '2022-04-12 13:28:05'),
(4, 270, 5000, 90, '2022-04-12 13:29:04', '2022-04-12 13:28:05'),
(5, 450, 8000, 90, '2022-04-12 13:29:22', '2022-04-12 13:26:24'),
(6, 800, 15000, 90, '2022-04-12 13:29:43', '2022-04-12 13:27:14'),
(7, 1300, 25000, 90, '2022-04-12 13:30:10', '2022-04-12 13:28:05'),
(8, 2100, 40000, 90, '2022-04-12 13:30:43', '2022-04-12 13:28:05'),
(9, 3200, 60000, 90, '2022-04-12 13:32:08', '2022-04-12 13:28:05'),
(10, 4200, 80000, 90, '2022-04-12 13:32:15', '2022-04-12 13:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_plans`
--

CREATE TABLE `purchased_plans` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `daily_income` double NOT NULL,
  `price` double DEFAULT NULL,
  `valid` text DEFAULT NULL,
  `start_date` text DEFAULT NULL,
  `end_date` text DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchased_plans`
--

INSERT INTO `purchased_plans` (`id`, `user_id`, `plan_id`, `daily_income`, `price`, `valid`, `start_date`, `end_date`, `last_updated`, `date_created`) VALUES
(6, 13, 1, 30, 600, '90', '2022-04-13', '2022-07-12', NULL, '2022-04-13 17:38:16'),
(7, 13, 1, 30, 600, '90', '2022-04-13', '2022-07-12', NULL, '2022-04-13 17:46:01');

-- --------------------------------------------------------

--
-- Table structure for table `recharges`
--

CREATE TABLE `recharges` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `payment_type` text DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recharges`
--

INSERT INTO `recharges` (`id`, `user_id`, `amount`, `status`, `payment_type`, `last_updated`, `date_created`) VALUES
(2, 13, 100, 1, 'upi', NULL, '2022-04-12 19:31:13'),
(3, 13, 100, 1, 'upi', NULL, '2022-04-12 19:39:32'),
(4, 13, 100, 1, 'upi', NULL, '2022-04-12 19:39:49'),
(5, 13, 50, 1, 'upi', NULL, '2022-04-12 19:40:05'),
(6, 13, 500, 1, 'upi', '2022-04-13 14:07:44', '2022-04-13 14:06:14'),
(7, 13, 500, 1, 'upi', '2022-04-13 14:07:48', '2022-04-13 14:07:20'),
(8, 13, 500, 1, 'paytm', NULL, '2022-04-13 17:42:37'),
(9, 13, 500, 1, 'paytm', NULL, '2022-04-13 17:44:18'),
(10, 13, 500, 1, 'paytm', NULL, '2022-04-13 17:44:28');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `mobile` text DEFAULT NULL,
  `referral` text DEFAULT NULL,
  `my_refer_code` varchar(28) DEFAULT NULL,
  `balance` double DEFAULT NULL,
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `referral`, `my_refer_code`, `balance`, `last_updated`, `date_created`) VALUES
(11, 'Aravind', '9025635524', '2002', 'I1I2BSDBSD', 0, '2022-04-13 16:49:45', '2022-04-05 16:09:21'),
(12, 'Bala', '9055635524', 'I1I2BSDBSD', 'DDI2BAABSD', 0, '2022-04-06 14:43:42', '2022-04-05 16:09:21'),
(13, 'Prasad', '8778624681', 'I1I2BSDBSD', 'JAGPXA1FE6', 400, '2022-04-13 17:46:01', '2022-04-06 14:33:53'),
(14, 'Surya', '9090909090', 'JAGPXA1FE6', 'CPP3HK8Y8U', NULL, NULL, '2022-04-13 15:07:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `daily_income`
--
ALTER TABLE `daily_income`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchased_plans`
--
ALTER TABLE `purchased_plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharges`
--
ALTER TABLE `recharges`
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
-- AUTO_INCREMENT for table `daily_income`
--
ALTER TABLE `daily_income`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `purchased_plans`
--
ALTER TABLE `purchased_plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `recharges`
--
ALTER TABLE `recharges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
